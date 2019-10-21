<?php

namespace Ultraleet\WP\VerifyOnce;

use Ultraleet\WP\VerifyOnce\Admin\Main as Admin;
use Ultraleet\WP\VerifyOnce\Managers\ApiManager;
use Ultraleet\WP\VerifyOnce\Managers\SettingsManager;

/**
 * Class Plugin
 *
 * @package Ultraleet\WP\VerifyOnce
 *
 * @property-read SettingsManager $settings
 * @property-read ApiManager $api
 * @property-read Admin $admin
 */
final class Plugin
{
    private static $instance;
    private $settings;
    private $admin;
    private $api;

    private function __construct()
    {
        $this->enableDebugMode();
        add_action('init', [$this, 'init']);

        // Verification needs to be enabled before init
        new Verification();
    }

    public static function create()
    {
        self::$instance = new self();
    }

    public static function get(): self
    {
        return self::$instance;
    }

    public function init()
    {
        if (is_admin()) {
            $this->admin = new Admin($this->getSettings());
        }
    }

    public function getSettings(): SettingsManager
    {
        if (! isset($this->settings)) {
            $this->settings = new SettingsManager();
        }
        return $this->settings;
    }

    public function getAdmin(): Admin
    {
        return $this->admin;
    }

    public function getApi(): ApiManager
    {
        if (! isset($this->api)) {
            $this->api = new ApiManager($this->getSettings());
        }
        return $this->api;
    }

    /**
     * Fix to make sure errors are displayed in debug mode.
     */
    private function enableDebugMode()
    {
        if (WP_DEBUG) {
            add_action('plugins_loaded', function() {
                error_reporting(E_ALL | E_NOTICE);
            });
        }
    }

    public function __get(string $name)
    {
        $getter = 'get' . ucfirst($name);
        if (! method_exists($this, $getter)) {
            trigger_error('Undefined property:  ' . __CLASS__ . '::$' . $name, E_USER_ERROR);
        }
        return $getter();
    }
}
