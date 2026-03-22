<?php if (! defined('ABSPATH')) exit; ?>
<div class="fixed top-8 right-0 bottom-0 z-10 w-[420px] border-l border-solid border-gray-200 flex flex-col transition-all duration-300 shadow-2xl"
    :style="{
        backgroundColor: $store.admin.settings.bg_color || '#FFFFFF',
        color: $store.admin.settings.text_color || '#000000',
        fontFamily: $store.admin.settings.inherit_fonts ? 'inherit' : 'sans-serif'
    }">

    <!-- Side Cart Header Preview -->
    <div class="px-6 py-5 flex items-center justify-between">
        <h2 class="text-[17px] font-medium m-0 flex items-center leading-none" :style="{ color: $store.admin.settings.text_color || '#000000' }">
            <span x-text="$store.admin.settings.cart_title || 'Your Cart'"></span>
            <template x-if="$store.admin.settings.show_cart_count !== false">
                <span><span class="mx-1.5 opacity-60">•</span> 2</span>
            </template>
        </h2>
        <template x-if="$store.admin.settings.show_close_icon !== false">
            <button class="bg-gray-100 hover:bg-gray-200 border-0 rounded size-[30px] flex items-center justify-center cursor-pointer m-0 p-0 appearance-none shadow-none outline-none transition-colors" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f6f6f7' }">
                <span class="dashicons dashicons-no-alt text-gray-500 text-[16px] mt-0.5"></span>
            </button>
        </template>
    </div>
    
    <div class="w-full h-px bg-gray-200 border-0 m-0 p-0"></div>

    <!-- Side Cart Body Preview -->
    <div class="flex-1 overflow-y-auto px-6 py-5 space-y-6">
        
        <!-- Announcement Bar -->
        <div x-show="$store.admin.settings.show_announcement" class="mb-4 text-center font-medium rounded-lg"
            :class="{
                'p-2 text-xs': $store.admin.settings.announcement_bar_size === 'small',
                'p-3 text-sm': $store.admin.settings.announcement_bar_size === 'medium' || !$store.admin.settings.announcement_bar_size,
                'p-4 text-base': $store.admin.settings.announcement_bar_size === 'large'
            }"
            :style="{
                backgroundColor: $store.admin.settings.announcement_bg || '#000000', 
                color: $store.admin.settings.announcement_text_color || '#ffffff',
                fontSize: $store.admin.settings.announcement_font_size || '13px'
            }"
            x-text="$store.admin.settings.announcement_text || 'Free shipping on orders over $50!'">
        </div>

        <!-- Cart Countdown Timer -->
        <div x-show="$store.admin.settings.enable_timer" class="mb-4 p-3 text-center text-sm font-bold bg-amber-50 border border-solid border-amber-200 text-amber-800 rounded-lg flex items-center justify-center gap-2">
            <span class="dashicons dashicons-clock"></span>
            <span>Cart reserved for <span class="text-lg" x-text="($store.admin.settings.timer_duration || '15') + ':00'"></span> minutes!</span>
        </div>

        <!-- Progress Bar Component -->
        <div x-show="$store.admin.settings.enable_rewards_bar" class="pt-1 pb-4">
            <div class="text-[15.5px] text-center mb-4 leading-tight" :style="{ color: $store.admin.settings.text_color || '#000000' }">
                Only 2 products until <strong class="font-normal" x-text="$store.admin.settings.goals && $store.admin.settings.goals.length ? $store.admin.settings.goals[$store.admin.settings.goals.length - 1].label : 'Free Gift'"></strong>!
            </div>

            <div class="relative h-2.5 rounded-full mx-6 mt-2 mb-6" :style="{ backgroundColor: $store.admin.settings.rewards_bar_bg || '#E2E2E2' }">
                <div class="absolute top-0 left-0 h-full rounded-full transition-all duration-500" :style="{ width: '50%', backgroundColor: $store.admin.settings.rewards_bar_fg || '#93D3FF' }"></div>

                <!-- Dynamic Checkpoints -->
                <div class="absolute inset-0 pointer-events-none">
                    <template x-for="(goal, index) in $store.admin.settings.goals" :key="index">
                        <div class="absolute top-1/2 -translate-y-1/2 text-white rounded-full flex items-center justify-center shadow-sm group/checkpoint"
                            :style="{
                                left: (goal.threshold / Math.max(100, ...($store.admin.settings.goals || []).map(g => g.threshold || 0)) * 100) + '%',
                                width: '26px',
                                height: '26px',
                                transform: 'translate(-50%, -50%)',
                                backgroundColor: (goal.threshold / Math.max(100, ...($store.admin.settings.goals || []).map(g => g.threshold || 0)) * 100) <= 50 ? ($store.admin.settings.rewards_complete_icon_color || '#4D4949') : ($store.admin.settings.rewards_incomplete_icon_color || '#E2E2E2'),
                                color: (goal.threshold / Math.max(100, ...($store.admin.settings.goals || []).map(g => g.threshold || 0)) * 100) <= 50 ? '#FFFFFF' : '#4D4949'
                            }">
                            <span class="dashicons text-[14px] leading-none text-current" :class="'dashicons-' + (goal.icon || 'truck')"></span>

                            <!-- Fixed Label below icon -->
                            <div class="absolute top-full left-1/2 -translate-x-1/2 mt-1.5 text-[11px] font-medium whitespace-nowrap" :style="{ color: $store.admin.settings.text_color || '#000000' }" x-text="goal.label"></div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Dummy Cart Items -->
        <div class="space-y-6 pt-2">
            <div class="flex gap-[18px]">
                <template x-if="$store.admin.settings.show_item_images !== false">
                    <div class="w-24 h-24 rounded flex items-center justify-center shrink-0 border border-solid border-gray-100" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f9fafb' }">
                        <img src="https://via.placeholder.com/80x80?text=Seat" alt="Preview Image" class="max-w-full max-h-full object-contain mix-blend-multiply opacity-80" />
                    </div>
                </template>
                <div class="flex-1 flex flex-col justify-start relative">
                    <button class="absolute top-0 right-0 text-gray-400 hover:text-red-500 transition-colors bg-transparent border-0 p-0 m-0 leading-none cursor-pointer flex items-center shadow-none outline-none appearance-none">
                        <span class="dashicons dashicons-trash text-[16px]"></span>
                    </button>
                    
                    <h4 class="text-base font-semibold m-0 pr-6 pt-0.5 leading-tight" :style="{ color: $store.admin.settings.text_color || '#000000' }">Placeholder product</h4>
                    <p class="text-[13px] font-medium text-gray-400 m-0 mt-1 leading-tight">Size: Medium</p>
                    
                    <div class="flex items-center gap-1.5 mt-1.5">
                        <template x-if="$store.admin.settings.show_strikethrough !== false">
                            <span class="text-[13px] line-through text-gray-400">$120.00</span>
                        </template>
                        <span class="text-[15px] font-bold" :style="{ color: $store.admin.settings.text_color || '#000000' }">$84.00</span>
                        <span class="text-[13px] font-bold ml-0.5" :style="{ color: $store.admin.settings.savings_text_color || '#2ea818' }">(Speichern $36.00)</span>
                    </div>

                    <div class="flex justify-between items-end mt-3">
                        <div class="flex items-center border border-solid border-gray-300 rounded overflow-hidden h-8 bg-white" x-data="{qty: 2}">
                            <button class="w-8 h-full flex items-center justify-center text-gray-600 hover:bg-gray-50 bg-transparent border-0 border-r border-solid border-gray-300 cursor-pointer appearance-none m-0 p-0 shadow-none leading-none">-</button>
                            <span class="w-10 text-center text-[13px] font-semibold leading-none" x-text="qty"></span>
                            <button class="w-8 h-full flex items-center justify-center text-gray-600 hover:bg-gray-50 bg-transparent border-0 border-l border-solid border-gray-300 cursor-pointer appearance-none m-0 p-0 shadow-none leading-none">+</button>
                        </div>
                        <div class="flex items-center gap-[3px] bg-gray-100 rounded px-2 py-1 leading-none border border-solid border-gray-100" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f6f6f7' }">
                            <span class="dashicons dashicons-tag text-gray-500 text-[10px] m-0 p-0 mt-0.5" style="width: 10px; height: 10px;"></span>
                            <span class="text-[10px] font-bold text-gray-600 uppercase tracking-wide">AUTO 5</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Upsell -->
        <div x-show="$store.admin.settings.show_upsells" class="pt-8 mb-4">
            <div class="w-[calc(100%+3rem)] -mx-6 h-px bg-gray-200 border-0 mb-8 m-0 p-0"></div>
            
            <h3 class="text-xl font-medium m-0 mb-6 text-center tracking-tight" :style="{ color: $store.admin.settings.text_color || '#000000' }" x-text="$store.admin.settings.upsell_title || 'Diese werden Sie lieben'"></h3>
            
            <div class="p-4 rounded-xl flex gap-4 items-center border border-solid border-transparent" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f9fafb' }">
                <div class="w-24 h-24 rounded shrink-0 bg-transparent flex items-center justify-center overflow-hidden mix-blend-multiply opacity-90">
                    <img src="https://via.placeholder.com/90x90?text=Bag" alt="Bag" class="max-w-full max-h-full object-contain border-0 m-0">
                </div>
                <div class="flex-1">
                    <h5 class="text-lg font-semibold leading-tight m-0 mb-2" :style="{ color: $store.admin.settings.text_color || '#000000' }">Placeholder product</h5>
                    <div class="flex items-center gap-1.5 mb-2.5">
                        <span class="text-[13px] line-through text-gray-400">$126.00</span>
                        <span class="text-[15px] font-medium" :style="{ color: $store.admin.settings.text_color || '#000000' }">$113.00</span>
                    </div>
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <select class="w-full text-[13px] font-medium text-gray-700 border border-solid border-gray-300 rounded px-2 h-[34px] appearance-none box-border bg-white focus:outline-none focus:ring-1 focus:ring-gray-400 m-0 shadow-none">
                                <option>Nutmeg</option>
                            </select>
                            <span class="dashicons dashicons-arrow-down-alt2 absolute right-1.5 top-1/2 -translate-y-1/2 text-[14px] text-gray-500 pointer-events-none mt-0.5"></span>
                        </div>
                        <button class="h-[34px] px-3.5 text-[13px] font-semibold text-white appearance-none m-0 shadow-none outline-none border-0 transition-opacity hover:opacity-90 cursor-pointer flex items-center justify-center shrink-0 rounded box-border"
                            :style="{
                                backgroundColor: $store.admin.settings.btn_color || '#000000', 
                                color: $store.admin.settings.btn_text_color || '#FFFFFF',
                                borderRadius: $store.admin.settings.btn_radius || '4px'
                            }">
                            <span x-text="$store.admin.settings.upsell_btn_text || 'Hinzufügen'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Side Cart Footer Preview -->
    <div class="p-6 pt-4 border-0 border-t border-solid border-gray-200 bg-white space-y-4 shrink-0" :style="{ backgroundColor: $store.admin.settings.bg_color || '#FFFFFF' }">
        
        <div x-show="$store.admin.settings.enable_coupon" class="flex gap-2">
            <input type="text" :placeholder="$store.admin.settings.trans_coupon_placeholder || 'Coupon code'" class="flex-1 h-11 px-3.5 text-sm border border-solid border-gray-300 rounded bg-white m-0 appearance-none shadow-none outline-none box-border focus:ring-1 focus:ring-gray-300 transition-colors">
            <button class="h-11 px-5 text-[15px] font-semibold rounded border-0 cursor-pointer m-0 appearance-none shadow-none outline-none flex items-center justify-center transition-colors" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f6f6f7', color: $store.admin.settings.text_color || '#000000' }" x-text="$store.admin.settings.trans_coupon_apply_btn || 'Apply'"></button>
        </div>

        <div class="flex justify-between items-center text-[15.5px] pt-1" :style="{ color: $store.admin.settings.text_color || '#000000' }">
            <div class="flex items-center gap-2">
                <span>Rabatte</span>
                <div class="flex items-center gap-1 rounded px-2.5 py-1" :style="{ backgroundColor: $store.admin.settings.accent_color || '#f0f1f2' }">
                    <span class="dashicons dashicons-tag text-gray-500 text-[11px] leading-none mt-0.5" style="width: 12px; height: 12px;"></span>
                    <span class="text-[11px] font-bold text-gray-600 uppercase tracking-wide">AUTO 5</span>
                </div>
            </div>
            <span class="font-medium">- $36.00</span>
        </div>

        <div x-show="$store.admin.settings.enable_subtotal_line" class="flex justify-between items-center text-[15.5px] pt-1 pb-1" :style="{ color: $store.admin.settings.text_color || '#000000' }">
            <span x-text="$store.admin.settings.trans_subtotal || 'Subtotal'"></span>
            <span class="font-medium">$120.00</span>
        </div>

        <div class="pt-1">
            <button class="preview-checkout-btn w-full h-[52px] text-[16.5px] font-semibold text-white border-0 flex items-center justify-center rounded transition-opacity hover:opacity-90 cursor-pointer m-0 appearance-none shadow-none outline-none box-border leading-none"
                @mouseenter="$event.target.style.backgroundColor = ($store.admin.settings.btn_hover_color || '#333333'); $event.target.style.color = ($store.admin.settings.btn_hover_text_color || '#e9e9e9')"
                @mouseleave="$event.target.style.backgroundColor = ($store.admin.settings.btn_color || '#000000'); $event.target.style.color = ($store.admin.settings.btn_text_color || '#FFFFFF')"
                :style="{
                    backgroundColor: $store.admin.settings.btn_color || '#000000', 
                    color: $store.admin.settings.btn_text_color || '#FFFFFF',
                    borderRadius: $store.admin.settings.btn_radius || '4px'
                }">
                <span x-text="$store.admin.settings.trans_checkout_btn || 'Zur Kasse'"></span> 
                <span class="mx-2 font-bold opacity-80 text-sm mt-[1px]">•</span> 
                <span>€84,00</span>
            </button>
        </div>

        <!-- Trust Badges -->
        <div x-show="$store.admin.settings.show_trust_badges" class="pt-2 text-center flex justify-center">
            <template x-if="$store.admin.settings.trust_badge_image">
                <img :src="$store.admin.settings.trust_badge_image" class="h-6 w-auto max-w-full opacity-60 grayscale object-contain mx-auto" alt="Trust badges">
            </template>
        </div>
    </div>
</div>