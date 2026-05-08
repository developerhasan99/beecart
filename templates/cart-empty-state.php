<?php
/**
 * Cart empty state template for Popsi Cart Drawer.
 *
 * @package Popsi_Cart_Drawer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Initialize required variables.
$popsi_cart_cart           = WC()->cart;
$popsi_cart_is_empty       = $popsi_cart_cart ? $popsi_cart_cart->is_empty() : true;
$popsi_cart_settings       = ( new Popsi_Cart_Drawer() )->get_settings();
$popsi_cart_text_color     = $popsi_cart_settings['text_color'] ?? '#000000';
$popsi_cart_btn_color      = $popsi_cart_settings['btn_color'] ?? '#000000';
$popsi_cart_btn_text_color = $popsi_cart_settings['btn_text_color'] ?? '#FFFFFF';
$popsi_cart_btn_radius     = $popsi_cart_settings['btn_radius'] ?? '4px';

if ( $popsi_cart_is_empty ) :
	?>
	<div class="bc-empty-cart">
		<svg class="bc-empty-cart-icon" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
			<circle cx="9" cy="21" r="1"></circle>
			<circle cx="20" cy="21" r="1"></circle>
			<path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
		</svg>
		<p class="bc-empty-cart-text" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;"><?php echo esc_html( $popsi_cart_settings['trans_empty_cart'] ?? 'Your cart is empty.' ); ?></p>
		<button class="bc-empty-cart-btn"
			style="background-color: <?php echo esc_attr( $popsi_cart_btn_color ); ?>; color: <?php echo esc_attr( $popsi_cart_btn_text_color ); ?>; border-radius: <?php echo esc_attr( $popsi_cart_btn_radius ); ?>">
			<?php echo esc_html( $popsi_cart_settings['trans_continue_shopping'] ?? 'Return to shop' ); ?>
		</button>
	</div>
<?php endif; ?>
