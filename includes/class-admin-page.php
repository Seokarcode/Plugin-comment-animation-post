<?php
class ACG_Admin_Page {
    public function __construct() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }

    public function add_admin_menu() {
        add_menu_page(
            'Auto Comment Generator',
            'Auto Comments',
            'manage_options',
            'auto-comment-generator',
            [$this, 'render_admin_page'],
            'dashicons-testimonial'
        );
    }

    public function render_admin_page() {
        // رابط کاربری پیشرفته با فرم آپلود CSV و تنظیمات
        include ACG_PLUGIN_DIR . 'templates/admin-page.php';
    }

    public function enqueue_admin_assets($hook) {
        if ($hook === 'toplevel_page_auto-comment-generator') {
            wp_enqueue_style('acg-admin-css', plugins_url('assets/admin.css', __FILE__));
            wp_enqueue_script('acg-admin-js', plugins_url('assets/admin.js', __FILE__), ['jquery'], null, true);
        }
    }

    // متدهای پردازش آپلود فایل‌های CSV
}
