<?php if ( ! defined( 'ABSPATH' ) ) {
	exit;} ?>
<div x-data class="bc-drawer-wrap">
	<div class="bc-drawer-panel !top-[46px] md:!top-8 relative"
		:style="{
			transform: $store.admin.preview ? 'translateX(0px)' : 'translateX(100%)',
			backgroundColor: $store.admin.settings.bg_color || '#FFFFFF',
			color: $store.admin.settings.text_color || '#000000',
			fontFamily: $store.admin.settings.inherit_fonts ? 'inherit' : 'sans-serif'
		}">
		<button @click="$store.admin.preview = !$store.admin.preview" class="absolute top-32 right-full py-2 pr-3 pl-4 rounded-l-full bg-gray-900 text-white border-0 z-50 leading-none cursor-pointer" x-text="$store.admin.preview ? 'Hide Preview' : 'Show Preview'"></button>

		<!-- Side Cart Header Preview -->
		<div class="bc-drawer-header">
			<h2 class="bc-drawer-title" :style="{ color: $store.admin.settings.text_color || '#000000' }">
				<span x-text="$store.admin.settings.cart_title || 'Your Cart'"></span>
				<template x-if="$store.admin.settings.show_cart_count !== false">
					<span><span class="bc-drawer-title-sep">•</span> 2</span>
				</template>
			</h2>
			<button @click="$store.admin.preview = false" class="bc-drawer-close" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f6f6f7' }">
				<span class="dashicons dashicons-no-alt" style="color: #6b7280;"></span>
			</button>
		</div>

		<!-- Side Cart Body Preview -->
		<div class="bc-drawer-body">
			<!-- Top Notices area (Announcement and Timer) -->
			<template x-if="$store.admin.settings.show_announcement">
				<div class="bc-announcement"
					:class="{
							'size-small': $store.admin.settings.announcement_bar_size === 'small',
							'size-medium': $store.admin.settings.announcement_bar_size === 'medium' || !$store.admin.settings.announcement_bar_size,
							'size-large': $store.admin.settings.announcement_bar_size === 'large'
						}"
					:style="{
							backgroundColor: $store.admin.settings.announcement_bg || '#fffbeb', 
							color: $store.admin.settings.announcement_text_color || '#92400e',
							fontSize: $store.admin.settings.announcement_font_size || '13px'
						}"
					x-html="($store.admin.settings.announcement_text || 'Your products are reserved for {timer}!').replace('{timer}', '<strong class=\'bc-timer-bold\'>15:00</strong>')">
				</div>
			</template>

			<div class="bc-cart-contents-scroll">
				<!-- Progress Bar Component -->
				<div x-show="$store.admin.settings.enable_rewards_bar" class="bc-rewards-bars-wrap" :style="{ flexDirection: $store.admin.settings.rewards_bars_layout || 'column' }">
					<template x-for="(bar, barIndex) in $store.admin.settings.progress_bars" :key="barIndex">
						<div class="bc-progress-wrap">
							<div class="bc-progress-text" :style="{ color: $store.admin.settings.text_color || '#000000' }">
								<template x-if="barIndex === 0">
									<span x-html="(bar.away_text || 'You\'re only {amount} away from {goal}').replace('{amount}', '<strong>' + (bar.type === 'quantity' ? '2' : '$45.00') + '</strong>').replace('{goal}', '<strong>' + (bar.checkpoints && bar.checkpoints.length ? bar.checkpoints[0].label : 'Free Shipping') + '</strong>')"></span>
								</template>
								<template x-if="barIndex > 0">
									<span x-html="(bar.away_text || 'You\'re only {amount} away from {goal}').replace('{amount}', '<strong>' + (bar.type === 'quantity' ? '5' : '$120.00') + '</strong>').replace('{goal}', '<strong>' + (bar.checkpoints && bar.checkpoints.length ? bar.checkpoints[0].label : 'Next Reward') + '</strong>')"></span>
								</template>
							</div>

							<div class="bc-progress-bar" :style="{ 
								backgroundColor: $store.admin.settings.rewards_bar_bg || '#E2E2E2',
								marginBottom: (bar.show_labels !== false) ? '24px' : '0px'
							}">
								<div class="bc-progress-fill" :style="{ width: (barIndex === 0 ? '65%' : '35%'), backgroundColor: $store.admin.settings.rewards_bar_fg || '#93D3FF' }"></div>

								<div class="bc-checkpoints">
									<template x-for="(cp, cpIndex) in bar.checkpoints" :key="cpIndex">
										<div class="bc-checkpoint shadow-sm"
											:style="{
												left: (cp.threshold / Math.max(10, cp.threshold, ...(bar.checkpoints || []).map(g => g.threshold || 0)) * 100) + '%',
												backgroundColor: (cp.threshold / Math.max(10, cp.threshold, ...(bar.checkpoints || []).map(g => g.threshold || 0)) * 100) <= (barIndex === 0 ? 65 : 35) ? ($store.admin.settings.rewards_bar_fg || '#93D3FF') : ($store.admin.settings.rewards_bar_bg || '#E2E2E2'),
												color: (cp.threshold / Math.max(10, cp.threshold, ...(bar.checkpoints || []).map(g => g.threshold || 0)) * 100) <= (barIndex === 0 ? 65 : 35) ? ($store.admin.settings.rewards_complete_icon_color || '#4D4949') : ($store.admin.settings.rewards_incomplete_icon_color || '#4D4949')
											}">
											<span x-html="popsiCartAdminData.icon_svgs[cp.icon || 'truck'] || ''"></span>
											<template x-if="bar.show_labels !== false">
												<div class="bc-checkpoint-label" :style="{ color: $store.admin.settings.text_color || '#000000' }" x-text="cp.label"></div>
											</template>
										</div>
									</template>
								</div>
							</div>
						</div>
					</template>
				</div>

				<!-- Dummy Item List -->
				<div class="bc-item-list">
					<div class="bc-item">
						<template x-if="$store.admin.settings.show_item_images !== false">
							<div class="bc-item-img-wrap">
								<img src="<?php echo esc_url( POPSI_CART_URL . 'assets/img/demo-product-1.webp' ); ?>" alt="Preview Image" />
							</div>
						</template>
						<div class="bc-item-details">
							<button class="bc-item-remove">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash">
									<path d="M3 6h18"></path>
									<path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
									<path d="M8 6V4c0-.5.2-1 .6-1h6c.4 0 .6.5.6 1v2"></path>
								</svg>
							</button>

							<h4 class="bc-item-title" :style="{ color: $store.admin.settings.text_color || '#000000' }">Placeholder product</h4>
							<p class="bc-item-meta">Size: Medium</p>

							<div class="bc-item-prices">
								<template x-if="$store.admin.settings.show_strikethrough !== false">
									<span class="bc-item-old-price">$120.00</span>
								</template>
								<span class="bc-item-price" :style="{ color: $store.admin.settings.text_color || '#000000' }">$84.00</span>
								<template x-if="$store.admin.settings.show_savings !== false">
									<span class="bc-item-price" style="font-size: 13px;" :style="{ color: $store.admin.settings.savings_text_color || '#2ea818' }" x-text="'(' + ($store.admin.settings.trans_savings_prefix || 'Save') + ' $36.00)'"></span>
								</template>
							</div>

							<div class="bc-item-bottom">
								<div class="bc-qty-wrap" x-data="{qty: 2}">
									<button class="bc-qty-btn minus">-</button>
									<span class="bc-qty-val" x-text="qty"></span>
									<button class="bc-qty-btn plus">+</button>
								</div>
								<div class="bc-item-discount-badge">
									<?php
									$popsi_cart_icon_name  = 'tag';
									$popsi_cart_icon_class = 'bc-badge-icon';
									require POPSI_CART_PATH . 'templates/icons.php';
									?>
									<span class="bc-badge-text">AUTO 5</span>
								</div>
							</div>
						</div>
					</div>

					<div class="bc-item">
						<template x-if="$store.admin.settings.show_item_images !== false">
							<div class="bc-item-img-wrap">
								<img src="<?php echo esc_url( POPSI_CART_URL . 'assets/img/demo-product-2.jpeg' ); ?>" alt="Preview Image 2" />
							</div>
						</template>
						<div class="bc-item-details">
							<button class="bc-item-remove">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash">
									<path d="M3 6h18"></path>
									<path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
									<path d="M8 6V4c0-.5.2-1 .6-1h6c.4 0 .6.5.6 1v2"></path>
								</svg>
							</button>

							<h4 class="bc-item-title" :style="{ color: $store.admin.settings.text_color || '#000000' }">Another great product</h4>
							<p class="bc-item-meta">Color: Black</p>

							<div class="bc-item-prices">
								<span class="bc-item-price" :style="{ color: $store.admin.settings.text_color || '#000000' }">$55.00</span>
							</div>

							<div class="bc-item-bottom">
								<div class="bc-qty-wrap" x-data="{qty: 1}">
									<button class="bc-qty-btn minus">-</button>
									<span class="bc-qty-val" x-text="qty"></span>
									<button class="bc-qty-btn plus">+</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Recommended Upsell -->
				<div x-show="$store.admin.settings.show_upsells" class="bc-upsells" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f6f6f7' }">
					<h3 class="bc-upsells-title" :style="{ color: $store.admin.settings.text_color || '#000000' }" x-text="$store.admin.settings.upsell_title || 'You might also like...'"></h3>

					<div class="bc-upsells-list">
						<div class="bc-upsell-item">
							<div class="bc-upsell-img-wrap">
								<img src="<?php echo esc_url( POPSI_CART_URL . 'assets/img/demo-product-2.jpeg' ); ?>" alt="Bag">
							</div>
							<div class="bc-upsell-details">
								<h5 class="bc-upsell-title" :style="{ color: $store.admin.settings.text_color || '#000000' }">Placeholder product</h5>
								<div class="bc-upsell-prices">
									<span class="bc-upsell-price" :style="{ color: $store.admin.settings.text_color || '#000000' }">$113.00</span>
								</div>
								<div class="bc-upsell-actions">
									<div class="bc-upsell-select-wrap">
										<select class="bc-upsell-select">
											<option>Nutmeg</option>
										</select>
										<span class="bc-upsell-select-icon">
											<?php
											$popsi_cart_icon_name  = 'chevron-down';
											$popsi_cart_icon_class = '';
											require POPSI_CART_PATH . 'templates/icons.php';
											?>
										</span>
									</div>
									<button class="bc-upsell-add"
										@mouseenter="$event.target.style.backgroundColor = ($store.admin.settings.btn_hover_color || '#333333'); $event.target.style.color = ($store.admin.settings.btn_hover_text_color || '#e9e9e9')"
										@mouseleave="$event.target.style.backgroundColor = ($store.admin.settings.btn_color || '#000000'); $event.target.style.color = ($store.admin.settings.btn_text_color || '#FFFFFF')"
										:style="{
										backgroundColor: $store.admin.settings.btn_color || '#000000', 
										color: $store.admin.settings.btn_text_color || '#FFFFFF',
										borderRadius: $store.admin.settings.btn_radius || '4px'
									}">
										<span x-text="$store.admin.settings.upsell_btn_text || 'Add'"></span>
									</button>
								</div>
							</div>
						</div>

						<div class="bc-upsell-item">
							<div class="bc-upsell-img-wrap">
								<img src="<?php echo esc_url( POPSI_CART_URL . 'assets/img/demo-product-1.webp' ); ?>" alt="Product 2">
							</div>
							<div class="bc-upsell-details">
								<h5 class="bc-upsell-title" :style="{ color: $store.admin.settings.text_color || '#000000' }">Sample accessory</h5>
								<div class="bc-upsell-prices">
									<span class="bc-upsell-old-price">$75.00</span>
									<span class="bc-upsell-price" :style="{ color: $store.admin.settings.text_color || '#000000' }">$59.00</span>
								</div>
								<div class="bc-upsell-actions">
									<button class="bc-upsell-add"
										@mouseenter="$event.target.style.backgroundColor = ($store.admin.settings.btn_hover_color || '#333333'); $event.target.style.color = ($store.admin.settings.btn_hover_text_color || '#e9e9e9')"
										@mouseleave="$event.target.style.backgroundColor = ($store.admin.settings.btn_color || '#000000'); $event.target.style.color = ($store.admin.settings.btn_text_color || '#FFFFFF')"
										:style="{
										backgroundColor: $store.admin.settings.btn_color || '#000000', 
										color: $store.admin.settings.btn_text_color || '#FFFFFF',
										borderRadius: $store.admin.settings.btn_radius || '4px'
									}">
										<span x-text="$store.admin.settings.upsell_btn_text || 'Add'"></span>
									</button>
								</div>
							</div>
						</div>

						<div class="bc-upsell-item">
							<div class="bc-upsell-img-wrap">
								<img src="<?php echo esc_url( POPSI_CART_URL . 'assets/img/demo-product-2.jpeg' ); ?>" alt="Product 3">
							</div>
							<div class="bc-upsell-details">
								<h5 class="bc-upsell-title" :style="{ color: $store.admin.settings.text_color || '#000000' }">Bonus bundle</h5>
								<div class="bc-upsell-prices">
									<span class="bc-upsell-price" :style="{ color: $store.admin.settings.text_color || '#000000' }">$39.00</span>
								</div>
								<div class="bc-upsell-actions">
									<button class="bc-upsell-add"
										@mouseenter="$event.target.style.backgroundColor = ($store.admin.settings.btn_hover_color || '#333333'); $event.target.style.color = ($store.admin.settings.btn_hover_text_color || '#e9e9e9')"
										@mouseleave="$event.target.style.backgroundColor = ($store.admin.settings.btn_color || '#000000'); $event.target.style.color = ($store.admin.settings.btn_text_color || '#FFFFFF')"
										:style="{
										backgroundColor: $store.admin.settings.btn_color || '#000000', 
										color: $store.admin.settings.btn_text_color || '#FFFFFF',
										borderRadius: $store.admin.settings.btn_radius || '4px'
									}">
										<span x-text="$store.admin.settings.upsell_btn_text || 'Add'"></span>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Side Cart Footer Preview -->
		<div class="bc-drawer-footer" :style="{ backgroundColor: $store.admin.settings.bg_color || '#FFFFFF' }">

			<div x-show="$store.admin.settings.enable_coupon" class="bc-coupon-accordion" x-data="{ open: false }">
				<button type="button" @click="open = !open" class="bc-coupon-toggle" :style="{ color: $store.admin.settings.text_color || '#000000' }">
					<span x-text="$store.admin.settings.trans_coupon_accordion_title || 'Have a Coupon?'"></span>
					<span class="dashicons dashicons-arrow-down-alt2 bc-coupon-toggle-icon" :class="{ 'is-open': open }"></span>
				</button>
				<div x-show="open" x-collapse
					class="bc-coupon-accordion-content">
					<div class="bc-coupon-wrap">
						<input type="text" :placeholder="$store.admin.settings.trans_coupon_placeholder || 'Coupon code'" class="bc-coupon-input">
						<button class="bc-coupon-btn" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f6f6f7', color: $store.admin.settings.text_color || '#000000', borderRadius: $store.admin.settings.btn_radius || '4px' }" x-text="$store.admin.settings.trans_coupon_apply_btn || 'Apply'"></button>
					</div>
				</div>
			</div>

			<div x-show="$store.admin.settings.enable_subtotal_line" class="bc-summary-row" :style="{ color: $store.admin.settings.text_color || '#000000' }">
				<span x-text="$store.admin.settings.trans_subtotal || 'Subtotal'"></span>
				<span class="val-wrap">$120.00</span>
			</div>

			<div class="bc-summary-row" :style="{ color: $store.admin.settings.text_color || '#000000' }">
				<div class="label-wrap">
					<span x-text="($store.admin.settings.trans_discounts || 'Discounts') + ':'"></span>
					<div class="bc-summary-discount-badge">
						<span class="bc-summary-badge-text">SAVVY15</span>
						<span class="bc-badge-remove">
							<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
								<path d="M18 6 6 18" />
								<path d="m6 6 12 12" />
							</svg>
						</span>
					</div>
				</div>
				<span class="val-wrap bc-discount-val">- $19.50</span>
			</div>

			<div x-show="$store.admin.settings.enable_total_line" class="bc-summary-row bc-total-row" :style="{ color: $store.admin.settings.text_color || '#000000' }">
				<span x-text="$store.admin.settings.trans_total || 'Total'"></span>
				<span class="val-wrap">$84.00</span>
			</div>

			<div x-show="$store.admin.settings.show_shipping_notice" class="bc-shipping-notice" :style="{ color: $store.admin.settings.text_color || '#000000' }" x-text="$store.admin.settings.shipping_notice_text || 'Shipping and taxes will be calculated at checkout.'"></div>

			<div class="bc-checkout-btn-wrap">
				<button class="bc-checkout-btn"
					@mouseenter="$event.target.style.backgroundColor = ($store.admin.settings.btn_hover_color || '#333333'); $event.target.style.color = ($store.admin.settings.btn_hover_text_color || '#e9e9e9')"
					@mouseleave="$event.target.style.backgroundColor = ($store.admin.settings.btn_color || '#000000'); $event.target.style.color = ($store.admin.settings.btn_text_color || '#FFFFFF')"
					:style="{
						backgroundColor: $store.admin.settings.btn_color || '#000000', 
						color: $store.admin.settings.btn_text_color || '#FFFFFF',
						borderRadius: $store.admin.settings.btn_radius || '4px'
					}">
					<span x-text="$store.admin.settings.trans_checkout_btn || 'Zur Kasse'"></span>
					<template x-if="$store.admin.settings.show_subtotal_on_checkout">
						<span style="display: contents;">
							<span class="bc-checkout-sep">•</span>
							<span>€84,00</span>
						</span>
					</template>
				</button>
			</div>

			<!-- Trust Badges -->
			<div x-show="$store.admin.settings.show_trust_badges" class="bc-trust-badges">
				<template x-if="$store.admin.settings.trust_badge_image">
					<img :src="$store.admin.settings.trust_badge_image" alt="Trust badges">
				</template>
			</div>
		</div>
	</div>
</div>