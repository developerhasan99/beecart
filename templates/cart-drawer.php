<?php
if (! defined('ABSPATH')) {
    exit;
}

$heading = get_theme_mod('bee_cart_heading', 'Your Cart');
$enable_countdown = get_theme_mod('bee_cart_countdown_enable', true);
$countdown_minutes = get_theme_mod('bee_cart_countdown_minutes', 15);
$countdown_msg = get_theme_mod('bee_cart_countdown_msg', 'Your cart is reserved for [timer] minutes!');

$announcement = get_theme_mod('bee_cart_announcement_msg', 'Save 20% on all items today!');
?>
<div x-data="beeCart(<?php echo esc_attr($countdown_minutes); ?>)"
    @added_to_cart.window="openCart()"
    @open-bee-cart.window="openCart()"
    class="bee-cart-alpine-wrap">

    <div class="bee-cart-overlay" :class="{'is-active': isOpen}" @click="closeCart()"></div>
    <div class="bee-cart-drawer" id="bee-cart-drawer" :class="{'is-active': isOpen}">
        <div class="bee-cart-header">
            <div class="bee-cart-header-top">
                <h3 class="bee-cart-title"><?php echo esc_html($heading); ?></h3>
                <button class="bee-cart-close" @click="closeCart()" aria-label="Close cart">&times;</button>
            </div>

            <?php if (!empty($announcement)) : ?>
                <div class="bee-cart-announcement">
                    <?php echo esc_html($announcement); ?>
                </div>
            <?php endif; ?>

            <?php if ($enable_countdown) : ?>
                <div class="bee-cart-countdown" id="bee-cart-countdown-wrap" x-show="timerCount > 0">
                    <?php
                    $timerHtml = '<span class="bee-cart-timer" x-text="formatTime(timerCount)"></span>';
                    echo str_replace('[timer]', $timerHtml, esc_html($countdown_msg));
                    ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="bee-cart-body-wrap" id="bee-cart-content" :class="{'is-loading': isLoading}">
            <div x-html="cartHtml"></div>
            <!-- Initial content gets loaded via AJAX on open -->
            <div class="bee-cart-loading" x-show="isLoading" style="display: none;">
                <div class="bee-cart-spinner"></div>
            </div>
        </div>
    </div>
</div>