<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Renders an SVG icon based on the $popsi_cart_icon_name variable.
 * Expected variables:
 * @var string $popsi_cart_icon_name The name of the icon (e.g., 'cart', 'truck')
 * @var string $popsi_cart_icon_class Optional CSS class to add to the SVG
 */

$popsi_cart_icon_name  = $popsi_cart_icon_name ?? '';
$popsi_cart_icon_class = $popsi_cart_icon_class ?? '';

if ( 'truck' === $popsi_cart_icon_name ) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="<?php echo esc_attr( $popsi_cart_icon_class ); ?>"><path d="M4.75 4.5a.75.75 0 0 0 0 1.5h3.25a1 1 0 0 1 0 2h-4.75a.75.75 0 0 0 0 1.5h3a.75.75 0 0 1 0 1.5h-2.5a.75.75 0 0 0 0 1.5h.458a2.5 2.5 0 1 0 4.78.75h3.024a2.5 2.5 0 1 0 4.955-.153 1.75 1.75 0 0 0 1.033-1.597v-1.22a1.75 1.75 0 0 0-1.326-1.697l-1.682-.42a.25.25 0 0 1-.18-.174l-.426-1.494a2.75 2.75 0 0 0-2.645-1.995h-6.991Zm2.75 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Z" fill-rule="evenodd"></path></svg>
<?php elseif ( 'tag' === $popsi_cart_icon_name ) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="<?php echo esc_attr( $popsi_cart_icon_class ); ?>"><path d="M8.575 4.649a3.75 3.75 0 0 1 2.7-1.149h1.975a3.25 3.25 0 0 1 3.25 3.25v2.187a3.25 3.25 0 0 1-.996 2.34l-4.747 4.572a2.5 2.5 0 0 1-3.502-.033l-2.898-2.898a2.75 2.75 0 0 1-.036-3.852l4.254-4.417Zm4.425 3.351a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" fill-rule="evenodd"></path></svg>
<?php elseif ( 'gift' === $popsi_cart_icon_name ) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="<?php echo esc_attr( $popsi_cart_icon_class ); ?>"><path d="M7.835 9.5h-.96c-.343 0-.625-.28-.625-.628 0-.344.28-.622.619-.622.242 0 .463.142.563.363l.403.887Z"></path><path d="M10.665 9.5h.96c.343 0 .625-.28.625-.628 0-.344-.28-.622-.619-.622-.242 0-.463.142-.563.363l-.403.887Z"></path><path fill-rule="evenodd" d="M8.5 4h-3.25c-1.519 0-2.75 1.231-2.75 2.75v2.25h1.25c.414 0 .75.336.75.75s-.336.75-.75.75h-1.25v2.75c0 1.519 1.231 2.75 2.75 2.75h3.441c-.119-.133-.191-.308-.191-.5v-2c0-.414.336-.75.75-.75s.75.336.75.75v2c0 .192-.072.367-.191.5h4.941c1.519 0 2.75-1.231 2.75-2.75v-2.75h-2.75c-.414 0-.75-.336-.75-.75s.336-.75.75-.75h2.75v-2.25c0-1.519-1.231-2.75-2.75-2.75h-4.75v2.25c0 .414-.336.75-.75.75s-.75-.336-.75-.75v-2.25Zm.297 3.992c-.343-.756-1.097-1.242-1.928-1.242-1.173 0-2.119.954-2.119 2.122 0 1.171.95 2.128 2.125 2.128h.858c-.595.51-1.256.924-1.84 1.008-.41.058-.694.438-.635.848.058.41.438.695.848.636 1.11-.158 2.128-.919 2.803-1.53.121-.11.235-.217.341-.322.106.105.22.213.34.322.676.611 1.693 1.372 2.804 1.53.41.059.79-.226.848-.636.059-.41-.226-.79-.636-.848-.583-.084-1.244-.498-1.839-1.008h.858c1.176 0 2.125-.957 2.125-2.128 0-1.168-.946-2.122-2.119-2.122-.83 0-1.585.486-1.928 1.242l-.453.996-.453-.996Z"></path></svg>
<?php elseif ( 'star' === $popsi_cart_icon_name ) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star <?php echo esc_attr( $popsi_cart_icon_class ); ?>"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
<?php elseif ( 'credit-card' === $popsi_cart_icon_name ) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card <?php echo esc_attr( $popsi_cart_icon_class ); ?>"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
<?php elseif ( 'check' === $popsi_cart_icon_name ) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check <?php echo esc_attr( $popsi_cart_icon_class ); ?>"><polyline points="20 6 9 17 4 12"></polyline></svg>
<?php elseif ( 'shopping-bag' === $popsi_cart_icon_name ) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag <?php echo esc_attr( $popsi_cart_icon_class ); ?>"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
<?php elseif ( 'clock' === $popsi_cart_icon_name ) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock <?php echo esc_attr( $popsi_cart_icon_class ); ?>"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
<?php elseif ( 'image' === $popsi_cart_icon_name || 'format-image' === $popsi_cart_icon_name ) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image <?php echo esc_attr( $popsi_cart_icon_class ); ?>"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
<?php elseif ( 'chevron-down' === $popsi_cart_icon_name ) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down <?php echo esc_attr( $popsi_cart_icon_class ); ?>"><path d="m6 9 6 6 6-6"></path></svg>
<?php elseif ( 'bag-1' === $popsi_cart_icon_name ) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" class="<?php echo esc_attr( $popsi_cart_icon_class ); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
<?php elseif ( 'bag-2' === $popsi_cart_icon_name ) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" class="<?php echo esc_attr( $popsi_cart_icon_class ); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path><circle cx="12" cy="14" r="2" stroke-width="2"></circle></svg>
<?php elseif ( 'cart' === $popsi_cart_icon_name ) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" class="<?php echo esc_attr( $popsi_cart_icon_class ); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
<?php elseif ( 'basket' === $popsi_cart_icon_name ) : ?>
    <svg xmlns="http://www.w3.org/2000/svg" class="<?php echo esc_attr( $popsi_cart_icon_class ); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18l-2 9H5l-2-9zm6-5h6l3 5H6l3-5z"></path></svg>
<?php endif; ?>
