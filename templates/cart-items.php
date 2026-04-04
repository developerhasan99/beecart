<?php
if (! defined('ABSPATH')) {
    exit;
}

$beecart_cart = WC()->cart;
if (!$beecart_cart) return;

// Ensure totals are calculated so discounts and subtotals are accurate
$beecart_cart->calculate_totals();

$beecart_settings = $this->get_settings();

$beecart_is_empty = $beecart_cart->is_empty();
$beecart_items = $beecart_cart->get_cart();

$beecart_enable_rewards_bar   = $beecart_settings['enable_rewards_bar'] ?? true;
$beecart_text_color           = $beecart_settings['text_color'] ?? '#000000';
$beecart_show_item_images      = $beecart_settings['show_item_images'] ?? true;
$beecart_show_strikethrough    = $beecart_settings['show_strikethrough'] ?? true;
$beecart_show_savings          = $beecart_settings['show_savings'] ?? true;
$beecart_savings_color         = $beecart_settings['savings_text_color'] ?? '#1DC200';
$beecart_savings_prefix        = $beecart_settings['trans_savings_prefix'] ?? 'Save';
$beecart_btn_color             = $beecart_settings['btn_color'] ?? '#000000';
$beecart_btn_text_color        = $beecart_settings['btn_text_color'] ?? '#FFFFFF';
$beecart_btn_radius            = $beecart_settings['btn_radius'] ?? '4px';
$beecart_show_upsells          = $beecart_settings['show_upsells'] ?? true;

$beecart_enable_coupon          = $beecart_settings['enable_coupon'] ?? true;
$beecart_enable_subtotal_line   = $beecart_settings['enable_subtotal_line'] ?? true;
$beecart_accent_color           = $beecart_settings['accent_color'] ?? '#f6f6f7';
$beecart_btn_hover_color        = $beecart_settings['btn_hover_color'] ?? '#333333';
$beecart_btn_hover_text_color   = $beecart_settings['btn_hover_text_color'] ?? '#FFFFFF';
$beecart_bg_color               = $beecart_settings['bg_color'] ?? '#FFFFFF';
$beecart_show_trust_badges      = $beecart_settings['show_trust_badges'] ?? true;
?>

