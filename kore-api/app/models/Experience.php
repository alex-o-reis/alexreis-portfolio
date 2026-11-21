<?php

require_once __DIR__ . '/../../kore/Model.php';
require_once __DIR__ . '/../traits/ExperienceTrait.php';

class Experience extends Model
{
    use ExperienceTrait;

    protected static $table = 'experiences';
    protected static $primary_key = 'id';

    public static function listVisible(): array
    {
        $stmt = self::query(
            "SELECT * FROM experiences WHERE deleted_at IS NULL AND is_visible = 1 ORDER BY display_order ASC, id ASC"
        );
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'formatRow'], $rows);
    }

    public static function formatRow(array $row): array
    {
        return [
            'id' => (int) $row['id'],
            'company' => $row['company'],
            'period_label' => [
                'pt' => $row['period_label_pt'],
                'en' => $row['period_label_en'],
                'es' => $row['period_label_es'],
            ],
            'start_date' => $row['start_date'],
            'end_date' => $row['end_date'],
            'is_current' => (bool) $row['is_current'],
            'role' => [
                'pt' => $row['role_pt'],
                'en' => $row['role_en'],
                'es' => $row['role_es'],
            ],
            'description' => [
                'pt' => $row['description_pt'],
                'en' => $row['description_en'],
                'es' => $row['description_es'],
            ],
            'highlights' => json_decode($row['highlights_json'] ?: '{}', true) ?: [],
            'tags' => json_decode($row['tags_json'] ?: '{}', true) ?: [],
            'display_order' => (int) $row['display_order'],
        ];
    }
}
