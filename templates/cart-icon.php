<?php
/**
 * Cart icon template for Popsi Cart Drawer.
 *
 * @package Popsi_Cart_Drawer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$popsi_cart_icon_settings      = isset( $this ) ? $this->get_settings() : ( new Popsi_Cart_Drawer() )->get_settings();
$popsi_cart_icon_cart_url      = wc_get_cart_url();
$popsi_cart_icon_enable_drawer = isset( $popsi_cart_icon_settings['enable_cart_drawer'] ) ? (bool) $popsi_cart_icon_settings['enable_cart_drawer'] : false;

$popsi_cart_icon_type        = $popsi_cart_icon_settings['cart_icon_type'] ?? 'bag-1';
$popsi_cart_icon_color       = $popsi_cart_icon_settings['cart_icon_color'] ?? '#000000';
$popsi_cart_icon_size        = $popsi_cart_icon_settings['cart_icon_size'] ?? '24';
$popsi_cart_icon_bubble_bg   = $popsi_cart_icon_settings['cart_bubble_bg'] ?? '#ff0000';
$popsi_cart_icon_bubble_text = $popsi_cart_icon_settings['cart_bubble_text'] ?? '#ffffff';
?>

<?php if ( $popsi_cart_icon_enable_drawer ) : ?>
	<div class="popsi-cart-icon-wrapper bc-icon-trigger" 
		onclick="window.dispatchEvent(new CustomEvent('open-popsi-cart'))"
		style="position: relative; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; width: <?php echo esc_attr( $popsi_cart_icon_size ); ?>px; height: <?php echo esc_attr( $popsi_cart_icon_size ); ?>px; color: <?php echo esc_attr( $popsi_cart_icon_color ); ?>;">
		<?php
		$popsi_cart_icon_name = $popsi_cart_icon_type;
		include POPSI_CART_PATH . 'templates/icons.php';
		?>
		<?php if ( $popsi_cart_icon_settings['show_cart_count'] ?? true ) : ?>
			<span class="popsi-cart-count-bubble"
				style="position: absolute; top: -8px; right: -8px; background: <?php echo esc_attr( $popsi_cart_icon_bubble_bg ); ?>; color: <?php echo esc_attr( $popsi_cart_icon_bubble_text ); ?>; border-radius: 50%; padding: 2px; min-width: 18px; height: 18px; font-size: 10px; font-weight: 700; display: none; align-items: center; justify-content: center; line-height: 1;">
			</span>
		<?php endif; ?>
	</div>
<?php else : ?>
	<a href="<?php echo esc_url( $popsi_cart_icon_cart_url ); ?>" 
		class="popsi-cart-icon-wrapper" 
		style="position: relative; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; width: <?php echo esc_attr( $popsi_cart_icon_size ); ?>px; height: <?php echo esc_attr( $popsi_cart_icon_size ); ?>px; color: <?php echo esc_attr( $popsi_cart_icon_color ); ?>;">
		<?php
		$popsi_cart_icon_name = $popsi_cart_icon_type;
		include POPSI_CART_PATH . 'templates/icons.php';
		?>
		<?php if ( $popsi_cart_icon_settings['show_cart_count'] ?? true ) : ?>
			<span class="popsi-cart-count-bubble"
				style="position: absolute; top: -8px; right: -8px; background: <?php echo esc_attr( $popsi_cart_icon_bubble_bg ); ?>; color: <?php echo esc_attr( $popsi_cart_icon_bubble_text ); ?>; border-radius: 50%; padding: 2px; min-width: 18px; height: 18px; font-size: 10px; font-weight: 700; display: none; align-items: center; justify-content: center; line-height: 1;">
			</span>
		<?php endif; ?>
	</a>
<?php endif; ?>