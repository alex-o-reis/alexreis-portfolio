<?php

require_once __DIR__ . '/../../kore/Model.php';
require_once __DIR__ . '/../traits/ProfileSettingTrait.php';

class ProfileSetting extends Model
{
    use ProfileSettingTrait;

    protected static $table = 'profile_settings';
    protected static $primary_key = 'id';

    public static function getMain(): ?array
    {
        $stmt = self::query("SELECT * FROM profile_settings WHERE deleted_at IS NULL ORDER BY id ASC LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return self::formatRow($row);
    }

    public static function formatRow(array $row): array
    {
        return [
            'id' => (int) $row['id'],
            'full_name' => $row['full_name'],
            'short_name' => $row['short_name'],
            'brand_mark' => $row['brand_mark'],
            'role_subtitle' => [
                'pt' => $row['role_subtitle_pt'],
                'en' => $row['role_subtitle_en'],
                'es' => $row['role_subtitle_es'],
            ],
            'location' => [
                'pt' => $row['location_pt'],
                'en' => $row['location_en'],
                'es' => $row['location_es'],
            ],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'whatsapp_url' => $row['whatsapp_url'],
            'github_url' => $row['github_url'],
            'linkedin_url' => $row['linkedin_url'],
            'website_url' => $row['website_url'],
            'availability' => [
                'pt' => $row['availability_pt'],
                'en' => $row['availability_en'],
                'es' => $row['availability_es'],
            ],
            'summary' => json_decode($row['summary_json'] ?: '{}', true) ?: [],
            'metrics' => json_decode($row['metrics_json'] ?: '[]', true) ?: [],
            'principles' => json_decode($row['principles_json'] ?: '[]', true) ?: [],
            'languages' => json_decode($row['languages_json'] ?: '{}', true) ?: [],
            'resumes' => json_decode($row['resumes_json'] ?: '[]', true) ?: [],
        ];
    }
}
