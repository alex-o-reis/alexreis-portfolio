<?php

require_once __DIR__ . '/../../kore/Controller.php';
require_once __DIR__ . '/../models/Project.php';

class Projects extends Controller
{
    protected array $middleware = ['WriteAuthMiddleware'];

    public function get($idOrSlug = null)
    {
        if ($idOrSlug !== null && $idOrSlug !== '') {
            $project = Project::findByIdOrSlug($idOrSlug);
            if (!$project) {
                return $this->error('Projeto não encontrado.', 404);
            }
            return $this->json($project);
        }

        $filters = [
            'category' => $_GET['category'] ?? null,
            'status' => $_GET['status'] ?? null,
            'featured' => $_GET['featured'] ?? null,
        ];

        return $this->json(Project::listPublished($filters));
    }
}
