<?php
if (! defined('ABSPATH')) {
    exit;
}

class Bee_Cart_Customizer
{
    public function init()
    {
        add_action('customize_register', array($this, 'register_settings'));
        add_action('wp_head', array($this, 'output_custom_css'));
    }

    public function register_settings($wp_customize)
    {
        // Add Section
        $wp_customize->add_section('bee_cart_section', array(
            'title'    => __('Bee Cart Settings', 'bee-cart'),
            'priority' => 160,
        ));

        // Heading
        $wp_customize->add_setting('bee_cart_heading', array('default' => 'Your Cart'));
        $wp_customize->add_control('bee_cart_heading', array(
            'label'   => __('Cart Heading', 'bee-cart'),
            'section' => 'bee_cart_section',
            'type'    => 'text',
        ));

        // Colors
        $wp_customize->add_setting('bee_cart_primary_color', array('default' => '#000000'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bee_cart_primary_color', array(
            'label'   => __('Primary Color', 'bee-cart'),
            'section' => 'bee_cart_section',
        )));

        $wp_customize->add_setting('bee_cart_bg_color', array('default' => '#ffffff'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bee_cart_bg_color', array(
            'label'   => __('Background Color', 'bee-cart'),
            'section' => 'bee_cart_section',
        )));

        $wp_customize->add_setting('bee_cart_text_color', array('default' => '#333333'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'bee_cart_text_color', array(
            'label'   => __('Text Color', 'bee-cart'),
            'section' => 'bee_cart_section',
        )));

        // Cart Progress
        $wp_customize->add_setting('bee_cart_progress_enable', array('default' => true));
        $wp_customize->add_control('bee_cart_progress_enable', array(
            'label'   => __('Enable Cart Progress (Free Shipping)', 'bee-cart'),
            'section' => 'bee_cart_section',
            'type'    => 'checkbox',
        ));

        $wp_customize->add_setting('bee_cart_shipping_threshold', array('default' => 100));
        $wp_customize->add_control('bee_cart_shipping_threshold', array(
            'label'   => __('Free Shipping Threshold', 'bee-cart'),
            'section' => 'bee_cart_section',
            'type'    => 'number',
        ));

        $wp_customize->add_setting('bee_cart_progress_msg', array('default' => 'You are [amount] away from Free Shipping!'));
        $wp_customize->add_control('bee_cart_progress_msg', array(
            'label'   => __('Progress Message (Use [amount])', 'bee-cart'),
            'section' => 'bee_cart_section',
            'type'    => 'text',
        ));

        $wp_customize->add_setting('bee_cart_progress_success', array('default' => 'Congratulations! You get free shipping.'));
        $wp_customize->add_control('bee_cart_progress_success', array(
            'label'   => __('Progress Success Message', 'bee-cart'),
            'section' => 'bee_cart_section',
            'type'    => 'text',
        ));

        // Cart Countdown
        $wp_customize->add_setting('bee_cart_countdown_enable', array('default' => true));
        $wp_customize->add_control('bee_cart_countdown_enable', array(
            'label'   => __('Enable Cart Countdown', 'bee-cart'),
            'section' => 'bee_cart_section',
            'type'    => 'checkbox',
        ));

        $wp_customize->add_setting('bee_cart_countdown_minutes', array('default' => 15));
        $wp_customize->add_control('bee_cart_countdown_minutes', array(
            'label'   => __('Countdown Minutes', 'bee-cart'),
            'section' => 'bee_cart_section',
            'type'    => 'number',
        ));

        $wp_customize->add_setting('bee_cart_countdown_msg', array('default' => 'Your cart is reserved for [timer] minutes!'));
        $wp_customize->add_control('bee_cart_countdown_msg', array(
            'label'   => __('Countdown Message (Use [timer])', 'bee-cart'),
            'section' => 'bee_cart_section',
            'type'    => 'text',
        ));

        // Cart Message (announcement bar)
        $wp_customize->add_setting('bee_cart_announcement_msg', array('default' => 'Save 20% on all items today!'));
        $wp_customize->add_control('bee_cart_announcement_msg', array(
            'label'   => __('Cart Announcement Message', 'bee-cart'),
            'section' => 'bee_cart_section',
            'type'    => 'text',
        ));

        // Trust Badge
        $wp_customize->add_setting('bee_cart_trust_badge_enable', array('default' => true));
        $wp_customize->add_control('bee_cart_trust_badge_enable', array(
            'label'   => __('Enable Trust Badge', 'bee-cart'),
            'section' => 'bee_cart_section',
            'type'    => 'checkbox',
        ));

        $wp_customize->add_setting('bee_cart_trust_badge_img');
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'bee_cart_trust_badge_img', array(
            'label'   => __('Trust Badge Image', 'bee-cart'),
            'section' => 'bee_cart_section',
        )));

        // Upsells
        $wp_customize->add_setting('bee_cart_upsell_enable', array('default' => true));
        $wp_customize->add_control('bee_cart_upsell_enable', array(
            'label'   => __('Enable Upsells', 'bee-cart'),
            'section' => 'bee_cart_section',
            'type'    => 'checkbox',
        ));
        
        $wp_customize->add_setting('bee_cart_upsell_heading', array('default' => 'You might also like'));
        $wp_customize->add_control('bee_cart_upsell_heading', array(
            'label'   => __('Upsell Heading', 'bee-cart'),
            'section' => 'bee_cart_section',
            'type'    => 'text',
        ));

        // Checkout Button Text
        $wp_customize->add_setting('bee_cart_checkout_text', array('default' => 'Checkout'));
        $wp_customize->add_control('bee_cart_checkout_text', array(
            'label'   => __('Checkout Button Text', 'bee-cart'),
            'section' => 'bee_cart_section',
            'type'    => 'text',
        ));
    }

    public function output_custom_css()
    {
        $primary_col = get_theme_mod('bee_cart_primary_color', '#000000');
        $bg_col      = get_theme_mod('bee_cart_bg_color', '#ffffff');
        $text_col    = get_theme_mod('bee_cart_text_color', '#333333');
        ?>
        <style type="text/css">
            :root {
                --bee-cart-primary: <?php echo esc_attr($primary_col); ?>;
                --bee-cart-bg: <?php echo esc_attr($bg_col); ?>;
                --bee-cart-text: <?php echo esc_attr($text_col); ?>;
            }
            .bee-cart-drawer {
                background-color: var(--bee-cart-bg);
                color: var(--bee-cart-text);
            }
            .bee-cart-drawer .bee-cart-header,
            .bee-cart-drawer .bee-cart-footer {
                background-color: var(--bee-cart-bg);
            }
            .bee-cart-btn, .bee-cart-progress-bar-fill {
                background-color: var(--bee-cart-primary) !important;
                color: #fff !important;
            }
            .bee-cart-drawer .bee-cart-close {
                color: var(--bee-cart-text);
            }
        </style>
        <?php
    }
}
