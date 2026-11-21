/**
 * Configuracao Geral da Aplicacao Frontend (Userspace) — Alex Reis Portfolio
 */
const KoreConfig = {
    APP_NAME: 'Alex Reis — Portfolio',
    API_URL: window.KORE_API_URL || 'http://localhost:8000/',
    DEFAULT_ROUTE: '#/',
    TEMPLATE_PATH: 'templates/portfolio/template.html',

    // Rotas SPA da Aplicacao
    ROUTES: [
        { url: '#/', controller: 'HomeController' },
        { url: '#/projeto/:slug', controller: 'ProjectDetailController' },
        // Rota reservada para o painel administrativo da Fase 2
        { url: '#/login', controller: 'LoginController' }
    ],

    // Menu reservado para o painel administrativo futuro (Fase 2)
    MENU: []
};
