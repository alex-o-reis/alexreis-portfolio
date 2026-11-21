<?php

require_once __DIR__ . '/../../kore/Controller.php';
require_once __DIR__ . '/../models/Skill.php';

class Skills extends Controller
{
    protected array $middleware = ['WriteAuthMiddleware'];

    public function get()
    {
        return $this->json(Skill::listVisible());
    }
}
