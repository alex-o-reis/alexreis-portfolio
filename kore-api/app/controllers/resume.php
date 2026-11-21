<?php

require_once __DIR__ . '/../../kore/Controller.php';
require_once __DIR__ . '/../services/ResumePdfBuilder.php';

/**
 * Resume — Gerador dinamico de Curriculo em PDF e Pre-visualizacao HTML (Fase 3).
 * Endpoints:
 *   GET /resume/pdf?lang=pt|en|es&include_catalog=1&include_featured=1&inline=0|1
 *   GET /resume/preview?lang=pt|en|es&include_catalog=1&include_featured=1
 */
class Resume extends Controller
{
    public function get()
    {
        return $this->get_pdf();
    }

    public function get_preview()
    {
        $lang = $this->resolveLang();
        $includeCatalog = $this->resolveBool('include_catalog', true);
        $includeFeatured = $this->resolveBool('include_featured', true);

        $builder = new ResumePdfBuilder($lang, $includeCatalog, $includeFeatured, false);
        $html = $builder->buildHtml();

        header('Content-Type: text/html; charset=utf-8');
        echo $html;
        exit;
    }

    public function get_pdf()
    {
        $lang = $this->resolveLang();
        $includeCatalog = $this->resolveBool('include_catalog', true);
        $includeFeatured = $this->resolveBool('include_featured', true);
        $inline = $this->resolveBool('inline', false);

        $autoload = __DIR__ . '/../../vendor/autoload.php';
        if (!file_exists($autoload)) {
            return $this->error('Dompdf não instalado. Execute "composer install" dentro de kore-api/.', 500);
        }
        require_once $autoload;

        if (!class_exists('\Dompdf\Dompdf')) {
            return $this->error('Biblioteca Dompdf não disponível.', 500);
        }

        $builder = new ResumePdfBuilder($lang, $includeCatalog, $includeFeatured, true);
        $html = $builder->buildHtml();

        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', false);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new \Dompdf\Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileNames = [
            'pt' => 'Alex_Reis_Curriculo_PT.pdf',
            'en' => 'Alex_Reis_Resume_EN.pdf',
            'es' => 'Alex_Reis_Curriculum_ES.pdf',
        ];
        $filename = $fileNames[$lang] ?? 'Alex_Reis_Resume.pdf';

        // Sobrescreve header JSON padrao do Controller base
        header('Content-Type: application/pdf');
        header('Content-Disposition: ' . ($inline ? 'inline' : 'attachment') . '; filename="' . $filename . '"');
        header('Cache-Control: no-store, no-cache, must-revalidate');

        echo $dompdf->output();
        exit;
    }

    private function resolveLang(): string
    {
        $lang = strtolower(trim((string) ($_GET['lang'] ?? 'pt')));
        return in_array($lang, ['pt', 'en', 'es'], true) ? $lang : 'pt';
    }

    private function resolveBool(string $key, bool $default): bool
    {
        if (!isset($_GET[$key])) {
            return $default;
        }
        $v = strtolower(trim((string) $_GET[$key]));
        return in_array($v, ['1', 'true', 'yes', 'on'], true);
    }
}
