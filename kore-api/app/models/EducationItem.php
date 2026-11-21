<?php

require_once __DIR__ . '/../../kore/Model.php';
require_once __DIR__ . '/../traits/EducationItemTrait.php';

class EducationItem extends Model
{
    use EducationItemTrait;

    protected static $table = 'education_items';
    protected static $primary_key = 'id';

    public static function listVisible(?string $type = null): array
    {
        if ($type) {
            $stmt = self::query(
                "SELECT * FROM education_items WHERE deleted_at IS NULL AND is_visible = 1 AND item_type = ? ORDER BY display_order ASC, id ASC",
                [$type]
            );
        } else {
            $stmt = self::query(
                "SELECT * FROM education_items WHERE deleted_at IS NULL AND is_visible = 1 ORDER BY display_order ASC, id ASC"
            );
        }
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'formatRow'], $rows);
    }

    public static function formatRow(array $row): array
    {
        return [
            'id' => (int) $row['id'],
            'item_type' => $row['item_type'],
            'institution' => $row['institution'],
            'title' => [
                'pt' => $row['title_pt'],
                'en' => $row['title_en'],
                'es' => $row['title_es'],
            ],
            'period_label' => $row['period_label'],
            'details' => [
                'pt' => $row['details_pt'],
                'en' => $row['details_en'],
                'es' => $row['details_es'],
            ],
            'display_order' => (int) $row['display_order'],
            'is_visible' => (bool) $row['is_visible'],
        ];
    }
}
