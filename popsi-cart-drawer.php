<?php

/**
 * Plugin Name: Popsi Cart Drawer for WooCommerce
 * Description: A premium side cart plugin for WooCommerce featuring Cart Drawer, Upsell, and Cart Progress.
 * Version: 1.1.3
 * Author: Mehedi Hasan
 * Author URI: https://developerhasan99.github.io/
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 6.0
 * Tested up to: 6.9
 * Requires PHP: 7.4
 * Text Domain: popsi-cart-drawer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'POPSI_CART_VERSION', '1.1.3' );
define( 'POPSI_CART_FILE', __FILE__ );
define( 'POPSI_CART_PATH', plugin_dir_path( __FILE__ ) );
define( 'POPSI_CART_URL', plugin_dir_url( __FILE__ ) );

/**
 * Main instance initialization
 */
function popsi_cart_run() {
	if ( class_exists( 'WooCommerce' ) ) {
		require_once POPSI_CART_PATH . 'includes/class-popsi-cart.php';
		require_once POPSI_CART_PATH . 'includes/class-popsi-cart-admin.php';

		$plugin = new Popsi_Cart_Drawer();
		$plugin->init();

		$admin = new Popsi_Cart_Admin();
		$admin->init();
	}
}
add_action( 'plugins_loaded', 'popsi_cart_run' );
