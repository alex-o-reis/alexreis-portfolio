<?php
require_once __DIR__ . '/environment.php';
$version = 'v=' . KORE_VERSION;

// Carrega API_URL do .env se disponivel (fallback localhost:8000)
$apiUrl = 'http://localhost:8000/';
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        if (trim($k) === 'API_URL') {
            $apiUrl = trim($v, " \t\n\r\0\x0B\"'");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0a182a">
    <meta name="description" content="Alex de Oliveira Reis — Software engineering leadership, enterprise architecture, BPM, AI and open-source software portfolio.">
    <link rel="canonical" href="https://alexreis.me/">

    <!-- Open Graph & Social Cards -->
    <meta property="og:title" content="Alex Reis — Engineering Leadership &amp; Architecture">
    <meta property="og:description" content="Engineering leadership beyond code. Enterprise modernization, platforms, AI and open-source systems.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://alexreis.me/">
    <meta property="og:image" content="https://alexreis.me/assets/og-cover.svg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Alex Reis — Engineering Leadership &amp; Architecture">
    <meta name="twitter:description" content="Engineering leadership beyond code. Enterprise modernization, platforms, AI and open-source systems.">
    <meta name="twitter:image" content="https://alexreis.me/assets/og-cover.svg">

    <link rel="icon" href="assets/favicon.svg" type="image/svg+xml">
    <title>Alex Reis — Engineering Leadership &amp; Architecture</title>

    <!-- Bootstrap 5.3 & Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Portfolio Template Style -->
    <link rel="stylesheet" href="templates/portfolio/css/portfolio.css?<?=$version?>">
</head>
<body>
    <div class="conteudo-principal">
        <!-- Template carregado dinamicamente pelo Kore Framework -->
    </div>

    <script>
        window.KORE_API_URL = <?= json_encode($apiUrl, JSON_UNESCAPED_SLASHES) ?>;
    </script>

    <!-- Scripts Core Vendors -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Kore Framework Core (kore/ — imutavel) -->
    <script src="kore/js/kore.js?<?=$version?>"></script>
    <script src="kore/js/cookies.js?<?=$version?>"></script>
    <script src="kore/js/Style.js?<?=$version?>"></script>
    <script src="kore/renderers/base-renderer.js?<?=$version?>"></script>
    <script src="kore/renderers/bootstrap.js?<?=$version?>"></script>
    <script src="kore/js/ui.js?<?=$version?>"></script>
    <script src="kore/js/model.js?<?=$version?>"></script>
    <script src="kore/js/controller.js?<?=$version?>"></script>
    <script src="kore/js/view.js?<?=$version?>"></script>
    <script src="kore/js/template.js?<?=$version?>"></script>
    <script src="kore/js/router.js?<?=$version?>"></script>

    <!-- Configuracao Userspace -->
    <script src="app/config.js?<?=$version?>"></script>

    <!-- Auto-inclusao de arquivos Userspace (app/) -->
    <?php
    function includeUserScripts($dir, $version) {
        if (!is_dir($dir)) return;
        $files = scandir($dir);
        sort($files, SORT_NATURAL);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            $path = $dir . '/' . $file;
            if (is_dir($path)) {
                includeUserScripts($path, $version);
            } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'js') {
                $relative = str_replace('\\', '/', $path);
                echo "<script src=\"$relative?$version\"></script>\n";
            }
        }
    }
    includeUserScripts('app/services', $version);
    includeUserScripts('app/renderers', $version);
    includeUserScripts('app/models', $version);
    includeUserScripts('app/controllers', $version);
    includeUserScripts('app/views', $version);
    ?>

    <script>
        jQuery(document).ready(function() {
            // Registra o PortfolioRenderer modular (Bootstrap 5) no UI Relay do Kore
            if (typeof PortfolioRenderer !== 'undefined') {
                UI.setRenderer(new PortfolioRenderer());
            }

            let templateLoader = new Template();
            templateLoader.getTemplate('portfolio', KoreConfig.TEMPLATE_PATH + '?<?=$version?>', function(html) {
                jQuery('.conteudo-principal').html(html);
                PortfolioShell.init();
                router.init(KoreConfig.ROUTES, KoreConfig.MENU);
            });
        });
    </script>
</body>
</html>
