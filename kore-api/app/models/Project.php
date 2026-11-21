<?php

require_once __DIR__ . '/../../kore/Model.php';
require_once __DIR__ . '/../traits/ProjectTrait.php';

class Project extends Model
{
    use ProjectTrait;

    protected static $table = 'projects';
    protected static $primary_key = 'id';

    public static function listPublished(array $filters = []): array
    {
        $sql = "SELECT * FROM projects WHERE deleted_at IS NULL AND is_published = 1";
        $params = [];

        if (!empty($filters['category'])) {
            $sql .= " AND category = ?";
            $params[] = $filters['category'];
        }
        if (!empty($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }
        if (isset($filters['featured']) && $filters['featured'] !== '') {
            $sql .= " AND is_featured = ?";
            $params[] = (int) $filters['featured'];
        }

        $sql .= " ORDER BY display_order ASC, id ASC";
        $stmt = self::query($sql, $params);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map([self::class, 'formatRow'], $rows);
    }

    public static function findByIdOrSlug($idOrSlug): ?array
    {
        if (ctype_digit((string) $idOrSlug)) {
            $stmt = self::query(
                "SELECT * FROM projects WHERE deleted_at IS NULL AND is_published = 1 AND id = ? LIMIT 1",
                [(int) $idOrSlug]
            );
        } else {
            $stmt = self::query(
                "SELECT * FROM projects WHERE deleted_at IS NULL AND is_published = 1 AND slug = ? LIMIT 1",
                [(string) $idOrSlug]
            );
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? self::formatRow($row) : null;
    }

    public static function formatRow(array $row): array
    {
        return [
            'id' => (int) $row['id'],
            'slug' => $row['slug'],
            'name' => [
                'pt' => $row['name_pt'],
                'en' => $row['name_en'],
                'es' => $row['name_es'],
            ],
            'category' => $row['category'],
            'status' => $row['status'],
            'org' => [
                'pt' => $row['org_pt'],
                'en' => $row['org_en'],
                'es' => $row['org_es'],
            ],
            'stack' => [
                'pt' => $row['stack_pt'],
                'en' => $row['stack_en'],
                'es' => $row['stack_es'],
            ],
            'summary' => [
                'pt' => $row['summary_pt'],
                'en' => $row['summary_en'],
                'es' => $row['summary_es'],
            ],
            'has_detail_page' => (bool) $row['has_detail_page'],
            'detail' => [
                'pt' => json_decode($row['detail_json_pt'] ?: 'null', true),
                'en' => json_decode($row['detail_json_en'] ?: 'null', true),
                'es' => json_decode($row['detail_json_es'] ?: 'null', true),
            ],
            'cover_image' => $row['cover_image'],
            'theme_key' => $row['theme_key'] ?: 'default',
            'system_url' => $row['system_url'],
            'video_url' => $row['video_url'],
            'is_featured' => (bool) $row['is_featured'],
            'is_case_study' => (bool) $row['is_case_study'],
            'case_order' => (int) $row['case_order'],
            'case_label' => [
                'pt' => $row['case_label_pt'],
                'en' => $row['case_label_en'],
                'es' => $row['case_label_es'],
            ],
            'case_icon' => $row['case_icon'],
            'display_order' => (int) $row['display_order'],
        ];
    }
}
