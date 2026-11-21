/**
 * LoginView — Tela de login Bootstrap 5 dentro do layout principal do portfolio.
 */
class LoginView extends View {
    constructor() {
        super();
        this.render();
    }

    render() {
        document.title = 'Admin Login — Alex Reis';
        jQuery('.conteudo-interno').html(AdminRenderer.loginCard());

        jQuery('#kore-login-form').off('submit').on('submit', function(e) {
            e.preventDefault();
            const username = jQuery('#login-username').val().trim();
            const password = jQuery('#login-password').val();
            const $err = jQuery('#admin-login-error');
            const $btn = jQuery('#btn-login-submit');

            $err.addClass('d-none').text('');
            $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Entrando...');

            Model.authenticate(username, password)
                .done(function() {
                    window.location.hash = '#/admin';
                })
                .fail(function(xhr) {
                    const msg = (xhr.responseJSON && xhr.responseJSON.error) || 'Usuário ou senha inválidos.';
                    $err.removeClass('d-none').text(msg);
                    $btn.prop('disabled', false).html('<i class="bi bi-shield-lock me-2"></i>Entrar no Painel');
                });
        });
    }
}
