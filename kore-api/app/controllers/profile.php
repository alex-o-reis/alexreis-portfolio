<?php

require_once __DIR__ . '/../../kore/Controller.php';
require_once __DIR__ . '/../models/ProfileSetting.php';

class Profile extends Controller
{
    protected array $middleware = ['WriteAuthMiddleware'];

    public function get()
    {
        $profile = ProfileSetting::getMain();
        if (!$profile) {
            return $this->error('Perfil não configurado.', 404);
        }
        return $this->json($profile);
    }

    public function put()
    {
        $existing = Model::query("SELECT * FROM profile_settings WHERE deleted_at IS NULL ORDER BY id ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
        if (!$existing) {
            return $this->error('Perfil não encontrado.', 404);
        }

        $in = $this->request->all();
        $rolePt = trim((string) ($in['role_subtitle_pt'] ?? $existing['role_subtitle_pt']));
        $locPt = trim((string) ($in['location_pt'] ?? $existing['location_pt']));
        $availPt = trim((string) ($in['availability_pt'] ?? $existing['availability_pt']));

        $languages = isset($in['languages']) && is_array($in['languages'])
            ? json_encode($in['languages'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            : $existing['languages_json'];

        $summary = isset($in['summary']) && is_array($in['summary'])
            ? json_encode($in['summary'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            : $existing['summary_json'];

        $metrics = isset($in['metrics']) && is_array($in['metrics'])
            ? json_encode($in['metrics'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            : $existing['metrics_json'];

        Model::query(
            "UPDATE profile_settings SET
                full_name = ?, short_name = ?,
                role_subtitle_pt = ?, role_subtitle_en = ?, role_subtitle_es = ?,
                location_pt = ?, location_en = ?, location_es = ?,
                email = ?, phone = ?, whatsapp_url = ?, github_url = ?, linkedin_url = ?, website_url = ?,
                availability_pt = ?, availability_en = ?, availability_es = ?,
                languages_json = ?, summary_json = ?, metrics_json = ?, updated_at = NOW()
            WHERE id = ?",
            [
                trim((string) ($in['full_name'] ?? $existing['full_name'])),
                trim((string) ($in['short_name'] ?? $existing['short_name'])),
                $rolePt,
                trim((string) ($in['role_subtitle_en'] ?? $existing['role_subtitle_en'])) ?: $rolePt,
                trim((string) ($in['role_subtitle_es'] ?? $existing['role_subtitle_es'])) ?: $rolePt,
                $locPt,
                trim((string) ($in['location_en'] ?? $existing['location_en'])) ?: $locPt,
                trim((string) ($in['location_es'] ?? $existing['location_es'])) ?: $locPt,
                trim((string) ($in['email'] ?? $existing['email'])),
                trim((string) ($in['phone'] ?? $existing['phone'])),
                trim((string) ($in['whatsapp_url'] ?? $existing['whatsapp_url'])),
                trim((string) ($in['github_url'] ?? $existing['github_url'])),
                trim((string) ($in['linkedin_url'] ?? $existing['linkedin_url'])),
                trim((string) ($in['website_url'] ?? $existing['website_url'])),
                $availPt,
                trim((string) ($in['availability_en'] ?? $existing['availability_en'])) ?: $availPt,
                trim((string) ($in['availability_es'] ?? $existing['availability_es'])) ?: $availPt,
                $languages,
                $summary,
                $metrics,
                (int) $existing['id']
            ]
        );

        return $this->json([
            'message' => 'Perfil atualizado com sucesso.',
            'data' => ProfileSetting::getMain()
        ]);
    }
}
