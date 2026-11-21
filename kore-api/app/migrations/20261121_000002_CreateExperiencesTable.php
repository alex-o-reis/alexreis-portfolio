<?php

require_once __DIR__ . '/../../kore/Migration.php';
require_once __DIR__ . '/../../kore/Model.php';

class CreateExperiencesTable extends Migration
{
    public function up()
    {
        Model::query("CREATE TABLE IF NOT EXISTS `experiences` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `company` VARCHAR(160) NOT NULL,
            `period_label_pt` VARCHAR(100) NOT NULL,
            `period_label_en` VARCHAR(100) NOT NULL,
            `period_label_es` VARCHAR(100) NOT NULL,
            `start_date` VARCHAR(20) NULL,
            `end_date` VARCHAR(20) NULL,
            `is_current` TINYINT(1) DEFAULT 0,
            `role_pt` VARCHAR(255) NOT NULL,
            `role_en` VARCHAR(255) NOT NULL,
            `role_es` VARCHAR(255) NOT NULL,
            `description_pt` TEXT NULL,
            `description_en` TEXT NULL,
            `description_es` TEXT NULL,
            `highlights_json` TEXT NULL,
            `tags_json` TEXT NULL,
            `display_order` INT DEFAULT 0,
            `is_visible` TINYINT(1) DEFAULT 1,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` TIMESTAMP NULL DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    public function down()
    {
        Model::query("DROP TABLE IF EXISTS `experiences`;");
    }
}
