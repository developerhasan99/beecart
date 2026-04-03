<?php
if (! defined('ABSPATH')) {
    exit;
}

$settings = isset($this) ? $this->get_settings() : (new BeeCart())->get_settings();
$cart_url = wc_get_cart_url();
$cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
$enable_drawer = isset($settings['enable_cart_drawer']) ? (bool)$settings['enable_cart_drawer'] : false;

$icon_type = $settings['cart_icon_type'] ?? 'bag-1';
$icon_color = $settings['cart_icon_color'] ?? '#000000';
$icon_size = $settings['cart_icon_size'] ?? '24';
$bubble_bg = $settings['cart_bubble_bg'] ?? '#ff0000';
$bubble_text = $settings['cart_bubble_text'] ?? '#ffffff';
?>

<?php if ($enable_drawer) : ?>
    <div class="beecart-icon-wrapper bc-icon-trigger nocache" 
        data-nocache="1" 
        onclick="window.dispatchEvent(new CustomEvent('open-beecart'))"
        style="position: relative; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; width: <?php echo esc_attr($icon_size); ?>px; height: <?php echo esc_attr($icon_size); ?>px; color: <?php echo esc_attr($icon_color); ?>;">
        <?php echo BeeCart::get_svg_icon($icon_type); ?>
        <?php if ($settings['show_cart_count'] ?? true) : ?>
            <span class="beecart-count-bubble"
                style="position: absolute; top: -8px; right: -8px; background: <?php echo esc_attr($bubble_bg); ?>; color: <?php echo esc_attr($bubble_text); ?>; border-radius: 50%; padding: 2px; min-width: 18px; height: 18px; font-size: 10px; font-weight: 700; display: <?php echo ($cart_count > 0) ? 'flex' : 'none'; ?>; align-items: center; justify-content: center; line-height: 1;">
                <?php echo esc_html($cart_count); ?>
            </span>
        <?php endif; ?>
    </div>
<?php else : ?>
    <a href="<?php echo esc_url($cart_url); ?>" 
        class="beecart-icon-wrapper nocache" 
        data-nocache="1" 
        style="position: relative; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; width: <?php echo esc_attr($icon_size); ?>px; height: <?php echo esc_attr($icon_size); ?>px; color: <?php echo esc_attr($icon_color); ?>;">
        <?php echo BeeCart::get_svg_icon($icon_type); ?>
        <?php if ($settings['show_cart_count'] ?? true) : ?>
            <span class="beecart-count-bubble"
                style="position: absolute; top: -8px; right: -8px; background: <?php echo esc_attr($bubble_bg); ?>; color: <?php echo esc_attr($bubble_text); ?>; border-radius: 50%; padding: 2px; min-width: 18px; height: 18px; font-size: 10px; font-weight: 700; display: <?php echo ($cart_count > 0) ? 'flex' : 'none'; ?>; align-items: center; justify-content: center; line-height: 1;">
                <?php echo esc_html($cart_count); ?>
            </span>
        <?php endif; ?>
    </a>
<?php endif; ?>