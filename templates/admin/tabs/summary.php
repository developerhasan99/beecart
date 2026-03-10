<?php if (! defined('ABSPATH')) exit; ?>
<div x-show="$store.admin.activeTab === 'summary'" class="tab-pane p-6" style="display: none;">
    <h2 class="text-lg font-semibold mb-6 flex items-center gap-2"><span class="dashicons dashicons-cart"></span> Cart Summary</h2>

    <div class="space-y-6">
        <div class="flex items-center space-x-2">
            <input type="checkbox" id="enable_coupon" name="enable_coupon" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-gray-900 data-[state=checked]:text-white" <?php checked($settings['enable_coupon'] ?? true); ?>>
            <label for="enable_coupon" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
                Discount Coupon Field
            </label>
        </div>


    </div>
</div>