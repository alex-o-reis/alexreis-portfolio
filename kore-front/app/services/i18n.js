/**
 * PortfolioI18n — Servico de internacionalizacao (PT / EN / ES) e helpers de midia.
 */
const PortfolioI18n = {
    STORAGE_KEY: 'alex-lang',
    SUPPORTED: ['pt', 'en', 'es'],
    _lang: 'en',
    _listeners: [],

    dict: {
        en: {
            pageTitle: 'Alex Reis — Engineering Leadership & Architecture',
            navAbout: 'About',
            navExperience: 'Experience',
            navCases: 'Case studies',
            navPortfolio: 'Portfolio',
            navContact: 'Contact',
            download: 'Download résumé',
            explore: 'Explore my work',
            expTitle: 'From building software to <em>building capabilities.</em>',
            expSubtitle: 'Chronological progression of roles, leadership and lasting outcomes.',
            casesTitle: 'Decisions, trade-offs <em>and impact.</em>',
            casesSub: 'Selected engineering stories, from legacy modernization to organizational change.',
            challenge: 'THE CHALLENGE',
            approach: 'THE APPROACH',
            featuredOverline: 'FEATURED PRODUCT',
            featuredCta: 'Explore product ↗',
            portfolioTitle: 'A lifetime of building. <em>Still evolving.</em>',
            portfolioSub: 'Enterprise platforms, independent products, AI agents and open-source engineering. Status distinguishes released work from projects in development.',
            all: 'All projects',
            enterprise: 'Enterprise',
            platform: 'Platforms',
            product: 'Products',
            ai: 'AI',
            opensource: 'Open source',
            data: 'Data',
            tool: 'Tools',
            portfolioNote: 'Descriptions reflect current project stages. Development-stage products are not presented as commercially released.',
            otherToolsTitle: 'Other tools',
            otherToolsSub: 'Compact utilities and experiments published through Kodey / Kodes are listed separately below.',
            principles: 'Principles',
            principlesTitle: 'Engineering is a series of <em>informed choices.</em>',
            background: 'Background',
            skillsTitle: 'Technology with <em>purpose.</em>',
            skillsDesc: 'Hands-on knowledge across software architecture, enterprise integration, BPM, cloud, mobile and AI. Tools are chosen to fit the problem, not the other way around.',
            education: 'Education',
            courses: 'Complementary courses',
            languages: 'Languages',
            contactTitle: 'Let’s build what <em>comes next.</em>',
            contactDesc: 'Open to meaningful conversations about engineering leadership, architecture and complex platforms.',
            resumes: 'RÉSUMÉ DOWNLOADS',
            footer: 'Designed to evolve, just like good software.',
            backTop: '↑ TOP',
            backPortfolio: '← Back to portfolio',
            viewDetails: 'View details',
            openSystem: 'Open system',
            watchVideo: 'Watch video',
            videoSectionTitle: 'Product walkthrough video',
            exploreMore: 'Explore other projects ↗',
            loading: 'Loading portfolio...',
            errorLoad: 'Unable to load portfolio data from API.',
            retry: 'Try again',
            notFoundTitle: 'Project not found',
            notFoundDesc: 'The requested project page does not exist or is not published.',
            categories: {
                enterprise: 'ENTERPRISE',
                platform: 'PLATFORM',
                product: 'PRODUCT',
                ai: 'AI',
                opensource: 'OPEN SOURCE',
                data: 'DATA',
                tool: 'TOOL',
                othertool: 'OTHER TOOL'
            },
            statuses: {
                delivered: 'DELIVERED',
                evolving: 'EVOLVING',
                development: 'IN DEVELOPMENT',
                published: 'PUBLISHED',
                public: 'PUBLIC'
            }
        },
        pt: {
            pageTitle: 'Alex Reis — Liderança de Engenharia e Arquitetura',
            navAbout: 'Sobre',
            navExperience: 'Experiência',
            navCases: 'Estudos de caso',
            navPortfolio: 'Portfólio',
            navContact: 'Contato',
            download: 'Baixar currículo',
            explore: 'Conheça os projetos',
            expTitle: 'De criar software a <em>construir capacidades.</em>',
            expSubtitle: 'Trajetória cronológica de funções, liderança técnica e resultados duradouros.',
            casesTitle: 'Decisões, concessões <em>e impacto.</em>',
            casesSub: 'Histórias selecionadas de engenharia, modernização de legados e mudança organizacional.',
            challenge: 'O DESAFIO',
            approach: 'A ABORDAGEM',
            featuredOverline: 'PRODUTO EM DESTAQUE',
            featuredCta: 'Conhecer produto ↗',
            portfolioTitle: 'Uma trajetória de construção. <em>Em evolução constante.</em>',
            portfolioSub: 'Plataformas corporativas, produtos independentes, agentes de IA e engenharia open source. Cada projeto indica seu estágio atual.',
            all: 'Todos',
            enterprise: 'Corporativos',
            platform: 'Plataformas',
            product: 'Produtos',
            ai: 'IA',
            opensource: 'Open source',
            data: 'Dados',
            tool: 'Ferramentas',
            portfolioNote: 'As descrições refletem o estágio atual de cada iniciativa. Projetos em desenvolvimento não são apresentados como comercialmente lançados.',
            otherToolsTitle: 'Outras ferramentas',
            otherToolsSub: 'Utilitários e experimentos publicados em Kodey / Kodes ficam listados separadamente abaixo.',
            principles: 'Princípios',
            principlesTitle: 'Engenharia é uma sequência de <em>escolhas conscientes.</em>',
            background: 'Base técnica',
            skillsTitle: 'Tecnologia com <em>propósito.</em>',
            skillsDesc: 'Atuação prática em arquitetura de software, integração corporativa, BPM, cloud, mobile e IA. As ferramentas são escolhidas conforme o problema, e não o contrário.',
            education: 'Formação',
            courses: 'Cursos complementares',
            languages: 'Idiomas',
            contactTitle: 'Vamos construir o <em>próximo passo.</em>',
            contactDesc: 'Aberto a conversas relevantes sobre liderança de engenharia, arquitetura e plataformas complexas.',
            resumes: 'DOWNLOADS DO CURRÍCULO',
            footer: 'Projetado para evoluir, como todo bom software.',
            backTop: '↑ TOPO',
            backPortfolio: '← Voltar ao portfólio',
            viewDetails: 'Ver detalhes',
            openSystem: 'Acessar sistema',
            watchVideo: 'Ver vídeo',
            videoSectionTitle: 'Vídeo explicativo',
            exploreMore: 'Explorar outros projetos ↗',
            loading: 'Carregando portfólio...',
            errorLoad: 'Não foi possível carregar os dados do portfólio a partir da API.',
            retry: 'Tentar novamente',
            notFoundTitle: 'Projeto não encontrado',
            notFoundDesc: 'A página do projeto solicitado não existe ou não está publicada.',
            categories: {
                enterprise: 'CORPORATIVO',
                platform: 'PLATAFORMA',
                product: 'PRODUTO',
                ai: 'IA',
                opensource: 'OPEN SOURCE',
                data: 'DADOS',
                tool: 'FERRAMENTA',
                othertool: 'OUTRA FERRAMENTA'
            },
            statuses: {
                delivered: 'ENTREGUE',
                evolving: 'EM EVOLUÇÃO',
                development: 'EM DESENVOLVIMENTO',
                published: 'PUBLICADO',
                public: 'PÚBLICO'
            }
        },
        es: {
            pageTitle: 'Alex Reis — Liderazgo de Ingeniería y Arquitectura',
            navAbout: 'Acerca de',
            navExperience: 'Experiencia',
            navCases: 'Casos de estudio',
            navPortfolio: 'Portafolio',
            navContact: 'Contacto',
            download: 'Descargar currículum',
            explore: 'Explorar proyectos',
            expTitle: 'De construir software a <em>construir capacidades.</em>',
            expSubtitle: 'Evolución cronológica de roles, liderazgo técnico y resultados duraderos.',
            casesTitle: 'Decisiones, compromisos <em>e impacto.</em>',
            casesSub: 'Historias seleccionadas de ingeniería, modernización de legados y cambio organizacional.',
            challenge: 'EL DESAFÍO',
            approach: 'EL ENFOQUE',
            featuredOverline: 'PRODUCTO DESTACADO',
            featuredCta: 'Conocer producto ↗',
            portfolioTitle: 'Una trayectoria construyendo. <em>En evolución constante.</em>',
            portfolioSub: 'Plataformas corporativas, productos independientes, agentes de IA e ingeniería open source. Cada proyecto indica su etapa actual.',
            all: 'Todos',
            enterprise: 'Corporativos',
            platform: 'Plataformas',
            product: 'Productos',
            ai: 'IA',
            opensource: 'Open source',
            data: 'Datos',
            tool: 'Herramientas',
            portfolioNote: 'Las descripciones reflejan el estado actual de cada iniciativa. Los proyectos en desarrollo no se presentan como lanzados comercialmente.',
            otherToolsTitle: 'Otras herramientas',
            otherToolsSub: 'Utilidades y experimentos publicados a través de Kodey / Kodes aparecen listados por separado abajo.',
            principles: 'Principios',
            principlesTitle: 'La ingeniería es una serie de <em>decisiones conscientes.</em>',
            background: 'Base técnica',
            skillsTitle: 'Tecnología con <em>propósito.</em>',
            skillsDesc: 'Experiencia práctica en arquitectura de software, integración empresarial, BPM, cloud, móvil e IA. Las herramientas se eligen según el problema, no al revés.',
            education: 'Formación',
            courses: 'Cursos complementarios',
            languages: 'Idiomas',
            contactTitle: 'Construyamos lo que <em>viene después.</em>',
            contactDesc: 'Abierto a conversaciones relevantes sobre liderazgo de ingeniería, arquitectura y plataformas complejas.',
            resumes: 'DESCARGAS DE CURRÍCULUM',
            footer: 'Diseñado para evolucionar, como todo buen software.',
            backTop: '↑ ARRIBA',
            backPortfolio: '← Volver al portafolio',
            viewDetails: 'Ver detalles',
            openSystem: 'Abrir sistema',
            watchVideo: 'Ver video',
            videoSectionTitle: 'Video explicativo',
            exploreMore: 'Explorar otros proyectos ↗',
            loading: 'Cargando portafolio...',
            errorLoad: 'No fue posible cargar los datos del portafolio desde la API.',
            retry: 'Reintentar',
            notFoundTitle: 'Proyecto no encontrado',
            notFoundDesc: 'La página del proyecto solicitado no existe o no está publicada.',
            categories: {
                enterprise: 'CORPORATIVO',
                platform: 'PLATAFORMA',
                product: 'PRODUCTO',
                ai: 'IA',
                opensource: 'OPEN SOURCE',
                data: 'DATOS',
                tool: 'HERRAMIENTA',
                othertool: 'OTRA HERRAMIENTA'
            },
            statuses: {
                delivered: 'ENTREGADO',
                evolving: 'EN EVOLUCIÓN',
                development: 'EN DESARROLLO',
                published: 'PUBLICADO',
                public: 'PÚBLICO'
            }
        }
    },

    init() {
        try {
            let saved = localStorage.getItem(this.STORAGE_KEY);
            if (saved && this.SUPPORTED.includes(saved)) {
                this._lang = saved;
            }
        } catch (e) {}
        this.syncDocumentLang();
        return this._lang;
    },

    getLang() {
        return this._lang;
    },

    setLang(lang) {
        if (!this.SUPPORTED.includes(lang)) return;
        this._lang = lang;
        try {
            localStorage.setItem(this.STORAGE_KEY, lang);
        } catch (e) {}
        this.syncDocumentLang();
        this._listeners.forEach(fn => fn(lang));
    },

    onChange(fn) {
        if (typeof fn === 'function') {
            this._listeners.push(fn);
        }
    },

    syncDocumentLang() {
        const htmlLang = this._lang === 'pt' ? 'pt-BR' : this._lang;
        document.documentElement.lang = htmlLang;
        document.title = this.t('pageTitle');
    },

    t(key) {
        const current = this.dict[this._lang] || this.dict.en;
        return current[key] !== undefined ? current[key] : (this.dict.en[key] || key);
    },

    catLabel(catKey) {
        const current = this.dict[this._lang] || this.dict.en;
        return (current.categories && current.categories[catKey]) || catKey;
    },

    statusLabel(statusKey) {
        const current = this.dict[this._lang] || this.dict.en;
        return (current.statuses && current.statuses[statusKey]) || statusKey;
    },

    pick(localizedObj, fallback = '') {
        if (!localizedObj) return fallback;
        if (typeof localizedObj === 'string') return localizedObj;
        return localizedObj[this._lang] || localizedObj.en || localizedObj.pt || localizedObj.es || fallback;
    },

    escapeHtml(str) {
        return String(str || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    },

    parseVideoUrl(url) {
        if (!url) return null;
        const trimmed = String(url).trim();
        if (!trimmed) return null;

        // YouTube (watch?v=, youtu.be/, embed/)
        let yt = trimmed.match(/(?:youtube\.com\/(?:watch\?v=|embed\/|shorts\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/);
        if (yt) {
            return { type: 'iframe', src: 'https://www.youtube-nocookie.com/embed/' + yt[1] };
        }
        // Vimeo
        let vm = trimmed.match(/vimeo\.com\/(?:video\/)?(\d+)/);
        if (vm) {
            return { type: 'iframe', src: 'https://player.vimeo.com/video/' + vm[1] };
        }
        // Direct HTML5 video
        if (/\.(mp4|webm|ogg)(\?.*)?$/i.test(trimmed)) {
            return { type: 'video', src: trimmed };
        }
        return { type: 'link', src: trimmed };
    }
};
