<?php

require_once __DIR__ . '/../../kore/Middleware.php';
require_once __DIR__ . '/AuthMiddleware.php';

/**
 * Permite leitura publica (GET/HEAD/OPTIONS) e exige autenticacao Bearer
 * para qualquer operacao de escrita (POST/PUT/PATCH/DELETE), preparando a API
 * para o painel administrativo da Fase 2.
 */
class WriteAuthMiddleware implements Middleware
{
    public function handle(Request $request, callable $next)
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        if (in_array($method, ['GET', 'HEAD', 'OPTIONS'], true)) {
            return $next($request);
        }

        $auth = new AuthMiddleware();
        return $auth->handle($request, $next);
    }
}
