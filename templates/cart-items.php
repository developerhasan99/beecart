<?php
if (! defined('ABSPATH')) {
    exit;
}

$cart = WC()->cart;
if (!$cart) return;

$settings = get_option('bee_cart_settings', array(
    'progress_type' => 'subtotal',
    'goals' => array(
        array('threshold' => 50, 'label' => 'Free Shipping', 'icon' => 'truck'),
        array('threshold' => 100, 'label' => '20% Discount', 'icon' => 'tag')
    ),
    'primary_color' => '#000000',
    'enable_coupon' => true,
    'enable_badges' => true
));

$icons_map = array(
    'truck' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>',
    'tag' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>',
    'gift' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 12 20 22 4 22 4 12"></polyline><rect x="2" y="7" width="20" height="5"></rect><line x1="12" y1="22" x2="12" y2="7"></line><path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path><path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path></svg>',
    'star' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>',
    'credit-card' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>',
    'check' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>',
    'shopping-bag' => '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>',
);

$is_empty = $cart->is_empty();
$current_val = $settings['progress_type'] === 'quantity' ? $cart->get_cart_contents_count() : (float)$cart->get_subtotal();

// Find next unreached goal
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

$p_color = !empty($settings['primary_color']) ? $settings['primary_color'] : '#000000';
?>

<style>
    :root {
        --bee-cart-progress-fill: <?php echo esc_attr($p_color); ?>;
        --bee-cart-progress-bg: #f1f5f9;
        --bee-cart-primary: <?php echo esc_attr($p_color); ?>;
        --bee-cart-text-mut: #64748b;
    }

    .bee-cart-btn-primary {
        background-color: var(--bee-cart-primary);
        color: #fff;
    }
</style>

