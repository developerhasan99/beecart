<?php
if (! defined('ABSPATH')) {
    exit;
}

$cart = WC()->cart;
if (!$cart) return;

// Ensure totals are calculated so discounts and subtotals are accurate
$cart->calculate_totals();

$settings = $this->get_settings();

$is_empty = $cart->is_empty();

$enable_rewards_bar   = $settings['enable_rewards_bar'] ?? true;
$text_color           = $settings['text_color'] ?? '#000000';
$show_item_images      = $settings['show_item_images'] ?? true;
$show_strikethrough    = $settings['show_strikethrough'] ?? true;
$show_savings          = $settings['show_savings'] ?? true;
$savings_color         = $settings['savings_text_color'] ?? '#1DC200';
$savings_prefix        = $settings['trans_savings_prefix'] ?? 'Save';
$btn_color             = $settings['btn_color'] ?? '#000000';
$btn_text_color        = $settings['btn_text_color'] ?? '#FFFFFF';
$btn_radius            = $settings['btn_radius'] ?? '4px';
$show_upsells          = $settings['show_upsells'] ?? true;

$enable_coupon          = $settings['enable_coupon'] ?? true;
$enable_subtotal_line   = $settings['enable_subtotal_line'] ?? true;
$accent_color           = $settings['accent_color'] ?? '#f6f6f7';
$btn_hover_color        = $settings['btn_hover_color'] ?? '#333333';
$btn_hover_text_color   = $settings['btn_hover_text_color'] ?? '#FFFFFF';
$bg_color               = $settings['bg_color'] ?? '#FFFFFF';
$show_trust_badges      = $settings['show_trust_badges'] ?? true;
?>

