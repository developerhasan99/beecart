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
        add_action('wp_head', array($this, 'output_custom_css'), 999);

        add_shortcode('bee_cart_icon', array($this, 'cart_icon_shortcode'));

        add_action('wp_ajax_nopriv_beecart_get_cart', array($this, 'ajax_get_cart'));
        add_action('wp_ajax_beecart_get_cart', array($this, 'ajax_get_cart'));

        add_action('wp_ajax_nopriv_beecart_update_item', array($this, 'ajax_update_item'));
        add_action('wp_ajax_beecart_update_item', array($this, 'ajax_update_item'));

        add_action('wp_ajax_nopriv_beecart_apply_coupon', array($this, 'ajax_apply_coupon'));
        add_action('wp_ajax_beecart_apply_coupon', array($this, 'ajax_apply_coupon'));

        add_action('wp_ajax_nopriv_beecart_add_to_cart', array($this, 'ajax_add_to_cart'));
        add_action('wp_ajax_beecart_add_to_cart', array($this, 'ajax_add_to_cart'));

        add_filter('woocommerce_add_to_cart_fragments', array($this, 'cart_bubble_fragment'));
    }

    public function cart_bubble_fragment($fragments)
    {
        ob_start();
        $this->cart_icon_shortcode_output();
        $iconHtml = ob_get_clean();
        $fragments['div.bee-cart-icon-wrapper'] = $iconHtml;
        return $fragments;
    }

    public function cart_icon_shortcode_output()
    {
        include BEE_CART_PATH . 'templates/cart-icon.php';
    }

    public function enqueue_assets()
    {
        if (function_exists('is_cart') && is_cart()) return;
        if (function_exists('is_checkout') && is_checkout()) return;

        // We don't load bee-cart-admin.css anymore since it's tailwind
        // wp_enqueue_style('bee-cart-admin-style', BEE_CART_URL . 'assets/css/bee-cart-admin.css', array(), BEE_CART_VERSION);
        
        // Native / Frontend CSS
        wp_enqueue_style('bee-cart-style', BEE_CART_URL . 'assets/css/bee-cart.css', array(), BEE_CART_VERSION);
        
        // The newly created Vanilla CSS classes for the generic layout
        wp_enqueue_style('bee-cart-drawer-style', BEE_CART_URL . 'assets/css/cart-drawer.css', array(), BEE_CART_VERSION);
        wp_enqueue_script('bee-cart-script', BEE_CART_URL . 'assets/js/bee-cart.js', array('jquery'), BEE_CART_VERSION, true);
        wp_enqueue_script('alpine-js', 'https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js', array('bee-cart-script'), null, true);

        wp_localize_script('bee-cart-script', 'beeCartData', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('bee-cart-nonce'),
            'settings' => $this->get_settings()
        ));
    }

    public static function get_default_settings()
    {
        return array(
            'enable_cart_drawer'          => true,
            'cart_position'               => 'right',
            'auto_open_cart'              => true,
            'menu_placement'              => 'bottom',
            'progress_type'               => 'subtotal',
            'goals'                       => array(
                array( 'threshold' => 50, 'label' => 'Free Shipping', 'icon' => 'truck' ),
                array( 'threshold' => 100, 'label' => '20% Discount', 'icon' => 'tag' ),
            ),
            'primary_color'               => '#000000',
            'enable_coupon'               => true,
            'enable_badges'               => true,
            'enable_rewards_bar'          => true,
            'show_rewards_on_empty'       => true,
            'rewards_bar_bg'              => '#E2E2E2',
            'rewards_bar_fg'              => '#93D3FF',
            'rewards_complete_icon_color' => '#4D4949',
            'rewards_incomplete_icon_color' => '#4D4949',
            'rewards_completed_text'      => '🎉 Congratulations! You have unlocked all rewards.',
            'inherit_fonts'               => true,
            'show_strikethrough'          => true,
            'enable_subtotal_line'        => true,
            'bg_color'                    => '#FFFFFF',
            'accent_color'                => '#f6f6f7',
            'text_color'                  => '#000000',
            'savings_text_color'          => '#2ea818',
            'btn_radius'                  => '5px',
            'btn_color'                   => '#000000',
            'btn_text_color'              => '#FFFFFF',
            'btn_hover_color'             => '#333333',
            'btn_hover_text_color'        => '#e9e9e9',
            'cart_icon_type'              => 'bag-1',
            'cart_icon_color'             => '#000000',
            'cart_icon_size'              => '24',
            'cart_bubble_bg'              => '#ff0000',
            'cart_bubble_text'            => '#ffffff',
            'show_cart_count'             => true,
            'cart_title'                  => 'Your Cart',
            'show_announcement'           => false,
            'announcement_text'           => 'Your products are reserved for {timer}!',
            'announcement_bg'             => '#000000',
            'announcement_text_color'     => '#ffffff',
            'announcement_font_size'      => '13px',
            'announcement_bar_size'       => 'medium',
            'enable_timer'                => false,
            'timer_duration'              => '0',
            'show_item_images'            => true,
            'show_savings'                => true,
            'trans_savings_prefix'        => 'Save',
            'qty_selector_type'           => 'boxed',
            'show_upsells'                => true,
            'show_upsells_on_empty'       => true,
            'upsell_title'                => 'You might also like...',
            'upsell_max'                  => 3,
            'upsell_source'               => 'random',
            'upsell_layout'               => 'list',
            'upsell_btn_text'             => 'Add to Cart',
            'show_trust_badges'           => true,
            'trust_badge_image'           => 'data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 300 40\' width=\'300\' height=\'40\'%3E%3Crect width=\'300\' height=\'40\' fill=\'transparent\' rx=\'4\'/%3E%3Ctext x=\'150\' y=\'25\' font-family=\'sans-serif\' font-size=\'14\' font-weight=\'bold\' fill=\'%239ca3af\' text-anchor=\'middle\'%3ESECURE CHECKOUT%3C/text%3E%3C/svg%3E',
            'custom_css'                  => '',
            'trans_checkout_btn'          => 'Checkout',
            'trans_view_cart_btn'         => 'View Cart',
            'trans_continue_shopping'     => 'Continue Shopping',
            'trans_empty_cart'            => 'Your cart is currently empty.',
            'trans_subtotal'              => 'Subtotal',
            'trans_coupon_placeholder'    => 'Coupon code',
            'trans_coupon_apply_btn'      => 'Apply',
            'trans_rewards_away'          => "You're only {amount} away from {goal}",
        );
    }

    public function get_settings()
    {
        $saved_settings = get_option('bee_cart_settings', array());
        return wp_parse_args($saved_settings, self::get_default_settings());
    }

    public function output_custom_css()
    {
        $settings = $this->get_settings();
        $custom_css = isset($settings['custom_css']) ? $settings['custom_css'] : '';
        if (! empty($custom_css)) {
            echo '<style id="bee-cart-custom-css">' . wp_strip_all_tags($custom_css) . '</style>';
        }
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
