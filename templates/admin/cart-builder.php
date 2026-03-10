<?php if (! defined('ABSPATH')) exit;
$settings = get_option('bee_cart_settings', array(
    'progress_type' => 'subtotal',
    'goals' => array(
        array('threshold' => 50, 'label' => 'Free Shipping', 'icon' => 'truck'),
        array('threshold' => 100, 'label' => '20% Discount', 'icon' => 'tag')
    ),
    'primary_color' => '#000000',
    'enable_coupon' => true,
    'enable_badges' => true,
    // Design Defaults
    'inherit_fonts' => true,
    'show_strikethrough' => true,
    'enable_subtotal_line' => true,
    'bg_color' => '#FFFFFF',
    'accent_color' => '#f6f6f7',
    'text_color' => '#000000',
    'savings_text_color' => '#2ea818',
    'btn_radius' => '0px',
    'btn_color' => '#000000',
    'btn_text_color' => '#FFFFFF',
    'btn_hover_text_color' => '#e9e9e9',
    // Cart Icon Settings
    'cart_icon_type' => 'bag-1',
    'cart_icon_color' => '#000000',
    'cart_icon_size' => '24',
    'cart_bubble_bg' => '#ff0000',
    'cart_bubble_text' => '#ffffff',
    'show_cart_count' => true,
    'cart_title' => 'Your Cart',
    'show_close_icon' => true,
    // Announcement Settings
    'show_announcement' => false,
    'announcement_text' => 'Free shipping on orders over $50!',
    'announcement_bg' => '#000000',
    'announcement_text_color' => '#ffffff',
    // Cart Item Settings
    'show_item_images' => true,
    'show_item_total' => true,
    // Upsell Settings
    'show_upsells' => true,
    'upsell_title' => 'Complete your look',
    'upsell_max' => 3,
    // Trust Badge Settings
    'show_trust_badges' => true,
    'trust_badges_title' => 'Secure Checkout',
    'selected_badges' => array('visa', 'mastercard', 'paypal', 'apple-pay')
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
            array('title' => 'Placement', 'handle' => 'placement', 'icon' => 'dashicons-layout'),
            array('title' => 'Design', 'handle' => 'design', 'icon' => 'dashicons-art'),
            array('title' => 'Header', 'handle' => 'header', 'icon' => 'dashicons-heading')
        )
    ),
    array(
        'title' => 'Body',
        'tabs' => array(
            array('title' => 'Announcements', 'handle' => 'announcements', 'icon' => 'dashicons-megaphone'),
            array('title' => 'Tiered rewards', 'handle' => 'rewards', 'icon' => 'dashicons-awards'),
            array('title' => 'Triggered rewards', 'handle' => 'triggered_rewards', 'icon' => 'dashicons-controls-play'),
            array('title' => 'Recommendations', 'handle' => 'recommendations', 'icon' => 'dashicons-thumbs-up'),
            array('title' => 'Cart items', 'handle' => 'cart_items', 'icon' => 'dashicons-cart'),
            array('title' => 'Subscription upgrades', 'handle' => 'subscriptions', 'icon' => 'dashicons-update'),
            array('title' => 'Upsells', 'handle' => 'upsells', 'icon' => 'dashicons-arrow-up-alt2'),
            array('title' => 'Additional notes', 'handle' => 'notes', 'icon' => 'dashicons-edit')
        )
    ),
    array(
        'title' => 'Footer',
        'tabs' => array(
            array('title' => 'Add-ons', 'handle' => 'addons', 'icon' => 'dashicons-plus-alt'),
            array('title' => 'Discount codes', 'handle' => 'discount', 'icon' => 'dashicons-tickets'),
            array('title' => 'Cart summary', 'handle' => 'summary', 'icon' => 'dashicons-clipboard'),
            array('title' => 'Express payments', 'handle' => 'express_payments', 'icon' => 'dashicons-money-alt'),
            array('title' => 'Trust badges', 'handle' => 'badges', 'icon' => 'dashicons-shield')
        )
    )
);

?>

<div class="pr-[440px] mt-5" x-data>
    <!-- Header -->
    <div class="flex items-center justify-between mb-5">
        <h1 class="flex items-center gap-2 my-0">
            <span>Bee Cart editor</span>
            <span class="px-2 py-0.5 rounded-full bg-white text-green-700 text-xs font-medium">Active</span>
        </h1>
        <div class="flex gap-3">
            <button type="button" id="bee-preview-cart" class="px-4 py-2 text-sm font-medium rounded-md leading-none bg-white hover:bg-gray-100 text-gray-900 hover:text-gray-900 shadow cursor-pointer">Discard</button>
            <button type="button" id="bee-save-settings" class="px-4 py-2 text-sm font-medium rounded-md leading-none bg-gray-900 text-white hover:bg-gray-800 shadow cursor-pointer">Save</button>
        </div>
    </div>
    <div class="grid grid-cols-4 gap-5">
        <!-- Navigation Sidebar (Left) -->
        <div class="col-span-1 flex flex-col gap-3">
            <?php foreach ($sidebar_sections as $section) : ?>
                <div>
                    <h3 class="text-xs uppercase tracking-wider mt-0 mb-2 px-3"><?php echo $section['title']; ?></h3>
                    <div class="space-y-1">
                        <?php foreach ($section['tabs'] as $tab) : ?>
                            <button @click="$store.admin.setTab('<?php echo $tab['handle']; ?>')" :class="$store.admin.activeTab === '<?php echo $tab['handle']; ?>' ? 'bg-white text-gray-900' : 'bg-transparent text-gray-700 hover:bg-white/50'" class="w-full text-left px-3 py-2 text-sm rounded-full font-medium border-0 transition-all cursor-pointer">
                                <span class="flex items-center gap-2"><span class="dashicons <?php echo $tab['icon']; ?>"></span> <?php echo $tab['title']; ?></span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="pt-2 border-0 border-t border-solid border-gray-200">
                <button @click="$store.admin.setTab('settings')" :class="$store.admin.activeTab === 'settings' ? 'bg-white text-gray-900' : 'bg-transparent text-gray-700 hover:bg-white/50'" class="w-full text-left px-3 py-2 text-sm rounded-full font-medium border-0 transition-all cursor-pointer">
                    <span class="flex items-center gap-2"><span class="dashicons dashicons-admin-generic"></span> Settings</span>
                </button>
            </div>
        </div>
        <!-- Settings Content (Middle Side) -->
        <div class="col-span-3 border border-solid border-gray-300 bg-white overflow-hidden rounded-lg">

            <?php include BEE_CART_PATH . 'templates/admin/tabs/placement.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/design.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/header.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/announcements.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/rewards.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/triggered_rewards.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/recommendations.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/cart_items.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/subscriptions.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/upsells.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/notes.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/addons.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/discount.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/summary.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/express_payments.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/badges.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/settings.php'; ?>
        </div>
    </div>
</div>


<?php include BEE_CART_PATH . 'templates/admin/cart-preview.php'; ?>