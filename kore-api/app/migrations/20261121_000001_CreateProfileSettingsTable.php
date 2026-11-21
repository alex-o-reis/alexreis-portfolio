<?php

require_once __DIR__ . '/../../kore/Migration.php';
require_once __DIR__ . '/../../kore/Model.php';

class CreateProfileSettingsTable extends Migration
{
    public function up()
    {
        Model::query("CREATE TABLE IF NOT EXISTS `profile_settings` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `full_name` VARCHAR(160) NOT NULL,
            `short_name` VARCHAR(80) NOT NULL,
            `brand_mark` VARCHAR(20) DEFAULT 'ar',
            `role_subtitle_pt` VARCHAR(160) NULL,
            `role_subtitle_en` VARCHAR(160) NULL,
            `role_subtitle_es` VARCHAR(160) NULL,
            `location_pt` VARCHAR(120) NULL,
            `location_en` VARCHAR(120) NULL,
            `location_es` VARCHAR(120) NULL,
            `email` VARCHAR(160) NULL,
            `phone` VARCHAR(60) NULL,
            `whatsapp_url` VARCHAR(255) NULL,
            `github_url` VARCHAR(255) NULL,
            `linkedin_url` VARCHAR(255) NULL,
            `website_url` VARCHAR(255) NULL,
            `availability_pt` TEXT NULL,
            `availability_en` TEXT NULL,
            `availability_es` TEXT NULL,
            `summary_json` TEXT NULL,
            `metrics_json` TEXT NULL,
            `principles_json` TEXT NULL,
            `languages_json` TEXT NULL,
            `resumes_json` TEXT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` TIMESTAMP NULL DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    public function down()
    {
        Model::query("DROP TABLE IF EXISTS `profile_settings`;");
    }
}
