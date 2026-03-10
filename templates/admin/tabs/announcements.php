<div x-show="$store.admin.activeTab === 'announcements'" class="tab-pane p-6" style="display: none;">
    <h2 class="text-lg font-semibold mt-0 mb-6 flex items-center gap-2"><span class="dashicons dashicons-megaphone"></span> Announcements</h2>
    <p class="text-sm text-gray-500 mb-6">Set up global announcements for your cart. This will appear right above your cart progress bar.</p>

    <div class="space-y-8">
        <div class="flex items-center space-x-2">
            <input type="checkbox" id="show_announcement" x-model="$store.admin.settings.show_announcement" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
            <label for="show_announcement" class="text-sm font-medium leading-none">Enable Announcement Bar</label>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium">Timer Duration (minutes)</label>
            <input type="number" x-model.number="$store.admin.settings.timer_duration" class="flex h-10 w-40 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors">
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium">Announcement Text</label>
            <textarea x-model="$store.admin.settings.announcement_text" rows="2" class="flex w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors"></textarea>
            <p class="text-xs text-gray-500 mt-1">Accepts basic text and emojis. HTML is stripped for security. Use {timer} to show countdown timer</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="text-sm font-medium">Font Size</label>
                <input type="text" x-model="$store.admin.settings.announcement_font_size" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring" placeholder="e.g. 13px">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-x-4 gap-y-6">
            <!-- BG Color -->
            <div class="space-y-2" x-data="colorPicker('announcement_bg')">
                <label class="text-sm font-medium">Background Color</label>
                <div class="flex items-center gap-2">
                    <label class="relative cursor-pointer w-10 h-10 rounded-md border border-gray-200 shadow-sm overflow-hidden shrink-0">
                        <input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                    </label>
                    <input type="text" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                </div>
            </div>

            <!-- Text Color -->
            <div class="space-y-2" x-data="colorPicker('announcement_text_color')">
                <label class="text-sm font-medium">Text Color</label>
                <div class="flex items-center gap-2">
                    <label class="relative cursor-pointer w-10 h-10 rounded-md border border-gray-200 shadow-sm overflow-hidden shrink-0">
                        <input type="color" :value="isValid ? color : '#000000'" @input="updatePicker" class="absolute -inset-2 w-[150%] h-[150%] !p-0 !m-0 !border-0 cursor-pointer">
                    </label>
                    <input type="text" :value="color" @input="updateInput" :class="!isValid ? 'border-red-500 ring-red-200' : 'border-gray-300'" class="flex h-10 w-full rounded-md border bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring transition-colors" maxlength="7">
                </div>
            </div>
        </div>
    </div>
</div>