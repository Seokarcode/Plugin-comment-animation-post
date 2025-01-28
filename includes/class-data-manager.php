// مدیریت داده‌ها (ایمیل، متن، نام)
<?php
class ACG_Data_Manager {
    private static $table_name;

    public static function activate_plugin() {
        global $wpdb;
        self::$table_name = $wpdb->prefix . 'auto_comments_data';

        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE " . self::$table_name . " (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            type varchar(20) NOT NULL COMMENT 'email, name, comment',
            value text NOT NULL,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
        
        self::seed_initial_data();
    }

    private static function seed_initial_data() {
        // ایمپورت داده‌ها از فایل‌های CSV
        $data_types = ['emails', 'names', 'comments'];
        
        foreach ($data_types as $type) {
            $file_path = ACG_DATA_DIR . $type . '.csv';
            if (file_exists($file_path)) {
                $handle = fopen($file_path, 'r');
                while (($data = fgetcsv($handle)) !== FALSE) {
                    self::insert_data($type, $data[0]);
                }
                fclose($handle);
            }
        }
    }

    public static function get_random_data($type, $count = 1) {
        global $wpdb;
        return $wpdb->get_results(
            $wpdb->prepare("SELECT value FROM " . self::$table_name . " WHERE type = %s ORDER BY RAND() LIMIT %d", $type, $count),
            ARRAY_A
        );
    }

    // سایر متدها (insert_data, deactivate_plugin و...) 
}
