<?php

/**
 * Class For Database Migration
 *
 * @category Database
 * @author   BitCode Developer <developer@bitcode.pro>
 */

namespace BitCode\FI\Core\Database;

/**
 * Database Migration
 */
final class DB
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public static function migrate()
    {
        global $wpdb;
        global $btcbi_db_version;
        $collate = '';

        if ($wpdb->has_cap('collation')) {
            if (!empty($wpdb->charset)) {
                $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
            }
            if (!empty($wpdb->collate)) {
                $collate .= " COLLATE $wpdb->collate";
            }
        }
        $table_schema = [
            "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}btcbi_log` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `flow_id` bigint(20) DEFAULT NULL,
                `job_id` bigint(20) DEFAULT NULL,
                `api_type` varchar(255) DEFAULT NULL,
                `response_type` varchar(50) DEFAULT NULL,
                `response_obj` LONGTEXT DEFAULT NULL,
                `created_at` DATETIME NOT NULL,
                PRIMARY KEY (`id`),
                KEY `flow_id` (`flow_id`)
            ) $collate;",

            "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}btcbi_flow` (
                `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(255) DEFAULT NULL,
                `triggered_entity` varchar(50)  NOT NULL,
                `triggered_entity_id` varchar(100) DEFAULT NULL, /* form_id = 0 means all/app */
                `flow_details` longtext DEFAULT NULL,
                `status` tinyint(1) DEFAULT 1,/* 0 disabled, 1 enabled,  2 trashed */
                `user_id` bigint(20) unsigned DEFAULT NULL,
                `user_ip` int(11) unsigned DEFAULT NULL,
                `created_at` datetime DEFAULT NULL,
                `updated_at` datetime DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) $collate;"
        ];

        include_once ABSPATH . 'wp-admin/includes/upgrade.php';
        foreach ($table_schema as $table) {
            dbDelta($table);
        }

        update_option(
            'btcbi_db_version',
            $btcbi_db_version
        );
    }

    public static function fallbackDB()
    {
        global $wpdb;
        $wpdb->query("RENAME TABLE `{$wpdb->prefix}btcfi_log` TO `{$wpdb->prefix}btcbi_log`, 
                                   `{$wpdb->prefix}btcfi_flow` TO `{$wpdb->prefix}btcbi_flow`;");
        $options = [
            'btcfi_db_version' => 'btcbi_db_version',
            'btcfi_installed' => 'btcbi_installed',
            'btcfi_version' => 'btcbi_version'
        ];

        foreach ($options as $key => $option) {
            $wpdb->query($wpdb->prepare("UPDATE `{$wpdb->prefix}options` SET `option_name` = %s WHERE `option_name` = %s", $option, $key));
        }
    }
}
