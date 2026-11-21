<?php

require_once __DIR__ . '/../../kore/Controller.php';
require_once __DIR__ . '/../models/EducationItem.php';

class Education extends Controller
{
    protected array $middleware = ['WriteAuthMiddleware'];

    public function get()
    {
        $type = $_GET['type'] ?? null;
        return $this->json(EducationItem::listVisible($type ?: null));
    }
}
