/**
 * AdminProjectsPanel — Modulo de gerenciamento de Projetos e Sistemas do Portfolio.
 * Inclui editor de pagina explicativa (#/projeto/:slug), link do sistema e video explicativo.
 */
const AdminProjectsPanel = {
    _projects: [],
    _detailDraft: { pt: {}, en: {}, es: {} },
    _detailLang: 'pt',

    CATEGORIES: [
        { key: 'enterprise', label: 'Corporativo (enterprise)' },
        { key: 'platform', label: 'Plataforma (platform)' },
        { key: 'product', label: 'Produto (product)' },
        { key: 'ai', label: 'IA (ai)' },
        { key: 'opensource', label: 'Open Source (opensource)' },
        { key: 'data', label: 'Dados (data)' },
        { key: 'tool', label: 'Ferramenta (tool)' },
        { key: 'othertool', label: 'Outra Ferramenta / Kodes (othertool)' }
    ],

    STATUSES: [
        { key: 'delivered', label: 'Entregue (delivered)' },
        { key: 'published', label: 'Publicado (published)' },
        { key: 'public', label: 'Público / Open Source (public)' },
        { key: 'evolving', label: 'Em evolução (evolving)' },
        { key: 'development', label: 'Em desenvolvimento (development)' }
    ],

    THEMES: [
        { key: 'default', label: 'Padrão Portfólio (Navy / Teal)' },
        { key: 'satwa', label: 'SATWA (Verde Floresta / Areia)' },
        { key: 'kreww', label: 'Kreww (Azul / Violeta IA)' }
    ],

    esc(s) {
        return PortfolioI18n.escapeHtml(s);
    },

    render(projects = []) {
        this._projects = projects;
        const R = UI.getRenderer();

        const catOptions = '<option value="">Todas as categorias</option>' +
            this.CATEGORIES.map(c => `<option value="${c.key}">${this.esc(c.label)}</option>`).join('');

        const toolbarHtml = `
            <div class="row g-2 align-items-center">
                <div class="col-md-6">
                    <input type="search" id="pf-proj-search" class="form-control form-control-sm" placeholder="Buscar por nome, slug ou organização...">
                </div>
                <div class="col-md-4">
                    <select id="pf-proj-cat-filter" class="form-select form-select-sm">${catOptions}</select>
                </div>
                <div class="col-md-2 text-md-end small text-muted" id="pf-proj-count">${projects.length} itens</div>
            </div>`;

        const tableHtml = AdminRenderer.tableCard({
            title: 'Projetos & Sistemas do Portfólio',
            subtitle: 'Cadastre sistemas com página explicativa própria, link externo e vídeo explicativo.',
            addBtnId: 'btn-add-project',
            addBtnLabel: 'Novo Projeto',
            toolbarHtml: toolbarHtml,
            headers: ['Ordem', 'Projeto / Slug', 'Categoria / Status', 'Recursos & Visibilidade', 'Ações'],
            rowsHtml: this.buildRows(projects)
        });

        return tableHtml + this.renderModal();
    },

    buildRows(list) {
        if (!list.length) return '';
        return list.map(p => {
            const name = (p.name && (p.name.pt || p.name.en)) || p.slug;
            const org = (p.org && (p.org.pt || p.org.en)) || '';
            const badges = [];
            badges.push(p.is_published ? AdminRenderer.badge('Publicado', 'success') : AdminRenderer.badge('Rascunho', 'warning'));
            if (p.has_detail_page) badges.push(AdminRenderer.badge('Página', 'info'));
            if (p.system_url) badges.push(AdminRenderer.badge('Link', 'primary'));
            if (p.video_url) badges.push(AdminRenderer.badge('Vídeo', 'danger'));
            if (p.is_featured) badges.push(AdminRenderer.badge('Destaque', 'dark'));
            if (p.is_case_study) badges.push(AdminRenderer.badge('Case', 'secondary'));

            const previewBtn = p.has_detail_page && p.is_published
                ? `<a href="#/projeto/${encodeURIComponent(p.slug)}" class="btn btn-sm btn-outline-secondary" title="Abrir página explicativa"><i class="bi bi-eye"></i></a>`
                : '';

            return `
                <tr>
                    <td class="text-muted small fw-bold">#${p.display_order}</td>
                    <td>
                        <div class="fw-bold">${this.esc(name)}</div>
                        <div class="small text-muted"><code>${this.esc(p.slug)}</code>${org ? ' · ' + this.esc(org) : ''}</div>
                    </td>
                    <td>
                        <div class="small fw-semibold">${this.esc(p.category)}</div>
                        <div class="small text-muted">${this.esc(p.status)}</div>
                    </td>
                    <td><div class="d-flex flex-wrap gap-1">${badges.join('')}</div></td>
                    <td class="text-nowrap">
                        <div class="btn-group btn-group-sm">
                            ${previewBtn}
                            <button type="button" class="btn btn-outline-primary btn-edit-project" data-id="${p.id}" title="Editar"><i class="bi bi-pencil"></i></button>
                            <button type="button" class="btn btn-outline-danger btn-del-project" data-id="${p.id}" data-name="${this.esc(name)}" title="Remover"><i class="bi bi-trash"></i></button>
                        </div>
                    </td>
                </tr>`;
        }).join('');
    },

    renderModal() {
        const catOpts = this.CATEGORIES.map(c => `<option value="${c.key}">${this.esc(c.label)}</option>`).join('');
        const statusOpts = this.STATUSES.map(s => `<option value="${s.key}">${this.esc(s.label)}</option>`).join('');
        const themeOpts = this.THEMES.map(t => `<option value="${t.key}">${this.esc(t.label)}</option>`).join('');

        return `
        <div class="modal fade" id="modal-project" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content border-0 shadow rounded-4">
                    <form id="form-project">
                        <div class="modal-header border-bottom">
                            <div>
                                <h5 class="modal-title fw-bold mb-0" id="modal-project-title">Novo Projeto</h5>
                                <small class="text-muted">Campos EN/ES vazios herdam automaticamente o texto em PT.</small>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <input type="hidden" id="proj-id" value="">
                            <div class="alert alert-danger d-none small py-2" id="proj-form-error"></div>

                            <ul class="nav nav-tabs mb-4" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active fw-semibold" data-bs-toggle="tab" data-bs-target="#tab-proj-basic" type="button">
                                        <i class="bi bi-sliders me-1"></i>Dados Gerais, Links &amp; Vídeo
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-semibold" data-bs-toggle="tab" data-bs-target="#tab-proj-detail" type="button">
                                        <i class="bi bi-file-earmark-richtext me-1"></i>Página Explicativa (#/projeto/:slug)
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <!-- ABA 1: DADOS GERAIS -->
                                <div class="tab-pane fade show active" id="tab-proj-basic">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Nome (PT) *</label>
                                            <input type="text" class="form-control" id="proj-name-pt" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Nome (EN)</label>
                                            <input type="text" class="form-control" id="proj-name-en" placeholder="Igual ao PT se vazio">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Nome (ES)</label>
                                            <input type="text" class="form-control" id="proj-name-es" placeholder="Igual ao PT se vazio">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Slug (URL)</label>
                                            <input type="text" class="form-control" id="proj-slug" placeholder="ex: meu-sistema">
                                            <div class="form-text">Rota: <code>#/projeto/&lt;slug&gt;</code></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold">Categoria</label>
                                            <select class="form-select" id="proj-category">${catOpts}</select>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label small fw-bold">Status</label>
                                            <select class="form-select" id="proj-status">${statusOpts}</select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label small fw-bold">Ordem</label>
                                            <input type="number" class="form-control" id="proj-order" value="0">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Organização (PT)</label>
                                            <input type="text" class="form-control" id="proj-org-pt" placeholder="ex: Kodey, Emccamp, Independente">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Organização (EN)</label>
                                            <input type="text" class="form-control" id="proj-org-en">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Organização (ES)</label>
                                            <input type="text" class="form-control" id="proj-org-es">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Stack / Tags (PT)</label>
                                            <input type="text" class="form-control" id="proj-stack-pt" placeholder="PHP · REST · Bootstrap">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Stack / Tags (EN)</label>
                                            <input type="text" class="form-control" id="proj-stack-en">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Stack / Tags (ES)</label>
                                            <input type="text" class="form-control" id="proj-stack-es">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Resumo do Card (PT)</label>
                                            <textarea class="form-control" id="proj-summary-pt" rows="3"></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Resumo do Card (EN)</label>
                                            <textarea class="form-control" id="proj-summary-en" rows="3"></textarea>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Resumo do Card (ES)</label>
                                            <textarea class="form-control" id="proj-summary-es" rows="3"></textarea>
                                        </div>

                                        <div class="col-12"><hr class="my-1"></div>

                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold"><i class="bi bi-link-45deg me-1"></i>Link para o Sistema / Demo / GitHub</label>
                                            <input type="url" class="form-control" id="proj-system-url" placeholder="https://...">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold"><i class="bi bi-play-circle me-1"></i>URL do Vídeo Explicativo (YouTube, Vimeo ou MP4)</label>
                                            <div class="input-group">
                                                <input type="url" class="form-control" id="proj-video-url" placeholder="https://www.youtube.com/watch?v=...">
                                                <button class="btn btn-outline-secondary" type="button" id="btn-preview-video">Testar</button>
                                            </div>
                                            <div id="proj-video-preview" class="mt-2"></div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Imagem de Capa (caminho ou URL)</label>
                                            <input type="text" class="form-control" id="proj-cover-image" placeholder="assets/minha-capa.jpg ou https://...">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Tema da Página Explicativa</label>
                                            <select class="form-select" id="proj-theme">${themeOpts}</select>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex flex-wrap gap-4 p-3 bg-light rounded-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="proj-published" checked>
                                                    <label class="form-check-label fw-semibold small" for="proj-published">Publicado no site</label>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="proj-has-detail">
                                                    <label class="form-check-label fw-semibold small" for="proj-has-detail">Ativar Página Explicativa (#/projeto/:slug)</label>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="proj-featured">
                                                    <label class="form-check-label fw-semibold small" for="proj-featured">Destaque na Home (Promo)</label>
                                                </div>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="proj-case-study">
                                                    <label class="form-check-label fw-semibold small" for="proj-case-study">Exibir em Estudos de Caso</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-none" id="proj-case-fields">
                                            <div class="row g-2 p-3 border rounded-3">
                                                <div class="col-md-2">
                                                    <label class="form-label small fw-bold">Ordem Case</label>
                                                    <input type="number" class="form-control form-control-sm" id="proj-case-order" value="0">
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label small fw-bold">Ícone</label>
                                                    <input type="text" class="form-control form-control-sm" id="proj-case-icon" placeholder="↗">
                                                </div>
                                                <div class="col-md-8">
                                                    <label class="form-label small fw-bold">Rótulo do Case (PT / EN / ES)</label>
                                                    <div class="row g-2">
                                                        <div class="col-4"><input type="text" class="form-control form-control-sm" id="proj-case-label-pt" placeholder="PT"></div>
                                                        <div class="col-4"><input type="text" class="form-control form-control-sm" id="proj-case-label-en" placeholder="EN"></div>
                                                        <div class="col-4"><input type="text" class="form-control form-control-sm" id="proj-case-label-es" placeholder="ES"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ABA 2: PAGINA EXPLICATIVA -->
                                <div class="tab-pane fade" id="tab-proj-detail">
                                    <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded-3">
                                        <div class="small text-muted">Edite o conteúdo da página explicativa em cada idioma (se EN/ES ficar vazio, herda PT).</div>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-dark active btn-detail-lang" data-dlang="pt">PT</button>
                                            <button type="button" class="btn btn-outline-dark btn-detail-lang" data-dlang="en">EN</button>
                                            <button type="button" class="btn btn-outline-dark btn-detail-lang" data-dlang="es">ES</button>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Eyebrow (sobretítulo)</label>
                                            <input type="text" class="form-control form-control-sm" id="det-eyebrow" placeholder="ex: Plataforma SaaS em desenvolvimento">
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label small fw-bold">Headline (pode usar &lt;em&gt;destaque&lt;/em&gt;)</label>
                                            <input type="text" class="form-control form-control-sm" id="det-headline" placeholder="ex: Meu Sistema — <em>Clareza e produtividade.</em>">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Lead (parágrafo principal)</label>
                                            <textarea class="form-control form-control-sm" id="det-lead" rows="2"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Sublead (parágrafo complementar)</label>
                                            <textarea class="form-control form-control-sm" id="det-sublead" rows="2"></textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Faixa de Destaque — Título</label>
                                            <input type="text" class="form-control form-control-sm" id="det-bar-title" placeholder="ex: API REST + WORKFLOW + IA">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Faixa de Destaque — Subtítulo</label>
                                            <input type="text" class="form-control form-control-sm" id="det-bar-subtitle">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Desafio (Case Study)</label>
                                            <textarea class="form-control form-control-sm" id="det-challenge" rows="2"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold">Abordagem / Solução (Case Study)</label>
                                            <textarea class="form-control form-control-sm" id="det-approach" rows="2"></textarea>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label small fw-bold">Seção Diferenciais — Eyebrow</label>
                                            <input type="text" class="form-control form-control-sm" id="det-intro-eyebrow">
                                        </div>
                                        <div class="col-md-8">
                                            <label class="form-label small fw-bold">Seção Diferenciais — Título</label>
                                            <input type="text" class="form-control form-control-sm" id="det-intro-title">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label small fw-bold">Texto Introdutório dos Diferenciais</label>
                                            <textarea class="form-control form-control-sm" id="det-intro-text" rows="2"></textarea>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="form-label small fw-bold mb-0">Diferenciais / Módulos do Sistema</label>
                                                <button type="button" class="btn btn-outline-dark btn-sm" id="btn-add-feature">
                                                    <i class="bi bi-plus-lg me-1"></i>Adicionar diferencial
                                                </button>
                                            </div>
                                            <div id="det-features-list" class="d-flex flex-column gap-2"></div>
                                        </div>

                                        <div class="col-12 mt-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <label class="form-label small fw-bold mb-0">Pilares / Disciplinas (opcional)</label>
                                                <button type="button" class="btn btn-outline-dark btn-sm" id="btn-add-pillar">
                                                    <i class="bi bi-plus-lg me-1"></i>Adicionar pilar
                                                </button>
                                            </div>
                                            <div class="row g-2 mb-2">
                                                <div class="col-md-4"><input type="text" class="form-control form-control-sm" id="det-pillars-eyebrow" placeholder="Eyebrow dos pilares"></div>
                                                <div class="col-md-8"><input type="text" class="form-control form-control-sm" id="det-pillars-title" placeholder="Título dos pilares"></div>
                                            </div>
                                            <div id="det-pillars-list" class="d-flex flex-column gap-2"></div>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label small fw-bold">Nota / Disclaimer (rodapé da página)</label>
                                            <input type="text" class="form-control form-control-sm" id="det-disclaimer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-dark px-4 fw-semibold" id="btn-save-project">
                                <i class="bi bi-check-lg me-1"></i>Salvar Projeto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>`;
    },

    featureRowHtml(f = {}) {
        return `
            <div class="row g-2 align-items-start p-2 border rounded-3 bg-white det-feature-row">
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm f-code" placeholder="01 / MÓDULO" value="${this.esc(f.code || '')}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control form-control-sm f-title" placeholder="Título" value="${this.esc(f.title || '')}">
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control form-control-sm f-desc" placeholder="Descrição" value="${this.esc(f.desc || '')}">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row"><i class="bi bi-x-lg"></i></button>
                </div>
            </div>`;
    },

    pillarRowHtml(p = {}) {
        return `
            <div class="row g-2 align-items-start p-2 border rounded-3 bg-white det-pillar-row">
                <div class="col-md-4">
                    <input type="text" class="form-control form-control-sm p-title" placeholder="Título do pilar" value="${this.esc(p.title || '')}">
                </div>
                <div class="col-md-7">
                    <input type="text" class="form-control form-control-sm p-desc" placeholder="Descrição" value="${this.esc(p.desc || '')}">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-row"><i class="bi bi-x-lg"></i></button>
                </div>
            </div>`;
    },

    captureCurrentDetailLang() {
        const features = [];
        jQuery('#det-features-list .det-feature-row').each(function() {
            const code = jQuery(this).find('.f-code').val().trim();
            const title = jQuery(this).find('.f-title').val().trim();
            const desc = jQuery(this).find('.f-desc').val().trim();
            if (code || title || desc) features.push({ code, title, desc });
        });

        const pillars = [];
        jQuery('#det-pillars-list .det-pillar-row').each(function() {
            const title = jQuery(this).find('.p-title').val().trim();
            const desc = jQuery(this).find('.p-desc').val().trim();
            if (title || desc) pillars.push({ title, desc });
        });

        const obj = {
            eyebrow: jQuery('#det-eyebrow').val().trim(),
            headline: jQuery('#det-headline').val().trim(),
            lead: jQuery('#det-lead').val().trim(),
            sublead: jQuery('#det-sublead').val().trim(),
            bar_title: jQuery('#det-bar-title').val().trim(),
            bar_subtitle: jQuery('#det-bar-subtitle').val().trim(),
            challenge: jQuery('#det-challenge').val().trim(),
            approach: jQuery('#det-approach').val().trim(),
            intro_eyebrow: jQuery('#det-intro-eyebrow').val().trim(),
            intro_title: jQuery('#det-intro-title').val().trim(),
            intro_text: jQuery('#det-intro-text').val().trim(),
            features: features,
            pillars_eyebrow: jQuery('#det-pillars-eyebrow').val().trim(),
            pillars_title: jQuery('#det-pillars-title').val().trim(),
            pillars: pillars,
            disclaimer: jQuery('#det-disclaimer').val().trim()
        };

        this._detailDraft[this._detailLang] = obj;
    },

    loadDetailLangIntoForm(lang) {
        this._detailLang = lang;
        const d = this._detailDraft[lang] || {};
        jQuery('#det-eyebrow').val(d.eyebrow || '');
        jQuery('#det-headline').val(d.headline || '');
        jQuery('#det-lead').val(d.lead || '');
        jQuery('#det-sublead').val(d.sublead || '');
        jQuery('#det-bar-title').val(d.bar_title || '');
        jQuery('#det-bar-subtitle').val(d.bar_subtitle || '');
        jQuery('#det-challenge').val(d.challenge || '');
        jQuery('#det-approach').val(d.approach || '');
        jQuery('#det-intro-eyebrow').val(d.intro_eyebrow || '');
        jQuery('#det-intro-title').val(d.intro_title || '');
        jQuery('#det-intro-text').val(d.intro_text || '');
        jQuery('#det-pillars-eyebrow').val(d.pillars_eyebrow || '');
        jQuery('#det-pillars-title').val(d.pillars_title || '');
        jQuery('#det-disclaimer').val(d.disclaimer || '');

        const fHtml = (d.features || []).map(f => this.featureRowHtml(f)).join('');
        jQuery('#det-features-list').html(fHtml);

        const pHtml = (d.pillars || []).map(p => this.pillarRowHtml(p)).join('');
        jQuery('#det-pillars-list').html(pHtml);

        jQuery('.btn-detail-lang').removeClass('btn-dark active').addClass('btn-outline-dark');
        jQuery(`.btn-detail-lang[data-dlang="${lang}"]`).removeClass('btn-outline-dark').addClass('btn-dark active');
    },

    openModal(project = null) {
        jQuery('#proj-form-error').addClass('d-none').text('');
        jQuery('#proj-video-preview').html('');

        if (project) {
            jQuery('#modal-project-title').text('Editar Projeto: ' + ((project.name && project.name.pt) || project.slug));
            jQuery('#proj-id').val(project.id);
            jQuery('#proj-name-pt').val((project.name && project.name.pt) || '');
            jQuery('#proj-name-en').val((project.name && project.name.en) || '');
            jQuery('#proj-name-es').val((project.name && project.name.es) || '');
            jQuery('#proj-slug').val(project.slug || '');
            jQuery('#proj-category').val(project.category || 'product');
            jQuery('#proj-status').val(project.status || 'development');
            jQuery('#proj-order').val(project.display_order || 0);
            jQuery('#proj-org-pt').val((project.org && project.org.pt) || '');
            jQuery('#proj-org-en').val((project.org && project.org.en) || '');
            jQuery('#proj-org-es').val((project.org && project.org.es) || '');
            jQuery('#proj-stack-pt').val((project.stack && project.stack.pt) || '');
            jQuery('#proj-stack-en').val((project.stack && project.stack.en) || '');
            jQuery('#proj-stack-es').val((project.stack && project.stack.es) || '');
            jQuery('#proj-summary-pt').val((project.summary && project.summary.pt) || '');
            jQuery('#proj-summary-en').val((project.summary && project.summary.en) || '');
            jQuery('#proj-summary-es').val((project.summary && project.summary.es) || '');
            jQuery('#proj-system-url').val(project.system_url || '');
            jQuery('#proj-video-url').val(project.video_url || '');
            jQuery('#proj-cover-image').val(project.cover_image || '');
            jQuery('#proj-theme').val(project.theme_key || 'default');
            jQuery('#proj-published').prop('checked', !!project.is_published);
            jQuery('#proj-has-detail').prop('checked', !!project.has_detail_page);
            jQuery('#proj-featured').prop('checked', !!project.is_featured);
            jQuery('#proj-case-study').prop('checked', !!project.is_case_study);
            jQuery('#proj-case-order').val(project.case_order || 0);
            jQuery('#proj-case-icon').val(project.case_icon || '');
            jQuery('#proj-case-label-pt').val((project.case_label && project.case_label.pt) || '');
            jQuery('#proj-case-label-en').val((project.case_label && project.case_label.en) || '');
            jQuery('#proj-case-label-es').val((project.case_label && project.case_label.es) || '');

            this._detailDraft = {
                pt: (project.detail && project.detail.pt) ? JSON.parse(JSON.stringify(project.detail.pt)) : {},
                en: (project.detail && project.detail.en) ? JSON.parse(JSON.stringify(project.detail.en)) : {},
                es: (project.detail && project.detail.es) ? JSON.parse(JSON.stringify(project.detail.es)) : {}
            };
        } else {
            jQuery('#modal-project-title').text('Novo Projeto / Sistema');
            jQuery('#form-project')[0].reset();
            jQuery('#proj-id').val('');
            jQuery('#proj-order').val(this._projects.length + 1);
            jQuery('#proj-published').prop('checked', true);
            this._detailDraft = { pt: {}, en: {}, es: {} };
        }

        jQuery('#proj-case-fields').toggleClass('d-none', !jQuery('#proj-case-study').is(':checked'));
        this.loadDetailLangIntoForm('pt');

        // Volta para a primeira aba
        const firstTab = document.querySelector('#modal-project [data-bs-target="#tab-proj-basic"]');
        if (firstTab && typeof bootstrap !== 'undefined') {
            bootstrap.Tab.getOrCreateInstance(firstTab).show();
        }
        UI.showModal('#modal-project');
    },

    bind(projects, onReload) {
        const self = this;
        this._projects = projects;

        const applyFilter = function() {
            const q = jQuery('#pf-proj-search').val().trim().toLowerCase();
            const cat = jQuery('#pf-proj-cat-filter').val();
            const filtered = self._projects.filter(p => {
                const matchCat = !cat || p.category === cat;
                const haystack = [
                    p.slug,
                    p.name && p.name.pt,
                    p.name && p.name.en,
                    p.org && p.org.pt
                ].join(' ').toLowerCase();
                return matchCat && (!q || haystack.includes(q));
            });
            jQuery('#pf-proj-count').text(filtered.length + ' itens');
            jQuery('.conteudo-interno table tbody').html(
                self.buildRows(filtered) || '<tr><td colspan="5" class="text-center text-muted py-4">Nenhum projeto encontrado.</td></tr>'
            );
        };

        jQuery('#pf-proj-search').off('input').on('input', applyFilter);
        jQuery('#pf-proj-cat-filter').off('change').on('change', applyFilter);

        jQuery('#btn-add-project').off('click').on('click', () => self.openModal(null));

        jQuery('.conteudo-interno').off('click', '.btn-edit-project').on('click', '.btn-edit-project', function() {
            const id = parseInt(jQuery(this).data('id'), 10);
            const found = self._projects.find(x => x.id === id);
            if (found) self.openModal(found);
        });

        jQuery('.conteudo-interno').off('click', '.btn-del-project').on('click', '.btn-del-project', function() {
            const id = parseInt(jQuery(this).data('id'), 10);
            const name = jQuery(this).data('name');
            if (!confirm(`Remover o projeto "${name}"?`)) return;
            AdminModel.deleteProject(id)
                .done(() => onReload('Projeto removido com sucesso.'))
                .fail(xhr => AdminView.notify(AdminView.extractError(xhr), 'danger'));
        });

        jQuery('#proj-case-study').off('change').on('change', function() {
            jQuery('#proj-case-fields').toggleClass('d-none', !jQuery(this).is(':checked'));
        });

        jQuery('#proj-name-pt').off('input').on('input', function() {
            if (!jQuery('#proj-id').val()) {
                const slug = jQuery(this).val()
                    .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                    .toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                jQuery('#proj-slug').val(slug);
            }
        });

        jQuery('#btn-preview-video').off('click').on('click', function() {
            const url = jQuery('#proj-video-url').val().trim();
            const parsed = PortfolioI18n.parseVideoUrl(url);
            if (!parsed) {
                jQuery('#proj-video-preview').html('<span class="small text-muted">Informe uma URL válida do YouTube, Vimeo ou MP4.</span>');
                return;
            }
            if (parsed.type === 'iframe') {
                jQuery('#proj-video-preview').html(`<div class="ratio ratio-16x9 rounded overflow-hidden"><iframe src="${parsed.src}" allowfullscreen></iframe></div>`);
            } else if (parsed.type === 'video') {
                jQuery('#proj-video-preview').html(`<video controls class="w-100 rounded"><source src="${parsed.src}"></video>`);
            } else {
                jQuery('#proj-video-preview').html(`<a href="${parsed.src}" target="_blank" rel="noopener" class="small">Link externo de vídeo reconhecido ↗</a>`);
            }
        });

        jQuery('.btn-detail-lang').off('click').on('click', function() {
            self.captureCurrentDetailLang();
            self.loadDetailLangIntoForm(jQuery(this).data('dlang'));
        });

        jQuery('#btn-add-feature').off('click').on('click', function() {
            jQuery('#det-features-list').append(self.featureRowHtml({}));
        });

        jQuery('#btn-add-pillar').off('click').on('click', function() {
            jQuery('#det-pillars-list').append(self.pillarRowHtml({}));
        });

        jQuery('#modal-project').off('click', '.btn-remove-row').on('click', '.btn-remove-row', function() {
            jQuery(this).closest('.row').remove();
        });

        jQuery('#form-project').off('submit').on('submit', function(e) {
            e.preventDefault();
            self.captureCurrentDetailLang();

            const id = jQuery('#proj-id').val();
            const payload = {
                slug: jQuery('#proj-slug').val().trim(),
                name_pt: jQuery('#proj-name-pt').val().trim(),
                name_en: jQuery('#proj-name-en').val().trim(),
                name_es: jQuery('#proj-name-es').val().trim(),
                category: jQuery('#proj-category').val(),
                status: jQuery('#proj-status').val(),
                display_order: parseInt(jQuery('#proj-order').val() || '0', 10),
                org_pt: jQuery('#proj-org-pt').val().trim(),
                org_en: jQuery('#proj-org-en').val().trim(),
                org_es: jQuery('#proj-org-es').val().trim(),
                stack_pt: jQuery('#proj-stack-pt').val().trim(),
                stack_en: jQuery('#proj-stack-en').val().trim(),
                stack_es: jQuery('#proj-stack-es').val().trim(),
                summary_pt: jQuery('#proj-summary-pt').val().trim(),
                summary_en: jQuery('#proj-summary-en').val().trim(),
                summary_es: jQuery('#proj-summary-es').val().trim(),
                system_url: jQuery('#proj-system-url').val().trim(),
                video_url: jQuery('#proj-video-url').val().trim(),
                cover_image: jQuery('#proj-cover-image').val().trim(),
                theme_key: jQuery('#proj-theme').val(),
                is_published: jQuery('#proj-published').is(':checked') ? 1 : 0,
                has_detail_page: jQuery('#proj-has-detail').is(':checked') ? 1 : 0,
                is_featured: jQuery('#proj-featured').is(':checked') ? 1 : 0,
                is_case_study: jQuery('#proj-case-study').is(':checked') ? 1 : 0,
                case_order: parseInt(jQuery('#proj-case-order').val() || '0', 10),
                case_icon: jQuery('#proj-case-icon').val().trim(),
                case_label_pt: jQuery('#proj-case-label-pt').val().trim(),
                case_label_en: jQuery('#proj-case-label-en').val().trim(),
                case_label_es: jQuery('#proj-case-label-es').val().trim(),
                detail_pt: self._detailDraft.pt,
                detail_en: self._detailDraft.en,
                detail_es: self._detailDraft.es
            };

            const $btn = jQuery('#btn-save-project');
            $btn.prop('disabled', true);
            jQuery('#proj-form-error').addClass('d-none');

            const req = id ? AdminModel.updateProject(id, payload) : AdminModel.createProject(payload);
            req.done(function() {
                UI.hideModal('#modal-project');
                onReload(id ? 'Projeto atualizado com sucesso.' : 'Projeto cadastrado com sucesso.');
            }).fail(function(xhr) {
                jQuery('#proj-form-error').removeClass('d-none').text(AdminView.extractError(xhr));
            }).always(function() {
                $btn.prop('disabled', false);
            });
        });
    }
};
