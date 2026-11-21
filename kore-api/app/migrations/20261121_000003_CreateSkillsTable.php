<?php

require_once __DIR__ . '/../../kore/Migration.php';
require_once __DIR__ . '/../../kore/Model.php';

class CreateSkillsTable extends Migration
{
    public function up()
    {
        Model::query("CREATE TABLE IF NOT EXISTS `skills` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name_pt` VARCHAR(120) NOT NULL,
            `name_en` VARCHAR(120) NOT NULL,
            `name_es` VARCHAR(120) NOT NULL,
            `category_key` VARCHAR(60) NOT NULL,
            `category_pt` VARCHAR(100) NOT NULL,
            `category_en` VARCHAR(100) NOT NULL,
            `category_es` VARCHAR(100) NOT NULL,
            `is_featured` TINYINT(1) DEFAULT 1,
            `display_order` INT DEFAULT 0,
            `is_visible` TINYINT(1) DEFAULT 1,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `deleted_at` TIMESTAMP NULL DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    }

    public function down()
    {
        Model::query("DROP TABLE IF EXISTS `skills`;");
    }
}
