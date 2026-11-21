<?php

require_once __DIR__ . '/../../kore/Controller.php';
require_once __DIR__ . '/../models/EducationItem.php';

class Education extends Controller
{
    protected array $middleware = ['WriteAuthMiddleware'];

    public function get($id = null)
    {
        $includeHidden = isset($_GET['include_hidden']) && $_GET['include_hidden'] == '1';

        if ($id !== null && ctype_digit((string) $id)) {
            $sql = "SELECT * FROM education_items WHERE id = ? AND deleted_at IS NULL" . ($includeHidden ? '' : ' AND is_visible = 1') . " LIMIT 1";
            $row = Model::query($sql, [(int) $id])->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                return $this->error('Item de formação não encontrado.', 404);
            }
            return $this->json(EducationItem::formatRow($row));
        }

        $type = $_GET['type'] ?? null;
        if ($includeHidden) {
            if ($type) {
                $rows = Model::query(
                    "SELECT * FROM education_items WHERE deleted_at IS NULL AND item_type = ? ORDER BY display_order ASC, id ASC",
                    [$type]
                )->fetchAll(PDO::FETCH_ASSOC);
            } else {
                $rows = Model::query("SELECT * FROM education_items WHERE deleted_at IS NULL ORDER BY display_order ASC, id ASC")->fetchAll(PDO::FETCH_ASSOC);
            }
            return $this->json(array_map([EducationItem::class, 'formatRow'], $rows));
        }

        return $this->json(EducationItem::listVisible($type ?: null));
    }

    public function post()
    {
        $p = $this->extractPayload();
        if (!$p['institution'] || !$p['title_pt']) {
            return $this->error('Instituição e título (PT) são obrigatórios.', 422);
        }

        Model::query(
            "INSERT INTO education_items (
                item_type, institution,
                title_pt, title_en, title_es,
                period_label, details_pt, details_en, details_es,
                display_order, is_visible
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $p['item_type'], $p['institution'],
                $p['title_pt'], $p['title_en'], $p['title_es'],
                $p['period_label'], $p['details_pt'], $p['details_en'], $p['details_es'],
                $p['display_order'], $p['is_visible']
            ]
        );

        $newId = (int) Model::getPdo()->lastInsertId();
        $row = Model::query("SELECT * FROM education_items WHERE id = ? LIMIT 1", [$newId])->fetch(PDO::FETCH_ASSOC);
        return $this->json([
            'message' => 'Item de formação cadastrado com sucesso.',
            'data' => EducationItem::formatRow($row)
        ], 201);
    }

    public function put($id = null)
    {
        if (!$id || !ctype_digit((string) $id)) {
            return $this->error('ID inválido.', 400);
        }
        $existing = Model::query("SELECT id FROM education_items WHERE id = ? AND deleted_at IS NULL LIMIT 1", [(int) $id])->fetch(PDO::FETCH_ASSOC);
        if (!$existing) {
            return $this->error('Item de formação não encontrado.', 404);
        }

        $p = $this->extractPayload();
        if (!$p['institution'] || !$p['title_pt']) {
            return $this->error('Instituição e título (PT) são obrigatórios.', 422);
        }

        Model::query(
            "UPDATE education_items SET
                item_type = ?, institution = ?,
                title_pt = ?, title_en = ?, title_es = ?,
                period_label = ?, details_pt = ?, details_en = ?, details_es = ?,
                display_order = ?, is_visible = ?, updated_at = NOW()
            WHERE id = ?",
            [
                $p['item_type'], $p['institution'],
                $p['title_pt'], $p['title_en'], $p['title_es'],
                $p['period_label'], $p['details_pt'], $p['details_en'], $p['details_es'],
                $p['display_order'], $p['is_visible'],
                (int) $id
            ]
        );

        $row = Model::query("SELECT * FROM education_items WHERE id = ? LIMIT 1", [(int) $id])->fetch(PDO::FETCH_ASSOC);
        return $this->json([
            'message' => 'Item de formação atualizado com sucesso.',
            'data' => EducationItem::formatRow($row)
        ]);
    }

    public function delete($id = null)
    {
        if (!$id || !ctype_digit((string) $id)) {
            return $this->error('ID inválido.', 400);
        }
        $existing = Model::query("SELECT id FROM education_items WHERE id = ? AND deleted_at IS NULL LIMIT 1", [(int) $id])->fetch(PDO::FETCH_ASSOC);
        if (!$existing) {
            return $this->error('Item de formação não encontrado.', 404);
        }
        Model::query("UPDATE education_items SET deleted_at = NOW() WHERE id = ?", [(int) $id]);
        return $this->json(['message' => 'Item removido com sucesso.']);
    }

    private function extractPayload(): array
    {
        $in = $this->request->all();
        $titlePt = trim((string) ($in['title_pt'] ?? ''));
        $detailsPt = trim((string) ($in['details_pt'] ?? ''));
        $type = in_array($in['item_type'] ?? 'degree', ['degree', 'course'], true) ? $in['item_type'] : 'degree';

        return [
            'item_type' => $type,
            'institution' => trim((string) ($in['institution'] ?? '')),
            'title_pt' => $titlePt,
            'title_en' => trim((string) ($in['title_en'] ?? '')) ?: $titlePt,
            'title_es' => trim((string) ($in['title_es'] ?? '')) ?: $titlePt,
            'period_label' => trim((string) ($in['period_label'] ?? '')),
            'details_pt' => $detailsPt,
            'details_en' => trim((string) ($in['details_en'] ?? '')) ?: $detailsPt,
            'details_es' => trim((string) ($in['details_es'] ?? '')) ?: $detailsPt,
            'display_order' => (int) ($in['display_order'] ?? 0),
            'is_visible' => isset($in['is_visible']) ? ((int) (bool) $in['is_visible']) : 1,
        ];
    }
}
