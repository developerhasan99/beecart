<?php if (! defined('ABSPATH')) exit; ?>
<div x-show="$store.admin.activeTab === 'upsells'" class="tab-pane p-6" style="display: none;">
    <h2 class="text-lg font-semibold mt-0 mb-2 flex items-center gap-2">
        <span class="dashicons dashicons-products"></span> Product Recommendations
    </h2>
    <p class="text-sm text-gray-500 mb-8">Increase your average order value by suggesting complementary products to your customers directly within the cart.</p>

    <div class="space-y-8">
        <!-- Configuration Section -->
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Configuration</h3>
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="show_upsells" x-model="$store.admin.settings.show_upsells" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                    <label for="show_upsells" class="text-sm font-medium leading-none">Enable Product Recommendations</label>
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="show_upsells_on_empty" x-model="$store.admin.settings.show_upsells_on_empty" class="peer h-4 w-4 shrink-0 rounded-sm border border-gray-900 ring-offset-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                    <label for="show_upsells_on_empty" class="text-sm font-medium leading-none">Show recommendations even when cart is empty</label>
                </div>
            </div>
        </div>

        <!-- Display Settings Section -->
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-wider text-gray-500 mb-4">Display Settings</h3>
            <div class="space-y-2">
                <label for="upsell_title" class="text-sm font-medium">Section Title</label>
                <input type="text" id="upsell_title" x-model="$store.admin.settings.upsell_title" placeholder="You might also like..." class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                <p class="text-xs text-gray-400">The title displayed above the recommended products.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label for="upsell_source" class="text-sm font-medium">Recommendation Source</label>
                <select id="upsell_source" x-model="$store.admin.settings.upsell_source" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                    <option value="best_sellers" :selected="$store.admin.settings.upsell_source == 'best_sellers'">Best Sellers</option>
                    <option value="newest" :selected="$store.admin.settings.upsell_source == 'newest'">Newest Arrivals</option>
                    <option value="upsells" :selected="$store.admin.settings.upsell_source == 'upsells'">WooCommerce Upsells</option>
                    <option value="cross_sells" :selected="$store.admin.settings.upsell_source == 'cross_sells'">WooCommerce Cross-sells</option>
                    <option value="related" :selected="$store.admin.settings.upsell_source == 'related'">Related Products</option>
                    <option value="category" :selected="$store.admin.settings.upsell_source == 'category'">From a Category</option>
                </select>
                <p class="text-xs text-gray-400">How should we pick the products to recommend?</p>
            </div>

            <div class="space-y-2" x-show="$store.admin.settings.upsell_source === 'category'" x-transition style="display: none;">
                <label for="upsell_category" class="text-sm font-medium">Select Category</label>
                <select id="upsell_category" x-model="$store.admin.settings.upsell_category" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                    <option value="" :selected="$store.admin.settings.upsell_category == ''">— Select a category —</option>
                    <?php
                    $beecart_upsell_product_cats = get_terms(array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => false,
                    ));
                    if (!is_wp_error($beecart_upsell_product_cats) && !empty($beecart_upsell_product_cats)):
                        foreach ($beecart_upsell_product_cats as $beecart_upsell_cat): 
                           $beecart_upsell_slug = esc_attr($beecart_upsell_cat->slug); ?>
                            <option value="<?php echo esc_attr($beecart_upsell_slug); ?>" :selected="$store.admin.settings.upsell_category == '<?php echo esc_attr($beecart_upsell_slug); ?>'"><?php echo esc_html($beecart_upsell_cat->name); ?> (<?php echo esc_html($beecart_upsell_cat->count); ?>)</option>
                    <?php endforeach;
                    endif; ?>
                </select>
                <p class="text-xs text-gray-400">Show products only from this WooCommerce category.</p>
            </div>

            <div class="space-y-2">
                <label for="upsell_max" class="text-sm font-medium">Maximum Products to Show</label>
                <input type="number" id="upsell_max" x-model.number="$store.admin.settings.upsell_max" min="1" max="10" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                <p class="text-xs text-gray-400">Limit the number of products displayed in the recommendations section.</p>
            </div>

            <div class="space-y-2">
                <label for="upsell_btn_text" class="text-sm font-medium">Button Text</label>
                <input type="text" id="upsell_btn_text" x-model="$store.admin.settings.upsell_btn_text" placeholder="Add to Cart" class="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-ring">
                <p class="text-xs text-gray-400">The call-to-action text on the product cards.</p>
            </div>
        </div>
    </div>
</div>