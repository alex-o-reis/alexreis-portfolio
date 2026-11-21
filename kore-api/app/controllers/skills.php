<?php

require_once __DIR__ . '/../../kore/Controller.php';
require_once __DIR__ . '/../models/Skill.php';

class Skills extends Controller
{
    protected array $middleware = ['WriteAuthMiddleware'];

    public function get($id = null)
    {
        $includeHidden = isset($_GET['include_hidden']) && $_GET['include_hidden'] == '1';

        if ($id !== null && ctype_digit((string) $id)) {
            $sql = "SELECT * FROM skills WHERE id = ? AND deleted_at IS NULL" . ($includeHidden ? '' : ' AND is_visible = 1') . " LIMIT 1";
            $row = Model::query($sql, [(int) $id])->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                return $this->error('Skill não encontrada.', 404);
            }
            return $this->json(Skill::formatRow($row));
        }

        if ($includeHidden) {
            $rows = Model::query("SELECT * FROM skills WHERE deleted_at IS NULL ORDER BY display_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
            return $this->json(array_map([Skill::class, 'formatRow'], $rows));
        }

        return $this->json(Skill::listVisible());
    }

    public function post()
    {
        $p = $this->extractPayload();
        if (!$p['name_pt'] || !$p['category_key']) {
            return $this->error('Nome (PT) e categoria são obrigatórios.', 422);
        }

        Model::query(
            "INSERT INTO skills (
                name_pt, name_en, name_es,
                category_key, category_pt, category_en, category_es,
                is_featured, display_order, is_visible
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $p['name_pt'], $p['name_en'], $p['name_es'],
                $p['category_key'], $p['category_pt'], $p['category_en'], $p['category_es'],
                $p['is_featured'], $p['display_order'], $p['is_visible']
            ]
        );

        $newId = (int) Model::getPdo()->lastInsertId();
        $row = Model::query("SELECT * FROM skills WHERE id = ? LIMIT 1", [$newId])->fetch(PDO::FETCH_ASSOC);
        return $this->json([
            'message' => 'Skill cadastrada com sucesso.',
            'data' => Skill::formatRow($row)
        ], 201);
    }

    public function put($id = null)
    {
        if (!$id || !ctype_digit((string) $id)) {
            return $this->error('ID inválido.', 400);
        }
        $existing = Model::query("SELECT id FROM skills WHERE id = ? AND deleted_at IS NULL LIMIT 1", [(int) $id])->fetch(PDO::FETCH_ASSOC);
        if (!$existing) {
            return $this->error('Skill não encontrada.', 404);
        }

        $p = $this->extractPayload();
        if (!$p['name_pt'] || !$p['category_key']) {
            return $this->error('Nome (PT) e categoria são obrigatórios.', 422);
        }

        Model::query(
            "UPDATE skills SET
                name_pt = ?, name_en = ?, name_es = ?,
                category_key = ?, category_pt = ?, category_en = ?, category_es = ?,
                is_featured = ?, display_order = ?, is_visible = ?, updated_at = NOW()
            WHERE id = ?",
            [
                $p['name_pt'], $p['name_en'], $p['name_es'],
                $p['category_key'], $p['category_pt'], $p['category_en'], $p['category_es'],
                $p['is_featured'], $p['display_order'], $p['is_visible'],
                (int) $id
            ]
        );

        $row = Model::query("SELECT * FROM skills WHERE id = ? LIMIT 1", [(int) $id])->fetch(PDO::FETCH_ASSOC);
        return $this->json([
            'message' => 'Skill atualizada com sucesso.',
            'data' => Skill::formatRow($row)
        ]);
    }

    public function delete($id = null)
    {
        if (!$id || !ctype_digit((string) $id)) {
            return $this->error('ID inválido.', 400);
        }
        $existing = Model::query("SELECT id FROM skills WHERE id = ? AND deleted_at IS NULL LIMIT 1", [(int) $id])->fetch(PDO::FETCH_ASSOC);
        if (!$existing) {
            return $this->error('Skill não encontrada.', 404);
        }
        Model::query("UPDATE skills SET deleted_at = NOW() WHERE id = ?", [(int) $id]);
        return $this->json(['message' => 'Skill removida com sucesso.']);
    }

    private function extractPayload(): array
    {
        $in = $this->request->all();
        $presets = [
            'architecture' => ['pt' => 'Arquitetura & BPM', 'en' => 'Architecture & BPM', 'es' => 'Arquitectura y BPM'],
            'backend'      => ['pt' => 'Back-end & APIs', 'en' => 'Back-end & APIs', 'es' => 'Back-end y APIs'],
            'frontend'     => ['pt' => 'Front-end', 'en' => 'Front-end', 'es' => 'Front-end'],
            'mobile'       => ['pt' => 'Mobile', 'en' => 'Mobile', 'es' => 'Móvil'],
            'data'         => ['pt' => 'Dados & Cloud', 'en' => 'Data & Cloud', 'es' => 'Datos y Cloud'],
            'ai'           => ['pt' => 'IA Aplicada', 'en' => 'Applied AI', 'es' => 'IA Aplicada'],
            'practices'    => ['pt' => 'Práticas & Liderança', 'en' => 'Practices & Leadership', 'es' => 'Prácticas y Liderazgo'],
        ];

        $namePt = trim((string) ($in['name_pt'] ?? ''));
        $catKey = strtolower(trim((string) ($in['category_key'] ?? 'architecture')));
        $catPreset = $presets[$catKey] ?? ['pt' => ucfirst($catKey), 'en' => ucfirst($catKey), 'es' => ucfirst($catKey)];
        $catPt = trim((string) ($in['category_pt'] ?? '')) ?: $catPreset['pt'];

        return [
            'name_pt' => $namePt,
            'name_en' => trim((string) ($in['name_en'] ?? '')) ?: $namePt,
            'name_es' => trim((string) ($in['name_es'] ?? '')) ?: $namePt,
            'category_key' => $catKey,
            'category_pt' => $catPt,
            'category_en' => trim((string) ($in['category_en'] ?? '')) ?: $catPreset['en'],
            'category_es' => trim((string) ($in['category_es'] ?? '')) ?: $catPreset['es'],
            'is_featured' => isset($in['is_featured']) ? ((int) (bool) $in['is_featured']) : 1,
            'display_order' => (int) ($in['display_order'] ?? 0),
            'is_visible' => isset($in['is_visible']) ? ((int) (bool) $in['is_visible']) : 1,
        ];
    }
}
