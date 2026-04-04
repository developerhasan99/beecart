<?php
if (! defined('ABSPATH')) {
    exit;
}

$beecart_icon_settings = isset($this) ? $this->get_settings() : (new BeeCart())->get_settings();
$beecart_icon_cart_url = wc_get_cart_url();
// Initial count will be fetched via AJAX in JS to bypass caching
$beecart_icon_enable_drawer = isset($beecart_icon_settings['enable_cart_drawer']) ? (bool)$beecart_icon_settings['enable_cart_drawer'] : false;

$beecart_icon_type = $beecart_icon_settings['cart_icon_type'] ?? 'bag-1';
$beecart_icon_color = $beecart_icon_settings['cart_icon_color'] ?? '#000000';
$beecart_icon_size = $beecart_icon_settings['cart_icon_size'] ?? '24';
$beecart_icon_bubble_bg = $beecart_icon_settings['cart_bubble_bg'] ?? '#ff0000';
$beecart_icon_bubble_text = $beecart_icon_settings['cart_bubble_text'] ?? '#ffffff';
?>

<?php if ($beecart_icon_enable_drawer) : ?>
    <div class="beecart-icon-wrapper bc-icon-trigger" 
        onclick="window.dispatchEvent(new CustomEvent('open-beecart'))"
        style="position: relative; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; width: <?php echo esc_attr($beecart_icon_size); ?>px; height: <?php echo esc_attr($beecart_icon_size); ?>px; color: <?php echo esc_attr($beecart_icon_color); ?>;">
        <?php echo wp_kses_post(BeeCart::get_svg_icon($beecart_icon_type)); ?>
        <?php if ($beecart_icon_settings['show_cart_count'] ?? true) : ?>
            <span class="beecart-count-bubble"
                style="position: absolute; top: -8px; right: -8px; background: <?php echo esc_attr($beecart_icon_bubble_bg); ?>; color: <?php echo esc_attr($beecart_icon_bubble_text); ?>; border-radius: 50%; padding: 2px; min-width: 18px; height: 18px; font-size: 10px; font-weight: 700; display: none; align-items: center; justify-content: center; line-height: 1;">
            </span>
        <?php endif; ?>
    </div>
<?php else : ?>
    <a href="<?php echo esc_url($beecart_icon_cart_url); ?>" 
        class="beecart-icon-wrapper" 
        style="position: relative; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; width: <?php echo esc_attr($beecart_icon_size); ?>px; height: <?php echo esc_attr($beecart_icon_size); ?>px; color: <?php echo esc_attr($beecart_icon_color); ?>;">
        <?php echo wp_kses_post(BeeCart::get_svg_icon($beecart_icon_type)); ?>
        <?php if ($beecart_icon_settings['show_cart_count'] ?? true) : ?>
            <span class="beecart-count-bubble"
                style="position: absolute; top: -8px; right: -8px; background: <?php echo esc_attr($beecart_icon_bubble_bg); ?>; color: <?php echo esc_attr($beecart_icon_bubble_text); ?>; border-radius: 50%; padding: 2px; min-width: 18px; height: 18px; font-size: 10px; font-weight: 700; display: none; align-items: center; justify-content: center; line-height: 1;">
            </span>
        <?php endif; ?>
    </a>
<?php endif; ?>