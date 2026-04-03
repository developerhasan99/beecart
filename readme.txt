=== BeeCart – AOV Booster, Side Cart & WooCommerce Upsell Suite ===
Contributors: developerhasan99
Tags: woocommerce, cart, side cart, upsell, cart drawer
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.1.3
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A powerful WooCommerce side cart plugin with an AOV Booster, cart drawer, upsells, rewards progress bars, announcements, and full design control.

== Description ==

**BeeCart** is a premium WooCommerce side-cart plugin that transforms your store's cart experience into a conversion-optimized, fully customizable off-canvas drawer. It is designed to boost your Average Order Value (AOV) and reduce cart abandonment with a suite of powerful features — all manageable from a beautiful, no-code admin panel.

= Core Features =

**🛒 Slide-in Cart Drawer**
A smooth, animated off-canvas cart drawer that slides in from the right. Works site-wide and integrates seamlessly with WooCommerce's AJAX add-to-cart flow.

**📈 Rewards Progress Bar (AOV Booster)**
Motivate customers to spend more with a fully configurable rewards/progress bar system. Define multiple bars with custom thresholds, icons (truck, tag, gift), and reward labels like "Free Shipping" or "10% Discount."

**🤩 Upsells & Product Recommendations**
Show contextual upsell products inside the cart drawer. Source products from best sellers, newest arrivals, WooCommerce upsells, cross-sells, related products, or a specific category. Supports variable products with a variation selector.

**🏷 Coupon / Discount System**
An elegant, accordion-style coupon input inside the cart drawer. Apply or remove coupons without leaving the page.

**📢 Announcement Bar**
A configurable top-bar inside the cart drawer to display countdown timers, promotions, or urgency messages.

**🔒 Trust Badges**
Display a custom trust/payment badge image at the bottom of the cart to build buyer confidence.

**🎨 Full Design Customization**
Total control over colors, fonts (theme inheritance), button radius, icon style, cart bubble, and more — all from the admin panel live preview.

**🛍 Cart Icon**
Use `[beecart_icon]` shortcode or auto-inject the cart icon into any navigation menu.

**🌍 Translation Ready**
All user-facing strings are translatable. The text domain is `beecart`.

= Use Cases =

* Increase Average Order Value with smart reward milestones.
* Reduce friction at checkout with a non-interruptive slide-in cart.
* Promote upsells without redirecting customers away from their current page.
* Keep customers engaged with urgency timers and announcements.

= Requirements =

* WordPress 6.0 or higher
* WooCommerce 7.0 or higher
* PHP 7.4 or higher

== Installation ==

1. Upload the `beecart` folder to the `/wp-content/plugins/` directory, or install through the WordPress Plugins screen directly.
2. Activate the plugin through the **Plugins** screen in WordPress.
3. Navigate to **BeeCart** in the WordPress admin menu.
4. In the **Placement** tab, enable **"Enable Cart Drawer Site-wide"**.
5. Customize the design, rewards, upsells, and other settings to match your store.

== Frequently Asked Questions ==

= Does BeeCart work without WooCommerce? =

No. BeeCart is built exclusively for WooCommerce and requires it to be installed and activated.

= How do I display the cart icon in my header or navigation? =

You can use the `[beecart_icon]` shortcode anywhere on your site. Alternatively, go to **BeeCart → Placement → Menu Placement** to automatically inject the cart icon into a specific navigation menu.

= Can I change the colors and design of the cart? =

Yes! Go to **BeeCart → Design** and customize the background color, text color, button colors, border radius, cart icon style, and more. Changes are reflected in the live preview on the right.

= Does BeeCart support variable products in upsells? =

Yes. When a variable product is shown as an upsell recommendation, a variation selector (dropdown) is displayed so the customer can choose their option before adding to cart.

= Is the plugin compatible with AJAX add-to-cart? =

Yes. BeeCart intercepts standard WooCommerce add-to-cart form submissions and handles them via AJAX, then opens the cart drawer automatically.

= Can I run multiple progress bars? =

Yes! BeeCart supports multiple reward progress bars per cart. Each bar can have its own thresholds, type (subtotal or quantity), and reward checkpoints.

= Where do I find the changelog? =

See the **Changelog** section below or check the `readme.txt` file in the plugin folder.

== Screenshots ==

1. Cart Drawer — frontend slide-in cart with rewards progress bar, items, upsells, and checkout footer.
2. Admin Panel — Placement tab with live preview and key toggles.
3. Rewards Tab — configure multiple progress bars with custom thresholds and icons.
4. Design Tab — full color, icon, and styling customization with a live preview.
5. Upsells Tab — configure product recommendation source and display options.

== Changelog ==

= 1.1.3 =
* Performance: Implemented a "Pull-on-Init" AJAX strategy for the most reliable cache-busting on static sites.
* UI Fixes: Cleaned up the cart bubble logic—it is now hidden by default on page load to prevent showing stale cached counts.
* Stability: Added AJAX guards to prevent race conditions during page initialization.
* Bug Fixes: Refined the "auto-open" cookie logic to only trigger on true page refreshes, preventing unwanted drawer opening after manual navigation.

= 1.1.2 =
* Compatibility: Added a "Just Added" detection system to auto-open the drawer for themes that do not use AJAX on single product pages.
* Caching: Integrated with WooCommerce Fragments (AJAX re-sync) for 100% accuracy with caching plugins like LiteSpeed Cache and WP Rocket.
* UI Improvements: Added product links to upsell titles and images for better navigation.
* UI Improvements: Updated the cart bubble to automatically hide when the cart is empty.
* UI Fixes: Cleaned up duplicate CSS enqueues and improved fragment synchronization performance.

= 1.1.1 =
* Performance Optimization: Pre-rendered cart content on page load for instant drawer opening.
* AJAX Logic: Removed redundant AJAX calls; the cart now only refreshes on item changes.
* Event Handling: Improved synchronization with WooCommerce events (`added_to_cart`, `removed_from_cart`).
* Bug fixes: Resolved "Quantity 2" issue when adding products from some themes.
* Bug fixes: Fixed cart bubble count not updating when WooCommerce fragments are replaced.
* Bug fixes: Fixed discount total display issue in the cart summary footer.

= 1.1.0 =
* Performance Overhaul: Refactored frontend logic from Alpine.js to Vanilla JavaScript for faster loading and better compatibility.
* Optimized AJAX: Improved cart drawer update speed by removing redundant server-side calls.
* Enhanced Recommendations: Products already in the cart are now automatically excluded from the "You might also like" section.
* Admin Fixes: Improved select dropdown initialization in the admin panel; previously selected options now correctly show as active.
* Asset Management: Consolidated CSS files (merged cart-drawer.css into beecart.css) to reduce HTTP requests.
* UI improvements: Fixed the close button on the empty cart "Return to Shop" button and refined the checkout footer layout.
* Bug fixes: Resolved an issue where coupon forms, subtotals, and trust badges were not rendering on the frontend.

= 1.0.0 =
* Initial release.
* Side-cart drawer with AJAX add-to-cart integration.
* Multi-bar rewards progress system.
* Upsell recommendations with variable product support.
* Announcement bar with countdown timer.
* Coupon/discount accordion.
* Trust badge image upload.
* Full design customization panel.
* Cart icon shortcode and menu injection.
* Translation-ready (text domain: `beecart`).

== Upgrade Notice ==

= 1.0.0 =
Initial release. No upgrade steps required.
