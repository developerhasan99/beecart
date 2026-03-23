<?php if (! defined('ABSPATH')) exit; ?>
<div x-show="$store.admin.activeTab === 'settings'" class="tab-pane p-6" style="display: none;">
    <h2 class="text-lg font-semibold mt-0 mb-6 flex items-center gap-2"><span class="dashicons dashicons-admin-generic"></span> Settings</h2>

    <div class="space-y-8">
        <!-- Translations Section -->
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Translations</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-sm font-medium">Cart Title</label>
                    <input type="text" x-model="$store.admin.settings.cart_title" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium">View Cart Button</label>
                    <input type="text" x-model="$store.admin.settings.trans_view_cart_btn" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium">Continue Shopping</label>
                    <input type="text" x-model="$store.admin.settings.trans_continue_shopping" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium">Empty Cart Message</label>
                    <input type="text" x-model="$store.admin.settings.trans_empty_cart" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                </div>
                <!-- Subtotal and savings moved to summary -->
            </div>
        </div>

        <!-- Custom CSS Section -->
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Custom CSS</h3>
            <div class="space-y-2">
                <div class="relative rounded-md border border-gray-300 bg-slate-900 p-2 overflow-hidden group">
                    <div class="absolute right-3 top-3 px-2 py-1 rounded bg-slate-800 text-slate-400 text-[10px] font-mono select-none opacity-50 group-hover:opacity-100 transition-opacity">CSS EDITOR</div>
                    <textarea
                        x-model="$store.admin.settings.custom_css"
                        rows="12"
                        spellcheck="false"
                        placeholder="/* Add your custom CSS here */&#10;.bee-cart-drawer {&#10;    border-left: 2px solid #000;&#10;}"
                        class="block w-full rounded-none border-0 bg-transparent p-0 text-sm font-mono text-slate-300 ring-0 focus:ring-0 resize-none min-h-[300px]"></textarea>
                </div>
                <p class="text-xs text-gray-400">Add custom styles to override existing cart design. Use .bee-cart-drawer as root selector.</p>
            </div>
        </div>
    </div>
</div>