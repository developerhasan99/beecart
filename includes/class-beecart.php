<?php
if (! defined('ABSPATH')) {
    exit;
}

class BeeCart
{

    public function init()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_assets'));
        add_action('wp_footer', array($this, 'output_cart_drawer'));
        add_action('wp_head', array($this, 'output_custom_css'), 999);

        add_shortcode('beecart_icon', array($this, 'cart_icon_shortcode'));

        add_action('wp_ajax_nopriv_beecart_get_cart', array($this, 'ajax_get_cart'));
        add_action('wp_ajax_beecart_get_cart', array($this, 'ajax_get_cart'));

        add_action('wp_ajax_nopriv_beecart_update_item', array($this, 'ajax_update_item'));
        add_action('wp_ajax_beecart_update_item', array($this, 'ajax_update_item'));

        add_action('wp_ajax_nopriv_beecart_apply_coupon', array($this, 'ajax_apply_coupon'));
        add_action('wp_ajax_beecart_apply_coupon', array($this, 'ajax_apply_coupon'));

        add_action('wp_ajax_nopriv_beecart_remove_coupon', array($this, 'ajax_remove_coupon'));
        add_action('wp_ajax_beecart_remove_coupon', array($this, 'ajax_remove_coupon'));

        add_action('wp_ajax_nopriv_beecart_add_to_cart', array($this, 'ajax_add_to_cart'));
        add_action('wp_ajax_beecart_add_to_cart', array($this, 'ajax_add_to_cart'));

