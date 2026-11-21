<?php

require_once __DIR__ . '/../../kore/Controller.php';
require_once __DIR__ . '/../models/Experience.php';

class Experiences extends Controller
{
    protected array $middleware = ['WriteAuthMiddleware'];

    public function get($id = null)
    {
        $includeHidden = isset($_GET['include_hidden']) && $_GET['include_hidden'] == '1';

        if ($id !== null && ctype_digit((string) $id)) {
            $sql = "SELECT * FROM experiences WHERE id = ? AND deleted_at IS NULL" . ($includeHidden ? '' : ' AND is_visible = 1') . " LIMIT 1";
            $stmt = Model::query($sql, [(int) $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                return $this->error('Experiência não encontrada.', 404);
            }
            return $this->json(Experience::formatRow($row));
        }

        if ($includeHidden) {
            $stmt = Model::query("SELECT * FROM experiences WHERE deleted_at IS NULL ORDER BY display_order ASC, id ASC");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->json(array_map([Experience::class, 'formatRow'], $rows));
        }

        return $this->json(Experience::listVisible());
    }

    public function post()
    {
        $payload = $this->extractPayload();
        if (!$payload['company'] || !$payload['role_pt']) {
            return $this->error('Empresa e cargo (PT) são obrigatórios.', 422);
        }

        Model::query(
            "INSERT INTO experiences (
                company, period_label_pt, period_label_en, period_label_es,
                start_date, end_date, is_current,
                role_pt, role_en, role_es,
                description_pt, description_en, description_es,
                tags_json, display_order, is_visible
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $payload['company'],
                $payload['period_label_pt'], $payload['period_label_en'], $payload['period_label_es'],
                $payload['start_date'], $payload['end_date'], $payload['is_current'],
                $payload['role_pt'], $payload['role_en'], $payload['role_es'],
                $payload['description_pt'], $payload['description_en'], $payload['description_es'],
                $payload['tags_json'], $payload['display_order'], $payload['is_visible']
            ]
        );

        $newId = (int) Model::getPdo()->lastInsertId();
        $stmt = Model::query("SELECT * FROM experiences WHERE id = ? LIMIT 1", [$newId]);
        return $this->json([
            'message' => 'Experiência cadastrada com sucesso.',
            'data' => Experience::formatRow($stmt->fetch(PDO::FETCH_ASSOC))
        ], 201);
    }

    public function put($id = null)
    {
        if (!$id || !ctype_digit((string) $id)) {
            return $this->error('ID inválido.', 400);
        }
        $existing = Model::query("SELECT id FROM experiences WHERE id = ? AND deleted_at IS NULL LIMIT 1", [(int) $id])->fetch(PDO::FETCH_ASSOC);
        if (!$existing) {
            return $this->error('Experiência não encontrada.', 404);
        }

        $payload = $this->extractPayload();
        if (!$payload['company'] || !$payload['role_pt']) {
            return $this->error('Empresa e cargo (PT) são obrigatórios.', 422);
        }

        Model::query(
            "UPDATE experiences SET
                company = ?, period_label_pt = ?, period_label_en = ?, period_label_es = ?,
                start_date = ?, end_date = ?, is_current = ?,
                role_pt = ?, role_en = ?, role_es = ?,
                description_pt = ?, description_en = ?, description_es = ?,
                tags_json = ?, display_order = ?, is_visible = ?, updated_at = NOW()
            WHERE id = ?",
            [
                $payload['company'],
                $payload['period_label_pt'], $payload['period_label_en'], $payload['period_label_es'],
                $payload['start_date'], $payload['end_date'], $payload['is_current'],
                $payload['role_pt'], $payload['role_en'], $payload['role_es'],
                $payload['description_pt'], $payload['description_en'], $payload['description_es'],
                $payload['tags_json'], $payload['display_order'], $payload['is_visible'],
                (int) $id
            ]
        );

        $stmt = Model::query("SELECT * FROM experiences WHERE id = ? LIMIT 1", [(int) $id]);
        return $this->json([
            'message' => 'Experiência atualizada com sucesso.',
            'data' => Experience::formatRow($stmt->fetch(PDO::FETCH_ASSOC))
        ]);
    }

    public function delete($id = null)
    {
        if (!$id || !ctype_digit((string) $id)) {
            return $this->error('ID inválido.', 400);
        }
        $existing = Model::query("SELECT id FROM experiences WHERE id = ? AND deleted_at IS NULL LIMIT 1", [(int) $id])->fetch(PDO::FETCH_ASSOC);
        if (!$existing) {
            return $this->error('Experiência não encontrada.', 404);
        }
        Model::query("UPDATE experiences SET deleted_at = NOW() WHERE id = ?", [(int) $id]);
        return $this->json(['message' => 'Experiência removida com sucesso.']);
    }

    private function extractPayload(): array
    {
        $in = $this->request->all();
        $periodPt = trim((string) ($in['period_label_pt'] ?? ''));
        $rolePt = trim((string) ($in['role_pt'] ?? ''));
        $descPt = trim((string) ($in['description_pt'] ?? ''));

        $tags = $in['tags'] ?? null;
        if (is_array($tags)) {
            $tagsNorm = [
                'pt' => $this->normalizeTags($tags['pt'] ?? []),
                'en' => $this->normalizeTags($tags['en'] ?? ($tags['pt'] ?? [])),
                'es' => $this->normalizeTags($tags['es'] ?? ($tags['pt'] ?? [])),
            ];
        } else {
            $ptTags = $this->normalizeTags($in['tags_pt'] ?? '');
            $tagsNorm = [
                'pt' => $ptTags,
                'en' => $this->normalizeTags($in['tags_en'] ?? '') ?: $ptTags,
                'es' => $this->normalizeTags($in['tags_es'] ?? '') ?: $ptTags,
            ];
        }

        return [
            'company' => trim((string) ($in['company'] ?? '')),
            'period_label_pt' => $periodPt,
            'period_label_en' => trim((string) ($in['period_label_en'] ?? '')) ?: $periodPt,
            'period_label_es' => trim((string) ($in['period_label_es'] ?? '')) ?: $periodPt,
            'start_date' => trim((string) ($in['start_date'] ?? '')) ?: null,
            'end_date' => trim((string) ($in['end_date'] ?? '')) ?: null,
            'is_current' => !empty($in['is_current']) ? 1 : 0,
            'role_pt' => $rolePt,
            'role_en' => trim((string) ($in['role_en'] ?? '')) ?: $rolePt,
            'role_es' => trim((string) ($in['role_es'] ?? '')) ?: $rolePt,
            'description_pt' => $descPt,
            'description_en' => trim((string) ($in['description_en'] ?? '')) ?: $descPt,
            'description_es' => trim((string) ($in['description_es'] ?? '')) ?: $descPt,
            'tags_json' => json_encode($tagsNorm, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'display_order' => (int) ($in['display_order'] ?? 0),
            'is_visible' => isset($in['is_visible']) ? ((int) (bool) $in['is_visible']) : 1,
        ];
    }

    private function normalizeTags($raw): array
    {
        if (is_array($raw)) {
            return array_values(array_filter(array_map('trim', $raw), fn($v) => $v !== ''));
        }
        return array_values(array_filter(array_map('trim', explode(',', (string) $raw)), fn($v) => $v !== ''));
    }
}
