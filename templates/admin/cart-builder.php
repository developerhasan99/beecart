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

$sidebar_sections = array(
    array(
        'title' => 'General',
        'tabs' => array(
            array('title' => 'Design', 'handle' => 'design', 'icon' => 'dashicons-art'),
            array('title' => 'Header', 'handle' => 'header', 'icon' => 'dashicons-heading')
        )
    ),
    array(
        'title' => 'Body',
        'tabs' => array(
            array('title' => 'Rewards', 'handle' => 'rewards', 'icon' => 'dashicons-awards')
        )
    ),
    array(
        'title' => 'Footer',
        'tabs' => array(
            array('title' => 'Summary', 'handle' => 'summary', 'icon' => 'dashicons-cart')
        )
    )
);

?>

<div class="pr-[440px] mt-5">
    <!-- Header -->
    <div class="flex items-center justify-between mb-5">
        <h1 class="flex items-center gap-2 my-0">
            <span>Cart editor</span>
            <span class="px-2 py-0.5 rounded-full bg-white text-green-700 text-xs font-medium">Active</span>
        </h1>
        <div class="flex gap-3">
            <button type="button" id="bee-preview-cart" class="px-4 py-2 text-sm font-medium rounded-md leading-none bg-white hover:bg-gray-100 text-gray-900 hover:text-gray-900 shadow cursor-pointer">Discard</button>
            <button type="button" id="bee-save-settings" class="px-4 py-2 text-sm font-medium rounded-md leading-none bg-gray-900 text-white hover:bg-gray-800 shadow cursor-pointer">Save</button>
        </div>
    </div>
    <div class="grid grid-cols-3 gap-5">
        <!-- Navigation Sidebar (Left) -->
        <div class="col-span-1 flex flex-col gap-3">
            <?php foreach ($sidebar_sections as $section) : ?>
                <div>
                    <h3 class="text-xs uppercase tracking-wider mt-0 mb-2 px-3"><?php echo $section['title']; ?></h3>
                    <div class="space-y-1">
                        <?php foreach ($section['tabs'] as $tab) : ?>
                            <button class="w-full text-left px-3 py-2 text-sm rounded-full font-medium bg-transparent hover:bg-white text-gray-700 border-0 tab-btn" data-target="tab-<?php echo $tab['handle']; ?>">
                                <span class="flex items-center gap-2"><span class="dashicons <?php echo $tab['icon']; ?>"></span> <?php echo $tab['title']; ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="pt-2 border-0 border-t border-solid border-gray-200">

            </div>
        </div>

        <!-- Settings Content (Middle Side) -->
        <div class="col-span-2 border border-solid border-gray-300 bg-white flex flex-col overflow-hidden">
            <!-- Panels -->
            <div class="flex-1 overflow-y-auto">
                <div id="tab-design" class="tab-pane p-6 block">
                    <h2 class="text-lg font-semibold mb-6 flex items-center gap-2"><span class="dashicons dashicons-art"></span> Design</h2>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Primary Theme Color</label>
                            <div class="flex items-center gap-3">
                                <label class="relative cursor-pointer w-10 h-10 rounded-md border border-gray-200 shadow-sm overflow-hidden">
                                    <input type="color" name="primary_color" value="<?php echo esc_attr($settings['primary_color']); ?>" class="absolute -inset-2 w-[200%] h-[200%] cursor-pointer">
                                </label>
                                <input type="text" value="<?php echo esc_attr($settings['primary_color']); ?>" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-white file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" readonly>
                            </div>
                            <p class="text-sm text-gray-500">Used for buttons, progress bars, and active states.</p>
                        </div>
                    </div>
                </div>

                <div id="tab-header" class="tab-pane p-6 hidden">
                    <h2 class="text-lg font-semibold mb-6 flex items-center gap-2"><span class="dashicons dashicons-heading"></span> Header</h2>
                    <p class="text-sm text-gray-500 mb-6">Customize the top part of the side cart.</p>
                </div>

                <div id="tab-rewards" class="tab-pane p-6 hidden">
                    <h2 class="text-lg font-semibold mb-6 flex items-center gap-2"><span class="dashicons dashicons-awards"></span> Progress Rewards</h2>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Threshold Basis</label>
                            <select name="progress_type" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 appearance-none">
                                <option value="subtotal" <?php selected($settings['progress_type'], 'subtotal'); ?>>Cart Subtotal ($)</option>
                                <option value="quantity" <?php selected($settings['progress_type'], 'quantity'); ?>>Total Item Quantity</option>
                            </select>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <label class="text-sm font-medium">Reward Checkpoints</label>
                            </div>

                            <div id="bee-goals-list" class="space-y-3">
                                <?php foreach ($settings['goals'] as $index => $goal): ?>
                                    <div class="bee-goal-item rounded-lg border border-gray-200 bg-white p-4 shadow-sm relative group">
                                        <button class="bee-remove-goal absolute -top-2 -right-2 rounded-full bg-red-500 text-white w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-sm">
                                            <span class="dashicons dashicons-no-alt text-sm"></span>
                                        </button>
                                        <div class="grid gap-3">
                                            <div class="grid grid-cols-2 gap-3">
                                                <div class="space-y-1.5">
                                                    <label class="text-xs text-gray-500">Threshold</label>
                                                    <input type="number" value="<?php echo esc_attr($goal['threshold']); ?>" class="bee-goal-threshold flex h-9 w-full rounded-md border border-gray-300 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring">
                                                </div>
                                                <div class="space-y-1.5">
                                                    <label class="text-xs text-gray-500">Icon</label>
                                                    <select class="bee-icon-select flex h-9 w-full items-center justify-between rounded-md border border-gray-300 bg-transparent px-3 py-1 text-sm shadow-sm ring-offset-white focus:outline-none focus:ring-1 focus:ring-ring">
                                                        <?php foreach ($icons as $val => $name): ?>
                                                            <option value="<?php echo esc_attr($val); ?>" <?php selected($goal['icon'] ?? '', $val); ?>><?php echo esc_html($name); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="space-y-1.5">
                                                <label class="text-xs text-gray-500">Reward Label</label>
                                                <input type="text" value="<?php echo esc_attr($goal['label']); ?>" class="bee-goal-label flex h-9 w-full rounded-md border border-gray-300 bg-transparent px-3 py-1 text-sm shadow-sm transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring">
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <button type="button" id="bee-add-goal" class="w-full inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-gray-300 bg-white hover:bg-gray-100 hover:text-gray-900 h-9 px-4 py-2">
                                <span class="dashicons dashicons-plus mr-2 text-sm"></span> Add Goal Checkpoint
                            </button>
                        </div>
                    </div>
                </div>

                <div id="tab-footer" class="tab-pane p-6 hidden">
                    <h2 class="text-lg font-semibold mb-6 flex items-center gap-2"><span class="dashicons dashicons-cart"></span> Cart Summary</h2>

                    <div class="space-y-6">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="enable_coupon" name="enable_coupon" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-gray-900 data-[state=checked]:text-white" <?php checked($settings['enable_coupon'] ?? true); ?>>
                            <label for="enable_coupon" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                Discount Coupon Field
                            </label>
                        </div>

                        <div class="flex items-center space-x-2">
                            <input type="checkbox" id="enable_badges" name="enable_badges" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-gray-900 data-[state=checked]:text-white" <?php checked($settings['enable_badges'] ?? true); ?>>
                            <label for="enable_badges" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                                Show Trust Badges
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="fixed top-8 right-0 bottom-0 z-10 w-[420px] bg-white shadow-lg border-l border-gray-200 flex flex-col transition-all duration-300">
    <!-- Side Cart Header Preview -->
    <div class="p-6 border-0 border-b border-solid border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-semibold my-0">Your Cart</h2>
        <button class="bg-gray-100 border-0 rounded size-8 flex items-center justify-center cursor-pointer">
            <span class="dashicons dashicons-no-alt"></span>
        </button>
    </div>

    <!-- Side Cart Body Preview -->
    <div class="flex-1 overflow-y-auto p-6 space-y-6">

        <!-- Progress Bar Component -->
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="text-sm text-center mb-3">
                You are <span class="font-bold">$45.00</span> away from <strong class="text-gray-900" style="color: <?php echo esc_attr($settings['primary_color']); ?>">Free Shipping</strong>
            </div>

            <div class="relative h-2 bg-gray-100 rounded-full overflow-visible">
                <div class="absolute top-0 left-0 h-full bg-gray-900 rounded-full transition-all duration-500" style="width: 45%; background-color: <?php echo esc_attr($settings['primary_color']); ?>;"></div>

                <!-- Checkpoints -->
                <div id="bee-preview-checkpoints" class="absolute inset-0 pointer-events-none">
                    <!-- Will be hydrated by JS, but adding dummy for visual -->
                    <div class="absolute top-1/2 -translate-y-1/2 bg-gray-900 text-white rounded-full p-1 flex items-center justify-center shadow-md border-2 border-background" style="left: 50%; width: 24px; height: 24px; transform: translate(-50%, -50%); background-color: <?php echo esc_attr($settings['primary_color']); ?>;">
                        <span class="dashicons dashicons-truck text-[12px] leading-none"></span>
                    </div>
                    <div class="absolute top-1/2 -translate-y-1/2 bg-white text-gray-500 rounded-full p-1 flex items-center justify-center shadow-sm border-2 border-muted" style="left: 100%; width: 24px; height: 24px; transform: translate(-50%, -50%);">
                        <span class="dashicons dashicons-tag text-[12px] leading-none"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cart Item Example -->
        <div class="flex gap-4">
            <div class="w-20 h-20 bg-gray-100 rounded-md flex items-center justify-center">
                <span class="dashicons dashicons-format-image text-3xl text-gray-300"></span>
            </div>
            <div class="flex-1 flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <h4 class="text-sm font-medium">Premium Leather Bag</h4>
                        <p class="text-xs text-gray-500 mt-0.5">Brown / One Size</p>
                    </div>
                    <button class="text-gray-500 hover:text-red-500 transition-colors">
                        <span class="dashicons dashicons-trash text-sm"></span>
                    </button>
                </div>
                <div class="flex justify-between items-center mt-2">
                    <div class="flex items-center border border-gray-200 rounded-md">
                        <button class="w-7 h-7 flex items-center justify-center text-gray-500 hover:bg-muted">-</button>
                        <span class="w-8 text-center text-sm font-medium">1</span>
                        <button class="w-7 h-7 flex items-center justify-center text-gray-500 hover:bg-muted">+</button>
                    </div>
                    <span class="text-sm font-semibold">$120.00</span>
                </div>
            </div>
        </div>

        <!-- Recommended Upsell -->
        <div class="pt-4 border-t border-gray-200">
            <h4 class="text-sm font-semibold mb-3">You might also like</h4>
            <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg">
                <div class="w-12 h-12 bg-gray-100 rounded shrink-0"></div>
                <div class="flex-1">
                    <h5 class="text-sm font-medium leading-none mb-1">Leather Polish</h5>
                    <span class="text-sm text-gray-500">$15.00</span>
                </div>
                <button class="shrink-0 h-8 px-3 text-xs font-medium bg-gray-900 text-white rounded-md" style="background-color: <?php echo esc_attr($settings['primary_color']); ?>;">Add</button>
            </div>
        </div>
    </div>
    <!-- Side Cart Footer Preview -->
    <div class="p-4 border-t border-gray-200 bg-white space-y-4">
        <div id="preview-coupon-section" class="flex gap-2" style="<?php echo empty($settings['enable_coupon']) ? 'display: none;' : ''; ?>">
            <input type="text" placeholder="Gift card or discount code" class="flex-1 h-10 px-3 text-sm border border-gray-300 rounded-md bg-white">
            <button class="h-10 px-4 text-sm font-medium bg-gray-100 text-gray-900 rounded-md">Apply</button>
        </div>
        <div class="flex justify-between items-center text-sm font-medium">
            <span>Subtotal</span>
            <span class="text-lg font-semibold">$120.00</span>
        </div>
        <button class="w-full h-12 text-base font-semibold bg-gray-900 text-white rounded-md flex items-center justify-center gap-2 shadow-md hover:opacity-90 transition-opacity" style="background-color: <?php echo esc_attr($settings['primary_color']); ?>;">
            Checkout <span class="opacity-80">•</span> $120.00
        </button>
        <div id="preview-badges-section" class="flex justify-center gap-3 opacity-60 grayscale" style="<?php echo empty($settings['enable_badges']) ? 'display: none;' : ''; ?>">
            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" class="h-4" alt="PayPal">
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" class="h-4" alt="Visa">
            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b7/MasterCard_Logo.svg" class="h-4" alt="Mastercard">
        </div>
    </div>
</div>