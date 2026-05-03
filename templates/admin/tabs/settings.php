<?php if (! defined('ABSPATH')) exit; ?>
<div x-show="$store.admin.activeTab === 'settings'" class="tab-pane p-6" style="display: none;">
    <h2 class="text-lg font-semibold mt-0 mb-6 flex items-center gap-2"><span class="dashicons dashicons-admin-generic"></span> Settings</h2>

    <div class="space-y-8">
        <!-- Translations Section -->
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Translations</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="cart_title" class="text-sm font-medium">Cart Title</label>
                    <input type="text" id="cart_title" x-model="$store.admin.settings.cart_title" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                </div>

                <div class="space-y-2">
                    <label for="trans_continue_shopping" class="text-sm font-medium">Continue Shopping</label>
                    <input type="text" id="trans_continue_shopping" x-model="$store.admin.settings.trans_continue_shopping" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                </div>
                <div class="space-y-2">
                    <label for="trans_empty_cart" class="text-sm font-medium">Empty Cart Message</label>
                    <input type="text" id="trans_empty_cart" x-model="$store.admin.settings.trans_empty_cart" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                </div>
                <!-- Subtotal and savings moved to summary -->
            </div>
        </div>
    </div>
</div>