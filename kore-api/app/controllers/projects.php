<?php

require_once __DIR__ . '/../../kore/Controller.php';
require_once __DIR__ . '/../models/Project.php';

class Projects extends Controller
{
    protected array $middleware = ['WriteAuthMiddleware'];

    public function get($idOrSlug = null)
    {
        $includeHidden = isset($_GET['include_hidden']) && $_GET['include_hidden'] == '1';

        if ($idOrSlug !== null && $idOrSlug !== '') {
            if ($includeHidden) {
                $col = ctype_digit((string) $idOrSlug) ? 'id' : 'slug';
                $val = $col === 'id' ? (int) $idOrSlug : (string) $idOrSlug;
                $row = Model::query("SELECT * FROM projects WHERE deleted_at IS NULL AND {$col} = ? LIMIT 1", [$val])->fetch(PDO::FETCH_ASSOC);
                if (!$row) {
                    return $this->error('Projeto não encontrado.', 404);
                }
                return $this->json(Project::formatRow($row));
            }

            $project = Project::findByIdOrSlug($idOrSlug);
            if (!$project) {
                return $this->error('Projeto não encontrado.', 404);
            }
            return $this->json($project);
        }

        if ($includeHidden) {
            $rows = Model::query("SELECT * FROM projects WHERE deleted_at IS NULL ORDER BY display_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
            return $this->json(array_map([Project::class, 'formatRow'], $rows));
        }

        $filters = [
            'category' => $_GET['category'] ?? null,
            'status' => $_GET['status'] ?? null,
            'featured' => $_GET['featured'] ?? null,
        ];

        return $this->json(Project::listPublished($filters));
    }

    public function post()
    {
        $p = $this->extractPayload();
        if (!$p['name_pt']) {
            return $this->error('O nome do projeto (PT) é obrigatório.', 422);
        }

        $dup = Model::query("SELECT id FROM projects WHERE slug = ? AND deleted_at IS NULL LIMIT 1", [$p['slug']])->fetch(PDO::FETCH_ASSOC);
        if ($dup) {
            return $this->error("Já existe um projeto com o slug '{$p['slug']}'.", 409);
        }

        Model::query(
            "INSERT INTO projects (
                slug, name_pt, name_en, name_es,
                category, status,
                org_pt, org_en, org_es,
                stack_pt, stack_en, stack_es,
                summary_pt, summary_en, summary_es,
                has_detail_page, detail_json_pt, detail_json_en, detail_json_es,
                cover_image, theme_key, system_url, video_url,
                is_featured, is_case_study, case_order,
                case_label_pt, case_label_en, case_label_es, case_icon,
                display_order, is_published
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $p['slug'], $p['name_pt'], $p['name_en'], $p['name_es'],
                $p['category'], $p['status'],
                $p['org_pt'], $p['org_en'], $p['org_es'],
                $p['stack_pt'], $p['stack_en'], $p['stack_es'],
                $p['summary_pt'], $p['summary_en'], $p['summary_es'],
                $p['has_detail_page'], $p['detail_json_pt'], $p['detail_json_en'], $p['detail_json_es'],
                $p['cover_image'], $p['theme_key'], $p['system_url'], $p['video_url'],
                $p['is_featured'], $p['is_case_study'], $p['case_order'],
                $p['case_label_pt'], $p['case_label_en'], $p['case_label_es'], $p['case_icon'],
                $p['display_order'], $p['is_published']
            ]
        );

        $newId = (int) Model::getPdo()->lastInsertId();
        $row = Model::query("SELECT * FROM projects WHERE id = ? LIMIT 1", [$newId])->fetch(PDO::FETCH_ASSOC);
        return $this->json([
            'message' => 'Projeto cadastrado com sucesso.',
            'data' => Project::formatRow($row)
        ], 201);
    }

