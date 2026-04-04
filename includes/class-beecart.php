<?php
if (! defined('ABSPATH')) {
    exit;
}

class BeeCart
{
    /** @var array|null In-request cache for settings. Cleared after save. */
    private static $_settings_cache = null;

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

        // Settings save — admin-only
        add_action('wp_ajax_beecart_save_settings', array($this, 'ajax_save_settings'));

        add_filter('wp_nav_menu_items', array($this, 'append_cart_icon_to_menu'), 10, 2);
        add_action('woocommerce_add_to_cart', array($this, 'set_just_added_cookie'), 10, 6);
    }

    public function set_just_added_cookie() {
        if (!wp_doing_ajax() && !headers_sent()) {
            setcookie('beecart_just_added', '1', time() + 30, '/');
        }
    }

    public function append_cart_icon_to_menu($items, $args)
    {
        $settings = $this->get_settings();
        $placement = $settings['menu_placement'] ?? 'none';

        if ($placement === 'none') {
            return $items;
        }

        // Try to match the menu slug
        $menu_slug = '';
        if (isset($args->menu) && is_object($args->menu)) {
            $menu_slug = $args->menu->slug;
        } elseif (isset($args->menu)) {
            $term = get_term_by('id', $args->menu, 'nav_menu');
            if ($term) {
                $menu_slug = $term->slug;
            }
        }

        // Also check if the 'placement' matches the 'theme_location'
        if ($menu_slug === $placement || (isset($args->theme_location) && $args->theme_location === $placement)) {
            $items .= '<li class="menu-item beecart-menu-item">' . $this->cart_icon_shortcode() . '</li>';
        }

        return $items;
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
        
        // Priority loading: Enqueue in header with defer strategy for best performance
        wp_enqueue_script('beecart-script', BEECART_URL . 'assets/js/beecart.js', array('jquery'), BEECART_VERSION, array(
            'strategy' => 'defer',
        ));

        wp_localize_script('beecart-script', 'beecartData', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('beecart-nonce'),
            'settings' => $this->get_settings()
        ));
    }

    public static function get_default_settings()
    {
        return array(
            'enable_cart_drawer'          => false,
            'auto_open_cart'              => true,
            'menu_placement'              => 'bottom',
            'progress_bars'               => array(
                array(
                    'type'           => 'subtotal',
                    'away_text'      => "You're only {amount} away from {goal}",
                    'completed_text' => '🎉 Congratulations! You have unlocked all rewards.',
                    'show_labels'    => true,
                    'checkpoints'    => array(
                        array('threshold' => '50', 'label' => 'Free Shipping', 'icon' => 'truck'),
                        array('threshold' => '100', 'label' => '10% Discount', 'icon' => 'tag'),
                    ),
                )
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
            'rewards_bars_layout'         => 'column',
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
            'cart_bubble_bg'              => '#000000',
            'cart_bubble_text'            => '#ffffff',
            'show_cart_count'             => true,
            'cart_title'                  => 'Your Cart',
            'show_announcement'           => false,
            'announcement_text'           => 'Your products are reserved for {timer}!',
            'announcement_bg'             => '#fffbeb',
            'announcement_text_color'     => '#92400e',
            'announcement_font_size'      => '13px',
            'announcement_bar_size'       => 'medium',
            'timer_duration'              => '15',
            'show_item_images'            => true,
            'show_savings'                => true,
            'trans_savings_prefix'        => 'Save',
            'show_upsells'                => true,
            'show_upsells_on_empty'       => true,
            'upsell_title'                => 'You might also like...',
            'upsell_max'                  => 3,
            'upsell_source'               => 'best_sellers',
            'upsell_category'             => '',
            'upsell_btn_text'             => 'Add to Cart',
            'show_trust_badges'           => true,
            'trust_badge_image'           => BEECART_URL . 'assets/img/payment-badge.svg',
            'custom_css'                  => '',
            'trans_checkout_btn'          => 'Checkout',
            'trans_continue_shopping'     => 'Continue Shopping',
            'trans_empty_cart'            => 'Your cart is currently empty.',
            'trans_subtotal'              => 'Subtotal',
            'trans_coupon_placeholder'    => 'Coupon code',
            'trans_coupon_apply_btn'      => 'Apply',
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
        // Static class-level cache: only one DB call per PHP request
        if (self::$_settings_cache !== null) {
            return self::$_settings_cache;
        }

        $saved    = get_option('beecart_settings', array());
        $defaults = self::get_default_settings();

        // wp_parse_args ensures new default keys appear for existing users automatically
        self::$_settings_cache = wp_parse_args($saved, $defaults);

        return self::$_settings_cache;
    }

    public function output_custom_css()
    {
        $settings   = $this->get_settings();
        $custom_css = isset($settings['custom_css']) ? $settings['custom_css'] : '';
        if (! empty($custom_css)) {
            // Strip any attempt to break out of the <style> block (XSS prevention)
            $safe_css = preg_replace('/<\s*\/?\s*style[^>]*>/i', '', $custom_css);
            $safe_css = wp_strip_all_tags($safe_css);
            echo '<style id="beecart-custom-css">' . $safe_css . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }

    public function output_cart_drawer()
    {
        $settings = $this->get_settings();
        if (! ($settings['enable_cart_drawer'] ?? false)) {
            return;
        }

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
        
        if (! isset($_POST['cart_item_key'])) {
            wp_send_json_error();
        }

        $cart_item_key = sanitize_text_field(wp_unslash($_POST['cart_item_key']));
        $quantity      = isset($_POST['quantity']) ? absint(wp_unslash($_POST['quantity'])) : 0;
        
        // Ensure cart is loaded
        if (!WC()->cart) {
            wp_send_json_error();
        }

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
        $coupon_code = isset($_POST['coupon']) ? sanitize_text_field(wp_unslash($_POST['coupon'])) : '';

        if (! empty($coupon_code)) {
            WC()->cart->apply_coupon($coupon_code);
        }

        WC()->cart->calculate_totals();
        $this->ajax_get_cart();
    }

    public function ajax_remove_coupon()
    {
        check_ajax_referer('beecart-nonce', 'security');
        $coupon_code = isset($_POST['coupon']) ? sanitize_text_field(wp_unslash($_POST['coupon'])) : '';

        if (! empty($coupon_code)) {
            WC()->cart->remove_coupon($coupon_code);
        }

        WC()->cart->calculate_totals();
        $this->ajax_get_cart();
    }

    public function ajax_add_to_cart()
    {
        check_ajax_referer('beecart-nonce', 'security');

        $product_id   = isset($_POST['product_id']) ? absint(wp_unslash($_POST['product_id'])) : (isset($_POST['add-to-cart']) ? absint(wp_unslash($_POST['add-to-cart'])) : 0);
        $quantity     = empty($_POST['quantity']) ? 1 : absint(wp_unslash($_POST['quantity']));
        $variation_id = isset($_POST['variation_id']) ? absint(wp_unslash($_POST['variation_id'])) : '';

        $variation = array();
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'attribute_') === 0) {
                $variation[$key] = wc_clean($value);
            }
        }

        $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variation); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound

        if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variation)) {
            if (isset($_POST['add-to-cart'])) {
                // If it came from a standard form, we might need to trigger this to help other plugins
                do_action('woocommerce_ajax_added_to_cart', $product_id); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
            }
            $this->ajax_get_cart();
        } else {
            wp_send_json_error(array('error' => true));
        }
    }

    // -------------------------------------------------------------------------
    // Settings: Save, Sanitize
    // -------------------------------------------------------------------------

    public function ajax_save_settings()
    {
        // 1. Verify admin nonce
        check_ajax_referer('beecart-admin-nonce', 'security');

        // 2. Verify capability
        if (! current_user_can('manage_options')) {
            wp_send_json_error(__('Unauthorized.', 'beecart'), 403);
        }

        // 3. Decode JSON payload from JS
        $raw = isset($_POST['settings']) ? wp_unslash($_POST['settings']) : '{}'; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
        $data = json_decode($raw, true);

        if (! is_array($data)) {
            wp_send_json_error(__('Invalid settings data.', 'beecart'));
        }

        // 4. Sanitize every field
        $clean = $this->sanitize_settings($data);

        // 5. Persist — autoload=false: only loaded when BeeCart needs them
        update_option('beecart_settings', $clean, false);

        // 6. Clear static cache so next get_settings() call reads fresh data
        self::$_settings_cache = null;

        wp_send_json_success(__('Settings saved.', 'beecart'));
    }

    private function sanitize_settings(array $raw): array
    {
        $defaults = self::get_default_settings();
        $allowed  = array_keys($defaults);
        $clean    = array();

        $bool_keys = [
            'enable_cart_drawer', 'auto_open_cart', 'enable_coupon',
            'enable_badges', 'enable_rewards_bar', 'show_rewards_on_empty',
            'inherit_fonts', 'show_strikethrough', 'enable_subtotal_line',
            'show_announcement', 'show_item_images',
            'show_savings', 'show_upsells', 'show_upsells_on_empty',
            'show_trust_badges', 'show_cart_count', 'show_shipping_notice',
            'show_subtotal_on_checkout', 'enable_total_line',
        ];

        $color_keys = [
            'primary_color', 'bg_color', 'accent_color', 'text_color',
            'savings_text_color', 'btn_color', 'btn_text_color',
            'btn_hover_color', 'btn_hover_text_color', 'cart_icon_color',
            'cart_bubble_bg', 'cart_bubble_text', 'rewards_bar_bg',
            'rewards_bar_fg', 'rewards_complete_icon_color',
            'rewards_incomplete_icon_color', 'announcement_bg',
            'announcement_text_color',
        ];

        $int_keys = ['upsell_max', 'cart_icon_size', 'timer_duration'];
        $url_keys = ['trust_badge_image'];

        foreach ($allowed as $key) {
            if (! array_key_exists($key, $raw)) {
                continue; // leave missing keys to wp_parse_args defaults
            }

            if (in_array($key, $bool_keys, true)) {
                $clean[$key] = (bool) $raw[$key];
            } elseif (in_array($key, $color_keys, true)) {
                $val = sanitize_hex_color((string) $raw[$key]);
                if ($val) {
                    $clean[$key] = $val;
                }
            } elseif (in_array($key, $int_keys, true)) {
                $clean[$key] = absint($raw[$key]);
            } elseif (in_array($key, $url_keys, true)) {
                $clean[$key] = esc_url_raw((string) $raw[$key]);
            } elseif ($key === 'progress_bars') {
                $clean[$key] = $this->sanitize_progress_bars($raw[$key]);
            } elseif ($key === 'custom_css') {
                $safe = preg_replace('/<\s*\/?\s*style[^>]*>/i', '', (string) $raw[$key]);
                $clean[$key] = wp_strip_all_tags($safe);
            } elseif ($key === 'rewards_bars_layout') {
                $layout = (string)$raw[$key];
                $clean[$key] = in_array($layout, ['row', 'column'], true) ? $layout : 'column';
            } else {
                $clean[$key] = sanitize_text_field((string) $raw[$key]);
            }
        }

        return $clean;
    }

    private function sanitize_progress_bars($input): array
    {
        $sanitized = array();
        if (is_array($input)) {
            foreach ($input as $bar) {
                $sanitized_bar = array(
                    'type'           => isset($bar['type']) ? sanitize_text_field($bar['type']) : 'subtotal',
                    'away_text'      => isset($bar['away_text']) ? sanitize_text_field($bar['away_text']) : '',
                    'completed_text' => isset($bar['completed_text']) ? sanitize_text_field($bar['completed_text']) : '',
                    'show_labels'    => isset($bar['show_labels']) ? (bool) $bar['show_labels'] : true,
                    'checkpoints'    => array()
                );

                if (isset($bar['checkpoints']) && is_array($bar['checkpoints'])) {
                    foreach ($bar['checkpoints'] as $checkpoint) {
                        $sanitized_bar['checkpoints'][] = array(
                            'threshold' => isset($checkpoint['threshold']) ? sanitize_text_field($checkpoint['threshold']) : '0',
                            'label'     => isset($checkpoint['label']) ? sanitize_text_field($checkpoint['label']) : '',
                            'icon'      => isset($checkpoint['icon']) ? sanitize_text_field($checkpoint['icon']) : 'truck',
                        );
                    }
                }
                $sanitized[] = $sanitized_bar;
            }
        }
        return $sanitized;
    }

    private function get_cart_upsell_cache_key(array $cart_items, string $upsell_source, int $upsell_max, string $upsell_category): string
    {
        $cart_signature = array();

        foreach ($cart_items as $cart_item) {
            $product_id = isset($cart_item['product_id']) ? (int) $cart_item['product_id'] : 0;
            $variation_id = isset($cart_item['variation_id']) ? (int) $cart_item['variation_id'] : 0;
            $cart_signature[] = $product_id . ':' . $variation_id;
        }

        sort($cart_signature, SORT_STRING);

        return 'bc_upsells_' . md5(wp_json_encode(array(
            'cart' => $cart_signature,
            'source' => $upsell_source,
            'max' => $upsell_max,
            'category' => $upsell_category,
        )));
    }

    private function collect_product_relation_ids(array $cart_items, string $relation): array
    {
        $collected_ids = array();

        foreach ($cart_items as $cart_item) {
            if (empty($cart_item['data']) || ! is_object($cart_item['data'])) {
                continue;
            }

            $product = $cart_item['data'];
            $relation_ids = array();

            if ($relation === 'upsells') {
                $relation_ids = $product->get_upsell_ids();
            } elseif ($relation === 'cross_sells') {
                $relation_ids = $product->get_cross_sell_ids();
            }

            foreach ($relation_ids as $relation_id) {
                $relation_id = (int) $relation_id;
                if ($relation_id > 0) {
                    $collected_ids[$relation_id] = $relation_id;
                }
            }
        }

        return array_values($collected_ids);
    }

    private function collect_related_product_ids(array $cart_items, int $limit): array
    {
        $related_ids = array();

        foreach ($cart_items as $cart_item) {
            $product_id = isset($cart_item['product_id']) ? (int) $cart_item['product_id'] : 0;
            if ($product_id <= 0) {
                continue;
            }

            $product_related_ids = wc_get_related_products($product_id, $limit);
            foreach ($product_related_ids as $related_id) {
                $related_id = (int) $related_id;
                if ($related_id > 0) {
                    $related_ids[$related_id] = $related_id;
                }
            }
        }

        return array_values($related_ids);
    }

    public function get_upsell_query_ids(array $cart_items, string $upsell_source, int $upsell_max, string $upsell_category = ''): array
    {
        if ($upsell_max < 1) {
            return array();
        }

        $cache_key = $this->get_cart_upsell_cache_key($cart_items, $upsell_source, $upsell_max, $upsell_category);
        $upsell_query_ids = get_transient($cache_key);

        if (false !== $upsell_query_ids && is_array($upsell_query_ids)) {
            return $upsell_query_ids;
        }

        $excluded_ids = array();
        foreach ($cart_items as $cart_item) {
            $product_id = isset($cart_item['product_id']) ? (int) $cart_item['product_id'] : 0;
            if ($product_id > 0) {
                $excluded_ids[$product_id] = $product_id;
            }
        }
        $excluded_ids = array_values($excluded_ids);

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $upsell_max,
            'post_status' => 'publish',
            'fields' => 'ids',
            'post__not_in' => $excluded_ids,
            'no_found_rows' => true,
            'ignore_sticky_posts' => true,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'cache_results' => true,
        );

        if ($upsell_source === 'best_sellers') {
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        } elseif ($upsell_source === 'newest') {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        } elseif ($upsell_source === 'category' && ! empty($upsell_category)) {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $upsell_category,
                ),
            );
        } elseif ($upsell_source === 'upsells') {
            $upsell_ids = $this->collect_product_relation_ids($cart_items, 'upsells');
            if (! empty($upsell_ids)) {
                $args['post__in'] = $upsell_ids;
                $args['orderby'] = 'post__in';
            } else {
                $args['meta_key'] = 'total_sales';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
            }
        } elseif ($upsell_source === 'cross_sells') {
            $cross_sell_ids = $this->collect_product_relation_ids($cart_items, 'cross_sells');
            if (! empty($cross_sell_ids)) {
                $args['post__in'] = $cross_sell_ids;
                $args['orderby'] = 'post__in';
            } else {
                $args['meta_key'] = 'total_sales';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
            }
        } elseif ($upsell_source === 'related') {
            $related_ids = array_slice($this->collect_related_product_ids($cart_items, $upsell_max), 0, $upsell_max);
            if (! empty($related_ids)) {
                $args['post__in'] = $related_ids;
                $args['orderby'] = 'post__in';
            } else {
                $args['meta_key'] = 'total_sales';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
            }
        } else {
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
            $args['order'] = 'DESC';
        }

        $query = new WP_Query($args);
        $upsell_query_ids = is_array($query->posts) ? $query->posts : array();

        set_transient($cache_key, $upsell_query_ids, 600);

        return $upsell_query_ids;
    }

    // -------------------------------------------------------------------------

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
            'bag-1'        => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>',
            'bag-2'        => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path><circle cx="12" cy="14" r="2" stroke-width="2"></circle></svg>',
            'cart'         => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
            'basket'       => '<svg xmlns="http://www.w3.org/2000/svg" class="' . esc_attr($class) . '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18l-2 9H5l-2-9zm6-5h6l3 5H6l3-5z"></path></svg>',
        );

        return isset($icons[$name]) ? $icons[$name] : '';
    }
}
