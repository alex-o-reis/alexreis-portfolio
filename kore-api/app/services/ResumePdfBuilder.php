<?php

require_once __DIR__ . '/../models/ProfileSetting.php';
require_once __DIR__ . '/../models/Experience.php';
require_once __DIR__ . '/../models/Skill.php';
require_once __DIR__ . '/../models/EducationItem.php';
require_once __DIR__ . '/../models/Project.php';

/**
 * ResumePdfBuilder — Gera o HTML/CSS A4 fiel ao layout do curriculo v9
 * consumindo 100% dos dados vivos do SQLite (PT / EN / ES).
 */
class ResumePdfBuilder
{
    private string $lang;
    private bool $includeCatalog;
    private bool $includeFeatured;
    private bool $forPdf;

    private array $labels = [
        'pt' => [
            'doc_title' => 'Alex Reis — Currículo Profissional',
            'badge' => 'LIDERANÇA TÉCNICA',
            'cta_top' => 'CONHEÇA MEUS PROJETOS',
            'sec_01' => '01 &nbsp; PERFIL / PROPOSTA DE VALOR',
            'sec_02' => '02 &nbsp; IMPACTO EM ENGENHARIA',
            'sec_03' => '03 &nbsp; EXPERIÊNCIA PROFISSIONAL',
            'sec_04' => '04 &nbsp; ESTUDOS DE CASO EM ENGENHARIA',
            'sec_05' => '05 &nbsp; LIDERANÇA DE ENGENHARIA — VOX POPULI',
            'sec_06' => '06 &nbsp; PRODUTOS PRÓPRIOS / OPEN SOURCE',
            'sec_07' => '07 &nbsp; COMPETÊNCIAS-CHAVE',
            'sec_08' => '08 &nbsp; FORMAÇÃO / CURSOS / IDIOMAS / CONTATO',
            'sec_09' => '09 &nbsp; OUTRAS EXPERIÊNCIAS PROFISSIONAIS',
            'sec_10' => '10 &nbsp; PRODUTOS E PLATAFORMAS SELECIONADOS',
            'sec_10_sub' => 'Plataformas corporativas, produtos próprios e ferramentas. Projetos em desenvolvimento refletem estágio atual e não implicam lançamento comercial.',
            'philosophy_title' => 'FILOSOFIA DE ENGENHARIA',
            'philosophy_text' => 'Construir sistemas duráveis: reduzir dependências desnecessárias, explicitar escolhas técnicas, criar bases reutilizáveis e preservar a continuidade dos negócios enquanto a tecnologia evolui.',
            'challenge' => 'Desafio.',
            'approach' => 'Abordagem.',
            'footer_left' => 'ALEX REIS / ENGINEERING LEADERSHIP',
            'footer_cta' => 'VEJA alexreis.me',
            'featured_tag' => 'PRODUTO EM DESTAQUE',
            'featured_cta_prefix' => 'Conheça',
            'featured_cta_suffix' => 'no meu portfólio',
            'dev_badge' => 'Produto em desenvolvimento',
            'kpi_teams' => 'PROFISSIONAIS / 3 EQUIPES',
            'kpi_contracts' => 'CONTRATOS EMPRESARIAIS',
            'kpi_research' => 'EQUIPES DE PESQUISA',
            'courses_label' => 'Cursos:',
            'impact_bullets' => [
                ['Arquitetura e modernização.', 'Concebeu a migração progressiva do ControlEmp de Silverlight para web, com banco compartilhado, API REST em C#, retrocompatibilidade e continuidade operacional.'],
                ['Liderança tecnológica.', 'Definiu arquitetura, padrões e integrações nas torres Obras, IA e Backoffice, colaborando com três Product Owners.'],
                ['Impacto organizacional.', 'Releases diários favoreceram ciclos mais rápidos; pioneiro em agente Copilot–SharePoint que ajudou a criar a equipe de P&D em IA.']
            ],
            'print_btn' => 'Imprimir / Salvar PDF',
            'download_btn' => 'Baixar PDF Direto'
        ],
        'en' => [
            'doc_title' => 'Alex Reis — Engineering Leadership Résumé',
            'badge' => 'ENGINEERING LEADER',
            'cta_top' => 'EXPLORE MY WORK',
            'sec_01' => '01 &nbsp; PROFILE / PROFESSIONAL VALUE',
            'sec_02' => '02 &nbsp; ENGINEERING IMPACT',
            'sec_03' => '03 &nbsp; PROFESSIONAL EXPERIENCE',
            'sec_04' => '04 &nbsp; SELECTED ENGINEERING CASE STUDIES',
            'sec_05' => '05 &nbsp; ENGINEERING LEADERSHIP — VOX POPULI',
            'sec_06' => '06 &nbsp; INDEPENDENT PRODUCTS / OPEN SOURCE',
            'sec_07' => '07 &nbsp; CORE CAPABILITIES',
            'sec_08' => '08 &nbsp; EDUCATION / COURSES / LANGUAGES / CONTACT',
            'sec_09' => '09 &nbsp; ADDITIONAL PROFESSIONAL EXPERIENCE',
            'sec_10' => '10 &nbsp; SELECTED PRODUCTS AND PLATFORMS',
            'sec_10_sub' => 'Corporate platforms, independent products and development tools. Some are in active development; this catalogue does not imply commercial release.',
            'philosophy_title' => 'ENGINEERING PHILOSOPHY',
            'philosophy_text' => 'Build systems that last: reduce unnecessary dependencies, make trade-offs explicit, give teams reusable foundations, and preserve business continuity while technology evolves.',
            'challenge' => 'Challenge.',
            'approach' => 'Approach.',
            'footer_left' => 'ALEX REIS / ENGINEERING LEADERSHIP',
            'footer_cta' => 'EXPLORE alexreis.me',
            'featured_tag' => 'FEATURED PRODUCT',
            'featured_cta_prefix' => 'Explore',
            'featured_cta_suffix' => 'in my portfolio',
            'dev_badge' => 'Product in development',
            'kpi_teams' => 'ENGINEERS IN 3 TEAMS',
            'kpi_contracts' => 'BUSINESS CONTRACTS',
            'kpi_research' => 'RESEARCH FIELD TEAMS',
            'courses_label' => 'Courses:',
            'impact_bullets' => [
                ['Architecture and modernization.', 'Conceived ControlEmp’s progressive Silverlight-to-web migration with a shared database, C# REST API, backward compatibility and business continuity.'],
                ['Technology leadership.', 'Defined architecture, technical standards and integration strategies across Construction, AI and Back Office groups while working with three Product Owners.'],
                ['Organizational impact.', 'Daily centralized releases helped enable faster product cycles; pioneered a Copilot–SharePoint assistant that contributed to establishing an AI R&D team.']
            ],
            'print_btn' => 'Print / Save PDF',
            'download_btn' => 'Download PDF'
        ],
        'es' => [
            'doc_title' => 'Alex Reis — Currículum de Liderazgo en Ingeniería',
            'badge' => 'LIDERAZGO TÉCNICO',
            'cta_top' => 'EXPLORAR PROYECTOS',
            'sec_01' => '01 &nbsp; PERFIL / PROPUESTA DE VALOR',
            'sec_02' => '02 &nbsp; IMPACTO EN INGENIERÍA',
            'sec_03' => '03 &nbsp; EXPERIENCIA PROFESIONAL',
            'sec_04' => '04 &nbsp; CASOS DE ESTUDIO EN INGENIERÍA',
            'sec_05' => '05 &nbsp; LIDERAZGO EN INGENIERÍA — VOX POPULI',
            'sec_06' => '06 &nbsp; PRODUCTOS PROPIOS / OPEN SOURCE',
            'sec_07' => '07 &nbsp; COMPETENCIAS CLAVE',
            'sec_08' => '08 &nbsp; FORMACIÓN / CURSOS / IDIOMAS / CONTACTO',
            'sec_09' => '09 &nbsp; OTRAS EXPERIENCIAS PROFESIONALES',
            'sec_10' => '10 &nbsp; PRODUCTOS Y PLATAFORMAS SELECCIONADOS',
            'sec_10_sub' => 'Plataformas corporativas, productos propios y herramientas. Algunos siguen en desarrollo; este catálogo no implica lanzamiento comercial.',
            'philosophy_title' => 'FILOSOFÍA DE INGENIERÍA',
            'philosophy_text' => 'Construir sistemas duraderos: reducir dependencias innecesarias, explicitar decisiones técnicas, crear bases reutilizables y preservar la continuidad del negocio mientras evoluciona la tecnología.',
            'challenge' => 'Desafío.',
            'approach' => 'Enfoque.',
            'footer_left' => 'ALEX REIS / ENGINEERING LEADERSHIP',
            'footer_cta' => 'VER alexreis.me',
            'featured_tag' => 'PRODUCTO DESTACADO',
            'featured_cta_prefix' => 'Conoce',
            'featured_cta_suffix' => 'en mi portafolio',
            'dev_badge' => 'Producto en desarrollo',
            'kpi_teams' => 'PROFESIONALES / 3 EQUIPOS',
            'kpi_contracts' => 'CONTRATOS EMPRESARIALES',
            'kpi_research' => 'EQUIPOS DE CAMPO',
            'courses_label' => 'Cursos:',
            'impact_bullets' => [
                ['Arquitectura y modernización.', 'Diseñó la migración progresiva de ControlEmp de Silverlight a web con base compartida, API REST en C#, retrocompatibilidad y continuidad operativa.'],
                ['Liderazgo tecnológico.', 'Definió arquitectura, estándares e integraciones para los equipos de Obras, IA y Backoffice colaborando con tres Product Owners.'],
                ['Impacto organizacional.', 'Entregas diarias centralizadas agilizaron el ciclo de producto; prototipó un agente Copilot–SharePoint que impulsó la creación del equipo de I+D en IA.']
            ],
            'print_btn' => 'Imprimir / Guardar PDF',
            'download_btn' => 'Descargar PDF'
        ]
    ];

