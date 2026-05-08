<?php
/**
 * Cart items list template for Popsi Cart Drawer.
 *
 * @package Popsi_Cart_Drawer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Initialize required variables.
$popsi_cart_cart               = WC()->cart;
$popsi_cart_is_empty           = $popsi_cart_cart ? $popsi_cart_cart->is_empty() : true;
$popsi_cart_settings           = ( new Popsi_Cart_Drawer() )->get_settings();
$popsi_cart_show_item_images   = $popsi_cart_settings['show_item_images'] ?? true;
$popsi_cart_text_color         = $popsi_cart_settings['text_color'] ?? '#000000';
$popsi_cart_show_strikethrough = $popsi_cart_settings['show_strikethrough'] ?? true;
$popsi_cart_show_savings       = $popsi_cart_settings['show_savings'] ?? true;
$popsi_cart_savings_color      = $popsi_cart_settings['savings_text_color'] ?? '#1DC200';
$popsi_cart_savings_prefix     = $popsi_cart_settings['trans_savings_prefix'] ?? 'Save';

if ( ! $popsi_cart_is_empty ) :
	?>
	<div class="bc-item-list">
		<?php
		foreach ( $popsi_cart_cart->get_cart() as $popsi_cart_cart_item_key => $popsi_cart_cart_item ) :
			$popsi_cart_product_obj = apply_filters( 'woocommerce_cart_item_product', $popsi_cart_cart_item['data'], $popsi_cart_cart_item, $popsi_cart_cart_item_key ); // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound
			if ( $popsi_cart_product_obj && $popsi_cart_product_obj->exists() && $popsi_cart_cart_item['quantity'] > 0 ) {
				$popsi_cart_product_name       = $popsi_cart_product_obj->get_name();
				$popsi_cart_thumbnail_id       = $popsi_cart_product_obj->get_image_id();
				$popsi_cart_thumbnail_url      = wp_get_attachment_image_url( $popsi_cart_thumbnail_id, 'thumbnail' );
				$popsi_cart_item_qty           = (int) $popsi_cart_cart_item['quantity'];
				$popsi_cart_unit_display_price = (float) $popsi_cart_cart_item['line_total'] / $popsi_cart_item_qty;
				$popsi_cart_unit_regular_price = (float) $popsi_cart_product_obj->get_regular_price();

				$popsi_cart_product_price = wc_price( $popsi_cart_unit_display_price );
				$popsi_cart_regular_price = $popsi_cart_unit_regular_price;
				$popsi_cart_has_sale      = $popsi_cart_unit_regular_price > $popsi_cart_unit_display_price;
				$popsi_cart_item_data     = wc_get_formatted_cart_item_data( $popsi_cart_cart_item );
				$popsi_cart_product_url   = $popsi_cart_product_obj->get_permalink();
				?>
				<div class="bc-item">
					<?php if ( false !== $popsi_cart_show_item_images ) : ?>
						<a href="<?php echo esc_url( $popsi_cart_product_url ); ?>" class="bc-item-img-wrap">
							<?php if ( $popsi_cart_thumbnail_url ) : ?>
								<img src="<?php echo esc_url( $popsi_cart_thumbnail_url ); ?>" alt="<?php echo esc_attr( $popsi_cart_product_name ); ?>" />
							<?php else : ?>
								<?php
								$popsi_cart_icon_name  = 'format-image';
								$popsi_cart_icon_class = 'bc-placeholder-icon';
								include POPSI_CART_PATH . 'templates/icons.php';
								?>
							<?php endif; ?>
						</a>
					<?php endif; ?>

					<div class="bc-item-details">
						<button class="bc-item-remove" data-key="<?php echo esc_attr( $popsi_cart_cart_item_key ); ?>">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash">
								<path d="M3 6h18"></path>
								<path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
								<path d="M8 6V4c0-.5.2-1 .6-1h6c.4 0 .6.5.6 1v2"></path>
							</svg>
						</button>

						<a href="<?php echo esc_url( $popsi_cart_product_url ); ?>" style="text-decoration: none;">
							<h4 class="bc-item-title" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;"><?php echo esc_html( $popsi_cart_product_name ); ?></h4>
						</a>
						<?php
						if ( $popsi_cart_item_data ) :
							echo '<div class="bc-item-meta">' . wp_kses_post( $popsi_cart_item_data ) . '</div>';
						elseif ( $popsi_cart_product_obj->is_type( 'variation' ) ) :
							$popsi_cart_variation_data = $popsi_cart_product_obj->get_variation_attributes();
							if ( ! empty( $popsi_cart_variation_data ) ) :
								echo '<div class="bc-item-meta">';
								$popsi_cart_meta_parts = array();
								foreach ( $popsi_cart_variation_data as $popsi_cart_key => $popsi_cart_value ) :
									$popsi_cart_label        = wc_attribute_label( str_replace( 'attribute_', '', $popsi_cart_key ), $popsi_cart_product_obj );
									$popsi_cart_meta_parts[] = esc_html( $popsi_cart_label ) . ': ' . esc_html( $popsi_cart_value );
								endforeach;
								echo wp_kses_post( implode( ', ', $popsi_cart_meta_parts ) );
								echo '</div>';
							endif;
						endif;
						?>

						<div class="bc-item-prices">
							<?php if ( $popsi_cart_has_sale && false !== $popsi_cart_show_strikethrough ) : ?>
								<span class="bc-item-old-price"><?php echo wp_kses_post( wc_price( $popsi_cart_regular_price ) ); ?></span>
							<?php endif; ?>
							<span class="bc-item-price" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;"><?php echo wp_kses_post( $popsi_cart_product_price ); ?></span>
							<?php
							if ( $popsi_cart_show_savings && $popsi_cart_has_sale ) :
								$popsi_cart_discount_amount = (float) $popsi_cart_regular_price - $popsi_cart_unit_display_price;
								if ( $popsi_cart_discount_amount > 0 ) :
									?>
									<span class="bc-item-price" style="font-size: 13px; color: <?php echo esc_attr( $popsi_cart_savings_color ); ?>;">
										(<?php echo esc_html( $popsi_cart_savings_prefix ); ?> <?php echo wp_kses_post( wc_price( $popsi_cart_discount_amount * $popsi_cart_cart_item['quantity'] ) ); ?>)
									</span>
									<?php
							endif;
							endif;
							?>
						</div>

						<div class="bc-item-bottom">
							<div class="bc-qty-wrap">
								<button class="bc-qty-btn minus" data-key="<?php echo esc_attr( $popsi_cart_cart_item_key ); ?>" data-qty="<?php echo (int) $popsi_cart_cart_item['quantity'] - 1; ?>">-</button>
								<span class="bc-qty-val"><?php echo esc_html( $popsi_cart_cart_item['quantity'] ); ?></span>
								<button class="bc-qty-btn plus" data-key="<?php echo esc_attr( $popsi_cart_cart_item_key ); ?>" data-qty="<?php echo (int) $popsi_cart_cart_item['quantity'] + 1; ?>">+</button>
							</div>

							<?php
							$popsi_cart_applied_coupons = WC()->cart->get_applied_coupons();
							if ( ! empty( $popsi_cart_applied_coupons ) ) :
								?>
								<div class="bc-item-coupons">
									<?php foreach ( $popsi_cart_applied_coupons as $popsi_cart_coupon_code ) : ?>
										<div class="bc-item-discount-badge">
											<?php
											$popsi_cart_icon_name  = 'tag';
											$popsi_cart_icon_class = 'bc-badge-icon';
											include POPSI_CART_PATH . 'templates/icons.php';
											?>
											<span class="bc-badge-text"><?php echo esc_html( strtoupper( $popsi_cart_coupon_code ) ); ?></span>
										</div>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<?php
			}
		endforeach;
		?>
	</div>
<?php endif; ?>
