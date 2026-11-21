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
}
