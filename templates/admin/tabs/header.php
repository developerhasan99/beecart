<div x-show="$store.admin.activeTab === 'header'" class="tab-pane p-6" style="display: none;">
    <h2 class="text-lg font-semibold mb-6 flex items-center gap-2"><span class="dashicons dashicons-heading"></span> Header</h2>
    <p class="text-sm text-gray-500 mb-6">Customize the top part of the side cart.</p>

    <div class="space-y-6">
        <div class="space-y-2">
            <label class="text-sm font-medium">Cart Title</label>
            <input type="text" name="cart_title" value="<?php echo esc_attr($settings['cart_title'] ?? 'Your Cart'); ?>" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors">
            <p class="text-xs text-gray-500 mt-1">Change the title displayed at the top of the cart drawer.</p>
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" id="show_close_icon" name="show_close_icon" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50" <?php checked($settings['show_close_icon'] ?? true); ?>>
            <label for="show_close_icon" class="text-sm font-medium leading-none">Show close toggle button</label>
        </div>
    </div>
</div>