<?php
/**
 * Summary tab template for Popsi Cart Drawer admin.
 *
 * @package Popsi_Cart_Drawer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div x-show="$store.admin.activeTab === 'summary'" class="tab-pane p-6" style="display: none;">
	<h2 class="text-lg font-semibold mt-0 mb-6 flex items-center gap-2"><span class="dashicons dashicons-cart"></span> Cart Summary</h2>

	<div class="space-y-6">
		<!-- Subtotal line -->
		<div class="space-y-4">
			<div class="flex items-center space-x-2">
				<input type="checkbox" id="enable_subtotal_line" x-model="$store.admin.settings.enable_subtotal_line" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-gray-900 data-[state=checked]:text-white">
				<label for="enable_subtotal_line" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Enable subtotal line</label>
			</div>

			<div x-show="$store.admin.settings.enable_subtotal_line" class="space-y-2">
				<label for="trans_subtotal" class="text-sm font-medium">Subtotal text</label>
				<input type="text" id="trans_subtotal" x-model="$store.admin.settings.trans_subtotal" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
			</div>

			<div class="space-y-2">
				<label for="trans_discounts" class="text-sm font-medium">Discounts text</label>
				<input type="text" id="trans_discounts" x-model="$store.admin.settings.trans_discounts" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
			</div>
		</div>

		<div class="border-t border-gray-100"></div>

		<!-- Total line -->
		<div class="space-y-4">
			<div class="flex items-center space-x-2">
				<input type="checkbox" id="enable_total_line" x-model="$store.admin.settings.enable_total_line" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-gray-900 data-[state=checked]:text-white">
				<label for="enable_total_line" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Enable total line</label>
			</div>

			<div x-show="$store.admin.settings.enable_total_line" class="space-y-2">
				<label for="trans_total" class="text-sm font-medium">Total text</label>
				<input type="text" id="trans_total" x-model="$store.admin.settings.trans_total" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
			</div>
		</div>

		<div class="border-t border-gray-100"></div>

		<!-- Shipping Notice -->
		<div class="space-y-4">
			<div class="flex items-center space-x-2">
				<input type="checkbox" id="show_shipping_notice" x-model="$store.admin.settings.show_shipping_notice" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-gray-900 data-[state=checked]:text-white">
				<label for="show_shipping_notice" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Enable shipping notice</label>
			</div>

			<div x-show="$store.admin.settings.show_shipping_notice" class="space-y-2">
				<label for="shipping_notice_text" class="text-sm font-medium">Shipping notice text</label>
				<input type="text" id="shipping_notice_text" x-model="$store.admin.settings.shipping_notice_text" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
			</div>
		</div>

		<div class="border-t border-gray-100"></div>

		<!-- Checkout Button -->
		<div class="space-y-4">
			<div class="space-y-2">
				<label for="trans_checkout_btn" class="text-sm font-medium">Checkout button text</label>
				<input type="text" id="trans_checkout_btn" x-model="$store.admin.settings.trans_checkout_btn" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
			</div>

			<div class="flex items-center space-x-2">
				<input type="checkbox" id="show_subtotal_on_checkout" x-model="$store.admin.settings.show_subtotal_on_checkout" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-gray-900 data-[state=checked]:text-white">
				<label for="show_subtotal_on_checkout" class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70">Show subtotal on checkout button</label>
			</div>
		</div>
	</div>
</div>