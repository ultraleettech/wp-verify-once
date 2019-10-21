<?php

namespace Ultraleet\WP\VerifyOnce\Managers;

use Exception;
use Ultraleet\VerifyOnce\VerifyOnce;
use Ultraleet\VerifyOnce\Data\CallbackInfo;
use Ultraleet\VerifyOnce\Data\InitiateResponse;
use Ultraleet\VerifyOnce\Exceptions\InvalidConfigException;
use Ultraleet\VerifyOnce\Exceptions\AuthenticationException;

class ApiManager
{
    /**
     * @var VerifyOnce
     */
    protected $api;

    /**
     * @var bool
     */
    protected $isActive = true;

    public function __construct(SettingsManager $settings)
    {
        $this->initApi($settings);
    }

    protected function initApi(SettingsManager $settings): void
    {
        $isTestMode = $settings->getSettingValue('dev', 'mode', 'api');
        $section = $isTestMode ? 'dev' : 'live';
        $config = [
            'username' => $settings->getSettingValue('username', $section, 'api'),
            'password' => $settings->getSettingValue('password', $section, 'api'),
        ];
        !$isTestMode ?: $config['baseUrl'] = 'https://test-app.verifyonce.com/api/verify/';
        try {
            $this->api = new VerifyOnce($config);
        } catch (InvalidConfigException $exception) {
            $this->isActive = false;
        }
    }

    /**
     * Check whether VerifyOnce API has been successfully activated by setting correct credentials.
     *
     * @return bool
     */
    public function active(): bool
    {
        return $this->isActive;
    }

    /**
     * @return bool|InitiateResponse
     *
     * @todo Notify admin of auth error
     */
    public function initiate()
    {
        try {
            $response = $this->api->initiate();
        } catch (AuthenticationException $exception) {
            return false;
        }
        return $response;
    }

    /**
     * @param string $body
     * @return CallbackInfo|null
     *
     * @todo Log results
     * @todo Check for all exception types that can be thrown
     */
    public function verify(string $body)
    {
        try {
            $info = $this->api->verify($body);
        } catch (Exception $exception) {
            return null;
        }
        return $info;
    }
}
