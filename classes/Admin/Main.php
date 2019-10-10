<?php

namespace Ultraleet\WP\VerifyOnce\Admin;

use Ultraleet\WP\VerifyOnce\Managers\SettingsManager;

class Main
{
    protected $menu;
    protected $settings;

    public function __construct()
    {
        $this->settings = new SettingsManager();

        add_action('admin_menu', [$this, 'menu']);
    }

    public function menu()
    {
        $this->menu = new Menu($this->settings);
    }
}
