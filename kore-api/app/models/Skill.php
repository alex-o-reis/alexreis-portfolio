<?php

require_once __DIR__ . '/../../kore/Model.php';
require_once __DIR__ . '/../traits/SkillTrait.php';

class Skill extends Model
{
    use SkillTrait;

    protected static $table = 'skills';
    protected static $primary_key = 'id';

    public static function listVisible(): array
    {
        $stmt = self::query(
            "SELECT * FROM skills WHERE deleted_at IS NULL AND is_visible = 1 ORDER BY display_order ASC, id ASC"
        );
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'formatRow'], $rows);
    }

    public static function formatRow(array $row): array
    {
        return [
            'id' => (int) $row['id'],
            'name' => [
                'pt' => $row['name_pt'],
                'en' => $row['name_en'],
                'es' => $row['name_es'],
            ],
            'category_key' => $row['category_key'],
            'category' => [
                'pt' => $row['category_pt'],
                'en' => $row['category_en'],
                'es' => $row['category_es'],
            ],
            'is_featured' => (bool) $row['is_featured'],
            'display_order' => (int) $row['display_order'],
        ];
    }
}
