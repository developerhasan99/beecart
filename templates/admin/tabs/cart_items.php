<div x-show="$store.admin.activeTab === 'cart_items'" class="tab-pane p-6" style="display: none;">
    <h2 class="text-lg font-semibold mb-6 flex items-center gap-2"><span class="dashicons dashicons-cart"></span> Cart items</h2>
    <p class="text-sm text-gray-500 mb-6">Customize how cart items are displayed inside the drawer.</p>

    <div class="space-y-6">
        <div class="flex items-center space-x-2">
            <input type="checkbox" id="show_item_images" name="show_item_images" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" <?php checked($settings['show_item_images'] ?? true); ?>>
            <label for="show_item_images" class="text-sm font-medium leading-none">Show product images</label>
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" id="show_item_total" name="show_item_total" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" <?php checked($settings['show_item_total'] ?? true); ?>>
            <label for="show_item_total" class="text-sm font-medium leading-none">Show item subtotal</label>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium">Quantity Selector Type</label>
            <select name="qty_selector_type" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors">
                <option value="boxed" <?php selected($settings['qty_selector_type'] ?? 'boxed', 'boxed'); ?>>Boxed with +/- buttons</option>
                <option value="simple" <?php selected($settings['qty_selector_type'] ?? 'boxed', 'simple'); ?>>Simple input</option>
            </select>
        </div>
    </div>
</div>