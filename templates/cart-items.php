<?php
/**
 * Cart items template for Popsi Cart Drawer.
 *
 * @package Popsi_Cart_Drawer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$popsi_cart_cart = WC()->cart;
if ( ! $popsi_cart_cart ) {
	return;
}

$popsi_cart_cart->calculate_totals();

$popsi_cart_settings = $this->get_settings();

$popsi_cart_is_empty = $popsi_cart_cart->is_empty();
$popsi_cart_items    = $popsi_cart_cart->get_cart();

$popsi_cart_enable_rewards_bar = $popsi_cart_settings['enable_rewards_bar'] ?? true;
$popsi_cart_text_color         = $popsi_cart_settings['text_color'] ?? '#000000';
$popsi_cart_show_item_images   = $popsi_cart_settings['show_item_images'] ?? true;
$popsi_cart_show_strikethrough = $popsi_cart_settings['show_strikethrough'] ?? true;
$popsi_cart_show_savings       = $popsi_cart_settings['show_savings'] ?? true;
$popsi_cart_savings_color      = $popsi_cart_settings['savings_text_color'] ?? '#1DC200';
$popsi_cart_savings_prefix     = $popsi_cart_settings['trans_savings_prefix'] ?? 'Save';
$popsi_cart_btn_color          = $popsi_cart_settings['btn_color'] ?? '#000000';
$popsi_cart_btn_text_color     = $popsi_cart_settings['btn_text_color'] ?? '#FFFFFF';
$popsi_cart_btn_radius         = $popsi_cart_settings['btn_radius'] ?? '4px';
$popsi_cart_show_upsells       = $popsi_cart_settings['show_upsells'] ?? true;

$popsi_cart_enable_coupon        = $popsi_cart_settings['enable_coupon'] ?? true;
$popsi_cart_enable_subtotal_line = $popsi_cart_settings['enable_subtotal_line'] ?? true;
$popsi_cart_accent_color         = $popsi_cart_settings['accent_color'] ?? '#f6f6f7';
$popsi_cart_btn_hover_color      = $popsi_cart_settings['btn_hover_color'] ?? '#333333';
$popsi_cart_btn_hover_text_color = $popsi_cart_settings['btn_hover_text_color'] ?? '#FFFFFF';
$popsi_cart_bg_color             = $popsi_cart_settings['bg_color'] ?? '#FFFFFF';
$popsi_cart_show_trust_badges    = $popsi_cart_settings['show_trust_badges'] ?? true;
?>

<div class="bc-cart-contents-scroll">
	<?php require POPSI_CART_PATH . 'templates/cart-rewards-bars.php'; ?>

	<?php require POPSI_CART_PATH . 'templates/cart-items-list.php'; ?>

	<?php require POPSI_CART_PATH . 'templates/cart-empty-state.php'; ?>

	<?php require POPSI_CART_PATH . 'templates/cart-upsells.php'; ?>

</div><!-- end bc-cart-contents-scroll -->
<?php require POPSI_CART_PATH . 'templates/cart-footer.php'; ?>
