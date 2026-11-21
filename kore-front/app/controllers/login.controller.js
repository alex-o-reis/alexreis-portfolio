/**
 * LoginController — Controlador de autenticacao para o painel administrativo (#/login).
 */
class LoginController extends Controller {
    constructor(params = {}) {
        super(params);
        HomeController.activeInstance = null;
        ProjectDetailController.activeInstance = null;
    }

    execute() {
        const token = Model.getToken();
        if (token) {
            AdminModel.checkSession()
                .done(function() {
                    window.location.hash = '#/admin';
                })
                .fail(function() {
                    new LoginView();
                });
            return;
        }
        new LoginView();
    }
}
