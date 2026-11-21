/**
 * ProjectDetailController — Controlador da rota #/projeto/:slug.
 */
class ProjectDetailController extends Controller {
    static activeInstance = null;

    constructor(params = {}) {
        super(params);
        this.project = null;
        ProjectDetailController.activeInstance = this;
        HomeController.activeInstance = null;
    }

    execute() {
        const self = this;
        const slug = this.params.slug;
        const R = UI.getRenderer();

        jQuery('.conteudo-interno').html(R.loadingState(PortfolioI18n.t('loading')));

        // Garante que o cabecalho/rodape estejam sincronizados com o perfil mesmo em deep-link direto
        PortfolioModel.getPortfolio().done(function(data) {
            if (typeof PortfolioShell !== 'undefined' && data && data.profile) {
                PortfolioShell.syncProfile(data.profile);
            }
        });

        PortfolioModel.getProject(slug)
            .done(function(project) {
                self.project = project;
                self.renderView();
            })
            .fail(function(xhr) {
                if (xhr && xhr.status === 404) {
                    jQuery('.conteudo-interno').html(
                        R.div('container pf-container py-5 my-5 text-center',
                            R.h2(PortfolioI18n.escapeHtml(PortfolioI18n.t('notFoundTitle')), 'fw-bold mb-3') +
                            R.p(PortfolioI18n.escapeHtml(PortfolioI18n.t('notFoundDesc')), 'text-muted mb-4') +
                            R.a(PortfolioI18n.escapeHtml(PortfolioI18n.t('backPortfolio')), '#/', '_self', 'pf-btn-primary')
                        )
                    );
                } else {
                    jQuery('.conteudo-interno').html(R.errorState(PortfolioI18n.t('errorLoad'), PortfolioI18n.t('retry')));
                    jQuery('#pf-retry-btn').on('click', function() {
                        PortfolioModel.clearCache();
                        self.execute();
                    });
                }
            });
    }

    renderView() {
        if (!this.project) return;
        new ProjectDetailView(this.project);
    }
}
