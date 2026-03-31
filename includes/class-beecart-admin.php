<?php
if (! defined('ABSPATH')) {
    exit;
}

class BeeCart_Admin
{

    public function init()
    {
        add_action('admin_menu', array($this, 'register_menus'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        add_action('admin_head', array($this, 'output_global_admin_css'));

        // Handle AJAX save settings (Disabled for now)
        // add_action('wp_ajax_beecart_save_settings', array($this, 'ajax_save_settings'));
    }

    public function register_menus()
    {
        add_menu_page(
            'BeeCart',
            'BeeCart',
            'manage_options',
            'beecart',
            array($this, 'render_cart_builder'),
            BEECART_URL . 'assets/img/bee-cart-icon.svg',
            58
        );

        add_submenu_page(
            'beecart',
            'Cart Builder',
            'Cart Builder',
            'manage_options',
            'beecart',
            array($this, 'render_cart_builder')
        );
    }

    public function enqueue_admin_assets($hook)
    {
        if (strpos($hook, 'beecart') === false) {
            return;
        }

        wp_enqueue_media();
        // Load standard admin styles for the tab system
        wp_enqueue_style('beecart-admin-style', BEECART_URL . 'assets/css/beecart-admin.css', array(), BEECART_VERSION);

        // Ensure Vanilla drawer classes load natively inside the admin without Tailwind conflicts
        wp_enqueue_style('beecart-drawer-style', BEECART_URL . 'assets/css/cart-drawer.css', array(), BEECART_VERSION);

        wp_enqueue_script('beecart-admin-script', BEECART_URL . 'assets/js/beecart-admin.js', array('jquery'), BEECART_VERSION, true);
        wp_enqueue_script('alpine-collapse', 'https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js', array('beecart-admin-script'), null, true);
        wp_enqueue_script('alpine-js', 'https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js', array('alpine-collapse'), null, true);

        // For the preview, we'll also need the frontend styles/scripts
        wp_enqueue_style('beecart-style', BEECART_URL . 'assets/css/beecart.css', array(), BEECART_VERSION);

        $plugin = new BeeCart();
        $settings = $plugin->get_settings();
        $menus = wp_get_nav_menus();
        $formatted_menus = array();
        foreach ($menus as $menu) {
            $formatted_menus[] = array(
                'slug' => $menu->slug,
                'name' => $menu->name
            );
        }


        wp_localize_script('beecart-admin-script', 'beecartAdminData', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('beecart-admin-nonce'),
            'settings' => $settings,
            'menus'    => $formatted_menus,
            // 'badges' array removed since we now use a single custom image uploader
        ));
    }

    public function render_cart_builder()
    {
        include BEECART_PATH . 'templates/admin/cart-builder.php';
    }

    public function output_global_admin_css()
    {
?>
        <style id="beecart-global-admin-css">
            #adminmenu .toplevel_page_beecart .wp-menu-image img {
                padding: 0;
                opacity: 0.9;
            }

            #adminmenu .toplevel_page_beecart.current .wp-menu-image img {
                opacity: 1;
            }
        </style>
<?php
    }
}
