/**
 * HomeView — Monta a pagina inicial do portfolio compondo modulos reutilizaveis
 * via UI.getRenderer() (PortfolioRenderer / Bootstrap 5).
 */
class HomeView extends View {
    constructor(data, state = {}) {
        super();
        this.data = data;
        this.activeFilter = state.filter || 'all';
        this.onFilterChange = state.onFilterChange || null;
        this.render();
    }

    getRenderer() {
        return UI.getRenderer();
    }

    buildHeroResumeHref(profile) {
        const lang = PortfolioI18n.getLang();
        return Model.getBaseUrl() + 'resume/pdf?lang=' + encodeURIComponent(lang);
    }

    buildDynamicResumes() {
        const base = Model.getBaseUrl();
        const lang = PortfolioI18n.getLang();
        return [
            { lang: 'pt', label: 'Português PDF ↓', url: base + 'resume/pdf?lang=pt' },
            { lang: 'en', label: 'English PDF ↓', url: base + 'resume/pdf?lang=en' },
            { lang: 'es', label: 'Español PDF ↓', url: base + 'resume/pdf?lang=es' },
            { lang: 'preview', label: (lang === 'en' ? 'Preview A4 ↗' : (lang === 'es' ? 'Vista previa A4 ↗' : 'Visualizar A4 ↗')), url: base + 'resume/preview?lang=' + encodeURIComponent(lang), preview: true }
        ];
    }

    buildProjectCardData(p) {
        return {
            categoryLabel: PortfolioI18n.catLabel(p.category),
            categoryKey: p.category,
            statusLabel: PortfolioI18n.statusLabel(p.status),
            title: PortfolioI18n.pick(p.name),
            summary: PortfolioI18n.pick(p.summary),
            org: PortfolioI18n.pick(p.org),
            stack: PortfolioI18n.pick(p.stack),
            detailUrl: p.has_detail_page ? ('#/projeto/' + encodeURIComponent(p.slug)) : '',
            systemUrl: p.system_url || '',
            videoUrl: p.video_url || '',
            labels: {
                viewDetails: PortfolioI18n.t('viewDetails'),
                openSystem: PortfolioI18n.t('openSystem'),
                watchVideo: PortfolioI18n.t('watchVideo')
            }
        };
    }

    groupSkills(skills) {
        const map = new Map();
        (skills || []).forEach(s => {
            const key = s.category_key || 'other';
            if (!map.has(key)) {
                map.set(key, {
                    title: PortfolioI18n.pick(s.category, key),
                    items: []
                });
            }
            map.get(key).items.push(PortfolioI18n.pick(s.name));
        });
        return Array.from(map.values());
    }

