<?php

/**
 * Plugin Name: Bee Cart
 * Description: A premium side cart plugin with cart progress, upsells, coupons, payment badges, and advanced cookie-based analytics for abandonment tracking.
 * Version: 1.0.0
 * Author: Your Name
 * Text Domain: bee-cart
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

define('BEE_CART_VERSION', '1.0.0');
define('BEE_CART_FILE', __FILE__);
define('BEE_CART_PATH', plugin_dir_path(__FILE__));
define('BEE_CART_URL', plugin_dir_url(__FILE__));

/**
 * Main instance initialization
 */
function run_bee_cart()
{
    if (class_exists('WooCommerce')) {
        require_once BEE_CART_PATH . 'includes/class-bee-cart.php';
        require_once BEE_CART_PATH . 'includes/class-bee-cart-analytics.php';
        require_once BEE_CART_PATH . 'includes/class-bee-cart-admin.php';
        require_once BEE_CART_PATH . 'includes/class-bee-cart-customizer.php';

        $plugin = new Bee_Cart();
        $plugin->init();

        $analytics = new Bee_Cart_Analytics();
        $analytics->init();

        $admin = new Bee_Cart_Admin();
        $admin->init();
    }
}
add_action('plugins_loaded', 'run_bee_cart');

/**
 * Handle activation
 */
function activate_bee_cart()
{
    // Custom DB tables or setup can go here
}
register_activation_hook(__FILE__, 'activate_bee_cart');
