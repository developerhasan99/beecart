<?php if (! defined('ABSPATH')) exit; ?>
<div x-show="$store.admin.activeTab === 'cart_items'" class="tab-pane p-6" style="display: none;">
    <h2 class="text-lg font-semibold mt-0 mb-2 flex items-center gap-2">
        <span class="dashicons dashicons-cart"></span> Cart items
    </h2>
    <p class="text-sm text-gray-500 mb-8">Customize how cart items are displayed inside the drawer.</p>

    <div class="space-y-8">
        <!-- Visibility Section -->
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Visibility</h3>
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="show_item_images" x-model="$store.admin.settings.show_item_images" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                    <label for="show_item_images" class="text-sm font-medium leading-none">Show product images</label>
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="show_strikethrough" x-model="$store.admin.settings.show_strikethrough" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-gray-900 data-[state=checked]:text-white">
                    <label for="show_strikethrough" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Show strikethrough prices</label>
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="show_savings" x-model="$store.admin.settings.show_savings" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                    <label for="show_savings" class="text-sm font-medium leading-none">Show savings text</label>
                </div>

                <div class="space-y-2 !mt-4" x-show="$store.admin.settings.show_savings">
                    <label for="trans_savings_prefix" class="text-sm font-medium">Savings text prefix</label>
                    <input type="text" id="trans_savings_prefix" x-model="$store.admin.settings.trans_savings_prefix" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="Save">
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-4">Control which elements of the cart items should be visible to customers.</p>
        </div>


    </div>
</div>