    public function put($id = null)
    {
        if (!$id || !ctype_digit((string) $id)) {
            return $this->error('ID inválido.', 400);
        }
        $existing = Model::query("SELECT id FROM projects WHERE id = ? AND deleted_at IS NULL LIMIT 1", [(int) $id])->fetch(PDO::FETCH_ASSOC);
        if (!$existing) {
            return $this->error('Projeto não encontrado.', 404);
        }

        $p = $this->extractPayload();
        if (!$p['name_pt']) {
            return $this->error('O nome do projeto (PT) é obrigatório.', 422);
        }

        $dup = Model::query("SELECT id FROM projects WHERE slug = ? AND id != ? AND deleted_at IS NULL LIMIT 1", [$p['slug'], (int) $id])->fetch(PDO::FETCH_ASSOC);
        if ($dup) {
            return $this->error("Já existe outro projeto com o slug '{$p['slug']}'.", 409);
        }

        Model::query(
            "UPDATE projects SET
                slug = ?, name_pt = ?, name_en = ?, name_es = ?,
                category = ?, status = ?,
                org_pt = ?, org_en = ?, org_es = ?,
                stack_pt = ?, stack_en = ?, stack_es = ?,
                summary_pt = ?, summary_en = ?, summary_es = ?,
                has_detail_page = ?, detail_json_pt = ?, detail_json_en = ?, detail_json_es = ?,
                cover_image = ?, theme_key = ?, system_url = ?, video_url = ?,
                is_featured = ?, is_case_study = ?, case_order = ?,
                case_label_pt = ?, case_label_en = ?, case_label_es = ?, case_icon = ?,
                display_order = ?, is_published = ?, updated_at = NOW()
            WHERE id = ?",
            [
                $p['slug'], $p['name_pt'], $p['name_en'], $p['name_es'],
                $p['category'], $p['status'],
                $p['org_pt'], $p['org_en'], $p['org_es'],
                $p['stack_pt'], $p['stack_en'], $p['stack_es'],
                $p['summary_pt'], $p['summary_en'], $p['summary_es'],
                $p['has_detail_page'], $p['detail_json_pt'], $p['detail_json_en'], $p['detail_json_es'],
                $p['cover_image'], $p['theme_key'], $p['system_url'], $p['video_url'],
                $p['is_featured'], $p['is_case_study'], $p['case_order'],
                $p['case_label_pt'], $p['case_label_en'], $p['case_label_es'], $p['case_icon'],
                $p['display_order'], $p['is_published'],
                (int) $id
            ]
        );

        $row = Model::query("SELECT * FROM projects WHERE id = ? LIMIT 1", [(int) $id])->fetch(PDO::FETCH_ASSOC);
        return $this->json([
            'message' => 'Projeto atualizado com sucesso.',
            'data' => Project::formatRow($row)
        ]);
    }

    public function delete($id = null)
    {
        if (!$id || !ctype_digit((string) $id)) {
            return $this->error('ID inválido.', 400);
        }
        $existing = Model::query("SELECT id FROM projects WHERE id = ? AND deleted_at IS NULL LIMIT 1", [(int) $id])->fetch(PDO::FETCH_ASSOC);
        if (!$existing) {
            return $this->error('Projeto não encontrado.', 404);
        }
        Model::query("UPDATE projects SET deleted_at = NOW() WHERE id = ?", [(int) $id]);
        return $this->json(['message' => 'Projeto removido com sucesso.']);
    }

