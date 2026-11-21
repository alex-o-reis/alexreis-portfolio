<?php

require_once __DIR__ . '/../../kore/Controller.php';
require_once __DIR__ . '/../../kore/Model.php';

class Auth extends Controller
{
    public function post_login()
    {
        $username = $this->request->input('username');
        $password = $this->request->input('password');

        if (!$username || !$password) {
            return $this->error('Usuário e senha são obrigatórios.', 400);
        }

        try {
            $stmt = Model::query(
                "SELECT * FROM users WHERE (username = ? OR email = ?) AND deleted_at IS NULL LIMIT 1",
                [$username, $username]
            );
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $token = bin2hex(random_bytes(32));
                Model::query("UPDATE users SET token = ? WHERE id = ?", [$token, $user['id']]);

                unset($user['password']);
                return $this->json([
                    'message' => 'Login realizado com sucesso',
                    'token' => $token,
                    'user' => $user
                ]);
            }
        } catch (Exception $e) {
            return $this->error('Erro ao autenticar: ' . $e->getMessage(), 500);
        }

        return $this->error('Usuário ou senha inválidos.', 401);
    }

    public function get_me()
    {
        $user = $this->resolveAuthenticatedUser();
        if (!$user) {
            return $this->error('Sessão expirada ou inválida.', 401);
        }

        unset($user['password']);
        return $this->json(['user' => $user]);
    }

    public function post_logout()
    {
        $user = $this->resolveAuthenticatedUser();
        if ($user) {
            Model::query("UPDATE users SET token = NULL WHERE id = ?", [$user['id']]);
        }
        return $this->json(['message' => 'Sessão encerrada com sucesso.']);
    }

    public function post_password()
    {
        $user = $this->resolveAuthenticatedUser();
        if (!$user) {
            return $this->error('Não autenticado.', 401);
        }

        $current = (string) $this->request->input('current_password', '');
        $next = (string) $this->request->input('new_password', '');

        if (!$current || !$next) {
            return $this->error('Informe a senha atual e a nova senha.', 400);
        }
        if (strlen($next) < 6) {
            return $this->error('A nova senha deve ter pelo menos 6 caracteres.', 422);
        }
        if (!password_verify($current, $user['password'])) {
            return $this->error('Senha atual incorreta.', 403);
        }

        $hash = password_hash($next, PASSWORD_DEFAULT);
        Model::query("UPDATE users SET password = ? WHERE id = ?", [$hash, $user['id']]);
        return $this->json(['message' => 'Senha atualizada com sucesso.']);
    }

    private function resolveAuthenticatedUser(): ?array
    {
        $token = $this->request->bearerToken();
        if (!$token) {
            return null;
        }
        try {
            $stmt = Model::query(
                "SELECT * FROM users WHERE token = ? AND deleted_at IS NULL LIMIT 1",
                [$token]
            );
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ?: null;
        } catch (Exception $e) {
            return null;
        }
    }
}
