<?php

require_once __DIR__ . '/../../kore/Migration.php';
require_once __DIR__ . '/../../kore/Model.php';

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Model::query("CREATE TABLE IF NOT EXISTS `projects` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `slug` VARCHAR(120) NOT NULL UNIQUE,
            `name_pt` VARCHAR(180) NOT NULL,
            `name_en` VARCHAR(180) NOT NULL,
            `name_es` VARCHAR(180) NOT NULL,
            `category` VARCHAR(50) NOT NULL,
            `status` VARCHAR(40) NOT NULL DEFAULT 'delivered',
            `org_pt` VARCHAR(140) NULL,
            `org_en` VARCHAR(140) NULL,
            `org_es` VARCHAR(140) NULL,
            `stack_pt` VARCHAR(255) NULL,
            `stack_en` VARCHAR(255) NULL,
            `stack_es` VARCHAR(255) NULL,
            `summary_pt` TEXT NULL,
            `summary_en` TEXT NULL,
            `summary_es` TEXT NULL,
            `has_detail_page` TINYINT(1) DEFAULT 0,
            `detail_json_pt` TEXT NULL,
            `detail_json_en` TEXT NULL,
            `detail_json_es` TEXT NULL,
            `cover_image` VARCHAR(255) NULL,
            `theme_key` VARCHAR(40) DEFAULT 'default',
            `system_url` VARCHAR(255) NULL,
            `video_url` VARCHAR(255) NULL,
            `is_featured` TINYINT(1) DEFAULT 0,
            `is_case_study` TINYINT(1) DEFAULT 0,
            `case_order` INT DEFAULT 0,
            `case_label_pt` VARCHAR(120) NULL,
            `case_label_en` VARCHAR(120) NULL,
            `case_label_es` VARCHAR(120) NULL,
            `case_icon` VARCHAR(30) NULL,
            `display_order` INT DEFAULT 0,
            `is_published` TINYINT(1) DEFAULT 1,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` TIMESTAMP NULL DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    public function down()
    {
        Model::query("DROP TABLE IF EXISTS `projects`;");
    }
}
