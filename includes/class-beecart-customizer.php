<?php
if (! defined('ABSPATH')) {
    exit;
}

class BeeCart_Customizer
{
    public function init()
    {
        add_action('customize_register', array($this, 'register_settings'));
        add_action('wp_head', array($this, 'output_custom_css'));
    }

    public function register_settings($wp_customize)
    {
        // Add Section
        $wp_customize->add_section('beecart_section', array(
            'title'    => __('BeeCart Settings', 'beecart'),
            'priority' => 160,
        ));

        // Heading
        $wp_customize->add_setting('beecart_heading', array('default' => 'Your Cart'));
        $wp_customize->add_control('beecart_heading', array(
            'label'   => __('Cart Heading', 'beecart'),
            'section' => 'beecart_section',
            'type'    => 'text',
        ));

        // Colors
        $wp_customize->add_setting('beecart_primary_color', array('default' => '#000000'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'beecart_primary_color', array(
            'label'   => __('Primary Color', 'beecart'),
            'section' => 'beecart_section',
        )));

        $wp_customize->add_setting('beecart_bg_color', array('default' => '#ffffff'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'beecart_bg_color', array(
            'label'   => __('Background Color', 'beecart'),
            'section' => 'beecart_section',
        )));

        $wp_customize->add_setting('beecart_text_color', array('default' => '#333333'));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'beecart_text_color', array(
            'label'   => __('Text Color', 'beecart'),
            'section' => 'beecart_section',
        )));

        // Cart Progress
        $wp_customize->add_setting('beecart_progress_enable', array('default' => true));
        $wp_customize->add_control('beecart_progress_enable', array(
            'label'   => __('Enable Cart Progress (Free Shipping)', 'beecart'),
            'section' => 'beecart_section',
            'type'    => 'checkbox',
        ));

        $wp_customize->add_setting('beecart_shipping_threshold', array('default' => 100));
        $wp_customize->add_control('beecart_shipping_threshold', array(
            'label'   => __('Free Shipping Threshold', 'beecart'),
            'section' => 'beecart_section',
            'type'    => 'number',
        ));

        $wp_customize->add_setting('beecart_progress_msg', array('default' => 'You are [amount] away from Free Shipping!'));
        $wp_customize->add_control('beecart_progress_msg', array(
            'label'   => __('Progress Message (Use [amount])', 'beecart'),
            'section' => 'beecart_section',
            'type'    => 'text',
        ));

        $wp_customize->add_setting('beecart_progress_success', array('default' => 'Congratulations! You get free shipping.'));
        $wp_customize->add_control('beecart_progress_success', array(
            'label'   => __('Progress Success Message', 'beecart'),
            'section' => 'beecart_section',
            'type'    => 'text',
        ));

        // Cart Countdown
        $wp_customize->add_setting('beecart_countdown_enable', array('default' => true));
        $wp_customize->add_control('beecart_countdown_enable', array(
            'label'   => __('Enable Cart Countdown', 'beecart'),
            'section' => 'beecart_section',
            'type'    => 'checkbox',
        ));

        $wp_customize->add_setting('beecart_countdown_minutes', array('default' => 15));
        $wp_customize->add_control('beecart_countdown_minutes', array(
            'label'   => __('Countdown Minutes', 'beecart'),
            'section' => 'beecart_section',
            'type'    => 'number',
        ));

        $wp_customize->add_setting('beecart_countdown_msg', array('default' => 'Your cart is reserved for [timer] minutes!'));
        $wp_customize->add_control('beecart_countdown_msg', array(
            'label'   => __('Countdown Message (Use [timer])', 'beecart'),
            'section' => 'beecart_section',
            'type'    => 'text',
        ));

        // Cart Message (announcement bar)
        $wp_customize->add_setting('beecart_announcement_msg', array('default' => 'Save 20% on all items today!'));
        $wp_customize->add_control('beecart_announcement_msg', array(
            'label'   => __('Cart Announcement Message', 'beecart'),
            'section' => 'beecart_section',
            'type'    => 'text',
        ));

        // Trust Badge
        $wp_customize->add_setting('beecart_trust_badge_enable', array('default' => true));
        $wp_customize->add_control('beecart_trust_badge_enable', array(
            'label'   => __('Enable Trust Badge', 'beecart'),
            'section' => 'beecart_section',
            'type'    => 'checkbox',
        ));

        $wp_customize->add_setting('beecart_trust_badge_img');
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'beecart_trust_badge_img', array(
            'label'   => __('Trust Badge Image', 'beecart'),
            'section' => 'beecart_section',
        )));

        // Upsells
        $wp_customize->add_setting('beecart_upsell_enable', array('default' => true));
        $wp_customize->add_control('beecart_upsell_enable', array(
            'label'   => __('Enable Upsells', 'beecart'),
            'section' => 'beecart_section',
            'type'    => 'checkbox',
        ));
        
        $wp_customize->add_setting('beecart_upsell_heading', array('default' => 'You might also like'));
        $wp_customize->add_control('beecart_upsell_heading', array(
            'label'   => __('Upsell Heading', 'beecart'),
            'section' => 'beecart_section',
            'type'    => 'text',
        ));

        // Checkout Button Text
        $wp_customize->add_setting('beecart_checkout_text', array('default' => 'Checkout'));
        $wp_customize->add_control('beecart_checkout_text', array(
            'label'   => __('Checkout Button Text', 'beecart'),
            'section' => 'beecart_section',
            'type'    => 'text',
        ));
    }

    public function output_custom_css()
    {
        $primary_col = get_theme_mod('beecart_primary_color', '#000000');
        $bg_col      = get_theme_mod('beecart_bg_color', '#ffffff');
        $text_col    = get_theme_mod('beecart_text_color', '#333333');
        ?>
        <style type="text/css">
            :root {
                --beecart-primary: <?php echo esc_attr($primary_col); ?>;
                --beecart-bg: <?php echo esc_attr($bg_col); ?>;
                --beecart-text: <?php echo esc_attr($text_col); ?>;
            }
            .beecart-drawer {
                background-color: var(--beecart-bg);
                color: var(--beecart-text);
            }
            .beecart-drawer .beecart-header,
            .beecart-drawer .beecart-footer {
                background-color: var(--beecart-bg);
            }
            .beecart-btn, .beecart-progress-bar-fill {
                background-color: var(--beecart-primary) !important;
                color: #fff !important;
            }
            .beecart-drawer .beecart-close {
                color: var(--beecart-text);
            }
        </style>
        <?php
    }
}
