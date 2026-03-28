<?php if (! defined('ABSPATH')) exit; ?>
<div x-show="$store.admin.activeTab === 'placement'" class="tab-pane p-6" style="display: none;">
    <h2 class="text-lg font-semibold mt-0 mb-6 flex items-center gap-2"><span class="dashicons dashicons-layout"></span> Placement</h2>
    <p class="text-sm text-gray-500 mb-6">Manage how and where the cart drawer appears on your site.</p>

    <div class="space-y-6">
        <div class="flex items-center space-x-2">
            <input type="checkbox" id="enable_cart_drawer" x-model="$store.admin.settings.enable_cart_drawer" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-gray-900 data-[state=checked]:text-white">
            <label for="enable_cart_drawer" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                Enable Cart Drawer Site-wide
            </label>
        </div>

        <div class="space-y-2">
            <label for="cart_position" class="text-sm font-medium">Cart Drawer Position</label>
            <select id="cart_position" x-model="$store.admin.settings.cart_position" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 appearance-none">
                <option value="right">Right Side</option>
                <option value="left">Left Side</option>
            </select>
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" id="auto_open_cart" x-model="$store.admin.settings.auto_open_cart" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-gray-900 data-[state=checked]:text-white">
            <label for="auto_open_cart" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                Auto open on Add to cart
            </label>
        </div>

        <div class="space-y-2">
            <label for="menu_placement" class="text-sm font-medium">Show Cart icon on menu</label>
            <select id="menu_placement" x-model="$store.admin.settings.menu_placement" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-white placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 appearance-none">
                <option value="none">None</option>
                <template x-for="menu in beecartAdminData.menus" :key="menu.slug">
                    <option :value="menu.slug" x-text="menu.name"></option>
                </template>
            </select>
            <p class="text-xs text-gray-500 mt-1">Select a menu to automatically append the cart icon.</p>
        </div>

        <div class="bg-blue-50 p-4 border border-blue-100 rounded-lg">
            <h3 class="text-sm font-semibold text-blue-900 mt-0 mb-2">Shortcode & Snippets</h3>
            <p class="text-sm text-blue-800 mb-3">You can use these shortcodes to place the cart icon manually on any page, menu, or builder.</p>
            <div class="flex items-center gap-2">
                <code class="px-2 py-1 bg-white text-blue-900 border border-blue-200 rounded text-xs select-all">[beecart_icon]</code>
                <span class="text-xs text-blue-700">Displays the floating cart toggle button.</span>
            </div>
        </div>
    </div>
</div>