<?php if (! defined('ABSPATH')) exit; ?>
<div class="fixed top-8 right-0 bottom-0 z-10 w-[420px] bg-white border-l border-gray-200 flex flex-col transition-all duration-300 shadow-2xl"
    style="background-color: <?php echo esc_attr($settings['bg_color'] ?? '#FFFFFF'); ?>;
            color: <?php echo esc_attr($settings['text_color'] ?? '#000000'); ?>;
            <?php echo ($settings['inherit_fonts'] ?? true) ? '' : 'font-family: sans-serif;'; ?>">

    <!-- Side Cart Header Preview -->
    <div class="p-6 border-0 border-b border-solid border-gray-200 flex justify-between items-center" style="border-color: <?php echo esc_attr($settings['accent_color'] ?? '#f6f6f7'); ?>;">
        <h2 class="text-lg font-semibold my-0"><?php echo esc_html($settings['cart_title'] ?? 'Your Cart'); ?></h2>
        <?php if ($settings['show_close_icon'] ?? true) : ?>
            <button class="bg-gray-100 border-0 rounded size-8 flex items-center justify-center cursor-pointer" style="background-color: <?php echo esc_attr($settings['accent_color'] ?? '#f6f6f7'); ?>;">
                <span class="dashicons dashicons-no-alt"></span>
            </button>
        <?php endif; ?>
    </div>

    <!-- Side Cart Body Preview -->
    <div class="flex-1 overflow-y-auto p-6 space-y-6">
        <!-- Announcement Bar -->
        <?php if ($settings['show_announcement'] ?? false) : ?>
            <div class="mb-4 p-3 text-center text-xs font-medium rounded-lg"
                style="background-color: <?php echo esc_attr($settings['announcement_bg'] ?? '#000000'); ?>; 
                        color: <?php echo esc_attr($settings['announcement_text_color'] ?? '#ffffff'); ?>;">
                <?php echo esc_html($settings['announcement_text'] ?? 'Free shipping on orders over $50!'); ?>
            </div>
        <?php endif; ?>

        <!-- Progress Bar Component -->
        <div class="rounded-lg p-4" style="background-color: <?php echo esc_attr($settings['accent_color'] ?? '#f6f6f7'); ?>;">
            <div class="text-sm text-center mb-3">
                You are <span class="font-bold">$45.00</span> away from <strong style="color: <?php echo esc_attr($settings['btn_color'] ?? '#000000'); ?>">Free Shipping</strong>
            </div>

            <div class="relative h-2 bg-gray-200 rounded-full overflow-visible">
                <div class="absolute top-0 left-0 h-full rounded-full transition-all duration-500" style="width: 45%; background-color: <?php echo esc_attr($settings['btn_color'] ?? '#000000'); ?>;"></div>

                <!-- Dynamic Checkpoints -->
                <div id="bee-preview-checkpoints" class="absolute inset-0 pointer-events-none">
                    <?php
                    $goals = $settings['goals'] ?? [];
                    // Simple max threshold for preview percentage calculation (e.g. 100)
                    $max_threshold = 100;
                    if (!empty($goals)) {
                        $max_threshold = max(100, (float)end($goals)['threshold']);
                    }
                    foreach ($goals as $goal) :
                        $left = ((float)$goal['threshold'] / $max_threshold) * 100;
                    ?>
                        <div class="absolute top-1/2 -translate-y-1/2 text-white rounded-full p-1 flex items-center justify-center shadow-md border-2 border-solid border-white group/checkpoint"
                            style="left: <?php echo $left; ?>%; width: 24px; height: 24px; transform: translate(-50%, -50%); background-color: <?php echo esc_attr($settings['btn_color'] ?? '#000000'); ?>;">
                            <span class="dashicons dashicons-<?php echo esc_attr($goal['icon'] ?? 'truck'); ?> text-[12px] leading-none"></span>

                            <!-- Simple tooltip for preview -->
                            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 bg-gray-900 text-[9px] rounded opacity-0 group-hover/checkpoint:opacity-100 transition-opacity whitespace-nowrap">
                                <?php echo esc_html($goal['label']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Cart Item Example -->
        <div class="flex gap-4">
            <?php if ($settings['show_item_images'] ?? true) : ?>
                <div class="w-20 h-20 rounded-md flex items-center justify-center shrink-0" style="background-color: <?php echo esc_attr($settings['accent_color'] ?? '#f6f6f7'); ?>;">
                    <span class="dashicons dashicons-format-image text-3xl text-gray-300 opacity-50"></span>
                </div>
            <?php endif; ?>
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
                        <?php if ($settings['show_strikethrough'] ?? true) : ?>
                            <span class="text-xs line-through mr-1 text-red-400">$150.00</span>
                        <?php endif; ?>
                        <span class="text-sm font-semibold">$120.00</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommended Upsell -->
        <?php if ($settings['show_upsells'] ?? true) : ?>
            <div class="pt-4 border-t border-solid border-gray-100">
                <h4 class="text-sm font-semibold mb-3"><?php echo esc_html($settings['upsell_title'] ?? 'Complete your look'); ?></h4>
                <div class="flex items-center gap-3 p-3 border border-solid border-gray-100 rounded-lg">
                    <div class="w-12 h-12 bg-gray-100 rounded shrink-0" style="background-color: <?php echo esc_attr($settings['accent_color'] ?? '#f6f6f7'); ?>;"></div>
                    <div class="flex-1">
                        <h5 class="text-sm font-medium leading-none mb-1 text-gray-500">Premium Polish</h5>
                        <span class="text-sm font-semibold" style="color: <?php echo esc_attr($settings['savings_text_color'] ?? '#2ea818'); ?>;">$15.00</span>
                    </div>
                    <button class="shrink-0 h-8 px-3 text-xs font-medium text-white border-0 transition-opacity hover:opacity-90 cursor-pointer"
                        style="background-color: <?php echo esc_attr($settings['btn_color'] ?? '#000000'); ?>; 
                               color: <?php echo esc_attr($settings['btn_text_color'] ?? '#FFFFFF'); ?>;
                               border-radius: <?php echo esc_attr($settings['btn_radius'] ?? '0px'); ?>;">Add</button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Side Cart Footer Preview -->
    <div class="p-4 border-t border-solid border-gray-200 bg-white space-y-4" style="background-color: <?php echo esc_attr($settings['bg_color'] ?? '#FFFFFF'); ?>;">
        <div id="preview-coupon-section" class="flex gap-2" style="<?php echo empty($settings['enable_coupon']) ? 'display: none;' : ''; ?>">
            <input type="text" placeholder="Gift card or discount code" class="flex-1 h-10 px-3 text-sm border border-solid border-gray-300 rounded-md bg-white">
            <button class="h-10 px-4 text-sm font-medium rounded-md border-0 cursor-pointer" style="background-color: <?php echo esc_attr($settings['accent_color'] ?? '#f6f6f7'); ?>; color: <?php echo esc_attr($settings['text_color'] ?? '#000000'); ?>;">Apply</button>
        </div>

        <?php if ($settings['enable_subtotal_line'] ?? true) : ?>
            <div class="flex justify-between items-center text-sm font-medium border-0 border-b border-dashed border-gray-200 pb-2">
                <span>Subtotal</span>
                <span class="font-semibold">$120.00</span>
            </div>
        <?php endif; ?>

        <div class="flex justify-between items-center text-sm font-medium">
            <span class="text-lg">Total</span>
            <span class="text-lg font-bold" style="color: <?php echo esc_attr($settings['btn_color'] ?? '#000000'); ?>;">$120.00</span>
        </div>

        <button class="w-full h-12 text-base font-semibold text-white border-0 flex items-center justify-center gap-2 shadow-md hover:opacity-95 transition-all cursor-pointer"
            style="background-color: <?php echo esc_attr($settings['btn_color'] ?? '#000000'); ?>; 
                       color: <?php echo esc_attr($settings['btn_text_color'] ?? '#FFFFFF'); ?>;
                       border-radius: <?php echo esc_attr($settings['btn_radius'] ?? '0px'); ?>;">
            Checkout <span class="opacity-80">•</span> $120.00
        </button>

        <!-- Trust Badges -->
        <?php if ($settings['show_trust_badges'] ?? true) : ?>
            <div class="pt-4 border-t border-solid border-gray-100 text-center">
                <span class="text-[10px] uppercase font-bold text-gray-400 tracking-widest block mb-3"><?php echo esc_html($settings['trust_badges_title'] ?? 'Secure Checkout'); ?></span>
                <div class="flex flex-wrap justify-center gap-3 opacity-60 grayscale">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d1/Visa_2014_logo_detail.svg" class="h-4" alt="Visa">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b7/MasterCard_Logo.svg" class="h-4" alt="Mastercard">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" class="h-4" alt="PayPal">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/30/Apple_Pay_logo.svg" class="h-4" alt="Apple Pay">
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
</content>