    public function __construct(string $lang = 'pt', bool $includeCatalog = true, bool $includeFeatured = true, bool $forPdf = true)
    {
        $this->lang = in_array($lang, ['pt', 'en', 'es'], true) ? $lang : 'pt';
        $this->includeCatalog = $includeCatalog;
        $this->includeFeatured = $includeFeatured;
        $this->forPdf = $forPdf;
    }

    private function l(string $key)
    {
        return $this->labels[$this->lang][$key] ?? $this->labels['en'][$key] ?? $key;
    }

    private function pick($obj, $fallback = '')
    {
        if (is_string($obj)) return $obj;
        if (!is_array($obj)) return $fallback;
        return $obj[$this->lang] ?? $obj['en'] ?? $obj['pt'] ?? $obj['es'] ?? $fallback;
    }

    private function esc(string $str): string
    {
        return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    private function truncateWords(string $str, int $maxChars): string
    {
        $str = trim($str);
        if (mb_strlen($str) <= $maxChars) {
            return $str;
        }
        $cut = mb_substr($str, 0, $maxChars);
        $lastSpace = mb_strrpos($cut, ' ');
        if ($lastSpace !== false && $lastSpace > 20) {
            $cut = mb_substr($cut, 0, $lastSpace);
        }
        return rtrim($cut, " ,.;:-") . '...';
    }

    private function imageDataUri(?string $relativePath): ?string
    {
        if (!$relativePath) return null;
        if (str_starts_with($relativePath, 'http://') || str_starts_with($relativePath, 'https://') || str_starts_with($relativePath, 'data:')) {
            return $relativePath;
        }
        $clean = ltrim(str_replace(['..', '\\'], ['', '/'], $relativePath), '/');
        $full = realpath(__DIR__ . '/../../../kore-front/' . $clean);
        if (!$full || !file_exists($full)) {
            return null;
        }
        $ext = strtolower(pathinfo($full, PATHINFO_EXTENSION));
        $mime = match ($ext) {
            'jpg', 'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            default => 'application/octet-stream'
        };
        return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($full));
    }

