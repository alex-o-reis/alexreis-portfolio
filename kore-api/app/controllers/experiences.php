<?php

require_once __DIR__ . '/../../kore/Controller.php';
require_once __DIR__ . '/../models/Experience.php';

class Experiences extends Controller
{
    protected array $middleware = ['WriteAuthMiddleware'];

    public function get($id = null)
    {
        if ($id !== null && ctype_digit((string) $id)) {
            $stmt = Model::query(
                "SELECT * FROM experiences WHERE id = ? AND deleted_at IS NULL AND is_visible = 1 LIMIT 1",
                [(int) $id]
            );
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                return $this->error('Experiência não encontrada.', 404);
            }
            return $this->json(Experience::formatRow($row));
        }

        return $this->json(Experience::listVisible());
    }
}