    render() {
        const R = this.getRenderer();
        const profile = this.data.profile || {};
        const lang = PortfolioI18n.getLang();
        const summary = (profile.summary && (profile.summary[lang] || profile.summary.en)) || {};
        document.title = PortfolioI18n.t('pageTitle');

        // 00. Hero
        const heroHtml = R.heroSection({
            eyebrow: summary.eyebrow || '',
            titleHtml: summary.hero_title || '',
            lead: summary.hero_lead || '',
            primaryAction: {
                label: PortfolioI18n.t('download'),
                href: this.buildHeroResumeHref(profile),
                download: true
            },
            secondaryAction: {
                label: PortfolioI18n.t('explore'),
                href: '#/',
                attrs: { 'data-scroll-to': 'case-studies' }
            },
            metrics: (profile.metrics || []).map(m => ({
                value: m.value,
                label: PortfolioI18n.pick(m.label)
            })),
            asideLocation: PortfolioI18n.pick(profile.location),
            asideTag: summary.aside_tag || ''
        });

        // 01. About
        const aboutHtml = R.aboutSection({
            indexLabel: PortfolioI18n.t('navAbout'),
            titleHtml: summary.about_title || '',
            paragraphs: summary.about_paragraphs || [],
            valueTags: summary.value_tags || []
        });

        // 02. Experience (em ordem cronologica decrescente)
        const expItems = (this.data.experiences || []).map(e => ({
            period: PortfolioI18n.pick(e.period_label),
            company: e.company,
            role: PortfolioI18n.pick(e.role),
            description: PortfolioI18n.pick(e.description),
            tags: PortfolioI18n.pick(e.tags, [])
        }));
        const experienceHtml = R.experienceSection({
            indexLabel: PortfolioI18n.t('navExperience'),
            titleHtml: PortfolioI18n.t('expTitle'),
            subtitle: PortfolioI18n.t('expSubtitle'),
            items: expItems
        });

        // 03. Case Studies
        const cases = (this.data.case_studies || []).map((c, idx) => {
            const detail = PortfolioI18n.pick(c.detail, null);
            const stackText = PortfolioI18n.pick(c.stack, '');
            const tags = stackText ? stackText.split('·').map(s => s.trim()).filter(Boolean) : [];
            return {
                label: PortfolioI18n.pick(c.case_label),
                icon: c.case_icon || '↗',
                title: PortfolioI18n.pick(c.name),
                summary: PortfolioI18n.pick(c.summary),
                challenge: detail && detail.challenge ? detail.challenge : '',
                approach: detail && detail.approach ? detail.approach : '',
                challengeLabel: PortfolioI18n.t('challenge'),
                approachLabel: PortfolioI18n.t('approach'),
                tags: tags,
                isFeature: idx === 0,
                detailUrl: c.has_detail_page ? ('#/projeto/' + encodeURIComponent(c.slug)) : '',
                viewLabel: PortfolioI18n.t('viewDetails')
            };
        });
        const casesHtml = R.caseStudiesSection({
            indexLabel: PortfolioI18n.t('navCases'),
            titleHtml: PortfolioI18n.t('casesTitle'),
            subtitle: PortfolioI18n.t('casesSub'),
            cases: cases
        });

        // Featured Products (SATWA / Kreww)
        const promoTiles = (this.data.featured_projects || []).map(p => ({
            themeKey: p.theme_key || 'default',
            overline: PortfolioI18n.t('featuredOverline'),
            image: p.cover_image || '',
            alt: PortfolioI18n.pick(p.name),
            title: PortfolioI18n.pick(p.name),
            summary: PortfolioI18n.pick(p.summary),
            ctaText: PortfolioI18n.t('featuredCta'),
            href: '#/projeto/' + encodeURIComponent(p.slug)
        }));
        const featuredHtml = R.featuredProductsSection(promoTiles, PortfolioI18n.t('featuredOverline'));

        // 04. Portfolio + Other Tools (com filtro 'platform' e #otherToolsGrid garantido)
        const filterDefs = [
            { key: 'all', label: PortfolioI18n.t('all') },
            { key: 'enterprise', label: PortfolioI18n.t('enterprise') },
            { key: 'platform', label: PortfolioI18n.t('platform') },
            { key: 'product', label: PortfolioI18n.t('product') },
            { key: 'ai', label: PortfolioI18n.t('ai') },
            { key: 'opensource', label: PortfolioI18n.t('opensource') },
            { key: 'data', label: PortfolioI18n.t('data') },
            { key: 'tool', label: PortfolioI18n.t('tool') }
        ];
        const filtersHtml = R.filterBar(filterDefs, this.activeFilter);
        const mainCardsHtml = this.renderFilteredCardsHtml();
        const otherCardsHtml = (this.data.other_tools || [])
            .map(p => R.projectCard(this.buildProjectCardData(p)))
            .join('');
        const otherToolsHtml = R.otherToolsSection({
            title: PortfolioI18n.t('otherToolsTitle'),
            subtitle: PortfolioI18n.t('otherToolsSub'),
            cardsHtml: otherCardsHtml
        });
        const portfolioHtml = R.portfolioSection({
            indexLabel: PortfolioI18n.t('navPortfolio'),
            titleHtml: PortfolioI18n.t('portfolioTitle'),
            subtitle: PortfolioI18n.t('portfolioSub'),
            filtersHtml: filtersHtml,
            cardsHtml: mainCardsHtml,
            otherToolsHtml: otherToolsHtml,
            note: PortfolioI18n.t('portfolioNote')
        });

        // 05. Principles
        const principlesHtml = R.principlesSection({
            indexLabel: PortfolioI18n.t('principles'),
            titleHtml: PortfolioI18n.t('principlesTitle'),
            items: (profile.principles || []).map(p => ({
                num: p.num,
                title: PortfolioI18n.pick(p.title),
                desc: PortfolioI18n.pick(p.desc)
            }))
        });

        // 06. Background: Skills + Education + Courses + Languages
        const credentialsHtml = R.credentialsSection({
            indexLabel: PortfolioI18n.t('background'),
            titleHtml: PortfolioI18n.t('skillsTitle'),
            desc: PortfolioI18n.t('skillsDesc'),
            skillGroups: this.groupSkills(this.data.skills),
            educationTitle: PortfolioI18n.t('education'),
            degrees: (this.data.education || []).map(d => ({
                title: PortfolioI18n.pick(d.title),
                institution: d.institution,
                period: d.period_label,
                details: PortfolioI18n.pick(d.details)
            })),
            coursesTitle: PortfolioI18n.t('courses'),
            courses: (this.data.courses || []).map(c => ({
                title: PortfolioI18n.pick(c.title),
                institution: c.institution
            })),
            languagesTitle: PortfolioI18n.t('languages'),
            languagesText: PortfolioI18n.pick(profile.languages)
        });

        // 07. Contact
        const contactProfile = Object.assign({}, profile, { resumes: this.buildDynamicResumes() });
        const contactHtml = R.contactSection({
            indexLabel: PortfolioI18n.t('navContact'),
            titleHtml: PortfolioI18n.t('contactTitle'),
            desc: PortfolioI18n.t('contactDesc'),
            availability: PortfolioI18n.pick(profile.availability),
            profile: contactProfile,
            resumesTitle: PortfolioI18n.t('resumes')
        });

        jQuery('.conteudo-interno').html(
            heroHtml +
            aboutHtml +
            experienceHtml +
            casesHtml +
            featuredHtml +
            portfolioHtml +
            principlesHtml +
            credentialsHtml +
            contactHtml
        );

        this.bindEvents();
    }

    renderFilteredCardsHtml() {
        const R = this.getRenderer();
        const projects = this.data.projects || [];
        const visible = projects.filter(p => this.activeFilter === 'all' || p.category === this.activeFilter);
        return visible.map(p => R.projectCard(this.buildProjectCardData(p))).join('');
    }

    bindEvents() {
        const self = this;
        jQuery('#filters').off('click', '.pf-filter-btn').on('click', '.pf-filter-btn', function() {
            const nextFilter = jQuery(this).data('filter');
            self.activeFilter = nextFilter;
            jQuery('#filters .pf-filter-btn').removeClass('active');
            jQuery(this).addClass('active');
            jQuery('#portfolioGrid').html(self.renderFilteredCardsHtml());
            if (typeof self.onFilterChange === 'function') {
                self.onFilterChange(nextFilter);
            }
        });

        jQuery('[data-scroll-to]').off('click').on('click', function(e) {
            e.preventDefault();
            const targetId = jQuery(this).data('scroll-to');
            const el = document.getElementById(targetId);
            if (el) el.scrollIntoView({ behavior: 'smooth' });
        });
    }
}
