<?php if (! defined('ABSPATH')) exit; ?>
<div x-show="$store.admin.activeTab === 'badges'" class="tab-pane p-6" style="display: none;"
    x-data="{
        openMediaUploader() {
            let wpMediaUploader = wp.media({
                title: 'Select Badge Image',
                button: { text: 'Use this image' },
                multiple: false
            });
            wpMediaUploader.on('select', () => {
                let attachment = wpMediaUploader.state().get('selection').first().toJSON();
                $store.admin.settings.trust_badge_image = attachment.url;
            });
            wpMediaUploader.open();
        }
    }">
    <h2 class="text-lg font-semibold mt-0 mb-6 flex items-center gap-2"><span class="dashicons dashicons-shield"></span> Trust badges</h2>
    <p class="text-sm text-gray-500 mb-6">Display payment methods and security trust badges at the bottom of the cart to build customer confidence.</p>

    <div class="space-y-6">
        <div class="flex items-center space-x-2">
            <input type="checkbox" id="show_trust_badges" x-model="$store.admin.settings.show_trust_badges" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50">
            <label for="show_trust_badges" class="text-sm font-medium leading-none">Enable Trust Badges Section</label>
        </div>

        <div class="space-y-4">
            <label class="text-sm font-medium">Badge Image</label>
            <div class="flex gap-4 items-start">
                <div class="flex-1">
                    <template x-if="$store.admin.settings.trust_badge_image">
                        <div class="mb-4 p-4 border border-gray-200 rounded-lg bg-gray-50 flex items-center justify-center min-h-[80px]">
                            <img :src="$store.admin.settings.trust_badge_image" class="max-h-12 w-auto object-contain">
                        </div>
                    </template>
                    <div class="flex gap-2">
                        <button type="button" class="px-4 py-2 text-sm font-medium rounded-md border border-solid border-gray-300 bg-white hover:bg-gray-50 cursor-pointer"
                            @click.prevent="openMediaUploader">
                            Select Image
                        </button>
                        <template x-if="$store.admin.settings.trust_badge_image">
                            <button type="button" class="px-4 py-2 text-sm font-medium text-gray-600 rounded-md border border-solid border-gray-200 bg-gray-50 hover:bg-gray-100 cursor-pointer"
                                @click.prevent="$store.admin.settings.trust_badge_image = beecartAdminData.default_badge">
                                Reset to Default
                            </button>
                        </template>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Upload a single image containing all your trusted payment logos (PNG, JPG, SVG).</p>
                </div>
            </div>
        </div>
    </div>
</div>