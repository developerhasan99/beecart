<?php
if (! defined('ABSPATH')) {
    exit;
}

$cart = WC()->cart;
if (!$cart) return;

$settings = $this->get_settings();

$is_empty = $cart->is_empty();

// Setup Progress Bar goals logic
$current_val = ($settings['progress_type'] ?? 'subtotal') === 'quantity' ? $cart->get_cart_contents_count() : (float)$cart->get_subtotal();
$goals = !empty($settings['goals']) ? $settings['goals'] : array();
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

// Setup generic settings
$text_color = $settings['text_color'] ?? '#000000';
$bg_color = $settings['bg_color'] ?? '#FFFFFF';
$accent_color = $settings['accent_color'] ?? '#f6f6f7';
$btn_color = $settings['btn_color'] ?? '#000000';
$btn_text_color = $settings['btn_text_color'] ?? '#FFFFFF';
$btn_hover_color = $settings['btn_hover_color'] ?? '#333333';
$btn_hover_text_color = $settings['btn_hover_text_color'] ?? '#e9e9e9';
$btn_radius = $settings['btn_radius'] ?? '4px';

$enable_rewards_bar = $settings['enable_rewards_bar'] ?? true;
$show_savings = $settings['show_savings'] ?? true;
$savings_prefix = $settings['trans_savings_prefix'] ?? 'Save';
$show_item_images = $settings['show_item_images'] ?? true;
$show_strikethrough = $settings['show_strikethrough'] ?? true;
$savings_color = $settings['savings_text_color'] ?? '#2ea818';
$enable_coupon = $settings['enable_coupon'] ?? true;
$enable_subtotal_line = $settings['enable_subtotal_line'] ?? true;
$show_trust_badges = $settings['show_trust_badges'] ?? true;
$show_upsells = $settings['show_upsells'] ?? true;
?>

