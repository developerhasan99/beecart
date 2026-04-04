<?php if (! defined('ABSPATH')) exit;

$beecart_sidebar_sections = array(
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
            array('title' => 'Recommendations', 'handle' => 'upsells', 'icon' => 'dashicons-products')
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
        <div class="flex items-center gap-2">
            <div class="bg-amber-400 p-2 rounded-xl leading-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag w-6 h-6 text-black" aria-hidden="true">
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                    <path d="M3.103 6.034h17.794"></path>
                    <path d="M3.4 5.467a2 2 0 0 0-.4 1.2V20a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6.667a2 2 0 0 0-.4-1.2l-2-2.667A2 2 0 0 0 17 2H7a2 2 0 0 0-1.6.8z"></path>
                </svg>
            </div><span class="text-2xl font-bold tracking-tight text-gray-900">Bee<span class="text-amber-500">Cart</span></span>
        </div>
        <div class="flex gap-3">
            <button type="button" 
                @click="$store.admin.discardSettings()" 
                class="px-6 py-2.5 text-sm font-semibold rounded-full leading-none bg-transparent hover:bg-gray-100 text-gray-600 hover:text-gray-900 transition-all border-2 border-solid border-gray-200"
                :class="!$store.admin.isDirty ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'cursor-pointer'"
                :disabled="!$store.admin.isDirty">
                Discard
            </button>
            <button type="button" id="bee-save-settings" 
                class="bg-black text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-gray-800 transition-all shadow-lg shadow-amber-200/50 border-0"
                :class="(!$store.admin.isDirty || $store.admin.isSaving) ? 'opacity-50 cursor-not-allowed pointer-events-none' : 'cursor-pointer'"
                :disabled="!$store.admin.isDirty || $store.admin.isSaving">
                <span x-show="!$store.admin.isSaving">Save</span>
                <span x-show="$store.admin.isSaving">Saving...</span>
            </button>
        </div>
    </div>
    <div class="grid grid-cols-4 gap-5">
        <!-- Navigation Sidebar (Left) -->
        <div class="col-span-4 md:col-span-1 flex flex-col gap-3">
            <?php foreach ($beecart_sidebar_sections as $beecart_section) : ?>
                <div>
                    <h3 class="text-xs uppercase tracking-wider mt-0 mb-2 px-3"><?php echo esc_html($beecart_section['title']); ?></h3>
                    <div class="space-y-1">
                        <?php foreach ($beecart_section['tabs'] as $beecart_tab) : ?>
                            <button @click="$store.admin.setTab('<?php echo esc_attr($beecart_tab['handle']); ?>')" :class="$store.admin.activeTab === '<?php echo esc_attr($beecart_tab['handle']); ?>' ? 'bg-white text-gray-900' : 'bg-transparent text-gray-700 hover:bg-white/50'" class="w-full text-left px-3 py-2 text-sm rounded-full font-medium border-0 transition-all cursor-pointer">
                                <span class="flex items-center gap-2"><span class="dashicons <?php echo esc_attr($beecart_tab['icon']); ?>"></span> <?php echo esc_html($beecart_tab['title']); ?></span>
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

            <?php include BEECART_PATH . 'templates/admin/tabs/placement.php'; ?>
            <?php include BEECART_PATH . 'templates/admin/tabs/design.php'; ?>
            <?php include BEECART_PATH . 'templates/admin/tabs/announcements.php'; ?>
            <?php include BEECART_PATH . 'templates/admin/tabs/rewards.php'; ?>
            <?php include BEECART_PATH . 'templates/admin/tabs/cart_items.php'; ?>
            <?php include BEECART_PATH . 'templates/admin/tabs/upsells.php'; ?>
            <?php include BEECART_PATH . 'templates/admin/tabs/addons.php'; ?>
            <?php include BEECART_PATH . 'templates/admin/tabs/discount.php'; ?>
            <?php include BEECART_PATH . 'templates/admin/tabs/summary.php'; ?>
            <?php include BEECART_PATH . 'templates/admin/tabs/express_payments.php'; ?>
            <?php include BEECART_PATH . 'templates/admin/tabs/badges.php'; ?>
            <?php include BEECART_PATH . 'templates/admin/tabs/settings.php'; ?>
        </div>
    </div>
</div>

<?php include BEECART_PATH . 'templates/admin/cart-preview.php'; ?>