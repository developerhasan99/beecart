<?php if (! defined('ABSPATH')) exit;
$settings = get_option('bee_cart_settings', array(
    'progress_type' => 'subtotal',
    'goals' => array(
        array('threshold' => 50, 'label' => 'Free Shipping', 'icon' => 'truck'),
        array('threshold' => 100, 'label' => '20% Discount', 'icon' => 'tag')
    ),
    'primary_color' => '#000000',
    'enable_coupon' => true,
    'enable_badges' => true
));

$icons = array(
    'truck' => 'Truck',
    'tag' => 'Tag',
    'gift' => 'Gift',
    'star' => 'Star',
    'credit-card' => 'Card',
    'check' => 'Check',
    'shopping-bag' => 'Bag'
);
?>

<div class="bee-admin-app bee_mt-6 bee_mr-6 bee_bg-background bee_text-foreground bee_font-sans">

    <div class="bee_flex bee_h-[calc(100vh-80px)] bee_max-w-7xl bee_mx-auto bee_rounded-lg bee_border bee_border-border bee_bg-card bee_overflow-hidden">

        <!-- Navigation Sidebar (Left) -->
        <div class="bee_w-64 bee_border-r bee_border-border bee_bg-muted/30 bee_flex bee_flex-col">
            <!-- Header -->
            <div class="bee_p-4 bee_border-b bee_border-border bee_flex bee_items-center bee_justify-between">
                <div class="bee_flex bee_items-center bee_gap-2">
                    <span class="bee_text-lg bee_font-semibold">Cart editor</span>
                    <span class="bee_px-2 bee_py-0.5 bee_rounded-full bee_bg-green-100 bee_text-green-700 bee_text-xs bee_font-medium">Active</span>
                </div>
            </div>

            <div class="bee_flex-1 bee_overflow-y-auto bee_p-3 bee_py-4 bee_space-y-4">

                <!-- General Section -->
                <div>
                    <h3 class="bee_text-xs bee_font-semibold bee_text-muted-foreground bee_uppercase bee_tracking-wider bee_mb-2 bee_px-3">General</h3>
                    <div class="bee_space-y-1">
                        <button class="bee_w-full bee_text-left bee_px-3 bee_py-2 bee_text-sm bee_rounded-md bee_font-medium bee_bg-secondary bee_text-secondary-foreground bee_tab-btn" data-target="tab-design">
                            <span class="bee_flex bee_items-center bee_gap-2"><span class="dashicons dashicons-art"></span> Design</span>
                        </button>
                        <button class="bee_w-full bee_text-left bee_px-3 bee_py-2 bee_text-sm bee_rounded-md bee_font-medium bee_text-muted-foreground hover:bee_bg-secondary/50 bee_tab-btn" data-target="tab-header">
                            <span class="bee_flex bee_items-center bee_gap-2"><span class="dashicons dashicons-heading"></span> Header</span>
                        </button>
                    </div>
                </div>

                <!-- Body Section -->
                <div>
                    <h3 class="bee_text-xs bee_font-semibold bee_text-muted-foreground bee_uppercase bee_tracking-wider bee_mb-2 bee_px-3">Body</h3>
                    <div class="bee_space-y-1">
                        <button class="bee_w-full bee_text-left bee_px-3 bee_py-2 bee_text-sm bee_rounded-md bee_font-medium bee_text-muted-foreground hover:bee_bg-secondary/50 bee_tab-btn" data-target="tab-rewards">
                            <span class="bee_flex bee_items-center bee_gap-2"><span class="dashicons dashicons-awards"></span> Progress Rewards</span>
                        </button>
                    </div>
                </div>

                <!-- Footer Section -->
                <div>
                    <h3 class="bee_text-xs bee_font-semibold bee_text-muted-foreground bee_uppercase bee_tracking-wider bee_mb-2 bee_px-3">Footer</h3>
                    <div class="bee_space-y-1">
                        <button class="bee_w-full bee_text-left bee_px-3 bee_py-2 bee_text-sm bee_rounded-md bee_font-medium bee_text-muted-foreground hover:bee_bg-secondary/50 bee_tab-btn" data-target="tab-footer">
                            <span class="bee_flex bee_items-center bee_gap-2"><span class="dashicons dashicons-cart"></span> Cart Summary</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bottom Actions -->
            <div class="bee_p-4 bee_border-t bee_border-border bee_flex bee_gap-2">
                <button type="button" class="bee_flex-1 bee_px-4 bee_py-2 bee_text-sm bee_font-medium bee_rounded-md bee_bg-secondary bee_text-secondary-foreground hover:bee_bg-secondary/80">Discard</button>
                <button type="button" id="bee-save-settings" class="bee_flex-1 bee_px-4 bee_py-2 bee_text-sm bee_font-medium bee_rounded-md bee_bg-primary bee_text-primary-foreground hover:bee_bg-primary/90 bee_shadow">Save</button>
            </div>
        </div>

        <!-- Settings Content (Middle Side) -->
        <div class="bee_w-[350px] bee_border-r bee_border-border bee_bg-card bee_flex bee_flex-col bee_overflow-hidden">
            <!-- Panels -->
            <div class="bee_flex-1 bee_overflow-y-auto">
                <div id="tab-design" class="bee_tab-pane bee_p-6 bee_block">
                    <h2 class="bee_text-lg bee_font-semibold bee_mb-6 bee_flex bee_items-center bee_gap-2"><span class="dashicons dashicons-art"></span> Design</h2>

                    <div class="bee_space-y-6">
                        <div class="bee_space-y-2">
                            <label class="bee_text-sm bee_font-medium bee_leading-none peer-disabled:bee_cursor-not-allowed peer-disabled:bee_opacity-70">Primary Theme Color</label>
                            <div class="bee_flex bee_items-center bee_gap-3">
                                <label class="bee_relative bee_cursor-pointer bee_w-10 bee_h-10 bee_rounded-md bee_border bee_border-border bee_shadow-sm bee_overflow-hidden">
                                    <input type="color" name="primary_color" value="<?php echo esc_attr($settings['primary_color']); ?>" class="bee_absolute bee_-inset-2 bee_w-[200%] bee_h-[200%] bee_cursor-pointer">
                                </label>
                                <input type="text" value="<?php echo esc_attr($settings['primary_color']); ?>" class="bee_flex bee_h-10 bee_w-full bee_rounded-md bee_border bee_border-input bee_bg-background bee_px-3 bee_py-2 bee_text-sm bee_ring-offset-background file:bee_border-0 file:bee_bg-transparent file:bee_text-sm file:bee_font-medium placeholder:bee_text-muted-foreground focus-visible:bee_outline-none focus-visible:bee_ring-2 focus-visible:bee_ring-ring focus-visible:bee_ring-offset-2 disabled:bee_cursor-not-allowed disabled:bee_opacity-50" readonly>
                            </div>
                            <p class="bee_text-sm bee_text-muted-foreground">Used for buttons, progress bars, and active states.</p>
                        </div>
                    </div>
                </div>

                <div id="tab-header" class="bee_tab-pane bee_p-6 bee_hidden">
                    <h2 class="bee_text-lg bee_font-semibold bee_mb-6 bee_flex bee_items-center bee_gap-2"><span class="dashicons dashicons-heading"></span> Header</h2>
                    <p class="bee_text-sm bee_text-muted-foreground bee_mb-6">Customize the top part of the side cart.</p>
                </div>

                <div id="tab-rewards" class="bee_tab-pane bee_p-6 bee_hidden">
                    <h2 class="bee_text-lg bee_font-semibold bee_mb-6 bee_flex bee_items-center bee_gap-2"><span class="dashicons dashicons-awards"></span> Progress Rewards</h2>

                    <div class="bee_space-y-6">
                        <div class="bee_space-y-2">
                            <label class="bee_text-sm bee_font-medium">Threshold Basis</label>
                            <select name="progress_type" class="bee_flex bee_h-10 bee_w-full bee_items-center bee_justify-between bee_rounded-md bee_border bee_border-input bee_bg-background bee_px-3 bee_py-2 bee_text-sm bee_ring-offset-background placeholder:bee_text-muted-foreground focus:bee_outline-none focus:bee_ring-2 focus:bee_ring-ring focus:bee_ring-offset-2 disabled:bee_cursor-not-allowed disabled:bee_opacity-50 bee_appearance-none">
                                <option value="subtotal" <?php selected($settings['progress_type'], 'subtotal'); ?>>Cart Subtotal ($)</option>
                                <option value="quantity" <?php selected($settings['progress_type'], 'quantity'); ?>>Total Item Quantity</option>
                            </select>
                        </div>

                        <div class="bee_space-y-4">
                            <div class="bee_flex bee_items-center bee_justify-between">
                                <label class="bee_text-sm bee_font-medium">Reward Checkpoints</label>
                            </div>

                            <div id="bee-goals-list" class="bee_space-y-3">
                                <?php foreach ($settings['goals'] as $index => $goal): ?>
                                    <div class="bee-goal-item bee_rounded-lg bee_border bee_border-border bee_bg-card bee_p-4 bee_shadow-sm bee_relative bee_group">
                                        <button class="bee-remove-goal bee_absolute bee_-top-2 bee_-right-2 bee_rounded-full bee_bg-destructive bee_text-destructive-foreground bee_w-6 bee_h-6 bee_flex bee_items-center bee_justify-center bee_opacity-0 group-hover:bee_opacity-100 bee_transition-opacity bee_shadow-sm">
                                            <span class="dashicons dashicons-no-alt bee_text-sm"></span>
                                        </button>
                                        <div class="bee_grid bee_gap-3">
                                            <div class="bee_grid bee_grid-cols-2 bee_gap-3">
                                                <div class="bee_space-y-1.5">
                                                    <label class="bee_text-xs bee_text-muted-foreground">Threshold</label>
                                                    <input type="number" value="<?php echo esc_attr($goal['threshold']); ?>" class="bee-goal-threshold bee_flex bee_h-9 bee_w-full bee_rounded-md bee_border bee_border-input bee_bg-transparent bee_px-3 bee_py-1 bee_text-sm bee_shadow-sm bee_transition-colors focus-visible:bee_outline-none focus-visible:bee_ring-1 focus-visible:bee_ring-ring">
                                                </div>
                                                <div class="bee_space-y-1.5">
                                                    <label class="bee_text-xs bee_text-muted-foreground">Icon</label>
                                                    <select class="bee-icon-select bee_flex bee_h-9 bee_w-full bee_items-center bee_justify-between bee_rounded-md bee_border bee_border-input bee_bg-transparent bee_px-3 bee_py-1 bee_text-sm bee_shadow-sm bee_ring-offset-background focus:bee_outline-none focus:bee_ring-1 focus:bee_ring-ring">
                                                        <?php foreach ($icons as $val => $name): ?>
                                                            <option value="<?php echo esc_attr($val); ?>" <?php selected($goal['icon'] ?? '', $val); ?>><?php echo esc_html($name); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="bee_space-y-1.5">
                                                <label class="bee_text-xs bee_text-muted-foreground">Reward Label</label>
                                                <input type="text" value="<?php echo esc_attr($goal['label']); ?>" class="bee-goal-label bee_flex bee_h-9 bee_w-full bee_rounded-md bee_border bee_border-input bee_bg-transparent bee_px-3 bee_py-1 bee_text-sm bee_shadow-sm bee_transition-colors focus-visible:bee_outline-none focus-visible:bee_ring-1 focus-visible:bee_ring-ring">
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <button type="button" id="bee-add-goal" class="bee_w-full bee_inline-flex bee_items-center bee_justify-center bee_whitespace-nowrap bee_rounded-md bee_text-sm bee_font-medium bee_ring-offset-background bee_transition-colors focus-visible:bee_outline-none focus-visible:bee_ring-2 focus-visible:bee_ring-ring focus-visible:bee_ring-offset-2 disabled:bee_pointer-events-none disabled:bee_opacity-50 bee_border bee_border-input bee_bg-background hover:bee_bg-accent hover:bee_text-accent-foreground bee_h-9 bee_px-4 bee_py-2">
                                <span class="dashicons dashicons-plus bee_mr-2 bee_text-sm"></span> Add Goal Checkpoint
                            </button>
                        </div>
                    </div>
                </div>

                <div id="tab-footer" class="bee_tab-pane bee_p-6 bee_hidden">
                    <h2 class="bee_text-lg bee_font-semibold bee_mb-6 bee_flex bee_items-center bee_gap-2"><span class="dashicons dashicons-cart"></span> Cart Summary</h2>

                    <div class="bee_space-y-6">
                        <div class="bee_flex bee_items-center bee_space-x-2">
                            <input type="checkbox" id="enable_coupon" name="enable_coupon" class="bee_peer bee_h-4 bee_w-4 bee_shrink-0 bee_rounded-sm bee_border bee_border-primary bee_ring-offset-background focus-visible:bee_outline-none focus-visible:bee_ring-2 focus-visible:bee_ring-ring focus-visible:bee_ring-offset-2 disabled:bee_cursor-not-allowed disabled:bee_opacity-50 data-[state=checked]:bee_bg-primary data-[state=checked]:bee_text-primary-foreground" <?php checked($settings['enable_coupon'] ?? true); ?>>
                            <label for="enable_coupon" class="bee_text-sm bee_font-medium bee_leading-none peer-disabled:bee_cursor-not-allowed peer-disabled:bee_opacity-70">
                                Discount Coupon Field
                            </label>
                        </div>

                        <div class="bee_flex bee_items-center bee_space-x-2">
                            <input type="checkbox" id="enable_badges" name="enable_badges" class="bee_peer bee_h-4 bee_w-4 bee_shrink-0 bee_rounded-sm bee_border bee_border-primary bee_ring-offset-background focus-visible:bee_outline-none focus-visible:bee_ring-2 focus-visible:bee_ring-ring focus-visible:bee_ring-offset-2 disabled:bee_cursor-not-allowed disabled:bee_opacity-50 data-[state=checked]:bee_bg-primary data-[state=checked]:bee_text-primary-foreground" <?php checked($settings['enable_badges'] ?? true); ?>>
                            <label for="enable_badges" class="bee_text-sm bee_font-medium bee_leading-none peer-disabled:bee_cursor-not-allowed peer-disabled:bee_opacity-70">
                                Show Trust Badges
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Preview Panel (Right) -->
        <div class="bee_flex-1 bee_bg-muted/30 bee_flex bee_items-center bee_justify-center bee_p-8 bee_relative bee_overflow-hidden">
            <!-- Background Decoration -->
            <div class="bee_absolute bee_inset-0 bee_bg-grid-slate-200 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))] bee_opacity-20"></div>

            <div class="bee_relative bee_z-10 bee_w-[380px] bee_h-[700px] bee_max-h-full bee_bg-background bee_rounded-xl bee_shadow-2xl bee_border bee_border-border bee_flex bee_flex-col bee_overflow-hidden bee_transition-all bee_duration-300">

                <!-- Side Cart Header Preview -->
                <div class="bee_p-4 bee_border-b bee_border-border bee_flex bee_justify-between bee_items-center">
                    <h2 class="bee_text-lg bee_font-semibold">Your Cart</h2>
                    <button class="bee_p-2 hover:bee_bg-muted bee_rounded-full bee_transition-colors">
                        <span class="dashicons dashicons-no-alt"></span>
                    </button>
                </div>

                <!-- Side Cart Body Preview -->
                <div class="bee_flex-1 bee_overflow-y-auto bee_p-4 bee_space-y-6">

                    <!-- Progress Bar Component -->
                    <div class="bee_bg-secondary/50 bee_rounded-lg bee_p-4">
                        <div class="bee_text-sm bee_text-center bee_mb-3">
                            You are <span class="bee_font-bold">$45.00</span> away from <strong class="bee_text-primary" style="color: <?php echo esc_attr($settings['primary_color']); ?>">Free Shipping</strong>
                        </div>

                        <div class="bee_relative bee_h-2 bee_bg-muted bee_rounded-full bee_overflow-visible">
                            <div class="bee_absolute bee_top-0 bee_left-0 bee_h-full bee_bg-primary bee_rounded-full bee_transition-all bee_duration-500" style="width: 45%; background-color: <?php echo esc_attr($settings['primary_color']); ?>;"></div>

                            <!-- Checkpoints -->
                            <div id="bee-preview-checkpoints" class="bee_absolute bee_inset-0 bee_pointer-events-none">
                                <!-- Will be hydrated by JS, but adding dummy for visual -->
                                <div class="bee_absolute bee_top-1/2 -bee_translate-y-1/2 bee_bg-primary bee_text-primary-foreground bee_rounded-full bee_p-1 bee_flex bee_items-center bee_justify-center bee_shadow-md bee_border-2 bee_border-background" style="left: 50%; width: 24px; height: 24px; transform: translate(-50%, -50%); background-color: <?php echo esc_attr($settings['primary_color']); ?>;">
                                    <span class="dashicons dashicons-truck bee_text-[12px] bee_leading-none"></span>
                                </div>
                                <div class="bee_absolute bee_top-1/2 -bee_translate-y-1/2 bee_bg-background bee_text-muted-foreground bee_rounded-full bee_p-1 bee_flex bee_items-center bee_justify-center bee_shadow-sm bee_border-2 bee_border-muted" style="left: 100%; width: 24px; height: 24px; transform: translate(-50%, -50%);">
                                    <span class="dashicons dashicons-tag bee_text-[12px] bee_leading-none"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cart Item Example -->
                    <div class="bee_flex bee_gap-4">
                        <div class="bee_w-20 bee_h-20 bee_bg-muted bee_rounded-md bee_flex bee_items-center bee_justify-center">
                            <span class="dashicons dashicons-format-image bee_text-3xl bee_text-muted-foreground/30"></span>
                        </div>
                        <div class="bee_flex-1 bee_flex bee_flex-col bee_justify-between">
                            <div class="bee_flex bee_justify-between bee_items-start">
                                <div>
                                    <h4 class="bee_text-sm bee_font-medium">Premium Leather Bag</h4>
                                    <p class="bee_text-xs bee_text-muted-foreground bee_mt-0.5">Brown / One Size</p>
                                </div>
                                <button class="bee_text-muted-foreground hover:bee_text-destructive bee_transition-colors">
                                    <span class="dashicons dashicons-trash bee_text-sm"></span>
                                </button>
                            </div>
                            <div class="bee_flex bee_justify-between bee_items-center bee_mt-2">
                                <div class="bee_flex bee_items-center bee_border bee_border-border bee_rounded-md">
                                    <button class="bee_w-7 bee_h-7 bee_flex bee_items-center bee_justify-center bee_text-muted-foreground hover:bee_bg-muted">-</button>
                                    <span class="bee_w-8 bee_text-center bee_text-sm bee_font-medium">1</span>
                                    <button class="bee_w-7 bee_h-7 bee_flex bee_items-center bee_justify-center bee_text-muted-foreground hover:bee_bg-muted">+</button>
                                </div>
                                <span class="bee_text-sm bee_font-semibold">$120.00</span>
                            </div>
                        </div>
                    </div>

                    <!-- Recommended Upsell -->
                    <div class="bee_pt-4 bee_border-t bee_border-border">
                        <h4 class="bee_text-sm bee_font-semibold bee_mb-3">You might also like</h4>
                        <div class="bee_flex bee_items-center bee_gap-3 bee_p-3 bee_border bee_border-border bee_rounded-lg">
                            <div class="bee_w-12 bee_h-12 bee_bg-muted bee_rounded bee_shrink-0"></div>
                            <div class="bee_flex-1">
                                <h5 class="bee_text-sm bee_font-medium bee_leading-none bee_mb-1">Leather Polish</h5>
                                <span class="bee_text-sm bee_text-muted-foreground">$15.00</span>
                            </div>
                            <button class="bee_shrink-0 bee_h-8 bee_px-3 bee_text-xs bee_font-medium bee_bg-primary bee_text-primary-foreground bee_rounded-md" style="background-color: <?php echo esc_attr($settings['primary_color']); ?>;">Add</button>
                        </div>
                    </div>

                </div>

                <!-- Side Cart Footer Preview -->
                <div class="bee_p-4 bee_border-t bee_border-border bee_bg-card bee_space-y-4">

                    <div id="preview-coupon-section" class="bee_flex bee_gap-2" style="<?php echo empty($settings['enable_coupon']) ? 'display: none;' : ''; ?>">
                        <input type="text" placeholder="Gift card or discount code" class="bee_flex-1 bee_h-10 bee_px-3 bee_text-sm bee_border bee_border-input bee_rounded-md bee_bg-background">
                        <button class="bee_h-10 bee_px-4 bee_text-sm bee_font-medium bee_bg-secondary bee_text-secondary-foreground bee_rounded-md">Apply</button>
                    </div>

                    <div class="bee_flex bee_justify-between bee_items-center bee_text-sm font-medium">
                        <span>Subtotal</span>
                        <span class="bee_text-lg bee_font-semibold">$120.00</span>
                    </div>

                    <button class="bee_w-full bee_h-12 bee_text-base bee_font-semibold bee_bg-primary bee_text-primary-foreground bee_rounded-md bee_flex bee_items-center bee_justify-center bee_gap-2 bee_shadow-md hover:bee_opacity-90 bee_transition-opacity" style="background-color: <?php echo esc_attr($settings['primary_color']); ?>;">
                        Checkout <span class="bee_opacity-80">•</span> $120.00
                    </button>

                    <div id="preview-badges-section" class="bee_flex bee_justify-center bee_gap-3 bee_opacity-60 bee_grayscale" style="<?php echo empty($settings['enable_badges']) ? 'display: none;' : ''; ?>">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" class="bee_h-4" alt="PayPal">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" class="bee_h-4" alt="Visa">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b7/MasterCard_Logo.svg" class="bee_h-4" alt="Mastercard">
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>