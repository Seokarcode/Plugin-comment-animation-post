<?php
/*
Plugin Name: Auto Comment Generator (Educational)
Description: Educational plugin for auto-comment generation - NOT FOR PRODUCTION
Version: 1.0.0
Author: Your Name
*/

if (!defined('ABSPATH')) exit;

// تعریف ثابت‌های ضروری
define('ACG_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ACG_DATA_DIR', ACG_PLUGIN_DIR . 'data/');

// بارگذاری کلاس‌ها
require_once ACG_PLUGIN_DIR . 'includes/class-data-manager.php';
require_once ACG_PLUGIN_DIR . 'includes/class-comment-generator.php';
require_once ACG_PLUGIN_DIR . 'includes/class-admin-page.php';

// راه‌اندازی افزونه
register_activation_hook(__FILE__, ['ACG_Data_Manager', 'activate_plugin']);
register_deactivation_hook(__FILE__, ['ACG_Data_Manager', 'deactivate_plugin']);

new ACG_Admin_Page();
new ACG_Comment_Generator();