<?php if (!$is_empty): ?>
    <!-- Progress Bar Section -->
    <?php if (!empty($goals)): ?>
        <div class="bee-cart-progress-container">
            <div class="bee-cart-progress-message">
                <?php if ($next_goal): ?>
                    You're only <strong><?php echo $settings['progress_type'] === 'subtotal' ? wc_price((float)$next_goal['threshold'] - $current_val) : (int)((float)$next_goal['threshold'] - $current_val) . ' items'; ?></strong> away from <strong><?php echo esc_html($next_goal['label']); ?></strong>
                <?php else: ?>
                    🎉 Congratulations! You have unlocked all rewards.
                <?php endif; ?>
            </div>
            <div class="bee-cart-progress-bar">
                <div class="bee-cart-progress-fill" style="width: <?php echo esc_attr($percent); ?>%;"></div>
                <div class="bee-progress-checkpoints">
                    <?php foreach ($goals as $goal):
                        $goal_val = (float)$goal['threshold'];
                        $is_reached = $current_val >= $goal_val;
                        $pos = ($goal_val / $max_threshold) * 100;
                        $icon_key = $goal['icon'] ?? 'star';
                        $icon_svg = $icons_map[$icon_key] ?? $icons_map['star'];
                    ?>
                        <div class="bee-checkpoint-point <?php echo $is_reached ? 'is-reached' : ''; ?>" style="left: <?php echo esc_attr($pos); ?>%;">
                            <div class="bee-checkpoint-icon">
                                <?php echo $icon_svg; ?>
                            </div>
                            <span class="bee-checkpoint-label"><?php echo esc_html($goal['label']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="bee-cart-items-list">
        <?php foreach ($cart->get_cart() as $cart_item_key => $cart_item):
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            if ($_product && $_product->exists() && $cart_item['quantity'] > 0) {
                $product_name  = $_product->get_name();
                $thumbnail     = $_product->get_image(array(80, 80));
                $product_price = $cart->get_product_price($_product);
        ?>
                <div class="bee-cart-item">
                    <div class="bee-cart-item-image"><?php echo $thumbnail; ?></div>
                    <div class="bee-cart-item-details">
                        <div class="bee-cart-item-title"><?php echo esc_html($product_name); ?></div>
                        <div class="bee-cart-item-meta"><?php echo wc_get_formatted_cart_item_data($cart_item); ?></div>
                        <div class="bee-cart-item-price"><?php echo $product_price; ?></div>
                        <div class="bee-cart-item-qty">
                            <button class="bee-cart-qty-btn bee-cart-qty-minus" @click.prevent="updateItem('<?php echo esc_attr($cart_item_key); ?>', <?php echo (int) $cart_item['quantity'] - 1; ?>)">-</button>
                            <input type="number" class="bee-cart-qty-input" value="<?php echo esc_attr($cart_item['quantity']); ?>" @change="updateItem('<?php echo esc_attr($cart_item_key); ?>', $event.target.value)">
                            <button class="bee-cart-qty-btn bee-cart-qty-plus" @click.prevent="updateItem('<?php echo esc_attr($cart_item_key); ?>', <?php echo (int) $cart_item['quantity'] + 1; ?>)">+</button>
                        </div>
                    </div>
                    <div class="bee-cart-item-remove-wrapper">
                        <button class="bee-cart-remove-btn" @click.prevent="updateItem('<?php echo esc_attr($cart_item_key); ?>', 0)">&times;</button>
                    </div>
                </div>
        <?php
            }
        endforeach; ?>
    </div>

    <!-- Upsells -->
    <?php
    $upsell_args = array('post_type' => 'product', 'posts_per_page' => 2, 'orderby' => 'rand');
    $upsell_query = new WP_Query($upsell_args);
    if ($upsell_query->have_posts()): ?>
        <div class="bee-cart-upsells">
            <h4 class="bee-cart-upsells-heading">Recommended for you</h4>
            <div class="bee-cart-upsells-list">
                <?php while ($upsell_query->have_posts()): $upsell_query->the_post();
                    global $product; ?>
                    <div class="bee-cart-upsell-item">
                        <div class="bee-cart-upsell-image"><?php the_post_thumbnail(array(60, 60)); ?></div>
                        <div class="bee-cart-upsell-details">
                            <div class="bee-cart-upsell-title"><?php the_title(); ?></div>
                            <div class="bee-cart-upsell-price"><?php echo $product->get_price_html(); ?></div>
                        </div>
                        <button class="bee-cart-add-upsell bee-sh-btn-primary" @click.prevent="addUpsell(<?php echo get_the_ID(); ?>)">+</button>
                    </div>
                <?php endwhile;
                wp_reset_postdata(); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="bee-cart-footer">
        <?php if ($settings['enable_coupon'] ?? true): ?>
            <div class="bee-cart-coupon" style="margin-bottom: 20px;">
                <div style="display: flex; gap: 8px; border: 1px dashed #ddd; padding: 4px; border-radius: 6px;">
                    <input type="text" id="bee-coupon-code" placeholder="Discount code" class="bee-input" x-ref="couponCode" style="border: none; margin: 0; padding: 4px 8px; flex: 1; height: 32px;">
                    <button class="bee-cart-btn bee-apply-coupon" @click.prevent="applyCoupon($refs.couponCode.value)" style="width: auto; padding: 0 16px; margin: 0; font-size: 13px; height: 32px;">Apply</button>
                </div>
            </div>
        <?php endif; ?>

        <div class="bee-cart-subtotal">
            <span>Subtotal</span>
            <span><?php echo $cart->get_cart_subtotal(); ?></span>
        </div>

        <?php if ($settings['enable_badges'] ?? true): ?>
            <div class="bee-cart-trust-badge">
                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" style="height: 16px; margin: 0 8px;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" style="height: 16px; margin: 0 8px;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" style="height: 16px; margin: 0 8px;">
            </div>
        <?php endif; ?>

        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="bee-cart-btn bee-cart-btn-primary" style="padding: 16px; font-size: 1.1rem; border-radius: 8px;">Checkout Now</a>
    </div>

<?php else: ?>
    <div class="bee-cart-empty">
        <div class="bee-cart-empty-icon">
            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
        </div>
        <p class="bee-cart-empty-text">Your cart is empty.</p>
        <button class="bee-cart-btn bee-cart-btn-primary" @click.prevent="closeCart()">Return to shop</button>
    </div>
<?php endif; ?>