    public function buildHtml(): string
    {
        $profile = ProfileSetting::getMain() ?: [];
        $experiences = Experience::listVisible();
        $skills = Skill::listVisible();
        $degrees = EducationItem::listVisible('degree');
        $courses = EducationItem::listVisible('course');
        $projects = Project::listPublished();

        // Classifica experiencias: principal (Emccamp), destaque historico (Vox Populi) e demais
        $primaryExp = $experiences[0] ?? null;
        $voxExp = null;
        $otherExps = [];
        foreach ($experiences as $idx => $exp) {
            if ($idx === 0) continue;
            if ($voxExp === null && stripos($exp['company'], 'Vox Populi') !== false) {
                $voxExp = $exp;
            } else {
                $otherExps[] = $exp;
            }
        }

        // Classifica projetos
        $caseStudies = [];
        $featuredPages = [];
        $ownProducts = [];
        foreach ($projects as $p) {
            if (!empty($p['is_case_study']) || $p['slug'] === 'framework-corporativo') {
                $caseStudies[] = $p;
            }
            if (!empty($p['is_featured']) && !empty($p['has_detail_page'])) {
                $featuredPages[] = $p;
            }
            if (in_array($p['slug'], ['opn1', 'kore-framework'], true)) {
                $ownProducts[] = $p;
            }
        }
        // Ordena estudos de caso: ControlEmp, Framework corporativo, Viabiliza, Agente IA
        $casePriority = ['controlemp' => 1, 'framework-corporativo' => 2, 'viabiliza' => 3, 'agente-conhecimento-ia' => 4, 'orion' => 5];
        usort($caseStudies, fn($a, $b) => ($casePriority[$a['slug']] ?? 99) <=> ($casePriority[$b['slug']] ?? 99));
        $caseStudies = array_slice($caseStudies, 0, 4);

        // Monta lista de paginas para numeracao 100% exata (ex: 01 / 06 .. 06 / 06)
        $pages = [];
        $pages[] = ['type' => 'cover', 'data' => compact('profile', 'primaryExp')];
        $pages[] = ['type' => 'cases', 'data' => compact('caseStudies')];
        $pages[] = ['type' => 'career', 'data' => compact('profile', 'voxExp', 'ownProducts', 'skills', 'degrees', 'courses', 'otherExps', 'featuredPages')];

        if ($this->includeCatalog) {
            $pages[] = ['type' => 'catalog', 'data' => compact('projects')];
        }
        if ($this->includeFeatured) {
            foreach ($featuredPages as $fp) {
                $pages[] = ['type' => 'featured', 'data' => ['project' => $fp, 'profile' => $profile]];
            }
        }

        $totalPages = count($pages);
        $pagesHtml = '';

        foreach ($pages as $index => $page) {
            $pageNum = $index + 1;
            $isLast = ($pageNum === $totalPages);
            $pageBody = match ($page['type']) {
                'cover' => $this->renderPage1Cover($page['data']['profile'], $page['data']['primaryExp'], $pageNum, $totalPages),
                'cases' => $this->renderPage2Cases($page['data']['caseStudies'], $pageNum, $totalPages),
                'career' => $this->renderPage3Career($page['data'], $pageNum, $totalPages),
                'catalog' => $this->renderPage4Catalog($page['data']['projects'], $pageNum, $totalPages),
                'featured' => $this->renderFeaturedPage($page['data']['project'], $page['data']['profile'], $pageNum, $totalPages),
            };
            $breakClass = $isLast ? 'page page-last' : 'page';
            $pagesHtml .= "<div class=\"{$breakClass}\">{$pageBody}</div>\n";
        }

        $toolbar = '';
        if (!$this->forPdf) {
            $qs = http_build_query([
                'lang' => $this->lang,
                'include_catalog' => $this->includeCatalog ? 1 : 0,
                'include_featured' => $this->includeFeatured ? 1 : 0,
                'inline' => 0
            ]);
            $toolbar = '<div class="no-print preview-toolbar">'
                . '<span><strong>' . $this->esc($this->l('doc_title')) . '</strong> (' . strtoupper($this->lang) . ' · ' . $totalPages . ' págs.)</span>'
                . '<div class="tb-actions">'
                . '<button onclick="window.print()" class="tb-btn tb-btn-light">' . $this->esc($this->l('print_btn')) . '</button>'
                . '<a href="/resume/pdf?' . $qs . '" class="tb-btn tb-btn-teal">' . $this->esc($this->l('download_btn')) . '</a>'
                . '</div></div>';
        }

        return '<!DOCTYPE html><html lang="' . $this->esc($this->lang) . '"><head><meta charset="utf-8">'
            . '<title>' . $this->esc($this->l('doc_title')) . '</title>'
            . '<style>' . $this->buildCss() . '</style></head><body>'
            . $toolbar . '<div class="sheet-wrap">' . $pagesHtml . '</div></body></html>';
    }

    private function renderStandardFooter(int $pageNum, int $totalPages, string $website = 'https://alexreis.me'): string
    {
        $numStr = sprintf('%02d / %02d', $pageNum, $totalPages);
        return '<div class="page-footer">'
            . '<table class="ft-table" width="100%" cellspacing="0" cellpadding="0"><tr>'
            . '<td class="ft-left">' . $this->esc($this->l('footer_left')) . '</td>'
            . '<td class="ft-num">' . $numStr . '</td>'
            . '<td class="ft-cta-cell"><a href="' . $this->esc($website) . '" class="ft-cta">' . $this->esc($this->l('footer_cta')) . '</a></td>'
            . '</tr></table></div>';
    }

    private function renderMinimalFooter(int $pageNum, int $totalPages, string $leftLabel = 'alexreis.me'): string
    {
        $numStr = sprintf('%02d / %02d', $pageNum, $totalPages);
        return '<div class="page-footer page-footer-min">'
            . '<table class="ft-table" width="100%" cellspacing="0" cellpadding="0"><tr>'
            . '<td class="ft-left">' . $this->esc($leftLabel) . '</td>'
            . '<td class="ft-num-right">' . $numStr . '</td>'
            . '</tr></table></div>';
    }

