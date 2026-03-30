<?php
if (! defined('ABSPATH')) {
    exit;
}

$settings = $this->get_settings();

$heading = $settings['cart_title'] ?? 'Your Cart';
$countdown_minutes = $settings['timer_duration'] ?? 15;
$bg_color = $settings['bg_color'] ?? '#FFFFFF';
$text_color = $settings['text_color'] ?? '#000000';
$accent_color = $settings['accent_color'] ?? '#f6f6f7';
$show_cart_count = $settings['show_cart_count'] ?? true;
$inherit_fonts = $settings['inherit_fonts'] ?? true;

$show_announcement = $settings['show_announcement'] ?? false;
$announcement = $settings['announcement_text'] ?? '';
$announcement_bg = $settings['announcement_bg'] ?? '#000000';
$announcement_text_color = $settings['announcement_text_color'] ?? '#ffffff';
$announcement_bar_size = $settings['announcement_bar_size'] ?? 'medium';
$announcement_font_size = $settings['announcement_font_size'] ?? '13px';

$enable_timer = $settings['enable_timer'] ?? false;
?>
<div x-data="beecart(<?php echo esc_attr($countdown_minutes); ?>)"
    @added_to_cart.window="openCart()"
    @open-beecart.window="openCart()"
    class="bc-drawer-wrap"
    :class="{'is-open': isOpen}"
    style="font-family: <?php echo $inherit_fonts ? 'inherit' : 'sans-serif'; ?>;">

    <!-- Overlay -->
    <div class="bc-overlay" @click="closeCart()"></div>

    <!-- Drawer container -->
    <div class="bc-drawer-panel" style="background-color: <?php echo esc_attr($bg_color); ?>; color: <?php echo esc_attr($text_color); ?>;">

        <!-- Header -->
        <div class="bc-drawer-header">
            <h2 class="bc-drawer-title" style="color: <?php echo esc_attr($text_color); ?>;">
                <span><?php echo esc_html($heading); ?></span>
                <?php if ($show_cart_count): ?>
                <span><span class="bc-drawer-title-sep">•</span> <span x-text="cartCount"></span></span>
                <?php endif; ?>
            </h2>
            <button @click="closeCart()" title="Close Cart" class="bc-drawer-close" style="background-color: <?php echo esc_attr($accent_color); ?>;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" style="color: #6b7280;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <!-- Announcement and Timer -->
        <?php if ($show_announcement || $enable_timer): ?>
        <div class="bc-drawer-top-notices">
            <?php if ($show_announcement): 
                $size_class = 'size-medium';
                if ($announcement_bar_size === 'small') $size_class = 'size-small';
                if ($announcement_bar_size === 'large') $size_class = 'size-large';
            ?>
            <div class="bc-announcement <?php echo esc_attr($size_class); ?>"
                style="background-color: <?php echo esc_attr($announcement_bg); ?>; color: <?php echo esc_attr($announcement_text_color); ?>; font-size: <?php echo esc_attr($announcement_font_size); ?>;">
                <?php echo esc_html($announcement); ?>
            </div>
            <?php endif; ?>

            <?php if ($enable_timer): ?>
            <div class="bc-timer">
                <?php echo BeeCart::get_svg_icon('clock', 'bc-timer-icon'); ?>
                <span>Cart reserved for <span class="bc-timer-val" x-text="formatTime(timerCount)"></span> minutes!</span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Cart AJAX Content Area -->
        <div class="bc-drawer-body" :class="{'is-loading': isLoading}">
            <div x-html="cartHtml" style="display: contents;"></div>
            
            <!-- Loading indicator -->
            <div class="bc-loading-overlay" x-show="isLoading" style="display: none;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" class="bc-spinner" style="animation: spin 1s linear infinite; opacity: 0.6; color: #6b7280;">
                    <circle opacity="0.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path opacity="0.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <style>@keyframes spin { 100% { transform: rotate(360deg); } }</style>
            </div>
        </div>
    </div>
</div>