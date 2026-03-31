<?php if (! defined('ABSPATH')) exit; ?>
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
            <div class="bc-drawer-top-notices" style="padding: 0; width: 100%;">
                <!-- Announcement Bar -->
                <div x-show="$store.admin.settings.show_announcement" class="bc-announcement"
                    :class="{
                        'size-small': $store.admin.settings.announcement_bar_size === 'small',
                        'size-medium': $store.admin.settings.announcement_bar_size === 'medium' || !$store.admin.settings.announcement_bar_size,
                        'size-large': $store.admin.settings.announcement_bar_size === 'large'
                    }"
                    :style="{
                        backgroundColor: $store.admin.settings.announcement_bg || '#000000', 
                        color: $store.admin.settings.announcement_text_color || '#ffffff',
                        fontSize: $store.admin.settings.announcement_font_size || '13px',
                        marginBottom: '16px'
                    }"
                    x-text="$store.admin.settings.announcement_text || 'Free shipping on orders over $50!'">
                </div>

                <!-- Cart Countdown Timer -->
                <div x-show="$store.admin.settings.enable_timer" class="bc-timer">
                    <span class="dashicons dashicons-clock"></span>
                    <span>Cart reserved for <span class="bc-timer-val" x-text="($store.admin.settings.timer_duration || '15') + ':00'"></span> minutes!</span>
                </div>
            </div>

            <!-- Progress Bar Component -->
            <div x-show="$store.admin.settings.enable_rewards_bar" class="bc-progress-wrap w-full mt-4">
                <div class="bc-progress-text" :style="{ color: $store.admin.settings.text_color || '#000000' }">
                    Only 2 products until <strong class="font-normal" x-text="$store.admin.settings.goals && $store.admin.settings.goals.length ? $store.admin.settings.goals[$store.admin.settings.goals.length - 1].label : 'Free Gift'"></strong>!
                </div>

                <div class="bc-progress-bar" :style="{ backgroundColor: $store.admin.settings.rewards_bar_bg || '#E2E2E2' }">
                    <div class="bc-progress-fill" :style="{ width: '50%', backgroundColor: $store.admin.settings.rewards_bar_fg || '#93D3FF' }"></div>

                    <!-- Dynamic Checkpoints -->
                    <div class="bc-checkpoints">
                        <template x-for="(goal, index) in $store.admin.settings.goals" :key="index">
                            <div class="bc-checkpoint"
                                :style="{
                                    left: (goal.threshold / Math.max(100, ...($store.admin.settings.goals || []).map(g => g.threshold || 0)) * 100) + '%',
                                    backgroundColor: (goal.threshold / Math.max(100, ...($store.admin.settings.goals || []).map(g => g.threshold || 0)) * 100) <= 50 ? ($store.admin.settings.rewards_complete_icon_color || '#4D4949') : ($store.admin.settings.rewards_incomplete_icon_color || '#E2E2E2'),
                                    color: (goal.threshold / Math.max(100, ...($store.admin.settings.goals || []).map(g => g.threshold || 0)) * 100) <= 50 ? '#FFFFFF' : '#4D4949'
                                }">
                                <span class="dashicons" :class="'dashicons-' + (goal.icon || 'truck')"></span>
                                <!-- Fixed Label below icon -->
                                <div class="bc-checkpoint-label" :style="{ color: $store.admin.settings.text_color || '#000000' }" x-text="goal.label"></div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Dummy Cart Items -->
            <div class="bc-item-list w-full">
                <div class="bc-item">
                    <template x-if="$store.admin.settings.show_item_images !== false">
                        <div class="bc-item-img-wrap">
                            <img src="<?php echo esc_url(BEECART_URL . 'assets/img/demo-product-1.webp'); ?>" alt="Preview Image" />
                        </div>
                    </template>
                    <div class="bc-item-details">
                        <button class="bc-item-remove">
                            <span class="dashicons dashicons-trash text-[16px]"></span>
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
                            <div class="bc-item-discount-badge" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f6f6f7' }">
                                <?php echo BeeCart::get_svg_icon('tag', 'bc-badge-icon'); ?>
                                <span class="bc-badge-text">AUTO 5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recommended Upsell -->
            <div x-show="$store.admin.settings.show_upsells" class="bc-upsells w-full">
                <div class="bc-upsells-divider"></div>

                <h3 class="bc-upsells-title" :style="{ color: $store.admin.settings.text_color || '#000000' }" x-text="$store.admin.settings.upsell_title || 'Diese werden Sie lieben'"></h3>

                <div class="bc-upsell-item" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f9fafb' }">
                    <div class="bc-upsell-img-wrap">
                        <img src="https://via.placeholder.com/90x90?text=Bag" alt="Bag">
                    </div>
                    <div class="bc-upsell-details">
                        <h5 class="bc-upsell-title" :style="{ color: $store.admin.settings.text_color || '#000000' }">Placeholder product</h5>
                        <div class="bc-upsell-prices">
                            <span class="bc-upsell-old-price">$126.00</span>
                            <span class="bc-upsell-price" :style="{ color: $store.admin.settings.text_color || '#000000' }">$113.00</span>
                        </div>
                        <div class="bc-upsell-actions">
                            <div class="bc-upsell-select-wrap">
                                <select class="bc-upsell-select">
                                    <option>Nutmeg</option>
                                </select>
                                <span class="dashicons dashicons-arrow-down-alt2 bc-upsell-select-icon"></span>
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
            </div>
        </div>

        <!-- Side Cart Footer Preview -->
        <div class="bc-drawer-footer" :style="{ backgroundColor: $store.admin.settings.bg_color || '#FFFFFF' }">

            <div x-show="$store.admin.settings.enable_coupon" class="bc-coupon-wrap">
                <input type="text" :placeholder="$store.admin.settings.trans_coupon_placeholder || 'Coupon code'" class="bc-coupon-input">
                <button class="bc-coupon-btn" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f6f6f7', color: $store.admin.settings.text_color || '#000000' }" x-text="$store.admin.settings.trans_coupon_apply_btn || 'Apply'"></button>
            </div>

            <div x-show="$store.admin.settings.enable_subtotal_line" class="bc-summary-row" :style="{ color: $store.admin.settings.text_color || '#000000' }">
                <span x-text="$store.admin.settings.trans_subtotal || 'Subtotal'"></span>
                <span class="val-wrap">$120.00</span>
            </div>

            <div class="bc-summary-row" :style="{ color: $store.admin.settings.text_color || '#000000' }">
                <div class="label-wrap">
                    <span x-text="($store.admin.settings.trans_discounts || 'Discounts') + ':'"></span>
                    <div class="bc-item-discount-badge" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f0f1f2' }">
                        <?php echo BeeCart::get_svg_icon('tag', 'bc-badge-icon'); ?>
                        <span class="bc-badge-text">AUTO 5</span>
                    </div>
                </div>
                <span class="val-wrap">- $36.00</span>
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