    private function renderPage1Cover(array $profile, ?array $primaryExp, int $pageNum, int $totalPages): string
    {
        $shortName = trim($profile['short_name'] ?? 'Alex Reis');
        $parts = preg_split('/\s+/', $shortName, 2);
        $firstName = strtoupper($parts[0] ?? 'ALEX');
        $lastName = strtoupper($parts[1] ?? 'REIS');

        $subtitle = strtoupper($this->pick($profile['role_subtitle'] ?? [], 'ARCHITECTURE / ENGINEERING'));
        $location = $this->pick($profile['location'] ?? [], 'Belo Horizonte, MG');
        $website = $profile['website_url'] ?: 'https://alexreis.me';
        $websiteClean = preg_replace('#^https?://#', '', rtrim($website, '/'));
        $github = $profile['github_url'] ?: 'https://github.com/alex-o-reis';
        $githubClean = preg_replace('#^https?://#', '', rtrim($github, '/'));

        $contactParts = [$this->esc($location)];
        if (!empty($profile['email'])) {
            $contactParts[] = '<a href="mailto:' . $this->esc($profile['email']) . '" class="hd-link">' . $this->esc($profile['email']) . '</a>';
        }
        if (!empty($profile['phone'])) {
            $contactParts[] = $this->esc($profile['phone']);
        }
        $contactParts[] = '<a href="' . $this->esc($website) . '" class="hd-link">' . $this->esc($websiteClean) . '</a>';
        $contactParts[] = '<a href="' . $this->esc($github) . '" class="hd-link">' . $this->esc($githubClean) . '</a>';
        if (!empty($profile['linkedin_url'])) {
            $liClean = preg_replace('#^https?://(www\.)?#', '', rtrim($profile['linkedin_url'], '/'));
            $contactParts[] = '<a href="' . $this->esc($profile['linkedin_url']) . '" class="hd-link">' . $this->esc($liClean) . '</a>';
        }

        // Resumo executivo a partir de profile.summary
        $summaryBlock = $profile['summary'][$this->lang] ?? ($profile['summary']['en'] ?? []);
        $aboutParagraphs = $summaryBlock['about_paragraphs'] ?? [];
        $summaryText = implode(' ', array_slice($aboutParagraphs, 0, 2));
        if (!$summaryText) {
            $summaryText = $summaryBlock['hero_lead'] ?? '';
        }

        // KPIs (3 cards estilo v9)
        $kpiHtml = '<table width="100%" cellspacing="0" cellpadding="0" class="kpi-table"><tr>'
            . '<td width="32%"><div class="kpi-card"><div class="kpi-val">30</div><div class="kpi-lbl">' . $this->esc($this->l('kpi_teams')) . '</div></div></td>'
            . '<td width="2%"></td>'
            . '<td width="32%"><div class="kpi-card"><div class="kpi-val">40K+</div><div class="kpi-lbl">' . $this->esc($this->l('kpi_contracts')) . '</div></div></td>'
            . '<td width="2%"></td>'
            . '<td width="32%"><div class="kpi-card"><div class="kpi-val">100+</div><div class="kpi-lbl">' . $this->esc($this->l('kpi_research')) . '</div></div></td>'
            . '</tr></table>';

        $impactBullets = '';
        foreach ($this->l('impact_bullets') as $b) {
            $impactBullets .= '<li><strong>' . $this->esc($b[0]) . '</strong> ' . $this->esc($b[1]) . '</li>';
        }

        $expHtml = '';
        if ($primaryExp) {
            $expHtml = '<table width="100%" cellspacing="0" cellpadding="0" class="exp-head-tbl"><tr>'
                . '<td class="exp-company">' . $this->esc(strtoupper($primaryExp['company'])) . '</td>'
                . '<td class="exp-period">' . $this->esc($this->pick($primaryExp['period_label'])) . '</td>'
                . '</tr></table>'
                . '<div class="exp-role">' . $this->esc($this->pick($primaryExp['role'])) . '</div>'
                . '<p class="body-p">' . $this->esc($this->pick($primaryExp['description'])) . '</p>';
        }

        return '<div class="cover-header">'
            . '<div class="gold-top"></div><div class="gold-right"></div>'
            . '<table width="100%" cellspacing="0" cellpadding="0" class="cover-tbl"><tr>'
            . '<td class="cover-left" valign="top">'
            . '<div class="leader-pill">' . $this->esc($this->l('badge')) . '</div>'
            . '<div class="cover-name-first">' . $this->esc($firstName) . '</div>'
            . '<div class="cover-name-last">' . $this->esc($lastName) . '</div>'
            . '<div class="cover-sub">' . $this->esc($subtitle) . '</div>'
            . '</td>'
            . '<td class="cover-right" valign="middle" align="right">'
            . '<a href="' . $this->esc($website) . '" class="cover-cta-box">'
            . '<div class="cover-cta-eyebrow">' . $this->esc($this->l('cta_top')) . '</div>'
            . '<div class="cover-cta-url">' . $this->esc($websiteClean) . '</div>'
            . '</a>'
            . '</td>'
            . '</tr></table>'
            . '<div class="cover-contact">' . implode(' &nbsp;•&nbsp; ', $contactParts) . '</div>'
            . '</div>'
            . '<div class="page-body">'
            . '<div class="sec-title">' . $this->l('sec_01') . '</div>'
            . '<p class="body-p">' . $this->esc($summaryText) . '</p>'
            . $kpiHtml
            . '<div class="sec-title">' . $this->l('sec_02') . '</div>'
            . '<ul class="pdf-list">' . $impactBullets . '</ul>'
            . '<div class="sec-title">' . $this->l('sec_03') . '</div>'
            . $expHtml
            . '</div>'
            . $this->renderStandardFooter($pageNum, $totalPages, $website);
    }

    private function renderPage2Cases(array $caseStudies, int $pageNum, int $totalPages): string
    {
        $cardsHtml = '';
        foreach ($caseStudies as $c) {
            $name = strtoupper($this->pick($c['name']));
            $sub = strtoupper($this->pick($c['case_label'] ?? [], $this->pick($c['stack'])));
            $detail = $c['detail'][$this->lang] ?? ($c['detail']['en'] ?? ($c['detail']['pt'] ?? null));
            $bullets = [];

            if (is_array($detail)) {
                if (!empty($detail['challenge'])) {
                    $bullets[] = '<strong>' . $this->esc($this->l('challenge')) . '</strong> ' . $this->esc($detail['challenge']);
                }
                if (!empty($detail['approach'])) {
                    $bullets[] = '<strong>' . $this->esc($this->l('approach')) . '</strong> ' . $this->esc($detail['approach']);
                }
                if (!empty($detail['features']) && is_array($detail['features'])) {
                    foreach (array_slice($detail['features'], 0, 2) as $f) {
                        $bullets[] = '<strong>' . $this->esc($f['title'] ?? '') . '.</strong> ' . $this->esc($f['desc'] ?? '');
                    }
                }
            }
            if (empty($bullets)) {
                $bullets[] = $this->esc($this->pick($c['summary']));
                $stack = $this->pick($c['stack']);
                if ($stack) {
                    $bullets[] = '<strong>Stack:</strong> ' . $this->esc($stack);
                }
            }

            $liHtml = implode('', array_map(fn($b) => '<li>' . $b . '</li>', $bullets));
            $cardsHtml .= '<div class="case-box">'
                . '<div class="case-box-title">' . $this->esc($name) . '</div>'
                . '<div class="case-box-sub">' . $this->esc($sub) . '</div>'
                . '<ul class="pdf-list case-list">' . $liHtml . '</ul>'
                . '</div>';
        }

        return '<div class="top-bar-accent"><div class="gold-top"></div></div>'
            . '<div class="page-body page-body-inner">'
            . '<div class="sec-title">' . $this->l('sec_04') . '</div>'
            . $cardsHtml
            . '</div>'
            . $this->renderStandardFooter($pageNum, $totalPages);
    }

