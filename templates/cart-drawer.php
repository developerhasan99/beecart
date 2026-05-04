<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$popsi_cart_drawer_settings = $this->get_settings();

$popsi_cart_drawer_heading           = $popsi_cart_drawer_settings['cart_title'] ?? 'Your Cart';
$popsi_cart_drawer_countdown_minutes = $popsi_cart_drawer_settings['timer_duration'] ?? 15;
$popsi_cart_drawer_bg_color          = $popsi_cart_drawer_settings['bg_color'] ?? '#FFFFFF';
$popsi_cart_drawer_text_color        = $popsi_cart_drawer_settings['text_color'] ?? '#000000';
$popsi_cart_drawer_accent_color      = $popsi_cart_drawer_settings['accent_color'] ?? '#f6f6f7';
$popsi_cart_drawer_show_cart_count   = $popsi_cart_drawer_settings['show_cart_count'] ?? true;
$popsi_cart_drawer_inherit_fonts     = $popsi_cart_drawer_settings['inherit_fonts'] ?? true;

$popsi_cart_drawer_show_announcement       = $popsi_cart_drawer_settings['show_announcement'] ?? false;
$popsi_cart_drawer_announcement            = $popsi_cart_drawer_settings['announcement_text'] ?? '';
$popsi_cart_drawer_announcement_bg         = $popsi_cart_drawer_settings['announcement_bg'] ?? '#000000';
$popsi_cart_drawer_announcement_text_color = $popsi_cart_drawer_settings['announcement_text_color'] ?? '#ffffff';
$popsi_cart_drawer_announcement_bar_size   = $popsi_cart_drawer_settings['announcement_bar_size'] ?? 'medium';
$popsi_cart_drawer_announcement_font_size  = $popsi_cart_drawer_settings['announcement_font_size'] ?? '13px';

$popsi_cart_drawer_enable_timer = $popsi_cart_drawer_settings['enable_timer'] ?? false;
?>
<div class="bc-drawer-wrap"
	style="font-family: <?php echo esc_attr( $popsi_cart_drawer_inherit_fonts ? 'inherit' : 'sans-serif' ); ?>;">

	<!-- Overlay -->
	<div class="bc-overlay"></div>

	<!-- Drawer container -->
	<div class="bc-drawer-panel" style="background-color: <?php echo esc_attr( $popsi_cart_drawer_bg_color ); ?>; color: <?php echo esc_attr( $popsi_cart_drawer_text_color ); ?>;">

		<!-- Header -->
		<div class="bc-drawer-header">
			<h2 class="bc-drawer-title" style="color: <?php echo esc_attr( $popsi_cart_drawer_text_color ); ?>;">
				<span><?php echo esc_html( $popsi_cart_drawer_heading ); ?></span>
				<?php if ( $popsi_cart_drawer_show_cart_count ) : ?>
				<span><span class="bc-drawer-title-sep">•</span> <span class="bc-cart-count-display"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span></span>
				<?php endif; ?>
			</h2>
			<button title="Close Cart" class="bc-drawer-close" style="background-color: <?php echo esc_attr( $popsi_cart_drawer_accent_color ); ?>;">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" style="color: #6b7280;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
			</button>
		</div>

		<!-- Announcement Bar -->
		<?php
		if ( $popsi_cart_drawer_show_announcement ) :
			$popsi_cart_drawer_size_class = 'size-medium';
			if ( $popsi_cart_drawer_announcement_bar_size === 'small' ) {
				$popsi_cart_drawer_size_class = 'size-small';
			}
			if ( $popsi_cart_drawer_announcement_bar_size === 'large' ) {
				$popsi_cart_drawer_size_class = 'size-large';
			}

			$popsi_cart_drawer_formatted_announcement = str_replace( '{timer}', '<strong class=\'bc-timer-bold\'>' . sprintf( '%02d:00', (int) $popsi_cart_drawer_countdown_minutes ) . '</strong>', $popsi_cart_drawer_announcement );
			?>
		<div class="bc-drawer-top-notices">
			<div class="bc-announcement <?php echo esc_attr( $popsi_cart_drawer_size_class ); ?>"
				style="background-color: <?php echo esc_attr( $popsi_cart_drawer_announcement_bg ); ?>; color: <?php echo esc_attr( $popsi_cart_drawer_announcement_text_color ); ?>; font-size: <?php echo esc_attr( $popsi_cart_drawer_announcement_font_size ); ?>;">
				<?php echo wp_kses_post( $popsi_cart_drawer_formatted_announcement ); ?>
			</div>
		</div>
		<?php endif; ?>

		<!-- Cart AJAX Content Area -->
		<div class="bc-drawer-body">
			<div class="bc-cart-html-container" style="display: contents;">
				<?php $this->render_cart_content(); ?>
			</div>
			
			<!-- Loading indicator -->
			<div class="bc-loading-overlay" style="display: none;">
				<svg width="32" height="32" viewBox="0 0 24 24" fill="none" class="bc-spinner" style="animation: spin 1s linear infinite; opacity: 0.6; color: #6b7280;">
					<circle opacity="0.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
					<path opacity="0.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
				</svg>
			</div>
		</div>
	</div>
</div>