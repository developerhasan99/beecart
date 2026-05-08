<?php
/**
 * Cart rewards bars template for Popsi Cart Drawer.
 *
 * @package Popsi_Cart_Drawer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Initialize required variables.
$popsi_cart_settings           = ( new Popsi_Cart_Drawer() )->get_settings();
$popsi_cart_enable_rewards_bar = $popsi_cart_settings['enable_rewards_bar'] ?? true;
$popsi_cart_cart               = WC()->cart;
$popsi_cart_is_empty           = $popsi_cart_cart ? $popsi_cart_cart->is_empty() : true;
$popsi_cart_text_color         = $popsi_cart_settings['text_color'] ?? '#000000';

$popsi_cart_progress_bars = $popsi_cart_settings['progress_bars'] ?? array();
if ( $popsi_cart_enable_rewards_bar && ! empty( $popsi_cart_progress_bars ) && ( ! $popsi_cart_is_empty || ( $popsi_cart_settings['show_rewards_on_empty'] ?? true ) ) ) :
	?>
	<div class="bc-rewards-bars-wrap" style="flex-direction: <?php echo esc_attr( $popsi_cart_settings['rewards_bars_layout'] ?? 'column' ); ?>;">
		<?php
		foreach ( $popsi_cart_progress_bars as $popsi_cart_bar ) :
			$popsi_cart_type        = $popsi_cart_bar['type'] ?? 'subtotal';
			$popsi_cart_current_val = ( 'quantity' === $popsi_cart_type ) ? $popsi_cart_cart->get_cart_contents_count() : (float) $popsi_cart_cart->get_subtotal();
			$popsi_cart_goals       = ! empty( $popsi_cart_bar['checkpoints'] ) ? $popsi_cart_bar['checkpoints'] : array();

			usort(
				$popsi_cart_goals,
				function ( $a, $b ) {
					return (float) $a['threshold'] - (float) $b['threshold'];
				}
			);

			$popsi_cart_next_goal = null;
			foreach ( $popsi_cart_goals as $popsi_cart_goal ) {
				if ( $popsi_cart_current_val < (float) $popsi_cart_goal['threshold'] ) {
					$popsi_cart_next_goal = $popsi_cart_goal;
					break;
				}
			}

			$popsi_cart_max_threshold = ! empty( $popsi_cart_goals ) ? (float) end( $popsi_cart_goals )['threshold'] : 100;
			$popsi_cart_percent       = $popsi_cart_max_threshold > 0 ? min( ( $popsi_cart_current_val / $popsi_cart_max_threshold ) * 100, 100 ) : 100;

			if ( empty( $popsi_cart_goals ) ) {
				continue;
			}
			?>
			<div class="bc-progress-wrap">
				<div class="bc-progress-text" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;">
					<?php
					if ( 'subtotal' === $popsi_cart_type ) {
						$popsi_cart_diff        = (float) $popsi_cart_next_goal['threshold'] - $popsi_cart_current_val;
						$popsi_cart_amount_text = ( 'subtotal' === $popsi_cart_type ) ? wc_price( $popsi_cart_diff ) : (int) $popsi_cart_diff;
						$popsi_cart_msg         = $popsi_cart_bar['away_text'] ?? "You're only {amount} away from {goal}";
						$popsi_cart_msg         = str_replace( '{amount}', '<strong>' . $popsi_cart_amount_text . '</strong>', $popsi_cart_msg );
						$popsi_cart_msg         = str_replace( '{goal}', '<strong>' . esc_html( $popsi_cart_next_goal['label'] ) . '</strong>', $popsi_cart_msg );
						echo wp_kses_post( $popsi_cart_msg );
					} else {
						?>
						<?php echo esc_html( $popsi_cart_bar['completed_text'] ?? '🎉 Congratulations! You have unlocked all rewards.' ); ?>
					<?php } ?>
				</div>

				<div class="bc-progress-bar" style="background-color: <?php echo esc_attr( $popsi_cart_settings['rewards_bar_bg'] ?? '#E2E2E2' ); ?>; margin-bottom: <?php echo ( $popsi_cart_bar['show_labels'] ?? true ) ? '24px' : '0'; ?>;">
					<div class="bc-progress-fill" style="width: <?php echo esc_attr( $popsi_cart_percent ); ?>%; background-color: <?php echo esc_attr( $popsi_cart_settings['rewards_bar_fg'] ?? '#93D3FF' ); ?>;"></div>

					<div class="bc-checkpoints">
						<?php
						foreach ( $popsi_cart_goals as $popsi_cart_goal ) {
							$popsi_cart_goal_val = (float) $popsi_cart_goal['threshold'];
							$popsi_cart_reached  = $popsi_cart_current_val >= $popsi_cart_goal_val;
							$popsi_cart_pos      = ( $popsi_cart_goal_val / $popsi_cart_max_threshold ) * 100;
							$popsi_cart_icon_key = $popsi_cart_goal['icon'] ?? 'truck';
							?>
							<div class="bc-checkpoint <?php echo esc_attr( $popsi_cart_reached ? 'is-reached' : '' ); ?>"
								style="left: <?php echo esc_attr( $popsi_cart_pos ); ?>%; 
									background-color: <?php echo esc_attr( $popsi_cart_reached ? ( $popsi_cart_settings['rewards_bar_fg'] ?? '#93D3FF' ) : ( $popsi_cart_settings['rewards_bar_bg'] ?? '#E2E2E2' ) ); ?>;
									color: <?php echo esc_attr( $popsi_cart_reached ? ( $popsi_cart_settings['rewards_complete_icon_color'] ?? '#4D4949' ) : ( $popsi_cart_settings['rewards_incomplete_icon_color'] ?? '#4D4949' ) ); ?>;">
								<?php
								$popsi_cart_icon_name  = $popsi_cart_icon_key;
								$popsi_cart_icon_class = 'bc-checkpoint-icon';
								include POPSI_CART_PATH . 'templates/icons.php';
								?>
								<?php if ( $popsi_cart_bar['show_labels'] ?? true ) : ?>
									<div class="bc-checkpoint-label" style="color: <?php echo esc_attr( $popsi_cart_text_color ); ?>;">
										<?php echo esc_html( $popsi_cart_goal['label'] ); ?>
									</div>
								<?php endif; ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
