<?php

require_once __DIR__ . '/../../kore/Migration.php';
require_once __DIR__ . '/../../kore/Model.php';

class CreateEducationItemsTable extends Migration
{
    public function up()
    {
        Model::query("CREATE TABLE IF NOT EXISTS `education_items` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `item_type` VARCHAR(30) NOT NULL DEFAULT 'degree',
            `institution` VARCHAR(180) NOT NULL,
            `title_pt` VARCHAR(180) NOT NULL,
            `title_en` VARCHAR(180) NOT NULL,
            `title_es` VARCHAR(180) NOT NULL,
            `period_label` VARCHAR(80) NULL,
            `details_pt` TEXT NULL,
            `details_en` TEXT NULL,
            `details_es` TEXT NULL,
            `display_order` INT DEFAULT 0,
            `is_visible` TINYINT(1) DEFAULT 1,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` TIMESTAMP NULL DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    public function down()
    {
        Model::query("DROP TABLE IF EXISTS `education_items`;");
    }
}
