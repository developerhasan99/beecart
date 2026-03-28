<?php

/**
 * Plugin Name: BeeCart
 * Description: A premium side cart plugin with cart progress, upsells, coupons, and payment badges.
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: beecart
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('BEECART_VERSION', '1.0.0');
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
        require_once BEECART_PATH . 'includes/class-beecart-customizer.php';

        $plugin = new BeeCart();
        $plugin->init();

        $admin = new BeeCart_Admin();
        $admin->init();
    }
}
add_action('plugins_loaded', 'run_beecart');

/**
 * Handle activation
 */
function activate_beecart()
{
    // Custom DB tables or setup can go here
}
register_activation_hook(__FILE__, 'activate_beecart');
