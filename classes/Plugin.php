<?php

namespace Ultraleet\WP\VerifyOnce;

use Ultraleet\WP\VerifyOnce\Admin\Main;

final class Plugin
{
    public function __construct()
    {
        add_action('init', [$this, 'init']);
    }

    public function init()
    {
        if (is_admin()) {
            new Main();
        }
    }
}