<div class="bc-cart-contents-scroll">
    <?php
    $beecart_progress_bars = $beecart_settings['progress_bars'] ?? array();
    if ($beecart_enable_rewards_bar && !empty($beecart_progress_bars) && (!$beecart_is_empty || ($beecart_settings['show_rewards_on_empty'] ?? true))):
    ?>
        <div class="bc-rewards-bars-wrap" style="flex-direction: <?php echo esc_attr($beecart_settings['rewards_bars_layout'] ?? 'column'); ?>;">
            <?php foreach ($beecart_progress_bars as $beecart_bar):
                $beecart_type = $beecart_bar['type'] ?? 'subtotal';
                $beecart_current_val = ($beecart_type === 'quantity') ? $beecart_cart->get_cart_contents_count() : (float)$beecart_cart->get_subtotal();
                $beecart_goals = !empty($beecart_bar['checkpoints']) ? $beecart_bar['checkpoints'] : array();

                // Sort goals by threshold
                usort($beecart_goals, function ($a, $b) {
                    return (float)$a['threshold'] - (float)$b['threshold'];
                });

                $beecart_next_goal = null;
                foreach ($beecart_goals as $beecart_goal) {
                    if ($beecart_current_val < (float)$beecart_goal['threshold']) {
                        $beecart_next_goal = $beecart_goal;
                        break;
                    }
                }

                $beecart_max_threshold = !empty($beecart_goals) ? (float)end($beecart_goals)['threshold'] : 100;
                $beecart_percent = $beecart_max_threshold > 0 ? min(($beecart_current_val / $beecart_max_threshold) * 100, 100) : 100;

                if (empty($beecart_goals)) continue;
            ?>
                <div class="bc-progress-wrap">
                    <div class="bc-progress-text" style="color: <?php echo esc_attr($beecart_text_color); ?>;">
                        <?php if ($beecart_next_goal):
                            $beecart_diff = (float)$beecart_next_goal['threshold'] - $beecart_current_val;
                            $beecart_amount_text = ($beecart_type === 'subtotal') ? wc_price($beecart_diff) : (int)$beecart_diff;
                            $beecart_msg = $beecart_bar['away_text'] ?? "You're only {amount} away from {goal}";
                            $beecart_msg = str_replace('{amount}', '<strong>' . $beecart_amount_text . '</strong>', $beecart_msg);
                            $beecart_msg = str_replace('{goal}', '<strong>' . esc_html($beecart_next_goal['label']) . '</strong>', $beecart_msg);
                            echo wp_kses_post($beecart_msg);
                        else: ?>
                            <?php echo esc_html($beecart_bar['completed_text'] ?? '🎉 Congratulations! You have unlocked all rewards.'); ?>
                        <?php endif; ?>
                    </div>

                    <div class="bc-progress-bar" style="background-color: <?php echo esc_attr($beecart_settings['rewards_bar_bg'] ?? '#E2E2E2'); ?>; margin-bottom: <?php echo ($beecart_bar['show_labels'] ?? true) ? '24px' : '0'; ?>;">
                        <div class="bc-progress-fill" style="width: <?php echo esc_attr($beecart_percent); ?>%; background-color: <?php echo esc_attr($beecart_settings['rewards_bar_fg'] ?? '#93D3FF'); ?>;"></div>

                        <div class="bc-checkpoints">
                            <?php foreach ($beecart_goals as $beecart_goal):
                                $beecart_goal_val = (float)$beecart_goal['threshold'];
                                $beecart_reached = $beecart_current_val >= $beecart_goal_val;
                                $beecart_pos = ($beecart_goal_val / $beecart_max_threshold) * 100;
                                $beecart_icon_key = $beecart_goal['icon'] ?? 'truck';
                            ?>
                                <div class="bc-checkpoint <?php echo $beecart_reached ? 'is-reached' : ''; ?>"
                                    style="left: <?php echo esc_attr($beecart_pos); ?>%; 
                                       background-color: <?php echo $beecart_reached ? esc_attr($beecart_settings['rewards_bar_fg'] ?? '#93D3FF') : esc_attr($beecart_settings['rewards_bar_bg'] ?? '#E2E2E2'); ?>;
                                       color: <?php echo $beecart_reached ? esc_attr($beecart_settings['rewards_complete_icon_color'] ?? '#4D4949') : esc_attr($beecart_settings['rewards_incomplete_icon_color'] ?? '#4D4949'); ?>;">
                                    <?php echo wp_kses_post(BeeCart::get_svg_icon($beecart_icon_key, 'bc-checkpoint-icon')); ?>
                                    <?php if ($beecart_bar['show_labels'] ?? true): ?>
                                        <div class="bc-checkpoint-label" style="color: <?php echo esc_attr($beecart_text_color); ?>;">
                                            <?php echo esc_html($beecart_goal['label']); ?>
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

    <?php if (!$beecart_is_empty): ?>
        <div class="bc-item-list">
            <?php foreach ($beecart_cart->get_cart() as $beecart_cart_item_key => $beecart_cart_item):
                $beecart_product_obj = apply_filters('woocommerce_cart_item_product', $beecart_cart_item['data'], $beecart_cart_item, $beecart_cart_item_key);
                if ($beecart_product_obj && $beecart_product_obj->exists() && $beecart_cart_item['quantity'] > 0) {
                    $beecart_product_name  = $beecart_product_obj->get_name();
                    $beecart_thumbnail_id  = $beecart_product_obj->get_image_id();
                    $beecart_thumbnail_url = wp_get_attachment_image_url($beecart_thumbnail_id, 'thumbnail');
                    $beecart_item_qty = (int)$beecart_cart_item['quantity'];
                    $beecart_unit_display_price = (float)$beecart_cart_item['line_total'] / $beecart_item_qty;
                    $beecart_unit_regular_price = (float)$beecart_product_obj->get_regular_price();

                    $beecart_product_price = wc_price($beecart_unit_display_price);
                    $beecart_regular_price = $beecart_unit_regular_price;
                    $beecart_has_sale = $beecart_unit_regular_price > $beecart_unit_display_price;
                    $beecart_item_data = wc_get_formatted_cart_item_data($beecart_cart_item);
                    $beecart_product_url   = $beecart_product_obj->get_permalink();
            ?>
                    <div class="bc-item">
                        <?php if ($beecart_show_item_images !== false): ?>
                            <a href="<?php echo esc_url($beecart_product_url); ?>" class="bc-item-img-wrap">
                                <?php if ($beecart_thumbnail_url): ?>
                                    <img src="<?php echo esc_url($beecart_thumbnail_url); ?>" alt="<?php echo esc_attr($beecart_product_name); ?>" />
                                <?php else: ?>
                                    <?php echo wp_kses_post(BeeCart::get_svg_icon('format-image', 'bc-placeholder-icon')); ?>
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>

                        <div class="bc-item-details">
                            <button class="bc-item-remove" data-key="<?php echo esc_attr($beecart_cart_item_key); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash">
                                    <path d="M3 6h18"></path>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                    <path d="M8 6V4c0-.5.2-1 .6-1h6c.4 0 .6.5.6 1v2"></path>
                                </svg>
                            </button>

                            <a href="<?php echo esc_url($beecart_product_url); ?>" style="text-decoration: none;">
                                <h4 class="bc-item-title" style="color: <?php echo esc_attr($beecart_text_color); ?>;"><?php echo esc_html($beecart_product_name); ?></h4>
                            </a>
                            <?php
                            if ($beecart_item_data):
                                echo '<div class="bc-item-meta">' . wp_kses_post($beecart_item_data) . '</div>';
                            elseif ($beecart_product_obj->is_type('variation')):
                                $beecart_variation_data = $beecart_product_obj->get_variation_attributes();
                                if (!empty($beecart_variation_data)):
                                    echo '<div class="bc-item-meta">';
                                    $beecart_meta_parts = array();
                                    foreach ($beecart_variation_data as $beecart_key => $beecart_value):
                                        $beecart_label = wc_attribute_label(str_replace('attribute_', '', $beecart_key), $beecart_product_obj);
                                        $beecart_meta_parts[] = esc_html($beecart_label) . ': ' . esc_html($beecart_value);
                                    endforeach;
                                    echo wp_kses_post(implode(', ', $beecart_meta_parts));
                                    echo '</div>';
                                endif;
                            endif;
                            ?>

                            <div class="bc-item-prices">
                                <?php if ($beecart_has_sale && $beecart_show_strikethrough !== false): ?>
                                    <span class="bc-item-old-price"><?php echo wp_kses_post(wc_price($beecart_regular_price)); ?></span>
                                <?php endif; ?>
                                <span class="bc-item-price" style="color: <?php echo esc_attr($beecart_text_color); ?>;"><?php echo wp_kses_post($beecart_product_price); ?></span>
                                <?php if ($beecart_show_savings && $beecart_has_sale):
                                    $beecart_discount_amount = (float)$beecart_regular_price - $beecart_unit_display_price;
                                    if ($beecart_discount_amount > 0):
                                ?>
                                        <span class="bc-item-price" style="font-size: 13px; color: <?php echo esc_attr($beecart_savings_color); ?>;">
                                            (<?php echo esc_html($beecart_savings_prefix); ?> <?php echo wp_kses_post(wc_price($beecart_discount_amount * $beecart_cart_item['quantity'])); ?>)
                                        </span>
                                <?php endif;
                                endif; ?>
                            </div>

                            <div class="bc-item-bottom">
                                <div class="bc-qty-wrap">
                                    <button class="bc-qty-btn minus" data-key="<?php echo esc_attr($beecart_cart_item_key); ?>" data-qty="<?php echo (int) $beecart_cart_item['quantity'] - 1; ?>">-</button>
                                    <span class="bc-qty-val"><?php echo esc_html($beecart_cart_item['quantity']); ?></span>
                                    <button class="bc-qty-btn plus" data-key="<?php echo esc_attr($beecart_cart_item_key); ?>" data-qty="<?php echo (int) $beecart_cart_item['quantity'] + 1; ?>">+</button>
                                </div>

                                <?php
                                $beecart_applied_coupons = WC()->cart->get_applied_coupons();
                                if (!empty($beecart_applied_coupons)): ?>
                                    <div class="bc-item-coupons">
                                        <?php foreach ($beecart_applied_coupons as $beecart_coupon_code): ?>
                                            <div class="bc-item-discount-badge">
                                                <?php echo wp_kses_post(BeeCart::get_svg_icon('tag', 'bc-badge-icon')); ?>
                                                <span class="bc-badge-text"><?php echo esc_html(strtoupper($beecart_coupon_code)); ?></span>
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
            <p class="bc-empty-cart-text" style="color: <?php echo esc_attr($beecart_text_color); ?>;"><?php echo esc_html($beecart_settings['trans_empty_cart'] ?? 'Your cart is empty.'); ?></p>
            <button class="bc-empty-cart-btn"
                style="background-color: <?php echo esc_attr($beecart_btn_color); ?>; color: <?php echo esc_attr($beecart_btn_text_color); ?>; border-radius: <?php echo esc_attr($beecart_btn_radius); ?>;">
                <?php echo esc_html($beecart_settings['trans_continue_shopping'] ?? 'Return to shop'); ?>
            </button>
        </div>
    <?php endif; ?>

    <?php
    $beecart_show_on_empty = $beecart_settings['show_upsells_on_empty'] ?? true;
    if ($beecart_show_upsells && (!$beecart_is_empty || $beecart_show_on_empty)):
        $beecart_upsell_title = $beecart_settings['upsell_title'] ?? 'Product Recommendations';
        $beecart_upsell_max = max(1, (int) ($beecart_settings['upsell_max'] ?? 3));
        $beecart_upsell_source   = $beecart_settings['upsell_source'] ?? 'best_sellers';
        $beecart_upsell_category = $beecart_settings['upsell_category'] ?? '';
        $beecart_upsell_query_ids = $this->get_upsell_query_ids(
            is_array($beecart_items) ? $beecart_items : array(),
            $beecart_upsell_source,
            $beecart_upsell_max,
            $beecart_upsell_category
        );

        $beecart_upsell_query = new WP_Query(array(
            'post_type' => 'product',
            'post__in'  => !empty($beecart_upsell_query_ids) ? $beecart_upsell_query_ids : array(0),
            'orderby'   => 'post__in',
            'posts_per_page' => $beecart_upsell_max,
            'no_found_rows' => true,
            'ignore_sticky_posts' => true,
        ));

        if ($beecart_upsell_query->have_posts()):
    ?>
            <div class="bc-upsells" style="background-color: <?php echo esc_attr($beecart_settings['accent_color'] ?? '#f9fafb'); ?>;">
                <h3 class="bc-upsells-title" style="color: <?php echo esc_attr($beecart_text_color); ?>;"><?php echo esc_html($beecart_upsell_title); ?></h3>

                <div class="bc-upsells-list">
                    <?php while ($beecart_upsell_query->have_posts()): $beecart_upsell_query->the_post();
                        global $product;
                        $beecart_upsell_img = wp_get_attachment_image_url($product->get_image_id(), 'thumbnail');

                        $beecart_prices_json = '';
                        $beecart_product_variations = array();
                        if ($product->is_type('variable')) {
                            $beecart_p_map = array();
                            $beecart_product_variations = $product->get_available_variations();
                            foreach ($beecart_product_variations as $beecart_v) {
                                $beecart_p_map[$beecart_v['variation_id']] = wp_strip_all_tags(wc_price($beecart_v['display_price']));
                            }
                            $beecart_prices_json = esc_attr(wp_json_encode($beecart_p_map));
                        }
                    ?>
                        <div class="bc-upsell-item" data-id="<?php echo esc_attr(get_the_ID()); ?>" <?php if ($beecart_prices_json) echo 'data-prices="' . $beecart_prices_json . '"'; ?>>
                            <div class="bc-upsell-img-wrap">
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="bc-upsell-link">
                                    <?php if ($beecart_upsell_img): ?>
                                        <img src="<?php echo esc_url($beecart_upsell_img); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                    <?php else: ?>
                                        <?php echo wp_kses_post(BeeCart::get_svg_icon('format-image', 'bc-placeholder-icon')); ?>
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="bc-upsell-details">
                                <h5 class="bc-upsell-title">
                                    <a href="<?php echo esc_url(get_permalink()); ?>" style="color: <?php echo esc_attr($beecart_text_color); ?>; text-decoration: none;">
                                        <?php the_title(); ?>
                                    </a>
                                </h5>
                                <div class="bc-upsell-prices">
                                    <span class="bc-upsell-price" style="color: <?php echo esc_attr($beecart_text_color); ?>;">
                                        <?php echo wp_kses_post($product->get_price_html()); ?>
                                    </span>
                                </div>
                                <div class="bc-upsell-actions">
                                    <?php if ($product->is_type('variable')):
                                        if (!empty($beecart_product_variations)):
                                    ?>
                                            <div class="bc-upsell-select-wrap">
                                                <select class="bc-upsell-select" data-product-id="<?php echo esc_attr(get_the_ID()); ?>">
                                                    <?php foreach ($beecart_product_variations as $beecart_v): ?>
                                                        <option value="<?php echo esc_attr($beecart_v['variation_id']); ?>">
                                                            <?php echo esc_html(implode(' / ', array_values($beecart_v['attributes']))); ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <span class="bc-upsell-select-icon">
                                                    <?php echo wp_kses_post(BeeCart::get_svg_icon('chevron-down')); ?>
                                                </span>
                                            </div>
                                    <?php endif;
                                    endif; ?>
                                    <button class="bc-upsell-add"
                                        onmouseenter="this.style.backgroundColor = '<?php echo esc_attr($beecart_btn_hover_color); ?>'; this.style.color = '<?php echo esc_attr($beecart_btn_hover_text_color); ?>'"
                                        onmouseleave="this.style.backgroundColor = '<?php echo esc_attr($beecart_btn_color); ?>'; this.style.color = '<?php echo esc_attr($beecart_btn_text_color); ?>'"
                                        style="background-color: <?php echo esc_attr($beecart_btn_color); ?>; color: <?php echo esc_attr($beecart_btn_text_color); ?>; border-radius: <?php echo esc_attr($beecart_btn_radius); ?>;"
                                        data-id="<?php echo esc_attr(get_the_ID()); ?>">
                                        <?php echo esc_html($beecart_settings['upsell_btn_text'] ?? 'Add'); ?>
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
<?php if (!$beecart_is_empty): ?>
    <div class="bc-drawer-footer" style="background-color: <?php echo esc_attr($beecart_bg_color); ?>; margin-top: auto;">
        <?php if ($beecart_enable_coupon): ?>
            <div class="bc-coupon-accordion">
                <button type="button" class="bc-coupon-toggle" style="color: <?php echo esc_attr($beecart_text_color); ?>;">
                    <span><?php echo esc_html($beecart_settings['trans_coupon_accordion_title'] ?? 'Have a Coupon?'); ?></span>
                    <span class="bc-coupon-toggle-icon">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg>
                    </span>
                </button>
                <div class="bc-coupon-accordion-content" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
                    <div class="bc-coupon-wrap">
                        <input type="text" placeholder="<?php echo esc_attr($beecart_settings['trans_coupon_placeholder'] ?? 'Coupon code'); ?>" class="bc-coupon-input">
                        <button class="bc-coupon-btn"
                            style="background-color: <?php echo esc_attr($beecart_accent_color); ?>; color: <?php echo esc_attr($beecart_text_color); ?>; border-radius: <?php echo esc_attr($beecart_btn_radius); ?>">
                            <?php echo esc_html($beecart_settings['trans_coupon_apply_btn'] ?? 'Apply'); ?>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($beecart_enable_subtotal_line): ?>
            <div class="bc-summary-row" style="color: <?php echo esc_attr($beecart_text_color); ?>;">
                <span><?php echo esc_html($beecart_settings['trans_subtotal'] ?? 'Subtotal'); ?></span>
                <span class="val-wrap"><?php echo wp_kses_post($beecart_cart->get_cart_subtotal()); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($beecart_cart->get_discount_total() > 0): ?>
            <div class="bc-summary-row" style="color: <?php echo esc_attr($beecart_text_color); ?>;">
                <div class="label-wrap">
                    <span><?php echo esc_html(($beecart_settings['trans_discounts'] ?? 'Discounts') . ':'); ?></span>
                    <?php if ($beecart_applied_coupons_footer = $beecart_cart->get_applied_coupons()): ?>
                        <?php foreach ($beecart_applied_coupons_footer as $beecart_coupon_code): ?>
                            <div class="bc-summary-discount-badge">
                                <span class="bc-summary-badge-text"><?php echo esc_html(strtoupper($beecart_coupon_code)); ?></span>
                                <span class="bc-badge-remove" data-code="<?php echo esc_js($beecart_coupon_code); ?>">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M18 6 6 18" />
                                        <path d="m6 6 12 12" />
                                    </svg>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <span class="val-wrap bc-discount-val">- <?php echo wp_kses_post(wc_price($beecart_cart->get_discount_total())); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($beecart_settings['enable_total_line'] ?? true): ?>
            <div class="bc-summary-row bc-total-row" style="color: <?php echo esc_attr($beecart_text_color); ?>;">
                <span><?php echo esc_html($beecart_settings['trans_total'] ?? 'Total'); ?></span>
                <span class="val-wrap"><?php echo wp_kses_post($beecart_cart->get_total()); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($beecart_settings['show_shipping_notice'] ?? true): ?>
            <div class="bc-shipping-notice" style="color: <?php echo esc_attr($beecart_text_color); ?>;">
                <?php echo esc_html($beecart_settings['shipping_notice_text'] ?? 'Shipping and taxes will be calculated at checkout.'); ?>
            </div>
        <?php endif; ?>

        <div class="bc-checkout-btn-wrap">
            <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="bc-checkout-btn"
                onmouseenter="this.style.backgroundColor = '<?php echo esc_attr($beecart_btn_hover_color); ?>'; this.style.color = '<?php echo esc_attr($beecart_btn_hover_text_color); ?>'"
                onmouseleave="this.style.backgroundColor = '<?php echo esc_attr($beecart_btn_color); ?>'; this.style.color = '<?php echo esc_attr($beecart_btn_text_color); ?>'"
                style="background-color: <?php echo esc_attr($beecart_btn_color); ?>; color: <?php echo esc_attr($beecart_btn_text_color); ?>; border-radius: <?php echo esc_attr($beecart_btn_radius); ?>;">
                <span><?php echo esc_html($beecart_settings['trans_checkout_btn'] ?? 'Zur Kasse'); ?></span>
                <?php if ($beecart_settings['show_subtotal_on_checkout'] ?? true): ?>
                    <span class="bc-checkout-sep">•</span>
                    <span><?php echo wp_kses_post($beecart_cart->get_total()); ?></span>
                <?php endif; ?>
            </a>
        </div>

        <!-- Trust Badges -->
        <?php if ($beecart_show_trust_badges):
            $beecart_trust_badge_image = $beecart_settings['trust_badge_image'] ?? '';
            if ($beecart_trust_badge_image):
        ?>
                <div class="bc-trust-badges">
                    <img src="<?php echo esc_url($beecart_trust_badge_image); ?>" alt="Trust badges">
                </div>
        <?php endif;
        endif; ?>
    </div>
<?php endif; ?>
