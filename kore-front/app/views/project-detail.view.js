/**
 * ProjectDetailView — Pagina explicativa dinamica para qualquer projeto (#/projeto/:slug).
 * Reutiliza os modulos Bootstrap do PortfolioRenderer e ja suporta system_url e video_url.
 */
class ProjectDetailView extends View {
    constructor(project) {
        super();
        this.project = project;
        this.render();
    }

    render() {
        const R = UI.getRenderer();
        const p = this.project;
        const themeClass = 'pf-detail-' + (p.theme_key || 'default');
        const detail = PortfolioI18n.pick(p.detail, {}) || {};
        const name = PortfolioI18n.pick(p.name);
        const summary = PortfolioI18n.pick(p.summary);

        document.title = name + ' — Alex Reis | Portfolio';

        const heroHtml = R.projectDetailHero({
            eyebrow: detail.eyebrow || PortfolioI18n.catLabel(p.category),
            headlineHtml: detail.headline || PortfolioI18n.escapeHtml(name),
            lead: detail.lead || summary,
            sublead: detail.sublead || '',
            coverImage: p.cover_image || '',
            coverAlt: name,
            systemUrl: p.system_url || '',
            openSystemLabel: PortfolioI18n.t('openSystem'),
            backLabel: PortfolioI18n.t('backPortfolio'),
            statusLabel: PortfolioI18n.statusLabel(p.status),
            org: PortfolioI18n.pick(p.org),
            stack: PortfolioI18n.pick(p.stack)
        });

        const barHtml = R.projectBannerBar(detail.bar_title, detail.bar_subtitle);

        const challengeHtml = R.projectChallengeApproach({
            challengeLabel: PortfolioI18n.t('challenge'),
            challenge: detail.challenge || '',
            approachLabel: PortfolioI18n.t('approach'),
            approach: detail.approach || ''
        });

        const videoHtml = R.videoPlayerSection(
            PortfolioI18n.t('videoSectionTitle'),
            p.video_url || ''
        );

        const featuresHtml = R.projectFeatureGrid({
            eyebrow: detail.intro_eyebrow || '',
            title: detail.intro_title || '',
            introText: detail.intro_text || '',
            features: detail.features || []
        });

        const pillarsHtml = R.projectPillarsSection({
            eyebrow: detail.pillars_eyebrow || '',
            title: detail.pillars_title || '',
            pillars: detail.pillars || []
        });

        const disclaimerHtml = R.disclaimerBox(detail.disclaimer || '');

        jQuery('.conteudo-interno').html(
            R.div(
                themeClass,
                heroHtml + barHtml + challengeHtml + videoHtml + featuresHtml + pillarsHtml + disclaimerHtml
            )
        );

        window.scrollTo({ top: 0, behavior: 'instant' });
    }
}
