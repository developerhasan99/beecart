<?php
/**
 * Cart footer template for Popsi Cart Drawer.
 *
 * @package Popsi_Cart_Drawer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Initialize required variables.
$popsi_cart_cart                 = WC()->cart;
$popsi_cart_is_empty             = $popsi_cart_cart ? $popsi_cart_cart->is_empty() : true;
$popsi_cart_settings             = ( new Popsi_Cart_Drawer() )->get_settings();
$popsi_cart_text_color           = $popsi_cart_settings['text_color'] ?? '#000000';
$popsi_cart_btn_color            = $popsi_cart_settings['btn_color'] ?? '#000000';
$popsi_cart_btn_text_color       = $popsi_cart_settings['btn_text_color'] ?? '#FFFFFF';
$popsi_cart_btn_radius           = $popsi_cart_settings['btn_radius'] ?? '4px';
$popsi_cart_bg_color             = $popsi_cart_settings['bg_color'] ?? '#FFFFFF';
$popsi_cart_enable_coupon        = $popsi_cart_settings['enable_coupon'] ?? true;
$popsi_cart_enable_subtotal_line = $popsi_cart_settings['enable_subtotal_line'] ?? true;
$popsi_cart_btn_hover_color      = $popsi_cart_settings['btn_hover_color'] ?? '#333333';
$popsi_cart_btn_hover_text_color = $popsi_cart_settings['btn_hover_text_color'] ?? '#FFFFFF';
$popsi_cart_accent_color         = $popsi_cart_settings['accent_color'] ?? '#f6f6f7';
$popsi_cart_show_trust_badges    = $popsi_cart_settings['show_trust_badges'] ?? true;

if ( ! $popsi_cart_is_empty ) :
	?>
	<div class="bc-drawer-footer" style="background-color: <?php echo esc_attr( $popsi_cart_bg_color ); ?>; margin-top: auto;">
		<?php if ( $popsi_cart_enable_coupon ) : ?>
			<div class="bc-coupon-accordion">
				<button type="button" class="bc-coupon-toggle" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;">
					<span><?php echo esc_html( $popsi_cart_settings['trans_coupon_accordion_title'] ?? 'Have a Coupon?' ); ?></span>
					<span class="bc-coupon-toggle-icon">
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down">
							<path d="m6 9 6 6 6-6"></path>
						</svg>
					</span>
				</button>
				<div class="bc-coupon-accordion-content" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out;">
					<div class="bc-coupon-wrap">
						<input type="text" placeholder="<?php echo esc_attr( $popsi_cart_settings['trans_coupon_placeholder'] ?? 'Coupon code' ); ?>" class="bc-coupon-input">
						<button class="bc-coupon-btn"
							style="background-color: <?php echo esc_attr( $popsi_cart_accent_color ); ?>; color: <?php echo esc_attr( $popsi_cart_text_color ); ?>; border-radius: <?php echo esc_attr( $popsi_cart_btn_radius ); ?>">
							<?php echo esc_html( $popsi_cart_settings['trans_coupon_apply_btn'] ?? 'Apply' ); ?>
						</button>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( $popsi_cart_enable_subtotal_line ) : ?>
			<div class="bc-summary-row" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;">
				<span><?php echo esc_html( $popsi_cart_settings['trans_subtotal'] ?? 'Subtotal' ); ?></span>
				<span class="val-wrap"><?php echo wp_kses_post( $popsi_cart_cart->get_cart_subtotal() ); ?></span>
			</div>
		<?php endif; ?>

		<?php if ( $popsi_cart_cart->get_discount_total() > 0 ) : ?>
			<div class="bc-summary-row" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;">
				<div class="label-wrap">
					<span><?php echo esc_html( ( $popsi_cart_settings['trans_discounts'] ?? 'Discounts' ) . ':' ); ?></span>
					<?php $popsi_cart_applied_coupons_footer = $popsi_cart_cart->get_applied_coupons(); ?>
					<?php if ( ! empty( $popsi_cart_applied_coupons_footer ) ) : ?>
						<?php foreach ( $popsi_cart_applied_coupons_footer as $popsi_cart_coupon_code ) : ?>
							<div class="bc-summary-discount-badge">
								<span class="bc-summary-badge-text"><?php echo esc_html( strtoupper( $popsi_cart_coupon_code ) ); ?></span>
								<span class="bc-badge-remove" data-code="<?php echo esc_js( $popsi_cart_coupon_code ); ?>">
									<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
										<path d="M18 6 6 18" />
										<path d="m6 6 12 12" />
									</svg>
								</span>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
				<span class="val-wrap bc-discount-val">- <?php echo wp_kses_post( wc_price( $popsi_cart_cart->get_discount_total() ) ); ?></span>
			</div>
		<?php endif; ?>

		<?php if ( $popsi_cart_settings['enable_total_line'] ?? true ) : ?>
			<div class="bc-summary-row bc-total-row" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;">
				<span><?php echo esc_html( $popsi_cart_settings['trans_total'] ?? 'Total' ); ?></span>
				<span class="val-wrap"><?php echo wp_kses_post( $popsi_cart_cart->get_total() ); ?></span>
			</div>
		<?php endif; ?>

		<?php if ( $popsi_cart_settings['show_shipping_notice'] ?? true ) : ?>
			<div class="bc-shipping-notice" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;">
				<?php echo esc_html( $popsi_cart_settings['shipping_notice_text'] ?? 'Shipping and taxes will be calculated at checkout.' ); ?>
			</div>
		<?php endif; ?>

		<div class="bc-checkout-btn-wrap">
			<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="bc-checkout-btn"
				onmouseenter="this.style.backgroundColor = '<?php echo esc_attr( $popsi_cart_btn_hover_color ); ?>'; this.style.color = '<?php echo esc_attr( $popsi_cart_btn_hover_text_color ); ?>'"
				onmouseleave="this.style.backgroundColor = '<?php echo esc_attr( $popsi_cart_btn_color ); ?>'; this.style.color = '<?php echo esc_attr( $popsi_cart_btn_text_color ); ?>'"
				style="background-color: <?php echo esc_attr( $popsi_cart_btn_color ); ?>; color: <?php echo esc_attr( $popsi_cart_btn_text_color ); ?>; border-radius: <?php echo esc_attr( $popsi_cart_btn_radius ); ?>;">
				<span><?php echo esc_html( $popsi_cart_settings['trans_checkout_btn'] ?? 'Checkout' ); ?></span>
				<?php if ( $popsi_cart_settings['show_subtotal_on_checkout'] ?? true ) : ?>
					<span class="bc-checkout-sep">•</span>
					<span><?php echo wp_kses_post( $popsi_cart_cart->get_total() ); ?></span>
				<?php endif; ?>
			</a>
		</div>

		<!-- Trust Badges -->
		<?php
		if ( $popsi_cart_show_trust_badges ) :
			$popsi_cart_trust_badge_image = $popsi_cart_settings['trust_badge_image'] ?? '';
			if ( $popsi_cart_trust_badge_image ) :
				?>
				<div class="bc-trust-badges">
					<img src="<?php echo esc_url( $popsi_cart_trust_badge_image ); ?>" alt="Trust badges">
				</div>
				<?php
		endif;
		endif;
		?>
	</div>
<?php endif; ?>
