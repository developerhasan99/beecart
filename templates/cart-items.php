<?php
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
	<?php
	$popsi_cart_progress_bars = $popsi_cart_settings['progress_bars'] ?? array();
	if ( $popsi_cart_enable_rewards_bar && ! empty( $popsi_cart_progress_bars ) && ( ! $popsi_cart_is_empty || ( $popsi_cart_settings['show_rewards_on_empty'] ?? true ) ) ) :
		?>
		<div class="bc-rewards-bars-wrap" style="flex-direction: <?php echo esc_attr( $popsi_cart_settings['rewards_bars_layout'] ?? 'column' ); ?>;">
			<?php
			foreach ( $popsi_cart_progress_bars as $popsi_cart_bar ) :
				$popsi_cart_type        = $popsi_cart_bar['type'] ?? 'subtotal';
				$popsi_cart_current_val = ( $popsi_cart_type === 'quantity' ) ? $popsi_cart_cart->get_cart_contents_count() : (float) $popsi_cart_cart->get_subtotal();
				$popsi_cart_goals       = ! empty( $popsi_cart_bar['checkpoints'] ) ? $popsi_cart_bar['checkpoints'] : array();

				usort(
					$popsi_cart_goals,
					function ( $a, $b ) {
						return (float) $a['threshold'] - (float) $b['threshold'];
					}
				);

				$popsi_cart_next_goal = null;
				foreach ( $popsi_cart_goals as $popsi_cart_goal ) {
					if ( $popsi_cart_current_val < (float) $popsi_cart_goal['threshold'] ) {
						$popsi_cart_next_goal = $popsi_cart_goal;
						break;
					}
				}

				$popsi_cart_max_threshold = ! empty( $popsi_cart_goals ) ? (float) end( $popsi_cart_goals )['threshold'] : 100;
				$popsi_cart_percent       = $popsi_cart_max_threshold > 0 ? min( ( $popsi_cart_current_val / $popsi_cart_max_threshold ) * 100, 100 ) : 100;

				if ( empty( $popsi_cart_goals ) ) {
					continue;
				}
				?>
				<div class="bc-progress-wrap">
					<div class="bc-progress-text" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;">
						<?php
						if ( $popsi_cart_next_goal ) :
							$popsi_cart_diff        = (float) $popsi_cart_next_goal['threshold'] - $popsi_cart_current_val;
							$popsi_cart_amount_text = ( $popsi_cart_type === 'subtotal' ) ? wc_price( $popsi_cart_diff ) : (int) $popsi_cart_diff;
							$popsi_cart_msg         = $popsi_cart_bar['away_text'] ?? "You're only {amount} away from {goal}";
							$popsi_cart_msg         = str_replace( '{amount}', '<strong>' . $popsi_cart_amount_text . '</strong>', $popsi_cart_msg );
							$popsi_cart_msg         = str_replace( '{goal}', '<strong>' . esc_html( $popsi_cart_next_goal['label'] ) . '</strong>', $popsi_cart_msg );
							echo wp_kses_post( $popsi_cart_msg );
						else :
							?>
							<?php echo esc_html( $popsi_cart_bar['completed_text'] ?? '🎉 Congratulations! You have unlocked all rewards.' ); ?>
						<?php endif; ?>
					</div>

					<div class="bc-progress-bar" style="background-color: <?php echo esc_attr( $popsi_cart_settings['rewards_bar_bg'] ?? '#E2E2E2' ); ?>; margin-bottom: <?php echo ( $popsi_cart_bar['show_labels'] ?? true ) ? '24px' : '0'; ?>;">
						<div class="bc-progress-fill" style="width: <?php echo esc_attr( $popsi_cart_percent ); ?>%; background-color: <?php echo esc_attr( $popsi_cart_settings['rewards_bar_fg'] ?? '#93D3FF' ); ?>;"></div>

						<div class="bc-checkpoints">
							<?php
							foreach ( $popsi_cart_goals as $popsi_cart_goal ) :
								$popsi_cart_goal_val = (float) $popsi_cart_goal['threshold'];
								$popsi_cart_reached  = $popsi_cart_current_val >= $popsi_cart_goal_val;
								$popsi_cart_pos      = ( $popsi_cart_goal_val / $popsi_cart_max_threshold ) * 100;
								$popsi_cart_icon_key = $popsi_cart_goal['icon'] ?? 'truck';
								?>
								<div class="bc-checkpoint <?php echo esc_attr( $popsi_cart_reached ? 'is-reached' : '' ); ?>"
									style="left: <?php echo esc_attr( $popsi_cart_pos ); ?>%; 
										background-color: <?php echo esc_attr( $popsi_cart_reached ? ( $popsi_cart_settings['rewards_bar_fg'] ?? '#93D3FF' ) : ( $popsi_cart_settings['rewards_bar_bg'] ?? '#E2E2E2' ) ); ?>;
										color: <?php echo esc_attr( $popsi_cart_reached ? ( $popsi_cart_settings['rewards_complete_icon_color'] ?? '#4D4949' ) : ( $popsi_cart_settings['rewards_incomplete_icon_color'] ?? '#4D4949' ) ); ?>;">
									<?php
									$popsi_cart_icon_name  = $popsi_cart_icon_key;
									$popsi_cart_icon_class = 'bc-checkpoint-icon';
									include POPSI_CART_PATH . 'templates/icons.php';
									?>
									<?php if ( $popsi_cart_bar['show_labels'] ?? true ) : ?>
										<div class="bc-checkpoint-label" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;">
											<?php echo esc_html( $popsi_cart_goal['label'] ); ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ( ! $popsi_cart_is_empty ) : ?>
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
						<?php if ( $popsi_cart_show_item_images !== false ) : ?>
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
								<?php if ( $popsi_cart_has_sale && $popsi_cart_show_strikethrough !== false ) : ?>
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
	<?php else : ?>
		<div class="bc-empty-cart">
			<svg class="bc-empty-cart-icon" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
				<circle cx="9" cy="21" r="1"></circle>
				<circle cx="20" cy="21" r="1"></circle>
				<path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
			</svg>
			<p class="bc-empty-cart-text" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;"><?php echo esc_html( $popsi_cart_settings['trans_empty_cart'] ?? 'Your cart is empty.' ); ?></p>
			<button class="bc-empty-cart-btn"
				style="background-color: <?php echo esc_attr( $popsi_cart_btn_color ); ?>; color: <?php echo esc_attr( $popsi_cart_btn_text_color ); ?>; border-radius: <?php echo esc_attr( $popsi_cart_btn_radius ); ?>;">
				<?php echo esc_html( $popsi_cart_settings['trans_continue_shopping'] ?? 'Return to shop' ); ?>
			</button>
		</div>
	<?php endif; ?>

	<?php
	$popsi_cart_show_on_empty = $popsi_cart_settings['show_upsells_on_empty'] ?? true;
	if ( $popsi_cart_show_upsells && ( ! $popsi_cart_is_empty || $popsi_cart_show_on_empty ) ) :
		$popsi_cart_upsell_title     = $popsi_cart_settings['upsell_title'] ?? 'Product Recommendations';
		$popsi_cart_upsell_max       = max( 1, (int) ( $popsi_cart_settings['upsell_max'] ?? 3 ) );
		$popsi_cart_upsell_source    = $popsi_cart_settings['upsell_source'] ?? 'best_sellers';
		$popsi_cart_upsell_category  = $popsi_cart_settings['upsell_category'] ?? '';
		$popsi_cart_upsell_query_ids = $this->get_upsell_query_ids(
			is_array( $popsi_cart_items ) ? $popsi_cart_items : array(),
			$popsi_cart_upsell_source,
			$popsi_cart_upsell_max,
			$popsi_cart_upsell_category
		);

		$popsi_cart_upsell_query = new WP_Query(
			array(
				'post_type'           => 'product',
				'post__in'            => ! empty( $popsi_cart_upsell_query_ids ) ? $popsi_cart_upsell_query_ids : array( 0 ),
				'orderby'             => 'post__in',
				'posts_per_page'      => $popsi_cart_upsell_max,
				'no_found_rows'       => true,
				'ignore_sticky_posts' => true,
			)
		);

		if ( $popsi_cart_upsell_query->have_posts() ) :
			?>
			<div class="bc-upsells" style="background-color: <?php echo esc_attr( $popsi_cart_settings['accent_color'] ?? '#f9fafb' ); ?>;">
				<h3 class="bc-upsells-title" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;"><?php echo esc_html( $popsi_cart_upsell_title ); ?></h3>

				<div class="bc-upsells-list">
					<?php
					while ( $popsi_cart_upsell_query->have_posts() ) :
						$popsi_cart_upsell_query->the_post();
						global $product;
						$popsi_cart_upsell_img = wp_get_attachment_image_url( $product->get_image_id(), 'thumbnail' );

						$popsi_cart_prices_json        = '';
						$popsi_cart_product_variations = array();
						if ( $product->is_type( 'variable' ) ) {
							$popsi_cart_p_map              = array();
							$popsi_cart_product_variations = $product->get_available_variations();
							foreach ( $popsi_cart_product_variations as $popsi_cart_v ) {
								$popsi_cart_p_map[ $popsi_cart_v['variation_id'] ] = wp_strip_all_tags( wc_price( $popsi_cart_v['display_price'] ) );
							}
							$popsi_cart_prices_json = wp_json_encode( $popsi_cart_p_map );
						}
						?>
						<div class="bc-upsell-item" data-id="<?php echo esc_attr( get_the_ID() ); ?>" 
						<?php
						if ( $popsi_cart_prices_json ) {
							echo ' data-prices="' . esc_attr( $popsi_cart_prices_json ) . '"';}
						?>
						>
							<div class="bc-upsell-img-wrap">
								<a href="<?php echo esc_url( get_permalink() ); ?>" class="bc-upsell-link">
									<?php if ( $popsi_cart_upsell_img ) : ?>
										<img src="<?php echo esc_url( $popsi_cart_upsell_img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>">
									<?php else : ?>
										<?php
										$popsi_cart_icon_name  = 'format-image';
										$popsi_cart_icon_class = 'bc-placeholder-icon';
										include POPSI_CART_PATH . 'templates/icons.php';
										?>
									<?php endif; ?>
								</a>
							</div>
							<div class="bc-upsell-details">
								<h5 class="bc-upsell-title">
									<a href="<?php echo esc_url( get_permalink() ); ?>" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>; text-decoration: none;">
										<?php the_title(); ?>
									</a>
								</h5>
								<div class="bc-upsell-prices">
									<span class="bc-upsell-price" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;">
										<?php echo wp_kses_post( $product->get_price_html() ); ?>
									</span>
								</div>
								<div class="bc-upsell-actions">
									<?php
									if ( $product->is_type( 'variable' ) ) :
										if ( ! empty( $popsi_cart_product_variations ) ) :
											?>
											<div class="bc-upsell-select-wrap">
												<select class="bc-upsell-select" data-product-id="<?php echo esc_attr( get_the_ID() ); ?>">
													<?php foreach ( $popsi_cart_product_variations as $popsi_cart_v ) : ?>
														<option value="<?php echo esc_attr( $popsi_cart_v['variation_id'] ); ?>">
															<?php echo esc_html( implode( ' / ', array_values( $popsi_cart_v['attributes'] ) ) ); ?>
														</option>
													<?php endforeach; ?>
												</select>
												<span class="bc-upsell-select-icon">
													<?php
													$popsi_cart_icon_name  = 'chevron-down';
													$popsi_cart_icon_class = '';
													include POPSI_CART_PATH . 'templates/icons.php';
													?>
												</span>
											</div>
											<?php
									endif;
									endif;
									?>
									<button class="bc-upsell-add"
										onmouseenter="this.style.backgroundColor = '<?php echo esc_attr( $popsi_cart_btn_hover_color ); ?>'; this.style.color = '<?php echo esc_attr( $popsi_cart_btn_hover_text_color ); ?>'"
										onmouseleave="this.style.backgroundColor = '<?php echo esc_attr( $popsi_cart_btn_color ); ?>'; this.style.color = '<?php echo esc_attr( $popsi_cart_btn_text_color ); ?>'"
										style="background-color: <?php echo esc_attr( $popsi_cart_btn_color ); ?>; color: <?php echo esc_attr( $popsi_cart_btn_text_color ); ?>; border-radius: <?php echo esc_attr( $popsi_cart_btn_radius ); ?>;"
										data-id="<?php echo esc_attr( get_the_ID() ); ?>">
										<?php echo esc_html( $popsi_cart_settings['upsell_btn_text'] ?? 'Add' ); ?>
									</button>
								</div>
							</div>
						</div>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		<?php endif; ?>
	<?php endif; ?>

</div><!-- end bc-cart-contents-scroll -->
<!-- Fixed Footer Area -->
<?php if ( ! $popsi_cart_is_empty ) : ?>
	<div class="bc-drawer-footer" style="background-color: <?php echo esc_attr( $popsi_cart_bg_color ); ?>; margin-top: auto;">
		<?php if ( $popsi_cart_enable_coupon ) : ?>
			<div class="bc-coupon-accordion">
				<button type="button" class="bc-coupon-toggle" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;">
					<span><?php echo esc_html( $popsi_cart_settings['trans_coupon_accordion_title'] ?? 'Have a Coupon?' ); ?></span>
					<span class="bc-coupon-toggle-icon">
						<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down">
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
					<?php if ( $popsi_cart_applied_coupons_footer = $popsi_cart_cart->get_applied_coupons() ) : ?>
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
