<?php
if (! defined('ABSPATH')) {
    exit;
}

class Bee_Cart_Analytics
{

    public function init()
    {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_analytics'));

        add_action('woocommerce_add_to_cart', array($this, 'track_cart_creation'));
        add_action('woocommerce_thankyou', array($this, 'track_successful_checkout'));

        add_action('wp_ajax_nopriv_beecart_log_event', array($this, 'ajax_log_event'));
        add_action('wp_ajax_beecart_log_event', array($this, 'ajax_log_event'));
    }

    public function enqueue_analytics()
    {
        wp_enqueue_script('bee-cart-analytics-script', BEE_CART_URL . 'assets/js/bee-cart-analytics.js', array(), BEE_CART_VERSION, true);
        wp_localize_script('bee-cart-analytics-script', 'beeCartAnalytics', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('beecart-analytics-nonce')
        ));
    }

    public function track_cart_creation()
    {
        if (! isset($_COOKIE['bee_cart_session'])) {
            $session_id = uniqid('bc_');
            setcookie('bee_cart_session', $session_id, time() + 30 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
            $this->log_event('cart_creation', $session_id);
        }
    }

    public function track_successful_checkout($order_id)
    {
        if (isset($_COOKIE['bee_cart_session'])) {
            $session_id = sanitize_text_field($_COOKIE['bee_cart_session']);
            $this->log_event('checkout_success', $session_id, $order_id);
            setcookie('bee_cart_session', '', time() - 3600, COOKIEPATH, COOKIE_DOMAIN);
        }
    }

    public function ajax_log_event()
    {
        check_ajax_referer('beecart-analytics-nonce', 'security');
        $event_type = sanitize_text_field($_POST['event_type']);
        $session_id = isset($_COOKIE['bee_cart_session']) ? sanitize_text_field($_COOKIE['bee_cart_session']) : uniqid('bc_');

        if (!isset($_COOKIE['bee_cart_session'])) {
            setcookie('bee_cart_session', $session_id, time() + 30 * DAY_IN_SECONDS, COOKIEPATH, COOKIE_DOMAIN);
        }

        $this->log_event($event_type, $session_id);
        wp_send_json_success();
    }

    private function log_event($event, $session, $order_id = 0)
    {
        $logs = get_option('bee_cart_analytics_logs', array());
        $logs[] = array(
            'timestamp' => current_time('mysql'),
            'event'     => $event,
            'session'   => $session,
            'order_id'  => $order_id,
            'season'    => $this->get_current_season()
        );
        if (count($logs) > 1000) {
            $logs = array_slice($logs, -1000);
        }
        update_option('bee_cart_analytics_logs', $logs);
    }

    private function get_current_season()
    {
        $month = date('n');
        if ($month >= 3 && $month <= 5) return 'Spring';
        if ($month >= 6 && $month <= 8) return 'Summer';
        if ($month >= 9 && $month <= 11) return 'Autumn';
        return 'Winter';
    }
}
