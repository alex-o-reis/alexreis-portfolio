<?php

require_once __DIR__ . '/../../kore/Middleware.php';
require_once __DIR__ . '/AuthMiddleware.php';

/**
 * Permite leitura publica (GET/HEAD/OPTIONS) e exige autenticacao Bearer
 * para operacoes de escrita (POST/PUT/PATCH/DELETE) ou leitura administrativa
 * (?include_hidden=1).
 */
class WriteAuthMiddleware implements Middleware
{
    public function handle(Request $request, callable $next)
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $includeHidden = isset($_GET['include_hidden']) && $_GET['include_hidden'] == '1';

        if (in_array($method, ['GET', 'HEAD', 'OPTIONS'], true) && !$includeHidden) {
            return $next($request);
        }

        $auth = new AuthMiddleware();
        return $auth->handle($request, $next);
    }
}