<!-- Scrollable Inner Content Area -->
<?php if ($enable_rewards_bar && (!$is_empty || ($settings['show_rewards_on_empty'] ?? true))): ?>
    <?php if (!empty($goals)): ?>
        <div class="bc-progress-wrap">
            <div class="bc-progress-text" style="color: <?php echo esc_attr($text_color); ?>;">
                <?php if ($next_goal):
                    $amount_text = ($settings['progress_type'] ?? 'subtotal') === 'subtotal' ? wc_price((float)$next_goal['threshold'] - $current_val) : (int)((float)$next_goal['threshold'] - $current_val);
                    $msg = $settings['trans_rewards_away'] ?? "You're only {amount} away from {goal}";
                    $msg = str_replace('{amount}', '<strong>' . $amount_text . '</strong>', $msg);
                    $msg = str_replace('{goal}', '<strong>' . esc_html($next_goal['label']) . '</strong>', $msg);
                    echo $msg;
                else: ?>
                    <?php echo esc_html($settings['rewards_completed_text'] ?? '🎉 Congratulations! You have unlocked all rewards.'); ?>
                <?php endif; ?>
            </div>

            <div class="bc-progress-bar" style="background-color: <?php echo esc_attr($settings['rewards_bar_bg'] ?? '#E2E2E2'); ?>;">
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
                            <div class="bc-checkpoint-label" style="color: <?php echo esc_attr($text_color); ?>;">
                                <?php echo esc_html($goal['label']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
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
                        <button class="bc-item-remove" @click.prevent="updateItem('<?php echo esc_attr($cart_item_key); ?>', 0)">
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
                                <button class="bc-qty-btn minus" @click.prevent="updateItem('<?php echo esc_attr($cart_item_key); ?>', <?php echo (int) $cart_item['quantity'] - 1; ?>)">-</button>
                                <span class="bc-qty-val"><?php echo esc_html($cart_item['quantity']); ?></span>
                                <button class="bc-qty-btn plus" @click.prevent="updateItem('<?php echo esc_attr($cart_item_key); ?>', <?php echo (int) $cart_item['quantity'] + 1; ?>)">+</button>
                            </div>

                            <!-- TODO: test the coupon and the badge on the frontend -->
                            <?php
                            $applied_coupons = WC()->cart->get_applied_coupons();
                            if (!empty($applied_coupons)): ?>
                                <div class="bc-item-coupons">
                                    <?php foreach ($applied_coupons as $coupon_code): ?>
                                        <div class="bc-coupon-badge">
                                            <?php echo BeeCart::get_svg_icon('tag', 'bc-badge-icon'); ?>
                                            <span><?php echo esc_html(strtoupper($coupon_code)); ?></span>
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

    <?php if ($show_upsells):
        $upsell_title = $settings['upsell_title'] ?? 'Diese werden Sie lieben';
        $upsell_max = $settings['upsell_max'] ?? 3;
        $upsell_source = $settings['upsell_source'] ?? 'random';
        $args = array('post_type' => 'product', 'posts_per_page' => $upsell_max, 'status' => 'publish');
        if ($upsell_source === 'best_sellers') {
            $args['meta_key'] = 'total_sales';
            $args['orderby'] = 'meta_value_num';
        } elseif ($upsell_source === 'newest') {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        } else {
            $args['orderby'] = 'rand';
        }
        $upsell_query = new WP_Query($args);
        if ($upsell_query->have_posts()):
    ?>
            <div class="bc-upsells">
                <div class="bc-upsells-divider"></div>
                <h3 class="bc-upsells-title" style="color: <?php echo esc_attr($text_color); ?>;"><?php echo esc_html($upsell_title); ?></h3>

                <div class="bc-upsells-list">
                    <?php while ($upsell_query->have_posts()): $upsell_query->the_post();
                        global $product;
                        $img = wp_get_attachment_image_url($product->get_image_id(), 'thumbnail');
                    ?>
                        <div class="bc-upsell-item" style="background-color: <?php echo esc_attr($settings['accent_color'] ?? '#f9fafb'); ?>;">
                            <div class="bc-upsell-img-wrap">
                                <?php if ($img): ?>
                                    <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                <?php else: ?>
                                    <?php echo BeeCart::get_svg_icon('format-image', 'bc-placeholder-icon'); ?>
                                <?php endif; ?>
                            </div>
                            <div class="bc-upsell-details">
                                <h5 class="bc-upsell-title" style="color: <?php echo esc_attr($text_color); ?>;"><?php the_title(); ?></h5>
                                <div class="bc-upsell-prices">
                                    <span class="bc-upsell-price" style="color: <?php echo esc_attr($text_color); ?>;"><?php echo $product->get_price_html(); ?></span>
                                </div>
                                <div class="bc-upsell-actions">
                                    <button class="bc-upsell-add"
                                        style="background-color: <?php echo esc_attr($btn_color); ?>; color: <?php echo esc_attr($btn_text_color); ?>; border-radius: <?php echo esc_attr($btn_radius); ?>;"
                                        @click.prevent="addUpsell(<?php echo get_the_ID(); ?>)">
                                        <?php echo esc_html($settings['upsell_btn_text'] ?? 'Add'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            </div>
    <?php endif;
    endif; ?>

<?php else: ?>
    <div class="bc-empty-cart">
        <svg class="bc-empty-cart-icon" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
        <p class="bc-empty-cart-text" style="color: <?php echo esc_attr($text_color); ?>;"><?php echo esc_html($settings['trans_empty_cart'] ?? 'Your cart is empty.'); ?></p>
        <button class="bc-empty-cart-btn"
            style="background-color: <?php echo esc_attr($btn_color); ?>; color: <?php echo esc_attr($btn_text_color); ?>; border-radius: <?php echo esc_attr($btn_radius); ?>;"
            @click.prevent="closeCart()">
            <?php echo esc_html($settings['trans_continue_shopping'] ?? 'Return to shop'); ?>
        </button>
    </div>
<?php endif; ?>

<!-- Fixed Footer Area -->
<?php if (!$is_empty): ?>
    </div> <!-- Make the footer part of the cart flow, wait, cartHtml injects straight into a flex body... we must ensure footer is below it. Actually, wait! The cart-drawer expects cartHtml to have `<style="display:contents">` but the scrollable area is `.bc-drawer-body`. So if I leave the footer outside the list but inside `cartHtml`, it needs negative margins? No, `bc-drawer-body` is flex column. The items will sit in it. The footer can just be standard blocks inside. Oh! I changed `bc-drawer-body` to padding: 20px 24px. So I should un-pad the drawer body and manually pad the contents, OR keep it as is. Let's just create a custom `bc-drawer-footer` wrapper. -->

    <div class="bc-drawer-footer" style="background-color: <?php echo esc_attr($bg_color); ?>; margin-top: auto;">

        <?php if ($enable_coupon): ?>
            <div class="bc-coupon-wrap">
                <input type="text" x-ref="couponCode" placeholder="<?php echo esc_attr($settings['trans_coupon_placeholder'] ?? 'Coupon code'); ?>" class="bc-coupon-input">
                <button class="bc-coupon-btn"
                    style="background-color: <?php echo esc_attr($accent_color); ?>; color: <?php echo esc_attr($text_color); ?>; border-radius: <?php echo esc_attr($btn_radius); ?>"
                    @click.prevent="applyCoupon($refs.couponCode.value)">
                    <?php echo esc_html($settings['trans_coupon_apply_btn'] ?? 'Apply'); ?>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($cart->get_total_discount() > 0): ?>
            <div class="bc-summary-row" style="color: <?php echo esc_attr($text_color); ?>;">
                <div class="label-wrap">
                    <span><?php echo esc_html($settings['trans_savings'] ?? 'Discounts'); ?></span>
                </div>
                <span class="val-wrap">- <?php echo wc_price($cart->get_total_discount()); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($enable_subtotal_line): ?>
            <div class="bc-summary-row" style="color: <?php echo esc_attr($text_color); ?>;">
                <span><?php echo esc_html($settings['trans_subtotal'] ?? 'Subtotal'); ?></span>
                <span class="val-wrap"><?php echo $cart->get_cart_subtotal(); ?></span>
            </div>
        <?php endif; ?>

        <div class="bc-checkout-btn-wrap">
            <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="bc-checkout-btn"
                @mouseenter="$event.target.style.backgroundColor = '<?php echo esc_attr($btn_hover_color); ?>'; $event.target.style.color = '<?php echo esc_attr($btn_hover_text_color); ?>'"
                @mouseleave="$event.target.style.backgroundColor = '<?php echo esc_attr($btn_color); ?>'; $event.target.style.color = '<?php echo esc_attr($btn_text_color); ?>'"
                style="background-color: <?php echo esc_attr($btn_color); ?>; color: <?php echo esc_attr($btn_text_color); ?>; border-radius: <?php echo esc_attr($btn_radius); ?>;">
                <span><?php echo esc_html($settings['trans_checkout_btn'] ?? 'Zur Kasse'); ?></span>
                <span class="bc-checkout-sep">•</span>
                <span><?php echo $cart->get_total(); ?></span>
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