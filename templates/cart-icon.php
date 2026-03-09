<?php
if (! defined('ABSPATH')) {
    exit;
}

$cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
?>
<div class="bee-cart-icon-wrapper" onclick="window.dispatchEvent(new Event('open-bee-cart'))" style="position: relative; cursor: pointer; display: inline-block;">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="9" cy="21" r="1"></circle>
        <circle cx="20" cy="21" r="1"></circle>
        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
    </svg>
    <span class="bee-cart-count-bubble" style="position: absolute; top: -8px; right: -8px; background: var(--bee-cart-primary, #000); color: #fff; border-radius: 50%; width: 18px; height: 18px; font-size: 11px; display: flex; align-items: center; justify-content: center;"><?php echo esc_html($cart_count); ?></span>
</div>