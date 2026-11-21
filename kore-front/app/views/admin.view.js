/**
 * AdminView — Orquestrador do painel administrativo (Visao Geral + delegacao modular).
 */
class AdminView extends View {
    constructor(opts) {
        super();
        this.user = opts.user;
        this.section = opts.section || 'overview';
        this.state = opts.state;
        this.onReload = opts.onReload;
        this.render();
    }

    static flashMessage = null;

    static notify(message, type = 'success') {
        const icon = type === 'danger' ? 'bi-exclamation-octagon' : 'bi-check-circle';
        const html = `
            <div class="alert alert-${type} alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
                <i class="bi ${icon} me-2"></i>${PortfolioI18n.escapeHtml(message)}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        jQuery('#admin-feedback-slot').html(html);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    static extractError(xhr, fallback = 'Ocorreu um erro ao salvar.') {
        return (xhr && xhr.responseJSON && (xhr.responseJSON.error || xhr.responseJSON.message)) || fallback;
    }

    render() {
        document.title = 'Admin — Alex Reis | Portfolio';
        let contentHtml = '';

        switch (this.section) {
            case 'projects':
                contentHtml = AdminProjectsPanel.render(this.state.projects);
                break;
            case 'experiences':
                contentHtml = AdminResumePanels.renderExperiences(this.state.experiences);
                break;
            case 'skills':
                contentHtml = AdminResumePanels.renderSkills(this.state.skills);
                break;
            case 'education':
                contentHtml = AdminResumePanels.renderEducation(this.state.education);
                break;
            case 'profile':
                contentHtml = AdminResumePanels.renderProfile(this.state.profile);
                break;
            case 'resume':
                contentHtml = AdminResumePdfPanel.render();
                break;
            default:
                contentHtml = this.renderOverview();
                break;
        }

        const shellHtml = AdminRenderer.adminShell({
            user: this.user,
            activeTab: this.section,
            contentHtml: contentHtml
        });

        jQuery('.conteudo-interno').html(shellHtml);

        if (AdminView.flashMessage) {
            AdminView.notify(AdminView.flashMessage.text, AdminView.flashMessage.type);
            AdminView.flashMessage = null;
        }

        this.bindEvents();
    }

    renderOverview() {
        const R = UI.getRenderer();
        const projects = this.state.projects || [];
        const publishedCount = projects.filter(p => p.is_published).length;
        const draftCount = projects.length - publishedCount;
        const withDetailCount = projects.filter(p => p.has_detail_page).length;
        const withVideoCount = projects.filter(p => p.video_url).length;
        const expCount = (this.state.experiences || []).length;
        const skillCount = (this.state.skills || []).length;
        const eduCount = (this.state.education || []).length;

        const kpis = R.div('row g-3 mb-4',
            AdminRenderer.kpiCard('bi-grid-1x2', String(projects.length), 'Projetos & Sistemas', `${publishedCount} publicados · ${draftCount} rascunhos`, '#/admin/projects') +
            AdminRenderer.kpiCard('bi-file-earmark-richtext', String(withDetailCount), 'Páginas Explicativas', `${withVideoCount} com vídeo explicativo`, '#/admin/projects') +
            AdminRenderer.kpiCard('bi-briefcase', String(expCount), 'Experiências', 'Ordem cronológica no portfólio', '#/admin/experiences') +
            AdminRenderer.kpiCard('bi-cpu', String(skillCount), 'Skills & Formação', `${eduCount} formações e cursos`, '#/admin/skills')
        );

        const quickActions = R.div('card border-0 shadow-sm rounded-4 p-4',
            R.h2('Atalhos Rápidos', 'h5 fw-bold mb-3') +
            R.p('Cadastre ou atualize qualquer seção do portfólio. As alterações são salvas diretamente no SQLite e refletem imediatamente no site público.', 'small text-muted mb-4') +
            R.div('d-flex flex-wrap gap-2',
                R.a('<i class="bi bi-plus-circle me-1"></i>Gerenciar Projetos & Vídeos', '#/admin/projects', '_self', 'btn btn-dark btn-sm px-3') +
                R.a('<i class="bi bi-briefcase me-1"></i>Gerenciar Experiências', '#/admin/experiences', '_self', 'btn btn-outline-dark btn-sm px-3') +
                R.a('<i class="bi bi-cpu me-1"></i>Gerenciar Skills', '#/admin/skills', '_self', 'btn btn-outline-dark btn-sm px-3') +
                R.a('<i class="bi bi-mortarboard me-1"></i>Formação & Cursos', '#/admin/education', '_self', 'btn btn-outline-dark btn-sm px-3') +
                R.a('<i class="bi bi-person-gear me-1"></i>Editar Perfil / LinkedIn / Senha', '#/admin/profile', '_self', 'btn btn-outline-secondary btn-sm px-3') +
                R.a('<i class="bi bi-file-earmark-pdf me-1"></i>Gerar Currículo PDF', '#/admin/resume', '_self', 'btn btn-outline-danger btn-sm px-3')
            )
        );

        return kpis + quickActions;
    }

    bindEvents() {
        const self = this;

        jQuery('#btn-admin-logout').off('click').on('click', function() {
            AdminModel.logout();
        });

        const reloadWithFlash = function(msg, type = 'success') {
            AdminView.flashMessage = { text: msg, type: type };
            self.onReload(self.section);
        };

        if (this.section === 'projects') {
            AdminProjectsPanel.bind(this.state.projects, reloadWithFlash);
        } else if (this.section === 'experiences') {
            AdminResumePanels.bindExperiences(this.state.experiences, reloadWithFlash);
        } else if (this.section === 'skills') {
            AdminResumePanels.bindSkills(this.state.skills, reloadWithFlash);
        } else if (this.section === 'education') {
            AdminResumePanels.bindEducation(this.state.education, reloadWithFlash);
        } else if (this.section === 'profile') {
            AdminResumePanels.bindProfile(this.state.profile, reloadWithFlash);
        } else if (this.section === 'resume') {
            AdminResumePdfPanel.bind();
        }
    }
}
