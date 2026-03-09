<?php
if (! defined('ABSPATH')) {
    exit;
}

class Bee_Cart_Admin
{

    public function init()
    {
        add_action('admin_menu', array($this, 'register_menus'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));

        // Handle AJAX save settings
        add_action('wp_ajax_beecart_save_settings', array($this, 'ajax_save_settings'));
    }

    public function register_menus()
    {
        add_menu_page(
            'Bee Cart',
            'Bee Cart',
            'manage_options',
            'bee-cart',
            array($this, 'render_cart_builder'),
            'dashicons-cart',
            58
        );

        add_submenu_page(
            'bee-cart',
            'Cart Builder',
            'Cart Builder',
            'manage_options',
            'bee-cart',
            array($this, 'render_cart_builder')
        );

        add_submenu_page(
            'bee-cart',
            'Analytics',
            'Analytics',
            'manage_options',
            'bee-cart-analytics',
            array($this, 'render_analytics')
        );
    }

    public function enqueue_admin_assets($hook)
    {
        if (strpos($hook, 'bee-cart') === false) {
            return;
        }

        wp_enqueue_style('bee-cart-admin-style', BEE_CART_URL . 'assets/css/bee-cart-admin.css', array(), BEE_CART_VERSION);
        wp_enqueue_script('bee-cart-admin-script', BEE_CART_URL . 'assets/js/bee-cart-admin.js', array('jquery'), BEE_CART_VERSION, true);

        // For the preview, we'll also need the frontend styles/scripts
        wp_enqueue_style('bee-cart-style', BEE_CART_URL . 'assets/css/bee-cart.css', array(), BEE_CART_VERSION);

        $settings = get_option('bee_cart_settings', array());
        wp_localize_script('bee-cart-admin-script', 'beeCartAdminData', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('beecart-admin-nonce'),
            'settings' => $settings
        ));
    }

    public function render_cart_builder()
    {
        include BEE_CART_PATH . 'templates/admin/cart-builder.php';
    }

    public function render_analytics()
    {
        include BEE_CART_PATH . 'templates/admin/analytics.php';
    }

    public function ajax_save_settings()
    {
        check_ajax_referer('beecart-admin-nonce', 'security');

        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }

        $settings = isset($_POST['settings']) ? json_decode(stripslashes($_POST['settings']), true) : array();

        update_option('bee_cart_settings', $settings);
        wp_send_json_success('Settings saved successfully!');
    }
}
