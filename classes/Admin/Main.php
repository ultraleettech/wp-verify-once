<?php

namespace Ultraleet\WP\VerifyOnce\Admin;

use Ultraleet\WP\VerifyOnce\Plugin;
use Ultraleet\WP\VerifyOnce\Managers\SettingsManager;

class Main
{
    protected $menu;
    protected $settings;

    public function __construct(SettingsManager $settings)
    {
        $this->settings = $settings;

        add_action('admin_menu', [$this, 'menu']);
        add_action('verify_once_save_settings', [$this, 'onSaveSettings']);
        if (! Plugin::get()->getApi()->active()) {
            add_action('admin_notices', [$this, 'noticeApiInactive']);
        }
    }

    public function menu()
    {
        $this->menu = new Menu($this->settings);
    }

    public function onSaveSettings()
    {
    }

    public function noticeApiInactive()
    {
        $notice = __('VerifyOnce API credentials are not configured. Please check your settings and try again.');
        echo <<<HTML
<div class="notice notice-warning is-dismissible">
    <p>
        <strong>$notice</strong>
    </p>
</div>
HTML;
    }
}
