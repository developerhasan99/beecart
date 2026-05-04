<?php
/**
 * Discount tab template for Popsi Cart Drawer admin.
 *
 * @package Popsi_Cart_Drawer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div x-show="$store.admin.activeTab === 'discount'" class="tab-pane p-6" style="display: none;">
	<h2 class="text-lg font-semibold mt-0 mb-6 flex items-center gap-2"><span class="dashicons dashicons-tickets"></span> Coupon form</h2>

	<div class="space-y-8">
		<div>
			<div class="flex items-center space-x-2">
				<input type="checkbox" id="enable_coupon" x-model="$store.admin.settings.enable_coupon" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-gray-900 data-[state=checked]:text-white">
				<label for="enable_coupon" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">
					Enable coupon form
				</label>
			</div>
		</div>

		<div class="space-y-4">
			<div class="space-y-2">
				<label class="text-sm font-medium">Accordion title text</label>
				<input type="text" x-model="$store.admin.settings.trans_coupon_accordion_title" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
			</div>

			<div class="space-y-2">
				<label class="text-sm font-medium">Coupon placeholder text</label>
				<input type="text" x-model="$store.admin.settings.trans_coupon_placeholder" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
			</div>

			<div class="space-y-2">
				<label class="text-sm font-medium">Apply button text</label>
				<input type="text" x-model="$store.admin.settings.trans_coupon_apply_btn" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
			</div>
		</div>
	</div>
</div>