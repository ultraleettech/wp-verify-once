<?php
/**
 * Plugin Name: VerifyOnce
 * Plugin URL:
 * Description: VerifyOnce verification service integration with user login.
 * Version: 1.0.0
 * Author: Rene Aavik
 * Author URI: mailto:renx81@gmail.com
 * License: MIT
 * License URI: https://tldrlegal.com/license/mit-license
 * Text Domain: verify-once
 * GitHub Plugin URI:
 * Requires WP: 4.6
 * Requires PHP: 7.2
 * Contributors: ultraleet
 */

use Ultraleet\WP\VerifyOnce\Plugin;
use Ultraleet\WP\RequirementsChecker;

// setup autoload
require_once('vendor/autoload.php');

$requirementsChecker = new RequirementsChecker(array(
    'title' => 'VerifyOnce',
    'php' => '7.2',
    'wp' => '4.6',
    'file' => __FILE__,
));
if ($requirementsChecker->passes()) {
    new Plugin();
}
