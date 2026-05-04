<?php
/**
 * Add-ons tab template for Popsi Cart Drawer admin.
 *
 * @package Popsi_Cart_Drawer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div x-show="$store.admin.activeTab === 'addons'" class="tab-pane p-6" style="display: none;">
	<h2 class="text-lg font-semibold mb-6 flex items-center gap-2"><span class="dashicons dashicons-plus-alt"></span> Add-ons</h2>
	<p class="text-sm text-gray-500 mb-6">Enable additional services like shipping insurance.</p>
</div>