    private function extractPayload(): array
    {
        $in = $this->request->all();
        $namePt = trim((string) ($in['name_pt'] ?? ''));
        $slug = $this->slugify(trim((string) ($in['slug'] ?? '')) ?: $namePt);

        $orgPt = trim((string) ($in['org_pt'] ?? ''));
        $stackPt = trim((string) ($in['stack_pt'] ?? ''));
        $summaryPt = trim((string) ($in['summary_pt'] ?? ''));
        $caseLabelPt = trim((string) ($in['case_label_pt'] ?? ''));

        $detailPt = $this->encodeDetail($in['detail_pt'] ?? ($in['detail']['pt'] ?? null));
        $detailEn = $this->encodeDetail($in['detail_en'] ?? ($in['detail']['en'] ?? null)) ?: $detailPt;
        $detailEs = $this->encodeDetail($in['detail_es'] ?? ($in['detail']['es'] ?? null)) ?: $detailPt;

        return [
            'slug' => $slug,
            'name_pt' => $namePt,
            'name_en' => trim((string) ($in['name_en'] ?? '')) ?: $namePt,
            'name_es' => trim((string) ($in['name_es'] ?? '')) ?: $namePt,
            'category' => trim((string) ($in['category'] ?? 'product')),
            'status' => trim((string) ($in['status'] ?? 'development')),
            'org_pt' => $orgPt,
            'org_en' => trim((string) ($in['org_en'] ?? '')) ?: $orgPt,
            'org_es' => trim((string) ($in['org_es'] ?? '')) ?: $orgPt,
            'stack_pt' => $stackPt,
            'stack_en' => trim((string) ($in['stack_en'] ?? '')) ?: $stackPt,
            'stack_es' => trim((string) ($in['stack_es'] ?? '')) ?: $stackPt,
            'summary_pt' => $summaryPt,
            'summary_en' => trim((string) ($in['summary_en'] ?? '')) ?: $summaryPt,
            'summary_es' => trim((string) ($in['summary_es'] ?? '')) ?: $summaryPt,
            'has_detail_page' => !empty($in['has_detail_page']) ? 1 : 0,
            'detail_json_pt' => $detailPt,
            'detail_json_en' => $detailEn,
            'detail_json_es' => $detailEs,
            'cover_image' => trim((string) ($in['cover_image'] ?? '')) ?: null,
            'theme_key' => in_array($in['theme_key'] ?? 'default', ['default', 'satwa', 'kreww'], true) ? $in['theme_key'] : 'default',
            'system_url' => trim((string) ($in['system_url'] ?? '')) ?: null,
            'video_url' => trim((string) ($in['video_url'] ?? '')) ?: null,
            'is_featured' => !empty($in['is_featured']) ? 1 : 0,
            'is_case_study' => !empty($in['is_case_study']) ? 1 : 0,
            'case_order' => (int) ($in['case_order'] ?? 0),
            'case_label_pt' => $caseLabelPt ?: null,
            'case_label_en' => (trim((string) ($in['case_label_en'] ?? '')) ?: $caseLabelPt) ?: null,
            'case_label_es' => (trim((string) ($in['case_label_es'] ?? '')) ?: $caseLabelPt) ?: null,
            'case_icon' => trim((string) ($in['case_icon'] ?? '')) ?: null,
            'display_order' => (int) ($in['display_order'] ?? 0),
            'is_published' => isset($in['is_published']) ? ((int) (bool) $in['is_published']) : 1,
        ];
    }

    private function encodeDetail($val): ?string
    {
        if (empty($val)) {
            return null;
        }
        if (is_string($val)) {
            $decoded = json_decode($val, true);
            return is_array($decoded) && !empty($decoded) ? json_encode($decoded, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : null;
        }
        if (is_array($val)) {
            // Remove campos completamente vazios
            $hasContent = false;
            foreach ($val as $v) {
                if ((is_string($v) && trim($v) !== '') || (is_array($v) && count($v) > 0)) {
                    $hasContent = true;
                    break;
                }
            }
            return $hasContent ? json_encode($val, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : null;
        }
        return null;
    }

    private function slugify(string $text): string
    {
        $text = strtolower($text);
        if (function_exists('iconv')) {
            $converted = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
            if ($converted !== false) {
                $text = $converted;
            }
        }
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim((string) $text, '-');
        return $text ?: ('projeto-' . time());
    }
}
