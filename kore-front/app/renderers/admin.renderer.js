/**
 * AdminRenderer — Componentes Bootstrap 5 modulares para o Painel Administrativo (Fase 2).
 * Utiliza o Renderer ativo do Kore (UI.getRenderer()) para composicao de elementos.
 */
const AdminRenderer = {
    esc(str) {
        return PortfolioI18n.escapeHtml(str);
    },

    loginCard() {
        const R = UI.getRenderer();
        const formInner =
            R.div('text-center mb-4',
                R.div('pf-brand-mark mb-2', 'ar' + R.span('', '.')) +
                R.h2('Acesso Administrativo', 'h4 fw-bold mb-1') +
                R.p('Gerencie projetos, experiências, skills e perfil do portfólio.', 'small text-muted mb-0')
            ) +
            R.div('alert alert-danger d-none py-2 small', '', { id: 'admin-login-error', role: 'alert' }) +
            R.input('text', 'login-username', true, 'Usuário ou E-mail', '', false, 'form-control-lg') +
            R.input('password', 'login-password', true, 'Senha', '', false, 'form-control-lg') +
            R.div('d-grid mt-4',
                R.element('button', { type: 'submit', class: 'btn btn-lg pf-btn-primary justify-content-center', id: 'btn-login-submit' },
                    '<i class="bi bi-shield-lock me-2"></i>Entrar no Painel'
                )
            ) +
            R.div('text-center mt-3',
                R.a('← Voltar ao portfólio público', '#/', '_self', 'small text-muted text-decoration-none')
            );

        return R.div(
            'container pf-container py-5 my-4',
            R.div('row justify-content-center',
                R.div('col-md-6 col-lg-5',
                    R.div('card border-0 shadow-sm rounded-4 p-4 p-md-5',
                        R.element('form', { id: 'kore-login-form', autocomplete: 'on' }, formInner)
                    )
                )
            )
        );
    },

    adminShell({ user, activeTab, contentHtml }) {
        const R = UI.getRenderer();
        const tabs = [
            { key: 'overview', label: 'Visão Geral', icon: 'bi-speedometer2' },
            { key: 'projects', label: 'Projetos & Sistemas', icon: 'bi-grid-1x2' },
            { key: 'experiences', label: 'Experiências', icon: 'bi-briefcase' },
            { key: 'skills', label: 'Skills', icon: 'bi-cpu' },
            { key: 'education', label: 'Formação & Cursos', icon: 'bi-mortarboard' },
            { key: 'profile', label: 'Perfil & Senha', icon: 'bi-person-gear' },
            { key: 'resume', label: 'Currículo PDF', icon: 'bi-file-earmark-pdf' }
        ];

        const navHtml = tabs.map(t => {
            const active = t.key === activeTab ? ' active' : '';
            return R.element('li', { class: 'nav-item' },
                R.a(
                    `<i class="bi ${t.icon} me-1"></i>${t.label}`,
                    '#/admin/' + t.key,
                    '_self',
                    'nav-link pf-admin-tab' + active
                )
            );
        }).join('');

        const topBar = R.div(
            'pf-admin-banner py-4 mb-4',
            R.div('container pf-container',
                R.div('d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3',
                    R.div('',
                        R.div('pf-section-index mb-1', R.span('', 'ADMIN / KORE CMS')) +
                        R.h1('Painel de Gestão do Portfólio', 'h3 fw-bold text-white mb-0')
                    ) +
                    R.div('d-flex flex-wrap align-items-center gap-2',
                        R.span('badge rounded-pill text-bg-dark border border-secondary px-3 py-2',
                            '<i class="bi bi-person-circle me-1 text-info"></i>' + this.esc((user && (user.name || user.username)) || 'Admin')
                        ) +
                        R.a('<i class="bi bi-box-arrow-up-right me-1"></i>Ver site', '#/', '_self', 'btn btn-sm btn-outline-light') +
                        R.button('btn-admin-logout', '<i class="bi bi-box-arrow-right me-1"></i>Sair', 'btn-sm btn-outline-warning')
                    )
                ) +
                R.element('ul', { class: 'nav nav-pills flex-wrap gap-2 mt-4' }, navHtml)
            )
        );

        const toastSlot = R.div('container pf-container', R.div('', '', { id: 'admin-feedback-slot' }));
        const body = R.div('container pf-container pb-5', contentHtml);

        return R.div('pf-admin-wrap', topBar + toastSlot + body);
    },

    kpiCard(icon, value, label, sub = '', linkHref = '') {
        const R = UI.getRenderer();
        const inner =
            R.div('d-flex align-items-center justify-content-between mb-2',
                R.span('small fw-bold text-uppercase text-muted', this.esc(label)) +
                `<i class="bi ${icon} fs-4" style="color: var(--pf-teal);"></i>`
            ) +
            R.div('fs-2 fw-bold mb-1', this.esc(value)) +
            (sub ? R.div('small text-muted', this.esc(sub)) : '');

        const card = R.div('card border-0 shadow-sm rounded-3 h-100 p-3 pf-admin-kpi', inner);
        return R.div('col-sm-6 col-lg-3', linkHref ? R.a(card, linkHref, '_self', 'text-decoration-none text-reset d-block h-100') : card);
    },

    tableCard({ title, subtitle = '', addBtnId = '', addBtnLabel = '', toolbarHtml = '', headers = [], rowsHtml = '', emptyText = 'Nenhum registro encontrado.' }) {
        const R = UI.getRenderer();
        const headerRight = addBtnId
            ? R.button(addBtnId, `<i class="bi bi-plus-lg me-1"></i>${this.esc(addBtnLabel)}`, 'btn-dark btn-sm px-3 fw-semibold')
            : '';

        const thead = R.thead(
            R.tr(headers.map(h => R.th(this.esc(h), 'small text-uppercase text-muted fw-bold')).join('')),
            'table-light'
        );
        const tbody = R.tbody(
            rowsHtml || R.tr(R.td(this.esc(emptyText), 'text-center text-muted py-4', { colspan: headers.length }))
        );

        return R.div(
            'card border-0 shadow-sm rounded-4 overflow-hidden',
            R.div('card-header bg-white border-bottom py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2',
                R.div('',
                    R.h2(this.esc(title), 'h5 fw-bold mb-0') +
                    (subtitle ? R.p(this.esc(subtitle), 'small text-muted mb-0 mt-1') : '')
                ) + headerRight
            ) +
            (toolbarHtml ? R.div('px-4 py-3 bg-light border-bottom', toolbarHtml) : '') +
            R.div('table-responsive', R.table(thead + tbody, 'table table-hover align-middle mb-0'))
        );
    },

    badge(text, variant = 'secondary') {
        return `<span class="badge text-bg-${variant} fw-semibold">${this.esc(text)}</span>`;
    }
};
