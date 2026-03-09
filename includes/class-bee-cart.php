<?php
if (! defined('ABSPATH')) {
    exit;
}

class Bee_Cart
{

    public function init()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('wp_footer', array($this, 'output_cart_drawer'));

        add_shortcode('bee_cart_icon', array($this, 'cart_icon_shortcode'));

        add_action('wp_ajax_nopriv_beecart_get_cart', array($this, 'ajax_get_cart'));
        add_action('wp_ajax_beecart_get_cart', array($this, 'ajax_get_cart'));

        add_action('wp_ajax_nopriv_beecart_update_item', array($this, 'ajax_update_item'));
        add_action('wp_ajax_beecart_update_item', array($this, 'ajax_update_item'));

        add_action('wp_ajax_nopriv_beecart_apply_coupon', array($this, 'ajax_apply_coupon'));
        add_action('wp_ajax_beecart_apply_coupon', array($this, 'ajax_apply_coupon'));

        add_action('wp_ajax_nopriv_beecart_add_to_cart', array($this, 'ajax_add_to_cart'));
        add_action('wp_ajax_beecart_add_to_cart', array($this, 'ajax_add_to_cart'));
    }

    public function enqueue_assets()
    {
        if (function_exists('is_cart') && is_cart()) return;
        if (function_exists('is_checkout') && is_checkout()) return;

        wp_enqueue_script('alpine-js', 'https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js', array(), null, true);
        wp_enqueue_style('bee-cart-style', BEE_CART_URL . 'assets/css/bee-cart.css', array(), BEE_CART_VERSION);
        wp_enqueue_script('bee-cart-script', BEE_CART_URL . 'assets/js/bee-cart.js', array('jquery'), BEE_CART_VERSION, true);

        wp_localize_script('bee-cart-script', 'beeCartData', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('bee-cart-nonce'),
            'free_shipping_threshold' => get_option('bee_cart_shipping_threshold', 100)
        ));
    }

    public function output_cart_drawer()
    {
        if (function_exists('is_cart') && is_cart()) return;
        if (function_exists('is_checkout') && is_checkout()) return;

        include BEE_CART_PATH . 'templates/cart-drawer.php';
    }

    public function ajax_get_cart()
    {
        check_ajax_referer('bee-cart-nonce', 'security');
        ob_start();
        $this->render_cart_content();
        $html = ob_get_clean();
        wp_send_json_success(array(
            'html' => $html,
            'count' => WC()->cart->get_cart_contents_count(),
            'subtotal' => WC()->cart->get_cart_subtotal(),
        ));
    }

    public function ajax_update_item()
    {
        check_ajax_referer('bee-cart-nonce', 'security');
        $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
        $quantity      = isset($_POST['quantity']) ? absint($_POST['quantity']) : 0;

        if ($quantity == 0) {
            WC()->cart->remove_cart_item($cart_item_key);
        } else {
            WC()->cart->set_quantity($cart_item_key, $quantity);
        }

        WC()->cart->calculate_totals();

        $this->ajax_get_cart();
    }

    public function ajax_apply_coupon()
    {
        check_ajax_referer('bee-cart-nonce', 'security');
        $coupon_code = sanitize_text_field($_POST['coupon']);

        if (! empty($coupon_code)) {
            WC()->cart->add_discount($coupon_code);
        }

        WC()->cart->calculate_totals();
        $this->ajax_get_cart();
    }

    public function ajax_add_to_cart()
    {
        check_ajax_referer('bee-cart-nonce', 'security');

        $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : (isset($_POST['add-to-cart']) ? absint($_POST['add-to-cart']) : 0);
        $quantity   = empty($_POST['quantity']) ? 1 : wc_stock_amount(wp_unslash($_POST['quantity']));
        $variation_id = isset($_POST['variation_id']) ? absint($_POST['variation_id']) : '';

        $variation = array();
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'attribute_') === 0) {
                $variation[$key] = wc_clean($value);
            }
        }

        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variation);

        if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation)) {
            if (isset($_POST['add-to-cart'])) {
                // If it came from a standard form, we might need to trigger this to help other plugins
                do_action('woocommerce_ajax_added_to_cart', $product_id);
            }
            $this->ajax_get_cart();
        } else {
            wp_send_json_error(array('error' => true));
        }
    }

    public function render_cart_content()
    {
        include BEE_CART_PATH . 'templates/cart-items.php';
    }

    public function cart_icon_shortcode()
    {
        ob_start();
        include BEE_CART_PATH . 'templates/cart-icon.php';
        return ob_get_clean();
    }
}
