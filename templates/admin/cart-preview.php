<?php if (! defined('ABSPATH')) exit; ?>
<div class="fixed top-8 right-0 bottom-0 z-10 w-[420px] border-l border-gray-200 flex flex-col transition-all duration-300 shadow-2xl"
    :style="{
        backgroundColor: $store.admin.settings.bg_color || '#FFFFFF',
        color: $store.admin.settings.text_color || '#000000',
        fontFamily: $store.admin.settings.inherit_fonts ? 'inherit' : 'sans-serif'
    }">

    <!-- Side Cart Header Preview -->
    <div class="p-6 border-0 border-b border-solid border-gray-200 flex justify-between items-center" :style="{ borderColor: $store.admin.settings.accent_color || '#f6f6f7' }">
        <h2 class="text-lg font-semibold my-0" x-text="$store.admin.settings.cart_title || 'Your Cart'"></h2>
        <template x-if="$store.admin.settings.show_close_icon !== false">
            <button class="bg-gray-100 border-0 rounded size-8 flex items-center justify-center cursor-pointer" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f6f6f7' }">
                <span class="dashicons dashicons-no-alt"></span>
            </button>
        </template>
    </div>

    <!-- Side Cart Body Preview -->
    <div class="flex-1 overflow-y-auto p-6 space-y-6">
        <!-- Announcement Bar -->
        <div x-show="$store.admin.settings.show_announcement" class="mb-4 text-center font-medium rounded-lg"
            :class="{
                'p-2 text-xs': $store.admin.settings.announcement_bar_size === 'small',
                'p-3 text-sm': $store.admin.settings.announcement_bar_size === 'medium' || !$store.admin.settings.announcement_bar_size,
                'p-4 text-base': $store.admin.settings.announcement_bar_size === 'large'
            }"
            :style="{
                backgroundColor: $store.admin.settings.announcement_bg || '#000000', 
                color: $store.admin.settings.announcement_text_color || '#ffffff'
            }"
            x-text="$store.admin.settings.announcement_text || 'Free shipping on orders over $50!'">
        </div>

        <!-- Cart Countdown Timer -->
        <div x-show="$store.admin.settings.enable_timer" class="mb-4 p-3 text-center text-sm font-bold bg-amber-50 border border-solid border-amber-200 text-amber-800 rounded-lg flex items-center justify-center gap-2">
            <span class="dashicons dashicons-clock"></span>
            <span>Cart reserved for <span class="text-lg" x-text="($store.admin.settings.timer_duration || '15') + ':00'"></span> minutes!</span>
        </div>

        <!-- Progress Bar Component -->
        <div x-show="$store.admin.settings.show_rewards_on_empty" class="rounded-lg p-4" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f6f6f7' }">
            <div class="text-sm text-center mb-3">
                You are <span class="font-bold">$45.00</span> away from <strong :style="{ color: $store.admin.settings.btn_color || '#000000' }">Free Shipping</strong>
            </div>

            <div class="relative h-2 rounded-full overflow-visible" :style="{ backgroundColor: $store.admin.settings.rewards_bar_bg || '#E2E2E2' }">
                <div class="absolute top-0 left-0 h-full rounded-full transition-all duration-500" :style="{ width: '45%', backgroundColor: $store.admin.settings.rewards_bar_fg || '#93D3FF' }"></div>

                <!-- Dynamic Checkpoints -->
                <div class="absolute inset-0 pointer-events-none">
                    <template x-for="(goal, index) in $store.admin.settings.goals" :key="index">
                        <div class="absolute top-1/2 -translate-y-1/2 text-white rounded-full p-1 flex items-center justify-center shadow-md border-2 border-solid border-white group/checkpoint"
                            :style="{
                                left: (goal.threshold / Math.max(100, ...($store.admin.settings.goals || []).map(g => g.threshold || 0)) * 100) + '%',
                                width: '24px',
                                height: '24px',
                                transform: 'translate(-50%, -50%)',
                                backgroundColor: (goal.threshold / Math.max(100, ...($store.admin.settings.goals || []).map(g => g.threshold || 0)) * 100) <= 45 ? ($store.admin.settings.rewards_complete_icon_color || '#4D4949') : ($store.admin.settings.rewards_incomplete_icon_color || '#4D4949')
                            }">
                            <span class="dashicons text-[12px] leading-none" :class="'dashicons-' + (goal.icon || 'truck')"></span>

                            <!-- Simple tooltip for preview -->
                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-[9px] rounded opacity-0 group-hover/checkpoint:opacity-100 transition-opacity whitespace-nowrap" x-text="goal.label"></div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Reward Completed Text -->
        <div x-show="$store.admin.settings.show_rewards_on_empty && 100 <= 45" class="p-3 text-center text-sm font-medium rounded-lg bg-green-50 text-green-800 border border-green-200" x-text="$store.admin.settings.rewards_completed_text">
        </div>

        <!-- Cart Item Example -->
        <div class="flex gap-4">
            <template x-if="$store.admin.settings.show_item_images !== false">
                <div class="w-20 h-20 rounded-md flex items-center justify-center shrink-0" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f6f6f7' }">
                    <span class="dashicons dashicons-format-image text-3xl text-gray-300 opacity-50"></span>
                </div>
            </template>
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-sm font-medium">Premium Leather Bag</h4>
                        <p class="text-xs opacity-60 mt-0.5">Brown / One Size</p>
                    </div>
                    <button class="text-gray-400 hover:text-red-500 transition-colors bg-transparent border-0 p-0 cursor-pointer">
                        <span class="dashicons dashicons-trash text-sm"></span>
                    </button>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <div class="flex items-center border border-gray-200 rounded-md">
                        <button class="w-7 h-7 flex items-center justify-center text-gray-400 hover:bg-gray-100 bg-transparent border-0 border-r border-solid border-gray-200 cursor-pointer">-</button>
                        <span class="w-8 text-center text-sm font-medium">1</span>
                        <button class="w-7 h-7 flex items-center justify-center text-gray-400 hover:bg-gray-100 bg-transparent border-0 border-l border-solid border-gray-200 cursor-pointer">+</button>
                    </div>
                    <div>
                        <template x-if="$store.admin.settings.show_strikethrough !== false">
                            <span class="text-xs line-through mr-1 text-red-400">$150.00</span>
                        </template>
                        <span class="text-sm font-semibold">$120.00</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Upsell -->
        <div x-show="$store.admin.settings.show_upsells" class="pt-4 border-t border-solid border-gray-100">
            <h4 class="text-sm font-semibold mb-3" x-text="$store.admin.settings.upsell_title || 'Complete your look'"></h4>
            <div class="flex items-center gap-3 p-3 border border-solid border-gray-100 rounded-lg">
                <div class="w-12 h-12 rounded shrink-0" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f6f6f7' }"></div>
                <div class="flex-1">
                    <h5 class="text-sm font-medium leading-none mb-1 text-gray-500">Premium Polish</h5>
                    <span class="text-sm font-semibold" :style="{ color: $store.admin.settings.savings_text_color || '#2ea818' }">$15.00</span>
                </div>
                <button class="shrink-0 h-8 px-3 text-xs font-medium text-white border-0 transition-opacity hover:opacity-90 cursor-pointer"
                    :style="{
                        backgroundColor: $store.admin.settings.btn_color || '#000000', 
                        color: $store.admin.settings.btn_text_color || '#FFFFFF',
                        borderRadius: $store.admin.settings.btn_radius || '0px'
                    }">Add</button>
            </div>
        </div>
    </div>

    <!-- Side Cart Footer Preview -->
    <div class="p-4 border-t border-solid border-gray-200 bg-white space-y-4" :style="{ backgroundColor: $store.admin.settings.bg_color || '#FFFFFF' }">
        <div x-show="$store.admin.settings.enable_coupon" class="flex gap-2">
            <input type="text" :placeholder="$store.admin.settings.trans_coupon_placeholder || 'Coupon code'" class="flex-1 h-10 px-3 text-sm border border-solid border-gray-300 rounded-md bg-white">
            <button class="h-10 px-4 text-sm font-medium rounded-md border-0 cursor-pointer" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f6f6f7', color: $store.admin.settings.text_color || '#000000' }" x-text="$store.admin.settings.trans_coupon_apply_btn || 'Apply'"></button>
        </div>

        <div x-show="$store.admin.settings.enable_subtotal_line" class="flex justify-between items-center text-sm font-medium border-0 border-b border-dashed border-gray-200 pb-2">
            <span>Subtotal</span>
            <span class="font-semibold">$120.00</span>
        </div>

        <div class="flex justify-between items-center text-sm font-medium">
            <span class="text-lg">Total</span>
            <span class="text-lg font-bold" :style="{ color: $store.admin.settings.btn_color || '#000000' }">$120.00</span>
        </div>

        <button class="preview-checkout-btn w-full h-12 text-base font-semibold text-white border-0 flex items-center justify-center gap-2 shadow-md transition-all cursor-pointer"
            @mouseenter="$event.target.style.backgroundColor = ($store.admin.settings.btn_hover_color || '#333333'); $event.target.style.color = ($store.admin.settings.btn_hover_text_color || '#e9e9e9')"
            @mouseleave="$event.target.style.backgroundColor = ($store.admin.settings.btn_color || '#000000'); $event.target.style.color = ($store.admin.settings.btn_text_color || '#FFFFFF')"
            :style="{
                backgroundColor: $store.admin.settings.btn_color || '#000000', 
                color: $store.admin.settings.btn_text_color || '#FFFFFF',
                borderRadius: $store.admin.settings.btn_radius || '0px'
            }">
            Checkout <span class="opacity-80">•</span> $120.00
        </button>

        <!-- Trust Badges -->
        <div x-show="$store.admin.settings.show_trust_badges" class="pt-4 border-t border-solid border-gray-100 text-center">
            <span class="text-[10px] uppercase font-bold text-gray-400 tracking-widest block mb-3" x-text="$store.admin.settings.trust_badges_title || 'Secure Checkout'"></span>
            <div class="flex flex-wrap justify-center gap-3 opacity-60 grayscale">
                <template x-if="($store.admin.settings.selected_badges || []).includes('visa')">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d1/Visa_2014_logo_detail.svg" class="h-4" alt="Visa">
                </template>
                <template x-if="($store.admin.settings.selected_badges || []).includes('mastercard')">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b7/MasterCard_Logo.svg" class="h-4" alt="Mastercard">
                </template>
                <template x-if="($store.admin.settings.selected_badges || []).includes('paypal')">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" class="h-4" alt="PayPal">
                </template>
                <template x-if="($store.admin.settings.selected_badges || []).includes('apple-pay')">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/30/Apple_Pay_logo.svg" class="h-4" alt="Apple Pay">
                </template>
                <template x-if="($store.admin.settings.selected_badges || []).includes('google-pay')">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c7/Google_Pay_Logo_%282020%29.svg" class="h-4" alt="Google Pay">
                </template>
            </div>
        </div>
    </div>
</div>