    private function renderPage3Career(array $data, int $pageNum, int $totalPages): string
    {
        $profile = $data['profile'];
        $voxExp = $data['voxExp'];
        $ownProducts = $data['ownProducts'];
        $skills = $data['skills'];
        $degrees = $data['degrees'];
        $courses = $data['courses'];
        $otherExps = $data['otherExps'];
        $featuredPages = $data['featuredPages'];

        // 05 Vox Populi
        $voxHtml = '';
        if ($voxExp) {
            $voxHtml = '<ul class="pdf-list">'
                . '<li><strong>' . $this->esc($this->pick($voxExp['period_label'])) . ' — ' . $this->esc($this->pick($voxExp['role'])) . '.</strong> ' . $this->esc($this->pick($voxExp['description'])) . '</li>'
                . '</ul>';
        }

        // 06 Produtos Proprios / Open Source
        $prodBullets = '';
        foreach ($ownProducts as $op) {
            $prodBullets .= '<li><strong>' . $this->esc($this->pick($op['name'])) . '.</strong> ' . $this->esc($this->pick($op['summary'])) . '</li>';
        }
        $featNames = array_map(fn($f) => $this->pick($f['name']), $featuredPages);
        if (!empty($featNames)) {
            $prodBullets .= '<li><strong>' . ($this->lang === 'en' ? 'Products in development.' : ($this->lang === 'es' ? 'Productos en desarrollo.' : 'Produtos em desenvolvimento.')) . '</strong> '
                . $this->esc(implode(', ', $featNames)) . ', Xian, ClawBox/OpenClaw Studio. Portfolio: alexreis.me.</li>';
        }

        // 07 Competencias-chave (inline bullet-separated como v9)
        $skillNames = array_map(fn($s) => $this->esc($this->pick($s['name'])), array_slice($skills, 0, 20));
        $skillsLine = implode(' &nbsp;•&nbsp; ', $skillNames);

        // 08 Formacao / Cursos / Idiomas / Contato
        $degParts = array_map(function ($d) {
            $t = $this->pick($d['title']) . ', ' . $d['institution'] . ($d['period_label'] ? ' (' . $d['period_label'] . ')' : '');
            return $this->esc($t);
        }, $degrees);
        $courseNames = array_map(fn($c) => $this->esc($this->pick($c['title']) . ' (' . $c['institution'] . ')'), array_slice($courses, 0, 5));
        $langsText = $this->pick($profile['languages'] ?? []);

        $contactItems = [];
        if (!empty($profile['email'])) $contactItems[] = $this->esc($profile['email']);
        if (!empty($profile['phone'])) $contactItems[] = $this->esc($profile['phone']);
        if (!empty($profile['website_url'])) $contactItems[] = $this->esc(preg_replace('#^https?://#', '', rtrim($profile['website_url'], '/')));
        if (!empty($profile['github_url'])) $contactItems[] = $this->esc(preg_replace('#^https?://#', '', rtrim($profile['github_url'], '/')));
        if (!empty($profile['linkedin_url'])) $contactItems[] = $this->esc(preg_replace('#^https?://(www\.)?#', '', rtrim($profile['linkedin_url'], '/')));

        // 09 Outras experiencias
        $otherRows = '';
        foreach ($otherExps as $oe) {
            $tags = $this->pick($oe['tags'] ?? [], []);
            $tagStr = is_array($tags) ? implode(', ', array_slice($tags, 0, 4)) : '';
            $otherRows .= '<tr>'
                . '<td class="oe-date" width="22%" valign="top">' . $this->esc($this->pick($oe['period_label'])) . '</td>'
                . '<td class="oe-body" width="78%" valign="top">'
                . '<div class="oe-comp">' . $this->esc(strtoupper($oe['company'])) . '</div>'
                . '<div class="oe-role">' . $this->esc($this->pick($oe['role'])) . ($tagStr ? ' · ' . $this->esc($tagStr) : '') . '</div>'
                . '</td></tr>';
        }

        return '<div class="top-bar-accent"><div class="gold-top"></div></div>'
            . '<div class="page-body page-body-inner">'
            . ($voxHtml ? '<div class="sec-title sec-compact">' . $this->l('sec_05') . '</div>' . $voxHtml : '')
            . '<div class="sec-title sec-compact">' . $this->l('sec_06') . '</div>'
            . '<ul class="pdf-list">' . $prodBullets . '</ul>'
            . '<div class="sec-title sec-compact">' . $this->l('sec_07') . '</div>'
            . '<p class="body-p small-p">' . $skillsLine . '</p>'
            . '<div class="sec-title sec-compact">' . $this->l('sec_08') . '</div>'
            . '<p class="body-p small-p">' . implode(' &nbsp;•&nbsp; ', $degParts) . ($langsText ? ' &nbsp;•&nbsp; ' . $this->esc($langsText) : '') . '</p>'
            . (!empty($courseNames) ? '<p class="body-p small-p"><strong>' . $this->esc($this->l('courses_label')) . '</strong> ' . implode(' · ', $courseNames) . '</p>' : '')
            . '<p class="contact-teal">' . implode(' &nbsp;•&nbsp; ', $contactItems) . '</p>'
            . '<div class="sec-title sec-compact">' . $this->l('sec_09') . '</div>'
            . '<table width="100%" cellspacing="0" cellpadding="0" class="oe-table">' . $otherRows . '</table>'
            . '<div class="philosophy-box">'
            . '<div class="philosophy-title">' . $this->esc($this->l('philosophy_title')) . '</div>'
            . '<div class="philosophy-text">' . $this->esc($this->l('philosophy_text')) . '</div>'
            . '</div>'
            . '</div>'
            . $this->renderStandardFooter($pageNum, $totalPages, $profile['website_url'] ?: 'https://alexreis.me');
    }

