# Changelog

All notable changes to **BeeCart** will be documented in this file.

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
