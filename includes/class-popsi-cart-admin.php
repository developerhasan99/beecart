<?php
if (! defined('ABSPATH')) {
    exit;
}

class Popsi_Cart_Admin
{

    public function init()
    {
        add_action('admin_menu', array($this, 'register_menus'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('admin_notices', array($this, 'maybe_display_disabled_notice'));
        add_filter('plugin_action_links_' . plugin_basename(POPSI_CART_FILE), array($this, 'add_plugin_action_links'));
    }

    public function register_menus()
    {
        add_menu_page(
            'Popsi Cart',
            'Popsi Cart',
            'manage_options',
            'popsi-cart',
            array($this, 'render_cart_builder'),
            POPSI_CART_URL . 'assets/img/popsi-cart-icon.svg',
            58
        );

        add_submenu_page(
            'popsi-cart',
            'Cart Builder',
            'Cart Builder',
            'manage_options',
            'popsi-cart',
            array($this, 'render_cart_builder')
        );
    }

    public function enqueue_admin_assets($hook)
    {
        if (strpos($hook, 'popsi-cart') === false) {
            return;
        }

        wp_enqueue_media();
        // Load standard admin styles for the tab system
        wp_enqueue_style('popsi-cart-admin-style', POPSI_CART_URL . 'assets/css/popsi-cart-admin.css', array(), POPSI_CART_VERSION);

        // Ensure Vanilla drawer classes load natively inside the admin without Tailwind conflicts
        wp_enqueue_style('popsi-cart-drawer-style', POPSI_CART_URL . 'assets/css/cart-drawer.css', array(), POPSI_CART_VERSION);

        wp_enqueue_script('popsi-cart-admin-script', POPSI_CART_URL . 'assets/js/popsi-cart-admin.js', array('jquery'), POPSI_CART_VERSION, true);

        // Use local Alpine.js files instead of CDN to comply with WordPress.org guidelines
        wp_enqueue_script('alpine-collapse', POPSI_CART_URL . 'assets/js/vendor/alpine-collapse.min.js', array('popsi-cart-admin-script'), '3.15.11', true);
        wp_enqueue_script('alpine-js', POPSI_CART_URL . 'assets/js/vendor/alpine.min.js', array('alpine-collapse'), '3.15.11', true);

        // For the preview, we'll also need the frontend styles/scripts
        wp_enqueue_style('popsi-cart-style', POPSI_CART_URL . 'assets/css/popsi-cart.css', array(), POPSI_CART_VERSION);

        $plugin = new Popsi_Cart_Drawer();
        $settings = $plugin->get_settings();
        $menus = wp_get_nav_menus();
        $formatted_menus = array();
        foreach ($menus as $menu) {
            $formatted_menus[] = array(
                'slug' => $menu->slug,
                'name' => $menu->name
            );
        }

        wp_localize_script('popsi-cart-admin-script', 'popsiCartAdminData', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('popsi-cart-admin-nonce'),
            'settings' => $settings,
            'menus'         => $formatted_menus,
            'default_badge' => POPSI_CART_URL . 'assets/img/payment-badge.svg',
            'icons' => array(
                'truck' => 'Shipping Truck',
                'tag'   => 'Discount Tag',
                'gift'  => 'Gift Box',
            ),
            'icon_svgs' => array(
                'truck' => Popsi_Cart_Drawer::get_svg_icon('truck', 'bc-checkpoint-icon'),
                'tag'   => Popsi_Cart_Drawer::get_svg_icon('tag', 'bc-checkpoint-icon'),
                'gift'  => Popsi_Cart_Drawer::get_svg_icon('gift', 'bc-checkpoint-icon'),
            ),
        ));

        // Add global admin CSS as inline style
        $admin_css = '
            #adminmenu .toplevel_page_popsi-cart .wp-menu-image img {
                padding: 0;
                opacity: 0.9;
            }

            #adminmenu .toplevel_page_popsi-cart.current .wp-menu-image img {
                opacity: 1;
            }
        ';
        wp_add_inline_style('popsi-cart-admin-style', $admin_css);
    }

    public function render_cart_builder()
    {
        include POPSI_CART_PATH . 'templates/admin/cart-builder.php';
    }

    public function maybe_display_disabled_notice()
    {
        // Don't show on our own settings page as we already have a banner there
        $screen = get_current_screen();
        if ($screen && strpos($screen->id, 'popsi-cart') !== false) {
            return;
        }

        $plugin = new Popsi_Cart_Drawer();
        $settings = $plugin->get_settings();

        if (! ($settings['enable_cart_drawer'] ?? false)) {
            $settings_url = admin_url('admin.php?page=popsi-cart');
            ?>
            <div class="notice notice-warning is-dismissible">
                <p>
                    <strong>Popsi Cart:</strong> The cart drawer is currently disabled.
                    <a href="<?php echo esc_url($settings_url); ?>">Enable it now</a> to show the drawer on your storefront.
                </p>
            </div>
            <?php
        }
    }

    public function add_plugin_action_links($links)
    {
        $settings_link = '<a href="' . admin_url('admin.php?page=popsi-cart') . '">' . __('Settings', 'popsi-cart-drawer') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
}
