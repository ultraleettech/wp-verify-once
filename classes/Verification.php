<?php

namespace Ultraleet\WP\VerifyOnce;

use WP_User;
use Exception;
use Ultraleet\VerifyOnce\Data\CallbackInfo;
use Ultraleet\WP\VerifyOnce\Managers\ApiManager;
use Ultraleet\VerifyOnce\Types\VerificationStatus;
use Ultraleet\WP\VerifyOnce\Managers\SettingsManager;

/**
 * Class Verification
 *
 * Main verification integration class.
 */
class Verification
{
    public function __construct()
    {
        add_action('wp_login', [$this, 'loginVerification'], -1337, 2);
        add_filter('verify_once_init_custom_verification', [$this, 'customVerification']);
        add_action('init', [$this, 'callback']);
        add_action('wp_ajax_verifyOnceCheckStatus', [$this, 'checkVerificationStatus']);
        add_action('wp_ajax_nopriv_verifyOnceCheckStatus', [$this, 'checkVerificationStatus']);
    }

    /**
     * Initiate VerifyOnce login verification process.
     *
     * @param string $login
     * @param WP_User $user
     *
     * @todo Refactor: extract common code
     */
    public function loginVerification(string $login, WP_User $user)
    {
        if (
            is_array($user->roles) && // sanity check
            !in_array('administrator', $user->roles) &&  // admins are exempt
            !get_user_meta($user->ID, '_vo_verified', true) && // unverified user
            $this->getApi()->active() && // api credentials need to be set
            $this->getSettings()->getSettingValue('enabled', 'login', 'verify') && // login verification enabled
            $response = $this->getApi()->initiate()
        ) {
            $transactionId = $response->getTransactionId();
            update_user_meta($user->ID, '_vo_transaction_id', $transactionId);
            wp_logout();

            $url = $response->getUrl();
            $type = 'login';
            include(ULTRALEET_VO_TEMPLATE_PATH . 'verify-once-iframe.php');

            Plugin::log()->info(
                "Initiated login verification for user #{$user->ID} ({$user->user_email})",
                $response->toArray()
            );
            die;
        }
    }

    /**
     * @param $dummy
     * @return string|false Transaction ID if successful, false otherwise.
     *
     * @todo Refactor: extract common code
     */
    public function customVerification($dummy)
    {
        if (
            $this->getApi()->active() && // api credentials need to be set
            $this->getSettings()->getSettingValue('enabled', 'custom', 'verify') && // custom verification enabled
            $response = $this->getApi()->initiate()
        ) {
            $transactionId = $response->getTransactionId();
            $url = $response->getUrl();
            include(ULTRALEET_VO_TEMPLATE_PATH . 'verify-once-iframe.php');

            Plugin::log()->info(
                'Initiated custom verification',
                $response->toArray()
            );
            return $transactionId;
        }
        return $dummy;
    }

    /**
     * Verification callback entry point.
     *
     * @throws Exception
     *
     * @todo Refactor
     */
    public function callback()
    {
        if (isset($_GET['action']) && 'verify-once-callback' === $_GET['action']) {
            try {
                $body = file_get_contents('php://input');
                Plugin::log(true)->debug("Received callback from API: $body");
                if (!$info = $this->getApi()->verify($body)) {
                    throw new Exception("Error verifying transaction payload.");
                }
                $transactionId = $info->transaction->id;
                if ($user = $this->getUserByTransactionId($transactionId)) {
                    // Login verification
                    if (!$this->verifyUser($user, $info)) {
                        throw new Exception("Unable to verify user #{$user->ID}.");
                    }
                    update_user_meta($user->ID, '_vo_callback_info', $info->toArray());
                    update_user_meta($user->ID, '_vo_verified', true);

                    Plugin::log(true)->info("User #{$user->ID} ({$user->user_email}) verified", $info->toArray());
                } else {
                    // Custom verification
                    if (!apply_filters('verify_once_verify_transaction', $info)) {
                        throw new Exception("Custom verification failed for transaction $transactionId");
                    }
                    Plugin::log(true)->info('Verification succeeded', $info->toArray());
                }
                wp_send_json(['status' => 'ok'], 200);
            } catch (Exception $exception) {
                Plugin::log(true)->error($exception->getMessage());
                Plugin::log()->debug(
                    $exception->getMessage(),
                    [
                        'code' => $exception->getCode(),
                        'file' => $exception->getFile(),
                        'line' => $exception->getLine(),
                        'trace' => $exception->getTrace(),
                    ]
                );
                wp_send_json(['status' => 'error', 'message' => $exception->getMessage()], 500);
            }
        }
    }

    /**
     * @param string $transactionId
     * @return mixed
     */
    protected function getUserByTransactionId(string $transactionId)
    {
        $users = get_users(['meta_key' => '_vo_transaction_id', 'meta_value' => $transactionId]);
        if (is_wp_error($users) || empty($users)) {
            return null;
        }
        $user = current($users);
        return $user;
    }

    /**
     * The main verification procedure.
     *
     * Currently only checks for valid response and matching email address.
     * More complex logic based on plugin settings will be added in the future.
     *
     * @param WP_User $user
     * @param CallbackInfo $info
     * @return bool
     *
     * @todo More complex verification logic
     */
    protected function verifyUser(WP_User $user, CallbackInfo $info)
    {
        if (is_null($info->identityVerification)) {
            return false;
        }
        if ((string)VerificationStatus::VERIFIED() !== (string)$info->identityVerification->status) {
            return false;
        }
        if (in_array(
                'email',
                $this->getSettings()->getSettingValue('fields', 'login', 'verify')
            ) && $user->user_email !== $info->getUser()->email) {
            return false;
        }
        return true;
    }

    /**
     * Ajax hook for checking verification status.
     */
    public function checkVerificationStatus()
    {
        if ($transactionId = $_REQUEST['transactionId'] && $type = $_REQUEST['type']) {
            try {
                if ('login' === $type) {
                    $user = $this->getUserByTransactionId($transactionId);
                    $isVerified = get_user_meta($user->ID, '_vo_verified', true);
                } elseif ('custom' === $type) {
                    $isVerified = apply_filters('verify_once_is_verified', $transactionId);
                } else {
                    throw new Exception("Invalid verification type '$type'.");
                }
            } catch (Exception $exception) {
                wp_send_json(['status' => 'error', 'message' => $exception->getMessage()]);
            }
            $response = ['status' => $isVerified ? 'verified' : 'pending'];
            if ($isVerified) {
                $response['redirect'] = is_string($isVerified) ? $isVerified : wp_login_url();
            }
            wp_send_json($response);
        }
        wp_send_json(['status' => 'error', 'message' => 'Transaction ID or verification type missing!']);
    }

    protected function getApi(): ApiManager
    {
        return Plugin::get()->getApi();
    }

    protected function getSettings(): SettingsManager
    {
        return Plugin::get()->getSettings();
    }
}