    private function renderPage4Catalog(array $projects, int $pageNum, int $totalPages): string
    {
        // 2-column grid matching v9 Page 4 (up to 26 items compactly fitted on one A4 page)
        $rowsHtml = '';
        $chunks = array_chunk($projects, 2);
        foreach ($chunks as $pair) {
            $rowsHtml .= '<tr>';
            for ($i = 0; $i < 2; $i++) {
                if (isset($pair[$i])) {
                    $p = $pair[$i];
                    $name = $this->pick($p['name']);
                    $desc = $this->truncateWords($this->pick($p['summary']), 86);
                    $rowsHtml .= '<td width="49%" valign="top"><div class="cat-card">'
                        . '<div class="cat-name">' . $this->esc($name) . '</div>'
                        . '<div class="cat-desc">' . $this->esc($desc) . '</div>'
                        . '</div></td>';
                } else {
                    $rowsHtml .= '<td width="49%"></td>';
                }
                if ($i === 0) {
                    $rowsHtml .= '<td width="2%"></td>';
                }
            }
            $rowsHtml .= '</tr>';
        }

        return '<div class="top-bar-accent"><div class="gold-top"></div></div>'
            . '<div class="page-body page-body-inner">'
            . '<div class="sec-title sec-compact">' . $this->l('sec_10') . '</div>'
            . '<p class="body-p small-p muted-p">' . $this->esc($this->l('sec_10_sub')) . '</p>'
            . '<table width="100%" cellspacing="0" cellpadding="0" class="cat-table">' . $rowsHtml . '</table>'
            . '</div>'
            . $this->renderStandardFooter($pageNum, $totalPages);
    }

    private function renderFeaturedPage(array $project, array $profile, int $pageNum, int $totalPages): string
    {
        $theme = $project['theme_key'] ?: 'default';
        $name = $this->pick($project['name']);
        $detail = $project['detail'][$this->lang] ?? ($project['detail']['en'] ?? ($project['detail']['pt'] ?? []));
        $imgUri = $this->imageDataUri($project['cover_image'] ?? null);
        $website = rtrim($profile['website_url'] ?: 'https://alexreis.me', '/');
        $projectUrl = $website . '/#/projeto/' . rawurlencode($project['slug']);
        $projectUrlClean = preg_replace('#^https?://#', '', $projectUrl);

        $topStrip = '<table width="100%" cellspacing="0" cellpadding="0" class="feat-top-strip"><tr>'
            . '<td class="ft-left">' . $this->esc($this->l('footer_left')) . '</td>'
            . '<td class="ft-right">' . $this->esc($this->l('featured_tag') . ' / ' . strtoupper($name)) . '</td>'
            . '</tr></table>';

        // Layout estilo SATWA (página 5 do v9)
        if ($theme === 'satwa') {
            $headlineClean = strip_tags($detail['headline'] ?? $name);
            $features = array_slice($detail['features'] ?? [], 0, 6);
            $featRows = '';
            foreach (array_chunk($features, 2) as $idxPair => $pair) {
                $featRows .= '<tr>';
                for ($i = 0; $i < 2; $i++) {
                    if (isset($pair[$i])) {
                        $f = $pair[$i];
                        $n = sprintf('%02d', ($idxPair * 2) + $i + 1);
                        $featRows .= '<td width="48.5%" valign="top"><div class="satwa-card">'
                            . '<div class="satwa-card-h"><span class="satwa-num">' . $n . '</span> &nbsp; ' . $this->esc($f['title'] ?? '') . '</div>'
                            . '<div class="satwa-card-p">' . $this->esc($f['desc'] ?? '') . '</div>'
                            . '</div></td>';
                    } else {
                        $featRows .= '<td width="48.5%"></td>';
                    }
                    if ($i === 0) $featRows .= '<td width="3%"></td>';
                }
                $featRows .= '</tr>';
            }

            return '<div class="page-body page-body-feat">'
                . $topStrip
                . '<div class="satwa-hero">'
                . '<table width="100%" cellspacing="0" cellpadding="0"><tr>'
                . '<td width="48%" valign="middle">'
                . ($imgUri ? '<img src="' . $imgUri . '" class="satwa-logo-img" />' : '')
                . '<div class="satwa-bar-txt">' . $this->esc($detail['bar_title'] ?? 'BPMN 2.0 + CRM + SCRUM + KANBAN') . '</div>'
                . '</td>'
                . '<td width="4%"></td>'
                . '<td width="48%" valign="middle">'
                . '<div class="satwa-hero-title">' . $this->esc($headlineClean) . '</div>'
                . '<div class="satwa-hero-sub">' . $this->esc($detail['bar_subtitle'] ?? $this->pick($project['summary'])) . '</div>'
                . '</td>'
                . '</tr></table></div>'
                . '<div class="satwa-intro-title">' . $this->esc($detail['intro_title'] ?? $name) . '</div>'
                . '<p class="body-p">' . $this->esc($detail['intro_text'] ?? $detail['lead'] ?? '') . '</p>'
                . '<table width="100%" cellspacing="0" cellpadding="0" class="satwa-grid">' . $featRows . '</table>'
                . '<div class="satwa-cta">'
                . '<div class="satwa-cta-h">' . $this->esc($this->l('featured_cta_prefix') . ' ' . $name . ' ' . $this->l('featured_cta_suffix')) . '</div>'
                . '<div class="satwa-cta-sub"><a href="' . $this->esc($projectUrl) . '" class="cta-white-link">' . $this->esc($projectUrlClean) . '</a> &nbsp;•&nbsp; ' . $this->esc($this->l('dev_badge')) . '</div>'
                . '</div>'
                . '</div>'
                . $this->renderMinimalFooter($pageNum, $totalPages, 'alexreis.me');
        }

        // Layout estilo Kreww / Default Featured (página 6 do v9)
        $features = array_slice($detail['features'] ?? [], 0, 3);
        $colsHtml = '';
        $colW = count($features) > 0 ? floor(94 / count($features)) : 31;
        foreach ($features as $idx => $f) {
            if ($idx > 0) $colsHtml .= '<td width="3%"></td>';
            $colsHtml .= '<td width="' . $colW . '%" valign="top"><div class="kreww-card">'
                . '<div class="kreww-card-h">' . $this->esc($f['title'] ?? '') . '</div>'
                . '<div class="kreww-card-p">' . $this->esc($f['desc'] ?? '') . '</div>'
                . '</div></td>';
        }

        return '<div class="page-body page-body-feat">'
            . $topStrip
            . ($imgUri ? '<div class="kreww-banner-wrap"><img src="' . $imgUri . '" class="kreww-banner-img" /></div>' : '')
            . '<div class="kreww-title">' . $this->esc(strip_tags($detail['headline'] ?? $name)) . '</div>'
            . '<p class="body-p">' . $this->esc($detail['lead'] ?? $this->pick($project['summary'])) . '</p>'
            . '<table width="100%" cellspacing="0" cellpadding="0" class="kreww-grid"><tr>' . $colsHtml . '</tr></table>'
            . (!empty($detail['disclaimer']) ? '<p class="kreww-disc">' . $this->esc($detail['disclaimer']) . '</p>' : '')
            . '<div class="kreww-cta">'
            . '<div class="kreww-cta-h">' . $this->esc($this->l('featured_cta_prefix') . ' ' . $name . ' ' . $this->l('featured_cta_suffix')) . '</div>'
            . '<div class="kreww-cta-url"><a href="' . $this->esc($projectUrl) . '" class="cta-teal-link">' . $this->esc($projectUrlClean) . '</a></div>'
            . '</div>'
            . '</div>'
            . $this->renderMinimalFooter($pageNum, $totalPages, 'PORTFOLIO · alexreis.me');
    }

