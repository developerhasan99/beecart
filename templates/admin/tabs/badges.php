<div x-show="$store.admin.activeTab === 'badges'" class="tab-pane p-6" style="display: none;">
    <h2 class="text-lg font-semibold mb-6 flex items-center gap-2"><span class="dashicons dashicons-shield"></span> Trust badges</h2>
    <p class="text-sm text-gray-500 mb-6">Display payment methods and security trust badges at the bottom of the cart to build customer confidence.</p>

    <div class="space-y-6">
        <div class="flex items-center space-x-2">
            <input type="checkbox" id="show_trust_badges" x-model="$store.admin.settings.show_trust_badges" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
            <label for="show_trust_badges" class="text-sm font-medium leading-none">Enable Trust Badges Section</label>
        </div>

        <div class="space-y-2">
            <label class="text-sm font-medium">Badges Title</label>
            <input type="text" x-model="$store.admin.settings.trust_badges_title" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
            <p class="text-xs text-gray-500 mt-1">Displayed centered above the icons.</p>
        </div>

        <div class="space-y-4 pt-4 border-t border-solid border-gray-100">
            <label class="text-sm font-medium">Select Badges to Display</label>
            <div class="grid grid-cols-4 gap-4">
                <template x-for="(label, id) in beeCartAdminData.badges" :key="id">
                    <label class="flex flex-col items-center gap-2 p-3 border border-gray-200 rounded-lg bg-white hover:bg-gray-50 cursor-pointer text-center relative transition-all"
                        :class="($store.admin.settings.selected_badges || []).includes(id) ? 'ring-2 ring-gray-900 border-transparent shadow-md bg-white' : 'border-gray-200'">
                        <input type="checkbox" :value="id" x-model="$store.admin.settings.selected_badges" class="peer sr-only">
                        <div class="text-[10px] font-medium" x-text="label"></div>
                    </label>
                </template>
            </div>
        </div>
    </div>
</div>