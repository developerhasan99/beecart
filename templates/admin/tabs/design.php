<?php if (! defined('ABSPATH')) exit; ?>
<div x-show="$store.admin.activeTab === 'design'" class="tab-pane p-6" style="display: none;">
    <h2 class="text-lg font-semibold mt-0 mb-6 flex items-center gap-2"><span class="dashicons dashicons-art"></span> Design</h2>

    <div class="space-y-8">
        <!-- General Section -->
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">General</h3>
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="inherit_fonts" name="inherit_fonts" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-gray-900 data-[state=checked]:text-white" <?php checked($settings['inherit_fonts'] ?? true); ?>>
                    <label for="inherit_fonts" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Inherit fonts from theme</label>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="show_strikethrough" name="show_strikethrough" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-gray-900 data-[state=checked]:text-white" <?php checked($settings['show_strikethrough'] ?? true); ?>>
                    <label for="show_strikethrough" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Show strikethrough prices</label>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="enable_subtotal_line" name="enable_subtotal_line" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-gray-900 data-[state=checked]:text-white" <?php checked($settings['enable_subtotal_line'] ?? true); ?>>
                    <label for="enable_subtotal_line" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Enable subtotal line</label>
                </div>
            </div>
        </div>

        <!-- Colors Section -->
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Colors</h3>
            <div class="grid grid-cols-2 gap-y-6 gap-x-4">
                <!-- Background color -->
                <div class="space-y-2" x-data="colorPicker('<?php echo esc_js($settings['bg_color'] ?? '#FFFFFF'); ?>')">
                    <label class="text-sm font-medium">Background color</label>
                    <div class="flex items-center gap-2">
                        <label class="relative cursor-pointer w-10 h-10 rounded-md border border-solid border-gray-200 shadow-sm overflow-hidden shrink-0">
                            <input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                        </label>
                        <input type="text" name="bg_color" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                    </div>
                    <p x-show="!isValid" class="text-xs text-red-500 mt-1" style="display: none;">Invalid hex value</p>
                </div>
                <!-- Cart accent color -->
                <div class="space-y-2" x-data="colorPicker('<?php echo esc_js($settings['accent_color'] ?? '#f6f6f7'); ?>')">
                    <label class="text-sm font-medium">Cart accent color</label>
                    <div class="flex items-center gap-2">
                        <label class="relative cursor-pointer w-10 h-10 rounded-md border border-solid border-gray-200 shadow-sm overflow-hidden shrink-0">
                            <input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                        </label>
                        <input type="text" name="accent_color" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                    </div>
                    <p x-show="!isValid" class="text-xs text-red-500 mt-1" style="display: none;">Invalid hex value</p>
                </div>
                <!-- Cart text color -->
                <div class="space-y-2" x-data="colorPicker('<?php echo esc_js($settings['text_color'] ?? '#000000'); ?>')">
                    <label class="text-sm font-medium">Cart text color</label>
                    <div class="flex items-center gap-2">
                        <label class="relative cursor-pointer w-10 h-10 rounded-md border border-solid border-gray-200 shadow-sm overflow-hidden shrink-0">
                            <input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                        </label>
                        <input type="text" name="text_color" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                    </div>
                    <p x-show="!isValid" class="text-xs text-red-500 mt-1" style="display: none;">Invalid hex value</p>
                </div>
                <!-- Savings text color -->
                <div class="space-y-2" x-data="colorPicker('<?php echo esc_js($settings['savings_text_color'] ?? '#2ea818'); ?>')">
                    <label class="text-sm font-medium">Savings text color</label>
                    <div class="flex items-center gap-2">
                        <label class="relative cursor-pointer w-10 h-10 rounded-md border border-solid border-gray-200 shadow-sm overflow-hidden shrink-0">
                            <input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                        </label>
                        <input type="text" name="savings_text_color" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                    </div>
                    <p x-show="!isValid" class="text-xs text-red-500 mt-1" style="display: none;">Invalid hex value</p>
                </div>
            </div>
        </div>

        <!-- Cart icon Section -->
        <div x-data="{
            iconType: '<?php echo esc_js($settings['cart_icon_type'] ?? 'bag-1'); ?>',
            iconSize: <?php echo (int)($settings['cart_icon_size'] ?? 24); ?>,
            showCountBubble: <?php echo ($settings['show_cart_count'] ?? true) ? 'true' : 'false'; ?>
        }">
            <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Cart icon</h3>
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium">Icon style</label>
                        <div class="flex flex-wrap gap-3">
                            <?php
                            $icon_types = array(
                                'bag-1' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>',
                                'bag-2' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path><circle cx="12" cy="14" r="2" stroke-width="2"></circle></svg>',
                                'cart' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>',
                                'basket' => '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18l-2 9H5l-2-9zm6-5h6l3 5H6l3-5z"></path></svg>'
                            );
                            foreach ($icon_types as $type => $svg):
                            ?>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="cart_icon_type" value="<?php echo $type; ?>" x-model="iconType" class="peer sr-only" <?php checked($settings['cart_icon_type'] ?? 'bag-1', $type); ?>>
                                    <div class="flex items-center justify-center p-3 border border-solid border-gray-200 rounded-lg bg-white hover:bg-gray-50 peer-checked:border-gray-900 peer-checked:ring-1 peer-checked:ring-gray-900 transition-all">
                                        <?php echo $svg; ?>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="space-y-2 rounded-lg bg-gray-200 flex items-center justify-center cursor-not-allowed">
                        <div class="relative flex items-center justify-center p-2 rounded-lg"
                            style="color: <?php echo esc_attr($settings['cart_icon_color'] ?? '#000000'); ?>;">

                            <!-- Bag 1 -->
                            <svg x-show="iconType === 'bag-1'" :style="'width:' + iconSize + 'px; height:' + iconSize + 'px;'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <!-- Bag 2 -->
                            <svg x-show="iconType === 'bag-2'" :style="'width:' + iconSize + 'px; height:' + iconSize + 'px;'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                <circle cx="12" cy="14" r="2" stroke-width="2"></circle>
                            </svg>
                            <!-- Cart -->
                            <svg x-show="iconType === 'cart'" :style="'width:' + iconSize + 'px; height:' + iconSize + 'px;'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <!-- Basket -->
                            <svg x-show="iconType === 'basket'" :style="'width:' + iconSize + 'px; height:' + iconSize + 'px;'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18l-2 9H5l-2-9zm6-5h6l3 5H6l3-5z"></path>
                            </svg>

                            <!-- Bubble -->
                            <div x-show="showCountBubble" class="absolute -top-1 -right-1 min-w-[18px] h-[18px] rounded-full flex items-center justify-center text-[11px] font-bold shadow-sm" style="background-color: #ff0000; color: #ffffff;">
                                3
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Icon Color -->
                    <div class="space-y-2" x-data="colorPicker('<?php echo esc_js($settings['cart_icon_color'] ?? '#000000'); ?>')">
                        <label class="text-sm font-medium">Icon color</label>
                        <div class="flex items-center gap-2">
                            <label class="relative cursor-pointer w-10 h-10 rounded-md border border-solid border-gray-200 shadow-sm overflow-hidden shrink-0">
                                <input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                            </label>
                            <input type="text" name="cart_icon_color" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                        </div>
                        <p x-show="!isValid" class="text-xs text-red-500 mt-1" style="display: none;">Invalid hex value</p>
                    </div>

                    <!-- Icon Size -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium">Icon size (px)</label>
                        <input type="number" name="cart_icon_size" x-model.number="iconSize" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="show_cart_count" name="show_cart_count" x-model="showCountBubble" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2" <?php checked($settings['show_cart_count'] ?? true); ?>>
                    <label for="show_cart_count" class="text-sm font-medium leading-none">Show cart count bubble</label>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- Bubble BG -->
                    <div class="space-y-2" x-data="colorPicker('<?php echo esc_js($settings['cart_bubble_bg'] ?? '#ff0000'); ?>')">
                        <label class="text-sm font-medium">Bubble background</label>
                        <div class="flex items-center gap-2">
                            <label class="relative cursor-pointer w-10 h-10 rounded-md border border-solid border-gray-200 shadow-sm overflow-hidden shrink-0">
                                <input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                            </label>
                            <input type="text" name="cart_bubble_bg" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                        </div>
                        <p x-show="!isValid" class="text-xs text-red-500 mt-1" style="display: none;">Invalid hex value</p>
                    </div>

                    <!-- Bubble Text -->
                    <div class="space-y-2" x-data="colorPicker('<?php echo esc_js($settings['cart_bubble_text'] ?? '#ffffff'); ?>')">
                        <label class="text-sm font-medium">Bubble text color</label>
                        <div class="flex items-center gap-2">
                            <label class="relative cursor-pointer w-10 h-10 rounded-md border border-solid border-gray-200 shadow-sm overflow-hidden shrink-0">
                                <input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                            </label>
                            <input type="text" name="cart_bubble_text" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                        </div>
                        <p x-show="!isValid" class="text-xs text-red-500 mt-1" style="display: none;">Invalid hex value</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button Settings Section -->
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Button settings</h3>
            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium">Corner radius</label>
                    <input type="text" name="btn_radius" value="<?php echo esc_attr($settings['btn_radius'] ?? '0px'); ?>" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2" x-data="colorPicker('<?php echo esc_js($settings['btn_color'] ?? '#000000'); ?>')">
                        <label class="text-sm font-medium">Button color</label>
                        <div class="flex items-center gap-2">
                            <label class="relative cursor-pointer w-10 h-10 rounded-md border border-solid border-gray-200 shadow-sm overflow-hidden shrink-0">
                                <input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                            </label>
                            <input type="text" name="btn_color" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                        </div>
                        <p x-show="!isValid" class="text-xs text-red-500 mt-1" style="display: none;">Invalid hex value</p>
                    </div>
                    <div class="space-y-2" x-data="colorPicker('<?php echo esc_js($settings['btn_text_color'] ?? '#FFFFFF'); ?>')">
                        <label class="text-sm font-medium">Button text color</label>
                        <div class="flex items-center gap-2">
                            <label class="relative cursor-pointer w-10 h-10 rounded-md border border-solid border-gray-200 shadow-sm overflow-hidden shrink-0">
                                <input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                            </label>
                            <input type="text" name="btn_text_color" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                        </div>
                        <p x-show="!isValid" class="text-xs text-red-500 mt-1" style="display: none;">Invalid hex value</p>
                    </div>
                    <div class="space-y-2" x-data="colorPicker('<?php echo esc_js($settings['btn_hover_color'] ?? '#333333'); ?>')">
                        <label class="text-sm font-medium">Button background hover color</label>
                        <div class="flex items-center gap-2">
                            <label class="relative cursor-pointer w-10 h-10 rounded-md border border-solid border-gray-200 shadow-sm overflow-hidden shrink-0">
                                <input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                            </label>
                            <input type="text" name="btn_hover_color" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                        </div>
                        <p x-show="!isValid" class="text-xs text-red-500 mt-1" style="display: none;">Invalid hex value</p>
                    </div>
                    <div class="space-y-2" x-data="colorPicker('<?php echo esc_js($settings['btn_hover_text_color'] ?? '#e9e9e9'); ?>')">
                        <label class="text-sm font-medium">Button text hover color</label>
                        <div class="flex items-center gap-2">
                            <label class="relative cursor-pointer w-10 h-10 rounded-md border border-solid border-gray-200 shadow-sm overflow-hidden shrink-0">
                                <input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                            </label>
                            <input type="text" name="btn_hover_text_color" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                        </div>
                        <p x-show="!isValid" class="text-xs text-red-500 mt-1" style="display: none;">Invalid hex value</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>