    private function buildCss(): string
    {
        $previewCss = $this->forPdf ? '' : <<<'PREVIEW'
body { background: #e8eef2; }
.sheet-wrap { padding: 18px 0 40px; }
.page {
    margin: 0 auto 20px;
    box-shadow: 0 12px 40px rgba(10, 24, 42, 0.16);
}
.preview-toolbar {
    position: sticky;
    top: 0;
    z-index: 100;
    background: #0a182a;
    color: #ffffff;
    padding: 12px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
}
.tb-actions { display: flex; gap: 10px; }
.tb-btn {
    border: 0;
    border-radius: 6px;
    padding: 7px 14px;
    font-weight: bold;
    font-size: 12px;
    cursor: pointer;
}
.tb-btn-light { background: #ffffff; color: #0a182a; }
.tb-btn-teal { background: #148b7e; color: #ffffff; }
@media screen and (max-width: 840px) {
    .sheet-wrap { padding: 12px 0 30px; overflow-x: hidden; }
    .page { zoom: 0.86; }
}
@media print {
    .no-print { display: none !important; }
    body { background: #ffffff; }
    .sheet-wrap { padding: 0; }
    .page { margin: 0; box-shadow: none; zoom: 1; }
}
PREVIEW;

        return <<<'CSS'
@page {
    size: A4 portrait;
    margin: 0;
}
* { box-sizing: border-box; }
body {
    margin: 0;
    padding: 0;
    font-family: "DejaVu Sans", Arial, Helvetica, sans-serif;
    color: #162636;
    font-size: 9.5pt;
    line-height: 1.48;
    background: #ffffff;
}
a { text-decoration: none; color: inherit; }

.page {
    position: relative;
    width: 210mm;
    height: 296mm;
    overflow: hidden;
    page-break-after: always;
    background: #ffffff;
}
.page-last {
    page-break-after: avoid;
}
CSS . "\n" . $previewCss . "\n" . <<<'CSS2'

/* Cover header (Page 1) */
.cover-header {
    position: relative;
    background: #0d2235;
    color: #ffffff;
    padding: 20px 36px 16px 36px;
}
.gold-top {
    position: absolute;
    top: 0;
    left: 0;
    width: 110px;
    height: 10px;
    background: #caa56a;
}
.gold-right {
    position: absolute;
    top: 16px;
    right: 0;
    width: 12px;
    height: 160px;
    background: #caa56a;
}
.top-bar-accent {
    position: relative;
    height: 10px;
    background: #0d2235;
}
.leader-pill {
    display: inline-block;
    background: #0f7e74;
    color: #ffffff;
    font-size: 8pt;
    font-weight: bold;
    letter-spacing: 0.8px;
    padding: 4px 14px;
    border-radius: 12px;
    margin-bottom: 10px;
}
.cover-name-first {
    font-size: 27pt;
    font-weight: bold;
    line-height: 1.02;
    letter-spacing: 0.5px;
    color: #ffffff;
}
.cover-name-last {
    font-size: 27pt;
    font-weight: normal;
    line-height: 1.04;
    letter-spacing: 1px;
    color: #dce7ee;
    margin-bottom: 8px;
}
.cover-sub {
    font-size: 8.5pt;
    letter-spacing: 0.9px;
    color: #9dc2cf;
    font-weight: bold;
}
.cover-cta-box {
    display: inline-block;
    background: #0f7e74;
    color: #ffffff;
    padding: 14px 24px;
    border-radius: 8px;
    text-align: left;
    min-width: 185px;
}
.cover-cta-eyebrow {
    font-size: 7.5pt;
    letter-spacing: 0.8px;
    color: #c8efe9;
    margin-bottom: 4px;
    font-weight: bold;
}
.cover-cta-url {
    font-size: 16pt;
    font-weight: bold;
    color: #ffffff;
}
.cover-contact {
    margin-top: 12px;
    padding-top: 8px;
    border-top: 1px solid #213c54;
    font-size: 8pt;
    color: #c4d7e3;
}
.hd-link { color: #8fe3d5; }

/* Body container */
.page-body {
    padding: 16px 36px 46px 36px;
}
.page-body-inner {
    padding-top: 14px;
}
.page-body-feat {
    padding: 16px 36px 44px 36px;
}

.sec-title {
    font-size: 9.8pt;
    font-weight: bold;
    color: #0e2235;
    letter-spacing: 0.4px;
    border-bottom: 1px solid #d9e3e8;
    padding-bottom: 4px;
    margin: 12px 0 7px 0;
}
.sec-compact {
    margin: 7px 0 4px 0;
}
.body-p {
    margin: 0 0 6px 0;
    color: #2b3d4f;
    font-size: 8.8pt;
    line-height: 1.44;
}
.small-p { font-size: 8pt; line-height: 1.38; }
.muted-p { color: #5c7082; }

/* KPIs */
.kpi-table { margin: 10px 0 8px 0; }
.kpi-card {
    background: #f2f7f6;
    border: 1px solid #e2ecea;
    border-radius: 8px;
    padding: 11px 14px;
}
.kpi-val {
    font-size: 19pt;
    font-weight: bold;
    color: #0e7b70;
    line-height: 1.1;
}
.kpi-lbl {
    font-size: 7pt;
    font-weight: bold;
    color: #4f6475;
    letter-spacing: 0.4px;
    margin-top: 4px;
}

/* Lists */
.pdf-list {
    margin: 0 0 8px 0;
    padding-left: 16px;
}
.pdf-list li {
    margin-bottom: 5px;
    font-size: 8.8pt;
    color: #2a3c4e;
    line-height: 1.45;
}

/* Experience */
.exp-head-tbl { margin-top: 4px; }
.exp-company {
    font-size: 10.5pt;
    font-weight: bold;
    color: #0d2235;
}
.exp-period {
    text-align: right;
    font-size: 8.5pt;
    font-weight: bold;
    color: #0e7b70;
}
.exp-role {
    font-size: 8.8pt;
    font-weight: bold;
    color: #137c72;
    margin: 3px 0 7px 0;
}

/* Case Study boxes (Page 2) */
.case-box {
    background: #f3f7f6;
    border: 1px solid #e1ecea;
    border-left: 4px solid #0f7e74;
    border-radius: 8px;
    padding: 12px 16px;
    margin-bottom: 12px;
}
.case-box-title {
    font-size: 10pt;
    font-weight: bold;
    color: #0d2235;
}
.case-box-sub {
    font-size: 7.5pt;
    font-weight: bold;
    color: #0f7e74;
    letter-spacing: 0.5px;
    margin: 2px 0 7px 0;
}
.case-list { margin-bottom: 0; }
.case-list li { font-size: 8.4pt; margin-bottom: 4px; }

/* Page 3 contact, other experiences & philosophy */
.contact-teal {
    margin: 2px 0 5px 0;
    font-size: 8.2pt;
    font-weight: bold;
    color: #0e7b70;
}
.oe-table { margin-bottom: 6px; }
.oe-table td { padding: 2px 0 4px 0; }
.oe-date {
    font-size: 7.8pt;
    font-weight: bold;
    color: #0e7b70;
}
.oe-comp {
    font-size: 8.4pt;
    font-weight: bold;
    color: #0d2235;
}
.oe-role {
    font-size: 7.7pt;
    color: #526778;
}
.philosophy-box {
    background: #0d2235;
    color: #ffffff;
    border-radius: 9px;
    padding: 10px 15px;
    margin-top: 4px;
}
.philosophy-title {
    font-size: 8.2pt;
    font-weight: bold;
    letter-spacing: 0.6px;
    color: #7ee3d2;
    margin-bottom: 3px;
}
.philosophy-text {
    font-size: 8.1pt;
    color: #dce8ee;
    line-height: 1.4;
}

/* Page 4 catalog */
.cat-table td { padding-bottom: 3.5px; }
.cat-card {
    background: #f3f7f6;
    border: 1px solid #e3ecea;
    border-radius: 5px;
    padding: 4px 8px;
}
.cat-name {
    font-size: 7.8pt;
    font-weight: bold;
    color: #0d2235;
    margin-bottom: 1px;
}
.cat-desc {
    font-size: 7pt;
    color: #4f6374;
    line-height: 1.25;
}

/* Featured pages (SATWA & Kreww) */
.feat-top-strip {
    border-bottom: 1px solid #dce5e8;
    padding-bottom: 7px;
    margin-bottom: 14px;
    font-size: 7.5pt;
    font-weight: bold;
    color: #556a7a;
}
.ft-right { text-align: right; color: #0e7b70; }

.satwa-hero {
    background: #ede7db;
    border-radius: 12px;
    padding: 18px 20px;
    margin-bottom: 16px;
}
.satwa-logo-img { width: 100%; max-height: 110px; border-radius: 6px; }
.satwa-bar-txt {
    font-size: 7.5pt;
    font-weight: bold;
    color: #2b4d3e;
    letter-spacing: 0.4px;
    margin-top: 7px;
}
.satwa-hero-title {
    font-size: 16pt;
    font-weight: bold;
    color: #1c3028;
    line-height: 1.15;
    margin-bottom: 8px;
}
.satwa-hero-sub {
    font-size: 8.8pt;
    color: #3d5649;
}
.satwa-intro-title {
    font-size: 13pt;
    font-weight: bold;
    color: #1c3028;
    margin: 4px 0 6px 0;
}
.satwa-grid td { padding-bottom: 10px; }
.satwa-card {
    background: #f7f5ef;
    border: 1px solid #e5dfd1;
    border-radius: 9px;
    padding: 11px 13px;
}
.satwa-card-h {
    font-size: 9pt;
    font-weight: bold;
    color: #1c3028;
    margin-bottom: 4px;
}
.satwa-num { color: #9c744c; }
.satwa-card-p {
    font-size: 8.2pt;
    color: #53665c;
    line-height: 1.42;
}
.satwa-cta {
    background: #445f50;
    color: #ffffff;
    border-radius: 10px;
    padding: 16px 20px;
    margin-top: 12px;
}
.satwa-cta-h { font-size: 12pt; font-weight: bold; margin-bottom: 4px; }
.satwa-cta-sub { font-size: 8.5pt; color: #d6e9de; }
.cta-white-link { color: #ffffff; font-weight: bold; }

/* Kreww showcase */
.kreww-banner-wrap { margin-bottom: 16px; }
.kreww-banner-img { width: 100%; border-radius: 14px; }
.kreww-title {
    font-size: 17pt;
    font-weight: bold;
    color: #0d2235;
    margin-bottom: 8px;
}
.kreww-grid { margin: 14px 0 18px 0; }
.kreww-card {
    background: #f5f7fa;
    border: 1px solid #dfe6ee;
    border-radius: 10px;
    padding: 14px;
    min-height: 92px;
}
.kreww-card-h {
    font-size: 9.5pt;
    font-weight: bold;
    color: #0d2235;
    margin-bottom: 6px;
}
.kreww-card-p {
    font-size: 8.3pt;
    color: #4f6375;
    line-height: 1.45;
}
.kreww-disc {
    font-size: 8pt;
    font-style: italic;
    color: #6b7d8e;
    margin: 14px 0 12px 0;
}
.kreww-cta {
    background: #0a1628;
    color: #ffffff;
    border-radius: 10px;
    padding: 16px 20px;
}
.kreww-cta-h { font-size: 12pt; font-weight: bold; margin-bottom: 4px; }
.kreww-cta-url { font-size: 9.5pt; font-weight: bold; }
.cta-teal-link { color: #5ce1c6; }

/* Consistent bottom footer */
.page-footer {
    position: absolute;
    left: 36px;
    right: 36px;
    bottom: 14px;
    border-top: 1px solid #dce5e8;
    padding-top: 7px;
}
.ft-left {
    font-size: 7.5pt;
    color: #6a7c8c;
    font-weight: bold;
}
.ft-num {
    text-align: right;
    font-size: 7.5pt;
    color: #6a7c8c;
    padding-right: 12px;
}
.ft-num-right {
    text-align: right;
    font-size: 7.5pt;
    color: #6a7c8c;
    font-weight: bold;
}
.ft-cta-cell {
    width: 145px;
    text-align: right;
}
.ft-cta {
    display: inline-block;
    background: #0f7e74;
    color: #ffffff;
    font-size: 7.8pt;
    font-weight: bold;
    padding: 5px 14px;
    border-radius: 5px;
}
CSS2;
    }
}
