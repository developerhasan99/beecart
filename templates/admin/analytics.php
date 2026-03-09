<?php if (! defined('ABSPATH')) exit;
$logs = get_option('bee_cart_analytics_logs', array());
$logs = array_reverse($logs);

$checkout_success = count(array_filter($logs, function ($l) {
    return $l['event'] === 'checkout_success';
}));
$cart_creations = count(array_filter($logs, function ($l) {
    return $l['event'] === 'cart_creation';
}));
$page_views = count(array_filter($logs, function ($l) {
    return $l['event'] === 'page_view';
}));
$sessions = count(array_unique(array_column($logs, 'session')));
?>

<div class="bee-admin-wrap">
    <div class="bee-admin-header">
        <h1>Bee Cart Analytics</h1>
        <div class="bee-header-actions">
            <span class="bee-badge-active">Tracking Active</span>
        </div>
    </div>

    <div class="bee-analytics-summary">
        <div class="bee-stat-card">
            <div class="bee-stat-label">Total Sessions</div>
            <div class="bee-stat-value"><?php echo number_format($sessions); ?></div>
        </div>
        <div class="bee-stat-card">
            <div class="bee-stat-label">Carts Created</div>
            <div class="bee-stat-value"><?php echo number_format($cart_creations); ?></div>
        </div>
        <div class="bee-stat-card">
            <div class="bee-stat-label">Successful Checkouts</div>
            <div class="bee-stat-value"><?php echo number_format($checkout_success); ?></div>
        </div>
        <div class="bee-stat-card">
            <div class="bee-stat-label">Conversion Rate</div>
            <div class="bee-stat-value"><?php echo $sessions > 0 ? round(($checkout_success / $sessions) * 100, 1) : 0; ?>%</div>
        </div>
    </div>

    <div class="bee-table-wrap">
        <h2>Recent Activity Log</h2>
        <table class="bee-admin-table">
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>Event Type</th>
                    <th>Session ID</th>
                    <th>Season</th>
                    <th>Order ID</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="5">No data tracked yet.</td>
                    </tr>
                    <?php else: foreach (array_slice($logs, 0, 50) as $log): ?>
                        <tr>
                            <td><?php echo date('M d, Y H:i', strtotime($log['timestamp'])); ?></td>
                            <td>
                                <span class="bee-badge-event-<?php echo esc_attr($log['event']); ?>">
                                    <?php echo esc_html(ucwords(str_replace('_', ' ', $log['event']))); ?>
                                </span>
                            </td>
                            <td><code><?php echo esc_html($log['session']); ?></code></td>
                            <td><?php echo esc_html($log['season']); ?></td>
                            <td><?php echo $log['order_id'] ? '#' . esc_html($log['order_id']) : '-'; ?></td>
                        </tr>
                <?php endforeach;
                endif; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .bee-badge-active {
        background: #ecfdf5;
        color: #059669;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .bee-badge-event-checkout_success {
        color: #059669;
        font-weight: 600;
    }

    .bee-badge-event-cart_creation {
        color: #2563eb;
        font-weight: 600;
    }

    .bee-badge-event-page_view {
        color: #646970;
    }
</style>