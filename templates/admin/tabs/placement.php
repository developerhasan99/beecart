<?php if (! defined('ABSPATH')) exit; ?>
<div x-show="$store.admin.activeTab === 'placement'" class="tab-pane p-6" style="display: none;">
    <h2 class="text-lg font-semibold mt-0 mb-0 flex items-center gap-2"><span class="dashicons dashicons-layout"></span> Placement</h2>
    <p class="text-sm text-gray-500 mb-6">Manage how and where the cart drawer appears on your site.</p>

    <div x-show="!$store.admin.settings.enable_cart_drawer" x-collapse>
        <div class="mb-6 p-3 bg-gradient-to-r from-amber-50 to-white border border-solid border-amber-200 rounded-xl flex items-center gap-3 text-amber-900 text-sm shadow-sm" x-cloak>
            <div class="flex items-center justify-center w-6 h-6 rounded-full bg-amber-500 text-white shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-alert-triangle">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                    <path d="M12 9v4" />
                    <path d="M12 17h.01" />
                </svg>
            </div>
            <p class="m-0 leading-snug">
                <span class="font-bold">Cart Drawer Disabled:</span>
                <span class="text-amber-800/80 ml-1">The drawer will not be visible on your site until you enable it below.</span>
            </p>
        </div>
    </div>

    <div class="space-y-6">
        <div class="flex items-center space-x-2">
            <input type="checkbox" id="enable_cart_drawer" x-model="$store.admin.settings.enable_cart_drawer" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-gray-900 data-[state=checked]:text-white">
            <label for="enable_cart_drawer" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                Enable Cart Drawer Site-wide
            </label>
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
                <option value="none" :selected="$store.admin.settings.menu_placement == 'none'">None</option>
                <?php
                $menus = get_terms('nav_menu', array('hide_empty' => false));
                foreach ($menus as $menu) :
                    $slug = esc_attr($menu->slug);
                ?>
                    <option value="<?php echo $slug; ?>" :selected="$store.admin.settings.menu_placement == '<?php echo $slug; ?>'"><?php echo esc_html($menu->name); ?></option>
                <?php endforeach; ?>
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