# Changelog

All notable changes to **BeeCart** will be documented in this file.

## [1.1.2] - 2026-04-03

### Added
- **Ultimate Compatibility**: Implemented a "Just Added" detection system (cookie-based) that automatically opens the cart drawer for themes that don't use AJAX for Single Product Pages.
- **Cache-Proof Sync**: Fully integrated the drawer contents with WooCommerce Fragments. This ensures 100% accurate cart data even when using rigorous caching plugins like LiteSpeed Cache (LSWC) or WP Rocket.

### Changed
- **Navigation Improvement**: Upsell products now feature clickable titles and images that link directly to their respective product pages.
- **Clean UI**: The cart bubble now automatically hides when the cart count is zero for a cleaner header experience.

### Fixed
- **Performance**: Removed redundant CSS enqueues and streamlined the WooCommerce fragment processing logic.

## [1.1.1] - 2026-04-02

### Added
- **Pre-rendering**: The cart drawer is now pre-rendered on the server for an instant first-open experience on page load.
- **Enhanced Sync**: Improved synchronization with WooCommerce events (`removed_from_cart`, `updated_cart_totals`) for better drawer accuracy.

### Changed
- **Optimized AJAX**: Reduced the number of AJAX requests by 75% for the add-to-cart flow by eliminating redundant drawer refreshes.
- **Improved Loading State**: Centralized the "isUpdatingUI" flag to prevent redundant UI fetches during internal operations.

### Fixed
- **Double-Add Bug**: Resolved an issue where multiple handlers could cause a product to be added twice on some themes.
- **Cart Bubble Count**: Fixed a bug where the cart item count wouldn't update if WooCommerce replaced the header fragments via AJAX.
- **Discount Display**: Fixed an issue where coupon discounts were showing as 0.00 even when a valid coupon was applied.

## [1.1.0] - 2026-04-02

### Added
- **Smart Recommendations**: Products already in the customer's cart are now automatically excluded from the "You might also like" section for a better shopping experience.

### Changed
- **Performance Overhaul**: Refactored frontend logic from Alpine.js to Vanilla JavaScript. This results in faster loading, better compatibility, and a smaller frontend footprint.
- **AJAX Optimization**: Significantly improved cart drawer responsiveness by removing redundant server-side calls in update handlers.
- **UI improvements**: Cleaned up the close button logic and refined the checkout footer layout for a more premium look.
- **Asset Management**: Consolidated CSS assets (merged `cart-drawer.css` into `beecart.css`) to reduce HTTP requests.

### Fixed
- **Admin UI Fixes**: Resolved an issue where select dropdowns (icons, sources, categories) wouldn't show the previously saved state on page load.
- **Frontend Bug Fixes**: Resolved an issue where coupon forms, subtotals, and trust badges were not rendering correctly on the frontend during AJAX updates.
- **Empty Cart Logic**: Fixed the "Return to Shop" button behavior inside the empty cart drawer.

## [1.0.0] - 2026-03-22

### Added
- Initial release.
- Side-cart drawer with AJAX add-to-cart integration.
- Multi-bar rewards progress system.
- Upsell recommendations with variable product support.
- Announcement bar with countdown timer.
- Coupon/discount accordion.
- Trust badge image upload.
- Full design customization panel.
- Cart icon shortcode and menu injection.
- Translation-ready (text domain: `beecart`).
