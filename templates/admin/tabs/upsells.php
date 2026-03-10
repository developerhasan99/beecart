<div x-show="$store.admin.activeTab === 'upsells'" class="tab-pane p-6" style="display: none;">
    <h2 class="text-lg font-semibold mb-6 flex items-center gap-2"><span class="dashicons dashicons-arrow-up-alt2"></span> Upsells</h2>
    <p class="text-sm text-gray-500 mb-6">Boost your average order value by showing relevant products directly in the cart drawer.</p>

    <div class="space-y-6">
        <div class="flex items-center space-x-2">
            <input type="checkbox" id="show_upsells" x-model="$store.admin.settings.show_upsells" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
            <label for="show_upsells" class="text-sm font-medium leading-none">Enable Upsell Section</label>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium">Section Title</label>
            <input type="text" x-model="$store.admin.settings.upsell_title" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
            <p class="text-xs text-gray-500 mt-1">Displayed above the recommended products.</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="text-sm font-medium">Max Products</label>
                <input type="number" x-model.number="$store.admin.settings.upsell_max" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium">Recommendation Source</label>
                <select x-model="$store.admin.settings.upsell_source" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                    <option value="cross_sells">WooCommerce Cross-sells</option>
                    <option value="related">Related Products</option>
                </select>
            </div>
        </div>
    </div>
</div>