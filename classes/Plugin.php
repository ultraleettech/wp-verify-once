<?php

namespace Ultraleet\WP\VerifyOnce;

use Elementor\Core\Admin\Admin;
use Ultraleet\WP\VerifyOnce\Admin\Main;
use Ultraleet\WP\VerifyOnce\Managers\SettingsManager;

final class Plugin
{
    private static $instance;
    private $settings;
    private $admin;

    private function __construct()
    {
        if (WP_DEBUG) {
            add_action('plugins_loaded', function() {
                error_reporting(E_ALL | E_NOTICE);
            });
        }
        add_action('init', [$this, 'init']);
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
            $this->admin = new Main();
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
        if (! isset($this->admin)) {
            $this->admin = new Admin();
        }
        return $this->admin;
    }

    public function __get(string $name)
    {
        $getter = 'get' . ucfirst($name);
        if (! method_exists($this, $getter)) {
            trigger_error('Undefined property:  ' . __CLASS__ . '::$' . $name, E_USER_NOTICE);
        }
        return $getter();
    }
}
