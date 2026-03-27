<?php if (! defined('ABSPATH')) exit;

$sidebar_sections = array(
    array(
        'title' => 'General',
        'tabs' => array(
            array('title' => 'Placement', 'handle' => 'placement', 'icon' => 'dashicons-layout'),
            array('title' => 'Design', 'handle' => 'design', 'icon' => 'dashicons-art')
        )
    ),
    array(
        'title' => 'Body',
        'tabs' => array(
            array('title' => 'Announcements', 'handle' => 'announcements', 'icon' => 'dashicons-megaphone'),
            array('title' => 'Tiered rewards', 'handle' => 'rewards', 'icon' => 'dashicons-awards'),
            array('title' => 'Cart items', 'handle' => 'cart_items', 'icon' => 'dashicons-cart'),
            array('title' => 'Upsells', 'handle' => 'upsells', 'icon' => 'dashicons-arrow-up-alt2')
        )
    ),
    array(
        'title' => 'Footer',
        'tabs' => array(
            // array('title' => 'Add-ons', 'handle' => 'addons', 'icon' => 'dashicons-plus-alt'),
            array('title' => 'Coupon form', 'handle' => 'discount', 'icon' => 'dashicons-tickets'),
            array('title' => 'Cart summary', 'handle' => 'summary', 'icon' => 'dashicons-clipboard'),
            // array('title' => 'Express payments', 'handle' => 'express_payments', 'icon' => 'dashicons-money-alt'),
            array('title' => 'Trust badges', 'handle' => 'badges', 'icon' => 'dashicons-shield')
        )
    )
);

?>

<div class="mt-5 transition-all duration-300 ease-linear" x-data :class="$store.admin.preview ? 'lg:pr-[440px]' : 'pr-5'">
    <!-- Header -->
    <div class="flex flex-wrap gap-4 items-center justify-between mb-5">
        <h1 class="flex items-center gap-2 my-0">
            <span>Bee Cart editor</span>
            <span class="px-2 py-0.5 rounded-full bg-white text-green-700 text-xs font-medium">Active</span>
        </h1>
        <!-- TODO: Work on buttons to make it more prominent on mobile, we can use floating buttons on mobile also -->
        <div class="flex gap-3">
            <button type="button" @click="window.location.reload()" class="px-4 py-2 text-sm font-medium rounded-md leading-none bg-white hover:bg-gray-100 text-gray-900 hover:text-gray-900 shadow cursor-pointer">Discard</button>
            <button type="button" id="bee-save-settings" class="px-4 py-2 text-sm font-medium rounded-md leading-none bg-gray-900 text-white hover:bg-gray-800 shadow cursor-pointer" :disabled="$store.admin.isSaving">
                <span x-show="!$store.admin.isSaving">Save</span>
                <span x-show="$store.admin.isSaving">Saving...</span>
            </button>
        </div>
    </div>
    <div class="grid grid-cols-4 gap-5">
        <!-- Navigation Sidebar (Left) -->
        <div class="col-span-4 md:col-span-1 flex flex-col gap-3">
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
        <div class="col-span-4 md:col-span-3 border border-solid border-gray-300 bg-white overflow-hidden rounded-lg min-h-[600px]">

            <?php include BEE_CART_PATH . 'templates/admin/tabs/placement.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/design.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/announcements.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/rewards.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/cart_items.php'; ?>
            <?php include BEE_CART_PATH . 'templates/admin/tabs/upsells.php'; ?>
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