<div class="bc-cart-contents-scroll">
    <?php
    $progress_bars = $settings['progress_bars'] ?? array();
    if ($enable_rewards_bar && !empty($progress_bars) && (!$is_empty || ($settings['show_rewards_on_empty'] ?? true))):
    ?>
        <div class="bc-rewards-bars-wrap" style="flex-direction: <?php echo esc_attr($settings['rewards_bars_layout'] ?? 'column'); ?>;">
            <?php foreach ($progress_bars as $bar):
                $type = $bar['type'] ?? 'subtotal';
                $current_val = ($type === 'quantity') ? $cart->get_cart_contents_count() : (float)$cart->get_subtotal();
                $goals = !empty($bar['checkpoints']) ? $bar['checkpoints'] : array();

                // Sort goals by threshold
                usort($goals, function ($a, $b) {
                    return (float)$a['threshold'] - (float)$b['threshold'];
                });

                $next_goal = null;
                foreach ($goals as $goal) {
                    if ($current_val < (float)$goal['threshold']) {
                        $next_goal = $goal;
                        break;
                    }
                }

                $max_threshold = !empty($goals) ? (float)end($goals)['threshold'] : 100;
                $percent = $max_threshold > 0 ? min(($current_val / $max_threshold) * 100, 100) : 100;

                if (empty($goals)) continue;
            ?>
                <div class="bc-progress-wrap">
                    <div class="bc-progress-text" style="color: <?php echo esc_attr($text_color); ?>;">
                        <?php if ($next_goal):
                            $diff = (float)$next_goal['threshold'] - $current_val;
                            $amount_text = ($type === 'subtotal') ? wc_price($diff) : (int)$diff;
                            $msg = $bar['away_text'] ?? "You're only {amount} away from {goal}";
                            $msg = str_replace('{amount}', '<strong>' . $amount_text . '</strong>', $msg);
                            $msg = str_replace('{goal}', '<strong>' . esc_html($next_goal['label']) . '</strong>', $msg);
                            echo $msg;
                        else: ?>
                            <?php echo esc_html($bar['completed_text'] ?? '🎉 Congratulations! You have unlocked all rewards.'); ?>
                        <?php endif; ?>
                    </div>

                    <div class="bc-progress-bar" style="background-color: <?php echo esc_attr($settings['rewards_bar_bg'] ?? '#E2E2E2'); ?>; margin-bottom: <?php echo ($bar['show_labels'] ?? true) ? '24px' : '0'; ?>;">
                        <div class="bc-progress-fill" style="width: <?php echo esc_attr($percent); ?>%; background-color: <?php echo esc_attr($settings['rewards_bar_fg'] ?? '#93D3FF'); ?>;"></div>

                        <div class="bc-checkpoints">
                            <?php foreach ($goals as $goal):
                                $goal_val = (float)$goal['threshold'];
                                $reached = $current_val >= $goal_val;
                                $pos = ($goal_val / $max_threshold) * 100;
                                $icon_key = $goal['icon'] ?? 'truck';
                            ?>
                                <div class="bc-checkpoint <?php echo $reached ? 'is-reached' : ''; ?>"
                                    style="left: <?php echo esc_attr($pos); ?>%; 
                                       background-color: <?php echo $reached ? esc_attr($settings['rewards_bar_fg'] ?? '#93D3FF') : esc_attr($settings['rewards_bar_bg'] ?? '#E2E2E2'); ?>;
                                       color: <?php echo $reached ? esc_attr($settings['rewards_complete_icon_color'] ?? '#4D4949') : esc_attr($settings['rewards_incomplete_icon_color'] ?? '#4D4949'); ?>;">
                                    <?php echo BeeCart::get_svg_icon($icon_key, 'bc-checkpoint-icon'); ?>
                                    <?php if ($bar['show_labels'] ?? true): ?>
                                        <div class="bc-checkpoint-label" style="color: <?php echo esc_attr($text_color); ?>;">
                                            <?php echo esc_html($goal['label']); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!$is_empty): ?>
        <div class="bc-item-list">
            <?php foreach ($cart->get_cart() as $cart_item_key => $cart_item):
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                if ($_product && $_product->exists() && $cart_item['quantity'] > 0) {
                    $product_name  = $_product->get_name();
                    $thumbnail_id  = $_product->get_image_id();
                    $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'thumbnail');
                    $item_qty = (int)$cart_item['quantity'];
                    $unit_display_price = (float)$cart_item['line_total'] / $item_qty;
                    $unit_regular_price = (float)$_product->get_regular_price();

                    $product_price = wc_price($unit_display_price);
                    $regular_price = $unit_regular_price;
                    $has_sale = $unit_regular_price > $unit_display_price;
                    $item_data = wc_get_formatted_cart_item_data($cart_item);
                    $product_url   = $_product->get_permalink();
            ?>
                    <div class="bc-item">
                        <?php if ($show_item_images !== false): ?>
                            <a href="<?php echo esc_url($product_url); ?>" class="bc-item-img-wrap">
                                <?php if ($thumbnail_url): ?>
                                    <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($product_name); ?>" />
                                <?php else: ?>
                                    <?php echo BeeCart::get_svg_icon('format-image', 'bc-placeholder-icon'); ?>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>

                        <div class="bc-item-details">
                            <button class="bc-item-remove" data-key="<?php echo esc_attr($cart_item_key); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash">
                                    <path d="M3 6h18"></path>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                    <path d="M8 6V4c0-.5.2-1 .6-1h6c.4 0 .6.5.6 1v2"></path>
                                </svg>
                            </button>

                            <a href="<?php echo esc_url($product_url); ?>" style="text-decoration: none;">
                                <h4 class="bc-item-title" style="color: <?php echo esc_attr($text_color); ?>;"><?php echo esc_html($product_name); ?></h4>
                            </a>
                            <?php
                            if ($item_data):
                                echo '<div class="bc-item-meta">' . wp_kses_post($item_data) . '</div>';
                            elseif ($_product->is_type('variation')):
                                $variation_data = $_product->get_variation_attributes();
                                if (!empty($variation_data)):
                                    echo '<div class="bc-item-meta">';
                                    $meta_parts = array();
                                    foreach ($variation_data as $key => $value):
                                        $label = wc_attribute_label(str_replace('attribute_', '', $key), $_product);
                                        $meta_parts[] = esc_html($label) . ': ' . esc_html($value);
                                    endforeach;
                                    echo implode(', ', $meta_parts);
                                    echo '</div>';
                                endif;
                            endif;
                            ?>

                            <div class="bc-item-prices">
                                <?php if ($has_sale && $show_strikethrough !== false): ?>
                                    <span class="bc-item-old-price"><?php echo wc_price($regular_price); ?></span>
                                <?php endif; ?>
                                <span class="bc-item-price" style="color: <?php echo esc_attr($text_color); ?>;"><?php echo $product_price; ?></span>
                                <?php if ($show_savings && $has_sale):
                                    $discount = (float)$regular_price - $unit_display_price;
                                    if ($discount > 0):
                                ?>
                                        <span class="bc-item-price" style="font-size: 13px; color: <?php echo esc_attr($savings_color); ?>;">
                                            (<?php echo esc_html($savings_prefix); ?> <?php echo wc_price($discount * $cart_item['quantity']); ?>)
                                        </span>
                                <?php endif;
                                endif; ?>
                            </div>

                            <div class="bc-item-bottom">
                                <div class="bc-qty-wrap">
                                    <button class="bc-qty-btn minus" data-key="<?php echo esc_attr($cart_item_key); ?>" data-qty="<?php echo (int) $cart_item['quantity'] - 1; ?>">-</button>
                                    <span class="bc-qty-val"><?php echo esc_html($cart_item['quantity']); ?></span>
                                    <button class="bc-qty-btn plus" data-key="<?php echo esc_attr($cart_item_key); ?>" data-qty="<?php echo (int) $cart_item['quantity'] + 1; ?>">+</button>
                                </div>

                                <?php
                                $applied_coupons = WC()->cart->get_applied_coupons();
                                if (!empty($applied_coupons)): ?>
                                    <div class="bc-item-coupons">
                                        <?php foreach ($applied_coupons as $coupon_code): ?>
                                            <div class="bc-item-discount-badge">
                                                <?php echo BeeCart::get_svg_icon('tag', 'bc-badge-icon'); ?>
                                                <span class="bc-badge-text"><?php echo esc_html(strtoupper($coupon_code)); ?></span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            endforeach; ?>
        </div>
    <?php else: ?>
        <div class="bc-empty-cart">
            <svg class="bc-empty-cart-icon" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <p class="bc-empty-cart-text" style="color: <?php echo esc_attr($text_color); ?>;"><?php echo esc_html($settings['trans_empty_cart'] ?? 'Your cart is empty.'); ?></p>
            <button class="bc-empty-cart-btn"
                style="background-color: <?php echo esc_attr($btn_color); ?>; color: <?php echo esc_attr($btn_text_color); ?>; border-radius: <?php echo esc_attr($btn_radius); ?>;">
                <?php echo esc_html($settings['trans_continue_shopping'] ?? 'Return to shop'); ?>
            </button>
        </div>
    <?php endif; ?>

    <?php
    $show_on_empty = $settings['show_upsells_on_empty'] ?? true;
    if ($show_upsells && (!$is_empty || $show_on_empty)):

        $upsell_title = $settings['upsell_title'] ?? 'Product Recommendations';
        $upsell_max = $settings['upsell_max'] ?? 3;
        $upsell_source   = $settings['upsell_source'] ?? 'best_sellers';
        $upsell_category = $settings['upsell_category'] ?? '';

        // Simple cache: Cache the query ID list for this session/request
        // Since AJAX runs in its own thread, we use a simple transient or session-based cache key
        $cart_ids_hash = md5(json_encode(array_keys(WC()->cart->get_cart())));
        $cache_key = 'bc_upsells_' . $cart_ids_hash . '_' . $upsell_source . '_' . $upsell_max;

        $upsell_query_ids = get_transient($cache_key);

        if (false === $upsell_query_ids) {
            $excluded_ids = array();
            foreach (WC()->cart->get_cart() as $cart_item) {
                $excluded_ids[] = $cart_item['product_id'];
            }
            $excluded_ids = array_filter(array_unique($excluded_ids));

            $args = array(
                'post_type'      => 'product',
                'posts_per_page' => $upsell_max,
                'post_status'    => 'publish',
                'fields'         => 'ids',
                'post__not_in'   => $excluded_ids
            );

            if ($upsell_source === 'best_sellers') {
                $args['meta_key'] = 'total_sales';
                $args['orderby']  = 'meta_value_num';
                $args['order']    = 'DESC';
            } elseif ($upsell_source === 'newest') {
                $args['orderby'] = 'date';
                $args['order']   = 'DESC';
            } elseif ($upsell_source === 'category' && !empty($upsell_category)) {
                $args['orderby'] = 'date';
                $args['order']   = 'DESC';
                $args['tax_query'] = array(array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $upsell_category,
                ));
            } elseif ($upsell_source === 'upsells') {
                $upsell_ids = array();
                foreach (WC()->cart->get_cart() as $cart_item) {
                    $_p = $cart_item['data'];
                    if ($_p) {
                        $upsell_ids = array_merge($upsell_ids, $_p->get_upsell_ids());
                    }
                }
                $upsell_ids = array_unique($upsell_ids);
                if (!empty($upsell_ids)) {
                    $args['post__in'] = $upsell_ids;
                    $args['orderby']  = 'post__in';
                } else {
                    $args['meta_key'] = 'total_sales';
                    $args['orderby']  = 'meta_value_num';
                    $args['order']    = 'DESC';
                }
            } elseif ($upsell_source === 'cross_sells') {
                $cross_sell_ids = array();
                foreach (WC()->cart->get_cart() as $cart_item) {
                    $_p = $cart_item['data'];
                    if ($_p) {
                        $cross_sell_ids = array_merge($cross_sell_ids, $_p->get_cross_sell_ids());
                    }
                }
                $cross_sell_ids = array_unique($cross_sell_ids);
                if (!empty($cross_sell_ids)) {
                    $args['post__in'] = $cross_sell_ids;
                    $args['orderby']  = 'post__in';
                } else {
                    $args['meta_key'] = 'total_sales';
                    $args['orderby']  = 'meta_value_num';
                    $args['order']    = 'DESC';
                }
            } elseif ($upsell_source === 'related') {
                $related_ids = array();
                foreach (WC()->cart->get_cart() as $cart_item) {
                    $related_ids = array_merge($related_ids, wc_get_related_products($cart_item['product_id'], $upsell_max));
                }
                $related_ids = array_unique($related_ids);
                if (!empty($related_ids)) {
                    $args['post__in'] = array_slice($related_ids, 0, $upsell_max);
                    $args['orderby']  = 'post__in';
                } else {
                    $args['meta_key'] = 'total_sales';
                    $args['orderby']  = 'meta_value_num';
                    $args['order']    = 'DESC';
                }
            } else {
                $args['meta_key'] = 'total_sales';
                $args['orderby']  = 'meta_value_num';
                $args['order']    = 'DESC';
            }

            $query = new WP_Query($args);
            $upsell_query_ids = $query->posts;
            set_transient($cache_key, $upsell_query_ids, 600); // 10 minutes cache
        }

        $upsell_query = new WP_Query(array(
            'post_type' => 'product',
            'post__in'  => !empty($upsell_query_ids) ? $upsell_query_ids : array(0),
            'orderby'   => 'post__in',
            'posts_per_page' => $upsell_max,
        ));

        if ($upsell_query->have_posts()):
    ?>
            <div class="bc-upsells" style="background-color: <?php echo esc_attr($settings['accent_color'] ?? '#f9fafb'); ?>;">
                <h3 class="bc-upsells-title" style="color: <?php echo esc_attr($text_color); ?>;"><?php echo esc_html($upsell_title); ?></h3>

                <div class="bc-upsells-list">
                    <?php while ($upsell_query->have_posts()): $upsell_query->the_post();
                        global $product;
                        $img = wp_get_attachment_image_url($product->get_image_id(), 'thumbnail');

                        $prices_json = '';
                        if ($product->is_type('variable')) {
                            $p_map = array();
                            foreach ($product->get_available_variations() as $v) {
                                $p_map[$v['variation_id']] = strip_tags(wc_price($v['display_price']));
                            }
                            $prices_json = esc_attr(json_encode($p_map));
                        }
                    ?>
                        <div class="bc-upsell-item" data-id="<?php echo get_the_ID(); ?>" <?php if ($prices_json) echo 'data-prices="' . $prices_json . '"'; ?>>
                            <div class="bc-upsell-img-wrap">
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="bc-upsell-link">
                                    <?php if ($img): ?>
                                        <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                    <?php else: ?>
                                        <?php echo BeeCart::get_svg_icon('format-image', 'bc-placeholder-icon'); ?>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="bc-upsell-details">
                                <h5 class="bc-upsell-title">
                                    <a href="<?php echo esc_url(get_permalink()); ?>" style="color: <?php echo esc_attr($text_color); ?>; text-decoration: none;">
                                        <?php the_title(); ?>
                                    </a>
                                </h5>
                                <div class="bc-upsell-prices">
                                    <span class="bc-upsell-price" style="color: <?php echo esc_attr($text_color); ?>;">
                                        <?php echo $product->get_price_html(); ?>
                                    </span>
                                </div>
                                <div class="bc-upsell-actions">
                                    <?php if ($product->is_type('variable')):
                                        $product_variations = $product->get_available_variations();
                                        if (!empty($product_variations)):
                                    ?>
                                            <div class="bc-upsell-select-wrap">
                                                <select class="bc-upsell-select" data-product-id="<?php echo get_the_ID(); ?>">
                                                    <?php foreach ($product_variations as $v): ?>
                                                        <option value="<?php echo esc_attr($v['variation_id']); ?>">
                                                            <?php echo esc_html(implode(' / ', array_values($v['attributes']))); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span class="bc-upsell-select-icon">
                                                    <?php echo BeeCart::get_svg_icon('chevron-down'); ?>
                                                </span>
                                            </div>
                                    <?php endif;
                                    endif; ?>
                                    <button class="bc-upsell-add"
                                        onmouseenter="this.style.backgroundColor = '<?php echo esc_attr($btn_hover_color); ?>'; this.style.color = '<?php echo esc_attr($btn_hover_text_color); ?>'"
                                        onmouseleave="this.style.backgroundColor = '<?php echo esc_attr($btn_color); ?>'; this.style.color = '<?php echo esc_attr($btn_text_color); ?>'"
                                        style="background-color: <?php echo esc_attr($btn_color); ?>; color: <?php echo esc_attr($btn_text_color); ?>; border-radius: <?php echo esc_attr($btn_radius); ?>;"
                                        data-id="<?php echo get_the_ID(); ?>">
                                        <?php echo esc_html($settings['upsell_btn_text'] ?? 'Add'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

</div><!-- end bc-cart-contents-scroll -->
<!-- Fixed Footer Area -->
<?php if (!$is_empty): ?>
    <div class="bc-drawer-footer" style="background-color: <?php echo esc_attr($bg_color); ?>; margin-top: auto;">
        <?php if ($enable_coupon): ?>
            <div class="bc-coupon-accordion">
                <button type="button" class="bc-coupon-toggle" style="color: <?php echo esc_attr($text_color); ?>;">
                    <span><?php echo esc_html($settings['trans_coupon_accordion_title'] ?? 'Have a Coupon?'); ?></span>
                    <span class="bc-coupon-toggle-icon">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg>
                    </span>
                </button>
                <div class="bc-coupon-accordion-content" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                    <div class="bc-coupon-wrap">
                        <input type="text" placeholder="<?php echo esc_attr($settings['trans_coupon_placeholder'] ?? 'Coupon code'); ?>" class="bc-coupon-input">
                        <button class="bc-coupon-btn"
                            style="background-color: <?php echo esc_attr($accent_color); ?>; color: <?php echo esc_attr($text_color); ?>; border-radius: <?php echo esc_attr($btn_radius); ?>">
                            <?php echo esc_html($settings['trans_coupon_apply_btn'] ?? 'Apply'); ?>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($enable_subtotal_line): ?>
            <div class="bc-summary-row" style="color: <?php echo esc_attr($text_color); ?>;">
                <span><?php echo esc_html($settings['trans_subtotal'] ?? 'Subtotal'); ?></span>
                <span class="val-wrap"><?php echo $cart->get_cart_subtotal(); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($cart->get_discount_total() > 0): ?>
            <div class="bc-summary-row" style="color: <?php echo esc_attr($text_color); ?>;">
                <div class="label-wrap">
                    <span><?php echo esc_html(($settings['trans_discounts'] ?? 'Discounts') . ':'); ?></span>
                    <?php if ($applied_coupons = $cart->get_applied_coupons()): ?>
                        <?php foreach ($applied_coupons as $coupon_code): ?>
                            <div class="bc-summary-discount-badge">
                                <span class="bc-summary-badge-text"><?php echo esc_html(strtoupper($coupon_code)); ?></span>
                                <span class="bc-badge-remove" data-code="<?php echo esc_js($coupon_code); ?>">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 6 6 18" />
                                        <path d="m6 6 12 12" />
                                    </svg>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <span class="val-wrap bc-discount-val">- <?php echo wc_price($cart->get_discount_total()); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($settings['enable_total_line'] ?? true): ?>
            <div class="bc-summary-row bc-total-row" style="color: <?php echo esc_attr($text_color); ?>;">
                <span><?php echo esc_html($settings['trans_total'] ?? 'Total'); ?></span>
                <span class="val-wrap"><?php echo $cart->get_total(); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($settings['show_shipping_notice'] ?? true): ?>
            <div class="bc-shipping-notice" style="color: <?php echo esc_attr($text_color); ?>;">
                <?php echo esc_html($settings['shipping_notice_text'] ?? 'Shipping and taxes will be calculated at checkout.'); ?>
            </div>
        <?php endif; ?>

        <div class="bc-checkout-btn-wrap">
            <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="bc-checkout-btn"
                onmouseenter="this.style.backgroundColor = '<?php echo esc_attr($btn_hover_color); ?>'; this.style.color = '<?php echo esc_attr($btn_hover_text_color); ?>'"
                onmouseleave="this.style.backgroundColor = '<?php echo esc_attr($btn_color); ?>'; this.style.color = '<?php echo esc_attr($btn_text_color); ?>'"
                style="background-color: <?php echo esc_attr($btn_color); ?>; color: <?php echo esc_attr($btn_text_color); ?>; border-radius: <?php echo esc_attr($btn_radius); ?>;">
                <span><?php echo esc_html($settings['trans_checkout_btn'] ?? 'Zur Kasse'); ?></span>
                <?php if ($settings['show_subtotal_on_checkout'] ?? true): ?>
                    <span class="bc-checkout-sep">•</span>
                    <span><?php echo $cart->get_total(); ?></span>
                <?php endif; ?>
            </a>
        </div>

        <!-- Trust Badges -->
        <?php if ($show_trust_badges):
            $trust_badge_image = $settings['trust_badge_image'] ?? '';
            if ($trust_badge_image):
        ?>
                <div class="bc-trust-badges">
                    <img src="<?php echo esc_url($trust_badge_image); ?>" alt="Trust badges">
                </div>
        <?php endif;
        endif; ?>
    </div>
<?php endif; ?>