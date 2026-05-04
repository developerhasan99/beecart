<?php
/**
 * Announcements tab template for Popsi Cart Drawer admin.
 *
 * @package Popsi_Cart_Drawer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div x-show="$store.admin.activeTab === 'announcements'" class="tab-pane p-6" style="display: none;">
	<h2 class="text-lg font-semibold mt-0 mb-2 flex items-center gap-2">
		<span class="dashicons dashicons-megaphone"></span> Announcements
	</h2>
	<p class="text-sm text-gray-500 mb-8">Set up global announcements for your cart. This will appear right above your cart progress bar.</p>

	<div class="space-y-8">
		<!-- Configuration Section -->
		<div>
			<h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Configuration</h3>
			<div class="space-y-4">
				<div class="flex items-center space-x-2">
					<input type="checkbox" id="show_announcement" x-model="$store.admin.settings.show_announcement" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
					<label for="show_announcement" class="text-sm font-medium leading-none">Enable Announcement Bar</label>
				</div>
			</div>
		</div>

		<!-- Content Section -->
		<div class="space-y-4">
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
				<div class="space-y-2">
					<label for="timer_duration" class="text-sm font-medium">Timer Duration (Minutes)</label>
					<input type="number" id="timer_duration" x-model.number="$store.admin.settings.timer_duration" min="1" max="60" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors">
				</div>
			</div>
			<div class="space-y-2">
				<label for="announcement_text" class="text-sm font-medium">Announcement Message</label>
				<textarea id="announcement_text" x-model="$store.admin.settings.announcement_text" rows="2" placeholder="Your products are reserved for {timer}!" class="flex w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors"></textarea>
				<p class="text-xs text-gray-400 mt-1">Use <strong>{timer}</strong> as a placeholder to display a real-time countdown timer within your message.</p>
			</div>
		</div>

		<!-- Appearance Section -->
		<div>
			<h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Appearance</h3>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
				<div class="space-y-2" x-data="colorPicker('announcement_bg')">
					<label for="announcement_bg" class="text-sm font-medium">Background Color</label>
					<div class="flex items-center gap-2">
						<label class="relative cursor-pointer w-10 h-10 rounded-md border border-solid border-gray-200 shadow-sm overflow-hidden shrink-0">
							<input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
						</label>
						<input type="text" id="announcement_bg" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
					</div>
				</div>

				<div class="space-y-2" x-data="colorPicker('announcement_text_color')">
					<label for="announcement_text_color" class="text-sm font-medium">Text Color</label>
					<div class="flex items-center gap-2">
						<label class="relative cursor-pointer w-10 h-10 rounded-md border border-solid border-gray-200 shadow-sm overflow-hidden shrink-0">
							<input type="color" :value="isValid ? color : '#ffffff'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
						</label>
						<input type="text" id="announcement_text_color" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
					</div>
				</div>

				<div class="space-y-2">
					<label for="announcement_font_size" class="text-sm font-medium">Font Size</label>
					<input type="text" id="announcement_font_size" x-model="$store.admin.settings.announcement_font_size" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="e.g. 13px">
					<p class="text-xs text-gray-400 mt-1">Include px (e.g., 14px).</p>
				</div>

				<div class="space-y-2">
					<label for="announcement_bar_size" class="text-sm font-medium">Bar Size</label>
					<select id="announcement_bar_size" x-model="$store.admin.settings.announcement_bar_size" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors">
						<option value="small" :selected="$store.admin.settings.announcement_bar_size == 'small'">Small</option>
						<option value="medium" :selected="$store.admin.settings.announcement_bar_size == 'medium'">Medium</option>
						<option value="large" :selected="$store.admin.settings.announcement_bar_size == 'large'">Large</option>
					</select>
					<p class="text-xs text-gray-400 mt-1">Adjust the overall height and font size of the bar.</p>
				</div>

			</div>
		</div>
	</div>
</div>