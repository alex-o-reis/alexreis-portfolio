/**
 * AdminController — Controlador autenticado das rotas #/admin e #/admin/:section.
 */
class AdminController extends Controller {
    static VALID_SECTIONS = ['overview', 'projects', 'experiences', 'skills', 'education', 'profile'];

    constructor(params = {}) {
        super(params);
        HomeController.activeInstance = null;
        ProjectDetailController.activeInstance = null;
        this.section = AdminController.VALID_SECTIONS.includes(params.section) ? params.section : 'overview';
        this.user = null;
        this.state = {
            projects: [],
            experiences: [],
            skills: [],
            education: [],
            profile: null
        };
    }

    execute() {
        const self = this;
        const R = UI.getRenderer();
        jQuery('.conteudo-interno').html(R.loadingState('Verificando sessão administrativa...'));

        AdminModel.checkSession()
            .done(function(res) {
                self.user = (res && res.user) || Model.getUser() || { username: 'admin' };
                self.loadData();
            })
            .fail(function() {
                window.location.hash = '#/login';
            });
    }

    loadData() {
        const self = this;
        const R = UI.getRenderer();

        jQuery.when(
            AdminModel.listProjects(),
            AdminModel.listExperiences(),
            AdminModel.listSkills(),
            AdminModel.listEducation(),
            AdminModel.getProfile()
        ).done(function(projRes, expRes, skillRes, eduRes, profRes) {
            self.state.projects = Array.isArray(projRes[0]) ? projRes[0] : [];
            self.state.experiences = Array.isArray(expRes[0]) ? expRes[0] : [];
            self.state.skills = Array.isArray(skillRes[0]) ? skillRes[0] : [];
            self.state.education = Array.isArray(eduRes[0]) ? eduRes[0] : [];
            self.state.profile = profRes[0] || {};

            if (typeof PortfolioShell !== 'undefined' && self.state.profile) {
                PortfolioShell.syncProfile(self.state.profile);
            }

            new AdminView({
                user: self.user,
                section: self.section,
                state: self.state,
                onReload: function(nextSection) {
                    if (nextSection) self.section = nextSection;
                    self.loadData();
                }
            });
        }).fail(function(xhr) {
            if (xhr && xhr.status === 401) {
                window.location.hash = '#/login';
                return;
            }
            jQuery('.conteudo-interno').html(R.errorState('Falha ao carregar os dados administrativos da API.', 'Tentar novamente'));
            jQuery('#pf-retry-btn').on('click', function() {
                self.loadData();
            });
        });
    }
}
