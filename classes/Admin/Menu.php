<?php

namespace Ultraleet\WP\VerifyOnce\Admin;

use Ultraleet\WP\VerifyOnce\Managers\SettingsManager;

class Menu
{
    protected $settingsManager;

    public function __construct(SettingsManager $settingsManager)
    {
        $this->settingsManager = $settingsManager;

        add_options_page(
            __('VerifyOnce Settings', ULTRALEET_VO_TEXTDOMAIN),
            __('VerifyOnce', ULTRALEET_VO_TEXTDOMAIN),
            'manage_options',
            'verify-once-settings',
            [$this, 'settings']
        );
    }

    public function settings()
    {
        $page = $_GET['tab'] ?? '';
        echo $this->settingsManager->renderPage($page);
    }
}
