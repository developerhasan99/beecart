<?php

/**
 * Plugin Name: BeeCart – AOV Booster, Cart Drawer & Upsell Suite
 * Description: A premium WooCommerce side cart plugin featuring AOV Booster, Cart Drawer, Upsell, Cart Progress.
 * Version: 1.1.0
 * Author: Mehedi Hasan
 * Author URI: https://developerhasan99.github.io/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 6.0
 * Tested up to: 6.7
 * Requires PHP: 7.4
 * Text Domain: beecart
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('BEECART_VERSION', '1.1.0');
define('BEECART_FILE', __FILE__);
define('BEECART_PATH', plugin_dir_path(__FILE__));
define('BEECART_URL', plugin_dir_url(__FILE__));

/**
 * Main instance initialization
 */
function run_beecart()
{
    if (class_exists('WooCommerce')) {
        require_once BEECART_PATH . 'includes/class-beecart.php';
        require_once BEECART_PATH . 'includes/class-beecart-admin.php';

        $plugin = new BeeCart();
        $plugin->init();

        $admin = new BeeCart_Admin();
        $admin->init();
    }
}
add_action('plugins_loaded', 'run_beecart');
