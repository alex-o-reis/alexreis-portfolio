/**
 * HomeController — Controlador da pagina inicial do portfolio (#/).
 */
class HomeController extends Controller {
    static activeInstance = null;
    static pendingScrollSection = null;

    constructor(params = {}) {
        super(params);
        this.currentFilter = 'all';
        this.portfolioData = null;
        HomeController.activeInstance = this;
        ProjectDetailController.activeInstance = null;
    }

    execute() {
        const self = this;
        const R = UI.getRenderer();
        jQuery('.conteudo-interno').html(R.loadingState(PortfolioI18n.t('loading')));

        PortfolioModel.getPortfolio()
            .done(function(data) {
                self.portfolioData = data;
                if (typeof PortfolioShell !== 'undefined') {
                    PortfolioShell.syncProfile(data.profile);
                }
                self.renderView();

                if (HomeController.pendingScrollSection) {
                    const targetId = HomeController.pendingScrollSection;
                    HomeController.pendingScrollSection = null;
                    setTimeout(function() {
                        const el = document.getElementById(targetId);
                        if (el) el.scrollIntoView({ behavior: 'smooth' });
                    }, 60);
                }
            })
            .fail(function() {
                jQuery('.conteudo-interno').html(R.errorState(PortfolioI18n.t('errorLoad'), PortfolioI18n.t('retry')));
                jQuery('#pf-retry-btn').on('click', function() {
                    PortfolioModel.clearCache();
                    self.execute();
                });
            });
    }

    renderView() {
        if (!this.portfolioData) return;
        const self = this;
        new HomeView(this.portfolioData, {
            filter: this.currentFilter,
            onFilterChange: function(nextFilter) {
                self.currentFilter = nextFilter;
            }
        });
    }
}