        add_filter('woocommerce_add_to_cart_fragments', array($this, 'cart_bubble_fragment'));
    }

    public function cart_bubble_fragment($fragments)
    {
        ob_start();
        $this->cart_icon_shortcode_output();
        $iconHtml = ob_get_clean();
        $fragments['div.beecart-icon-wrapper'] = $iconHtml;
        return $fragments;
    }

    public function cart_icon_shortcode_output()
    {
        include BEECART_PATH . 'templates/cart-icon.php';
    }

    public function enqueue_assets()
    {
        if (function_exists('is_cart') && is_cart()) return;
        if (function_exists('is_checkout') && is_checkout()) return;

        // We don't load beecart-admin.css anymore since it's tailwind
        // wp_enqueue_style('beecart-admin-style', BEECART_URL . 'assets/css/beecart-admin.css', array(), BEECART_VERSION);

        // Native / Frontend CSS
        wp_enqueue_style('beecart-style', BEECART_URL . 'assets/css/beecart.css', array(), BEECART_VERSION);

        // The newly created Vanilla CSS classes for the generic layout
        wp_enqueue_style('beecart-drawer-style', BEECART_URL . 'assets/css/cart-drawer.css', array(), BEECART_VERSION);
        wp_enqueue_script('beecart-script', BEECART_URL . 'assets/js/beecart.js', array('jquery'), BEECART_VERSION, true);
        wp_enqueue_script('alpine-collapse', 'https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js', array('beecart-script'), null, true);
        wp_enqueue_script('alpine-js', 'https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js', array('alpine-collapse'), null, true);

        wp_localize_script('beecart-script', 'beecartData', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('beecart-nonce'),
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
                array('threshold' => 50, 'label' => 'Free Shipping', 'icon' => 'truck'),
                array('threshold' => 100, 'label' => '20% Discount', 'icon' => 'tag'),
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
            'announcement_bg'             => '#fffbeb',
            'announcement_text_color'     => '#92400e',
            'announcement_font_size'      => '13px',
            'announcement_bar_size'       => 'medium',
            'enable_timer'                => false,
            'timer_duration'              => '0',
            'show_item_images'            => true,
            'show_savings'                => true,
            'trans_savings_prefix'        => 'Save',
            'show_upsells'                => true,
            'show_upsells_on_empty'       => true,
            'upsell_title'                => 'You might also like...',
            'upsell_max'                  => 3,
            'upsell_source'               => 'best_sellers',
            'upsell_category'             => '',
            'upsell_layout'               => 'list',
            'upsell_btn_text'             => 'Add to Cart',
            'show_trust_badges'           => true,
            'trust_badge_image'           => BEECART_URL . 'assets/img/payment-badge.svg',
            'custom_css'                  => '',
            'trans_checkout_btn'          => 'Checkout',
            'trans_view_cart_btn'         => 'View Cart',
            'trans_continue_shopping'     => 'Continue Shopping',
            'trans_empty_cart'            => 'Your cart is currently empty.',
            'trans_subtotal'              => 'Subtotal',
            'trans_coupon_placeholder'    => 'Coupon code',
            'trans_coupon_apply_btn'      => 'Apply',
            'trans_rewards_away'          => "You're only {amount} away from {goal}",
            'trans_discounts'             => 'Discounts',
            'trans_coupon_accordion_title' => 'Have a Coupon?',
            'show_shipping_notice'        => true,
            'shipping_notice_text'        => 'Shipping and taxes will be calculated at checkout.',
            'show_subtotal_on_checkout'   => true,
            'enable_total_line'           => true,
            'trans_total'                 => 'Total',
        );
    }

    public function get_settings()
    {
        return self::get_default_settings();
    }

    public function output_custom_css()
    {
        $settings = $this->get_settings();
        $custom_css = isset($settings['custom_css']) ? $settings['custom_css'] : '';
        if (! empty($custom_css)) {
            echo '<style id="beecart-custom-css">' . wp_strip_all_tags($custom_css) . '</style>';
        }
    }

    public function output_cart_drawer()
    {
        if (function_exists('is_cart') && is_cart()) return;
        if (function_exists('is_checkout') && is_checkout()) return;

        include BEECART_PATH . 'templates/cart-drawer.php';
    }

    public function ajax_get_cart()
    {
        check_ajax_referer('beecart-nonce', 'security');
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
        check_ajax_referer('beecart-nonce', 'security');
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
        check_ajax_referer('beecart-nonce', 'security');
        $coupon_code = sanitize_text_field($_POST['coupon']);

        if (! empty($coupon_code)) {
            WC()->cart->add_discount($coupon_code);
        }

        WC()->cart->calculate_totals();
        $this->ajax_get_cart();
    }

    public function ajax_remove_coupon()
    {
        check_ajax_referer('beecart-nonce', 'security');
        $coupon_code = sanitize_text_field($_POST['coupon']);

        if (! empty($coupon_code)) {
            WC()->cart->remove_coupon($coupon_code);
        }

        WC()->cart->calculate_totals();
        $this->ajax_get_cart();
    }

    public function ajax_add_to_cart()
    {
        check_ajax_referer('beecart-nonce', 'security');

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
        include BEECART_PATH . 'templates/cart-items.php';
    }

    public function cart_icon_shortcode()
    {
        ob_start();
        include BEECART_PATH . 'templates/cart-icon.php';
        return ob_get_clean();
    }
    public static function get_svg_icon($name, $class = '')
    {
        $icons = array(
            'truck' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="' . esc_attr($class) . '"><path d="M4.75 4.5a.75.75 0 0 0 0 1.5h3.25a1 1 0 0 1 0 2h-4.75a.75.75 0 0 0 0 1.5h3a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 0 0 1.5h.458a2.5 2.5 0 1 0 4.78.75h3.024a2.5 2.5 0 1 0 4.955-.153 1.75 1.75 0 0 0 1.033-1.597v-1.22a1.75 1.75 0 0 0-1.326-1.697l-1.682-.42a.25.25 0 0 1-.18-.174l-.426-1.494a2.75 2.75 0 0 0-2.645-1.995h-6.991Zm2.75 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" fill-rule="evenodd"></path></svg>',
            'tag' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="' . esc_attr($class) . '"><path d="M8.575 4.649a3.75 3.75 0 0 1 2.7-1.149h1.975a3.25 3.25 0 0 1 3.25 3.25v2.187a3.25 3.25 0 0 1-.996 2.34l-4.747 4.572a2.5 2.5 0 0 1-3.502-.033l-2.898-2.898a2.75 2.75 0 0 1-.036-3.852l4.254-4.417Zm4.425 3.351a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" fill-rule="evenodd"></path></svg>',
            'gift' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="' . esc_attr($class) . '"><path d="M7.835 9.5h-.96c-.343 0-.625-.28-.625-.628 0-.344.28-.622.619-.622.242 0 .463.142.563.363l.403.887Z"></path><path d="M10.665 9.5h.96c.343 0 .625-.28.625-.628 0-.344-.28-.622-.619-.622-.242 0-.463.142-.563.363l-.403.887Z"></path><path fill-rule="evenodd" d="M8.5 4h-3.25c-1.519 0-2.75 1.231-2.75 2.75v2.25h1.25c.414 0 .75.336.75.75s-.336.75-.75.75h-1.25v2.75c0 1.519 1.231 2.75 2.75 2.75h3.441c-.119-.133-.191-.308-.191-.5v-2c0-.414.336-.75.75-.75s.75.336.75.75v2c0 .192-.072.367-.191.5h4.941c1.519 0 2.75-1.231 2.75-2.75v-2.75h-2.75c-.414 0-.75-.336-.75-.75s.336-.75.75-.75h2.75v-2.25c0-1.519-1.231-2.75-2.75-2.75h-4.75v2.25c0 .414-.336.75-.75.75s-.75-.336-.75-.75v-2.25Zm.297 3.992c-.343-.756-1.097-1.242-1.928-1.242-1.173 0-2.119.954-2.119 2.122 0 1.171.95 2.128 2.125 2.128h.858c-.595.51-1.256.924-1.84 1.008-.41.058-.694.438-.635.848.058.41.438.695.848.636 1.11-.158 2.128-.919 2.803-1.53.121-.11.235-.217.341-.322.106.105.22.213.34.322.676.611 1.693 1.372 2.804 1.53.41.059.79-.226.848-.636.059-.41-.226-.79-.636-.848-.583-.084-1.244-.498-1.839-1.008h.858c1.176 0 2.125-.957 2.125-2.128 0-1.168-.946-2.122-2.119-2.122-.83 0-1.585.486-1.928 1.242l-.453.996-.453-.996Z"></path></svg>',
            'star' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star ' . esc_attr($class) . '"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>',
            'credit-card' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card ' . esc_attr($class) . '"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>',
            'check' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check ' . esc_attr($class) . '"><polyline points="20 6 9 17 4 12"></polyline></svg>',
            'shopping-bag' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag ' . esc_attr($class) . '"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>',
            'clock' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock ' . esc_attr($class) . '"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>',
            'image' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image ' . esc_attr($class) . '"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>',
            'format-image' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image ' . esc_attr($class) . '"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>',
            'chevron-down' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down ' . esc_attr($class) . '"><path d="m6 9 6 6 6-6"></path></svg>',
        );

        return isset($icons[$name]) ? $icons[$name] : '';
    }
}
