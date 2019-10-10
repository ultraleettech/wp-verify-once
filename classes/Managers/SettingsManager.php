<?php

namespace Ultraleet\WP\VerifyOnce\Managers;

use Ultraleet\WP\Settings\Settings;

/**
 * Class SettingsManager
 *
 * @package Ultraleet\WP\VerifyOnce
 *
 * @mixin Settings
 */
class SettingsManager
{
    /** @var Settings */
    private $api;

    public function __construct()
    {
        $config = $this->getConfig();
        $this->api = new Settings('verify_once', $config, [
            'pluginBaseFile' => ULTRALEET_VO_FILE,
            'isSettingsPage' => [$this, 'isSettingsPage'],
        ]);
    }

    /**
     * Populate and return plugin settings config array.
     *
     * @return array
     */
    protected function getConfig(): array
    {
        return include ULTRALEET_VO_CONFIG_PATH . 'settings.php';
    }

    public function isSettingsPage(): bool
    {
        if ($screen = get_current_screen()) {
            return 'settings_page_verify-once-settings' == $screen->id;
        }
        return false;
    }

    /**
     * Proxy settings API method calls.
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (!method_exists($this->api, $name)) {
            trigger_error('Call to undefined method ' . __CLASS__ . '::' . $name . '()', E_USER_ERROR);
        }
        return call_user_func_array([$this->api, $name], $arguments);
    }
}
