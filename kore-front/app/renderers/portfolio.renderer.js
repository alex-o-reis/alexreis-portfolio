/**
 * PortfolioRenderer — Renderer customizado baseado em Bootstrap 5 para o Kore Framework.
 * Estende BootstrapRenderer (sem alterar kore/) e modulariza cada bloco visual do portfólio
 * em componentes reutilizáveis.
 */
class PortfolioRenderer extends BootstrapRenderer {
    constructor() {
        super('Portfolio Bootstrap 5');
    }

    // --- Componentes Atomicos Reutilizaveis ---

    sectionIndex(num, label) {
        return this.div(
            'pf-section-index mb-3',
            this.span('', `${num} / ${PortfolioI18n.escapeHtml(label)}`)
        );
    }

    sectionHead(titleHtml, subtitle = '') {
        let left = this.col('lg-8', this.h2(titleHtml, 'pf-section-title mb-0'));
        let right = subtitle
            ? this.col('lg-4 d-flex align-items-lg-end justify-content-lg-end', this.p(PortfolioI18n.escapeHtml(subtitle), 'pf-section-subtitle mb-0'))
            : '';
        return this.div('row g-4 align-items-end mb-5', left + right);
    }

    pillList(items = [], extraClass = '') {
        if (!Array.isArray(items) || !items.length) return '';
        let html = items.map(item =>
            this.span('pf-pill ' + extraClass, PortfolioI18n.escapeHtml(item))
        ).join('');
        return this.div('d-flex flex-wrap gap-2', html);
    }

    loadingState(text) {
        return this.div(
            'container pf-container py-5 my-5 text-center',
            this.div('spinner-border text-secondary mb-3', '', { role: 'status' }) +
            this.p(PortfolioI18n.escapeHtml(text), 'text-muted mb-0')
        );
    }

    errorState(message, retryText) {
        return this.div(
            'container pf-container py-5 my-5 text-center',
            this.div('alert alert-warning d-inline-block px-4 py-3 text-start',
                this.div('fw-bold mb-2', '<i class="bi bi-exclamation-triangle me-2"></i>' + PortfolioI18n.escapeHtml(message)) +
                this.button('pf-retry-btn', PortfolioI18n.escapeHtml(retryText), 'btn-dark btn-sm')
            )
        );
    }

    // --- Secao 00: Hero ---

    heroSection({ eyebrow, titleHtml, lead, primaryAction, secondaryAction, metrics = [], asideLocation, asideTag }) {
        let eyebrowEl = this.div('pf-eyebrow', this.span('pf-pulse') + this.span('', PortfolioI18n.escapeHtml(eyebrow)));
        let titleEl = this.h1(titleHtml, 'pf-hero-title');
        let leadEl = this.p(PortfolioI18n.escapeHtml(lead), 'pf-hero-lead mb-4');

        let primaryBtn = this.a(
            this.span('', PortfolioI18n.escapeHtml(primaryAction.label)) + this.span('', '↗'),
            primaryAction.href,
            '_self',
            'pf-btn-primary',
            primaryAction.download ? { download: '' } : {}
        );
        let secondaryBtn = this.a(
            this.span('', PortfolioI18n.escapeHtml(secondaryAction.label)) + this.span('', '↘'),
            secondaryAction.href,
            '_self',
            'pf-btn-secondary',
            secondaryAction.attrs || {}
        );
        let actionsEl = this.div('d-flex flex-wrap gap-3 my-4 pt-1', primaryBtn + secondaryBtn);

        let metricsHtml = metrics.map(m =>
            this.div('pf-metric-item', this.b(PortfolioI18n.escapeHtml(m.value)) + this.span('', PortfolioI18n.escapeHtml(m.label)))
        ).join('');
        let metricsRow = this.div('d-flex flex-wrap gap-4 mt-4 pt-2', metricsHtml);

        let leftCol = this.div('col-lg-7', eyebrowEl + titleEl + leadEl + actionsEl + metricsRow);

        let asideFoot = this.div(
            'pf-aside-foot d-flex justify-content-between align-items-center gap-2',
            this.span('', PortfolioI18n.escapeHtml(asideLocation)) +
            this.span('', PortfolioI18n.escapeHtml(asideTag))
        );
        let asideCard = this.div(
            'pf-hero-aside d-flex align-items-center justify-content-center',
            this.div('pf-orbit') +
            this.div('pf-orbit pf-orbit-2') +
            this.div('pf-monogram', 'AR' + this.span('', '_')) +
            asideFoot
        );
        let rightCol = this.div('col-lg-5', asideCard);

        return this.element(
            'section',
            { class: 'pf-hero' },
            this.div('container pf-container', this.div('row g-5 align-items-center', leftCol + rightCol))
        );
    }

    // --- Secao 01: Sobre ---

    aboutSection({ indexLabel, titleHtml, paragraphs = [], valueTags = [] }) {
        let left = this.div(
            'col-lg-5',
            this.sectionIndex('01', indexLabel) +
            this.h2(titleHtml, 'pf-section-title mt-3')
        );

        let pHtml = paragraphs.map(text => this.p(PortfolioI18n.escapeHtml(text), 'pf-about-text mb-3')).join('');
        let tagsHtml = this.div(
            'd-flex flex-wrap gap-2 mt-4',
            valueTags.map(tag => this.span('pf-value-tag', PortfolioI18n.escapeHtml(tag))).join('')
        );
        let right = this.div('col-lg-7', pHtml + tagsHtml);

        return this.element(
            'section',
            { id: 'about', class: 'pf-section pf-section-dark' },
            this.div('container pf-container', this.div('row g-5', left + right))
        );
    }

    // --- Secao 02: Experiencia Profissional ---

    timelineItem({ period, company, role, description, tags = [] }) {
        let dateCol = this.div('col-md-3', this.div('pf-job-date pt-1', PortfolioI18n.escapeHtml(period)));
        let bodyCol = this.div(
            'col-md-9',
            this.h3(PortfolioI18n.escapeHtml(company), 'pf-job-company mb-2') +
            this.div('pf-job-role mb-3', PortfolioI18n.escapeHtml(role)) +
            this.p(PortfolioI18n.escapeHtml(description), 'pf-job-desc mb-3') +
            this.pillList(tags)
        );
        return this.element('article', { class: 'pf-job-row' }, this.div('row g-3', dateCol + bodyCol));
    }

    experienceSection({ indexLabel, titleHtml, subtitle, items = [] }) {
        let listHtml = items.map(it => this.timelineItem(it)).join('');
        return this.element(
            'section',
            { id: 'experience', class: 'pf-section' },
            this.div(
                'container pf-container',
                this.sectionIndex('02', indexLabel) +
                this.sectionHead(titleHtml, subtitle) +
                this.div('pf-timeline', listHtml)
            )
        );
    }

    // --- Secao 03: Estudos de Caso ---

    caseStudyCard({ label, icon, title, summary, challenge, approach, challengeLabel, approachLabel, tags = [], isFeature = false, detailUrl = '', viewLabel = '' }) {
        let detailBlock = '';
        if (challenge) {
            detailBlock += this.div('row g-2 mb-2 align-items-baseline',
                this.div('col-sm-4 pf-case-detail-label', PortfolioI18n.escapeHtml(challengeLabel)) +
                this.div('col-sm-8 pf-case-detail-text', PortfolioI18n.escapeHtml(challenge))
            );
        }
        if (approach) {
            detailBlock += this.div('row g-2 mb-3 align-items-baseline',
                this.div('col-sm-4 pf-case-detail-label', PortfolioI18n.escapeHtml(approachLabel)) +
                this.div('col-sm-8 pf-case-detail-text', PortfolioI18n.escapeHtml(approach))
            );
        }

        let actionHtml = detailUrl
            ? this.div('mt-3', this.a(PortfolioI18n.escapeHtml(viewLabel) + ' ↗', detailUrl, '_self', 'pf-case-link'))
            : '';

        let cardInner =
            this.div('pf-case-label', PortfolioI18n.escapeHtml(label)) +
            this.div('pf-case-icon', PortfolioI18n.escapeHtml(icon || '↗')) +
            this.h3(PortfolioI18n.escapeHtml(title)) +
            this.p(PortfolioI18n.escapeHtml(summary), 'mb-3') +
            detailBlock +
            this.div('mt-auto pt-3', this.pillList(tags) + actionHtml);

        return this.div(
            'col-lg-6',
            this.element('article', { class: 'pf-case-card ' + (isFeature ? 'pf-case-feature' : '') }, cardInner)
        );
    }

    caseStudiesSection({ indexLabel, titleHtml, subtitle, cases = [] }) {
        let grid = this.div('row g-4', cases.map(c => this.caseStudyCard(c)).join(''));
        return this.element(
            'section',
            { id: 'case-studies', class: 'pf-section pf-section-soft' },
            this.div(
                'container pf-container',
                this.sectionIndex('03', indexLabel) +
                this.sectionHead(titleHtml, subtitle) +
                grid
            )
        );
    }

    // --- Produtos em Destaque (SATWA / Kreww / futuros) ---

    promoTile({ themeKey = 'default', overline, image, alt, title, summary, ctaText, href }) {
        let themeClass = themeKey === 'satwa'
            ? 'pf-promo-satwa'
            : (themeKey === 'kreww' ? 'pf-promo-kreww' : 'pf-promo-default');

        let imgHtml = image
            ? this.img(image, PortfolioI18n.escapeHtml(alt || title), 'pf-promo-img')
            : '';

        let tile = this.a(
            this.span('pf-promo-overline', PortfolioI18n.escapeHtml(overline)) +
            imgHtml +
            this.strong(PortfolioI18n.escapeHtml(title)) +
            this.p(PortfolioI18n.escapeHtml(summary)) +
            this.span('pf-promo-cta', PortfolioI18n.escapeHtml(ctaText)),
            href,
            '_self',
            'pf-promo-tile ' + themeClass
        );
        return this.div('col-md-6', tile);
    }

    featuredProductsSection(tiles = [], ariaLabel = 'Featured products') {
        if (!tiles.length) return '';
        return this.element(
            'section',
            { class: 'pt-5 pb-2', 'aria-label': PortfolioI18n.escapeHtml(ariaLabel) },
            this.div('container pf-container', this.div('row g-4', tiles.map(t => this.promoTile(t)).join('')))
        );
    }

    // --- Secao 04: Portfolio & Outras Ferramentas ---

    filterBar(filters = [], activeFilter = 'all') {
        let btns = filters.map(f => {
            let activeClass = f.key === activeFilter ? ' active' : '';
            return this.element('button', {
                type: 'button',
                class: 'pf-filter-btn' + activeClass,
                'data-filter': f.key
            }, PortfolioI18n.escapeHtml(f.label));
        }).join('');
        return this.div('d-flex flex-wrap gap-2 mb-4', btns, { id: 'filters' });
    }

    projectCard({ categoryLabel, categoryKey, statusLabel, title, summary, org, stack, detailUrl, systemUrl, videoUrl, labels }) {
        let catClass = 'pf-project-cat' + (categoryKey === 'othertool' ? ' pf-project-cat-other' : '');
        let top = this.div(
            'd-flex align-items-center justify-content-between gap-2',
            this.span(catClass, PortfolioI18n.escapeHtml(categoryLabel)) +
            this.span('pf-project-status', PortfolioI18n.escapeHtml(statusLabel))
        );

        let links = [];
        if (detailUrl) {
            links.push(this.a(PortfolioI18n.escapeHtml(labels.viewDetails) + ' ↗', detailUrl, '_self', 'pf-project-action'));
        }
        if (systemUrl) {
            links.push(this.a(PortfolioI18n.escapeHtml(labels.openSystem) + ' ↗', systemUrl, '_blank', 'pf-project-action', { rel: 'noopener noreferrer' }));
        }
        if (videoUrl && !detailUrl) {
            links.push(this.a('<i class="bi bi-play-circle me-1"></i>' + PortfolioI18n.escapeHtml(labels.watchVideo), videoUrl, '_blank', 'pf-project-action', { rel: 'noopener noreferrer' }));
        } else if (videoUrl && detailUrl) {
            links.push(this.a('<i class="bi bi-play-circle me-1"></i>' + PortfolioI18n.escapeHtml(labels.watchVideo), detailUrl, '_self', 'pf-project-action'));
        }

        let linksHtml = links.length ? this.div('d-flex flex-wrap gap-3 mt-2 pt-1', links.join('')) : '';

        let foot = this.div(
            'pf-project-foot',
            this.b(PortfolioI18n.escapeHtml(org)) +
            this.span('', PortfolioI18n.escapeHtml(stack)) +
            linksHtml
        );

        let card = this.element(
            'article',
            { class: 'pf-project-card' },
            top +
            this.h3(PortfolioI18n.escapeHtml(title)) +
            this.p(PortfolioI18n.escapeHtml(summary)) +
            foot
        );

        return this.div('col-md-6 col-lg-4', card);
    }

    otherToolsSection({ title, subtitle, cardsHtml }) {
        let head = this.div(
            'row g-3 align-items-end mb-4',
            this.div('col-md-5', this.h3(PortfolioI18n.escapeHtml(title), 'fw-bold mb-0')) +
            this.div('col-md-7 text-md-end', this.p(PortfolioI18n.escapeHtml(subtitle), 'text-muted small mb-0'))
        );
        return this.div(
            'pf-other-tools-block',
            head + this.div('row g-3', cardsHtml, { id: 'otherToolsGrid' })
        );
    }

    portfolioSection({ indexLabel, titleHtml, subtitle, filtersHtml, cardsHtml, otherToolsHtml, note }) {
        return this.element(
            'section',
            { id: 'portfolio', class: 'pf-section' },
            this.div(
                'container pf-container',
                this.sectionIndex('04', indexLabel) +
                this.sectionHead(titleHtml, subtitle) +
                filtersHtml +
                this.div('row g-3', cardsHtml, { id: 'portfolioGrid' }) +
                otherToolsHtml +
                this.p(PortfolioI18n.escapeHtml(note), 'pf-portfolio-note mt-4 mb-0')
            )
        );
    }

    // --- Secao 05: Principios ---

    principleCard({ num, title, desc }) {
        return this.div(
            'col-md-4',
            this.div(
                'pf-principle-box',
                this.span('pf-principle-num', PortfolioI18n.escapeHtml(num)) +
                this.h3(PortfolioI18n.escapeHtml(title)) +
                this.p(PortfolioI18n.escapeHtml(desc), 'mb-0')
            )
        );
    }

    principlesSection({ indexLabel, titleHtml, items = [] }) {
        return this.element(
            'section',
            { class: 'pf-section pf-section-dark' },
            this.div(
                'container pf-container',
                this.sectionIndex('05', indexLabel) +
                this.h2(titleHtml, 'pf-section-title mt-3 mb-5') +
                this.div('row g-4', items.map(p => this.principleCard(p)).join(''))
            )
        );
    }

    // --- Secao 06: Base Tecnica, Skills, Formacao e Cursos ---

    skillGroupBlock(groupTitle, skills = []) {
        let chips = skills.map(s => this.span('pf-skill-chip', PortfolioI18n.escapeHtml(s))).join('');
        return this.div(
            'mb-3',
            this.div('pf-skill-group-title', PortfolioI18n.escapeHtml(groupTitle)) +
            this.div('d-flex flex-wrap gap-2', chips)
        );
    }

    credentialsSection({ indexLabel, titleHtml, desc, skillGroups = [], educationTitle, degrees = [], coursesTitle, courses = [], languagesTitle, languagesText }) {
        let introCol = this.div(
            'col-lg-5',
            this.h2(titleHtml, 'pf-section-title mb-3') +
            this.p(PortfolioI18n.escapeHtml(desc), 'text-muted')
        );

        let skillsCol = this.div(
            'col-lg-7',
            skillGroups.map(g => this.skillGroupBlock(g.title, g.items)).join('')
        );

        let degreesHtml = degrees.map(d =>
            this.div('pf-cred-item',
                this.strong(PortfolioI18n.escapeHtml(d.title)) +
                ` — ${PortfolioI18n.escapeHtml(d.institution)}` +
                (d.period ? ` (${PortfolioI18n.escapeHtml(d.period)})` : '') +
                (d.details ? this.small(PortfolioI18n.escapeHtml(d.details)) : '')
            )
        ).join('');

        let coursesHtml = courses.map(c =>
            this.div('pf-cred-item mb-2',
                this.strong(PortfolioI18n.escapeHtml(c.title)) +
                ` — ${PortfolioI18n.escapeHtml(c.institution)}`
            )
        ).join('');

        let credRow = this.div(
            'row g-4 pf-credentials-divider',
            this.div('col-lg-4', this.div('pf-cred-title', PortfolioI18n.escapeHtml(educationTitle)) + degreesHtml) +
            this.div('col-lg-5', this.div('pf-cred-title', PortfolioI18n.escapeHtml(coursesTitle)) + coursesHtml) +
            this.div('col-lg-3', this.div('pf-cred-title', PortfolioI18n.escapeHtml(languagesTitle)) + this.p(PortfolioI18n.escapeHtml(languagesText), 'pf-cred-item'))
        );

        return this.element(
            'section',
            { class: 'pf-section' },
            this.div(
                'container pf-container',
                this.sectionIndex('06', indexLabel) +
                this.div('row g-5 mt-1', introCol + skillsCol) +
                credRow
            )
        );
    }

    // --- Secao 07: Contato & Curriculos ---

    contactSection({ indexLabel, titleHtml, desc, availability, profile, resumesTitle }) {
        let links = [];
        if (profile.email) {
            links.push(this.a(PortfolioI18n.escapeHtml(profile.email) + ' ↗', 'mailto:' + profile.email, '_self', 'pf-contact-link'));
        }
        if (profile.phone) {
            let telHref = 'tel:' + profile.phone.replace(/[^+\d]/g, '');
            links.push(this.a('<i class="bi bi-telephone me-1"></i>' + PortfolioI18n.escapeHtml(profile.phone), telHref, '_self', 'pf-contact-link'));
        }
        if (profile.whatsapp_url) {
            links.push(this.a('<i class="bi bi-whatsapp me-1"></i>WhatsApp ↗', profile.whatsapp_url, '_blank', 'pf-contact-link', { rel: 'noopener noreferrer' }));
        }
        if (profile.github_url) {
            links.push(this.a('<i class="bi bi-github me-1"></i>GitHub ↗', profile.github_url, '_blank', 'pf-contact-link', { rel: 'noopener noreferrer' }));
        }
        if (profile.linkedin_url) {
            links.push(this.a('<i class="bi bi-linkedin me-1"></i>LinkedIn ↗', profile.linkedin_url, '_blank', 'pf-contact-link', { rel: 'noopener noreferrer' }));
        }

        let downloads = (profile.resumes || []).map(r =>
            this.a(PortfolioI18n.escapeHtml(r.label), r.url, '_self', 'pf-download-link', { download: '' })
        ).join('');

        let downloadsBar = this.div(
            'pf-downloads d-flex flex-wrap align-items-center gap-4 mt-5',
            this.span('pf-downloads-label', PortfolioI18n.escapeHtml(resumesTitle)) + downloads
        );

        let availHtml = availability
            ? this.p('<i class="bi bi-geo-alt me-2 text-info"></i>' + PortfolioI18n.escapeHtml(availability), 'small text-secondary mt-3 mb-0')
            : '';

        return this.element(
            'section',
            { id: 'contact', class: 'pf-section pf-section-dark' },
            this.div(
                'container pf-container',
                this.sectionIndex('07', indexLabel) +
                this.h2(titleHtml, 'pf-contact-title my-4') +
                this.p(PortfolioI18n.escapeHtml(desc), 'pf-contact-desc mb-4') +
                this.div('d-flex flex-wrap gap-4 my-4', links.join('')) +
                availHtml +
                downloadsBar
            )
        );
    }

    // --- Componentes Modulares da Pagina Explicativa de Projeto (#/projeto/:slug) ---

    projectDetailHero({ eyebrow, headlineHtml, lead, sublead, coverImage, coverAlt, systemUrl, openSystemLabel, backLabel, statusLabel, org, stack }) {
        let backBtn = this.div('mb-4', this.a(PortfolioI18n.escapeHtml(backLabel), '#/', '_self', 'fw-bold text-decoration-none', { style: 'color: var(--pf-teal);' }));

        let metaBadges = this.div(
            'd-flex flex-wrap gap-2 mb-3',
            this.span('pf-project-status', PortfolioI18n.escapeHtml(statusLabel)) +
            (org ? this.span('pf-pill', PortfolioI18n.escapeHtml(org)) : '')
        );

        let actionBtns = [];
        if (systemUrl) {
            actionBtns.push(this.a(
                this.span('', PortfolioI18n.escapeHtml(openSystemLabel)) + this.span('', '↗'),
                systemUrl,
                '_blank',
                'pf-btn-primary',
                { rel: 'noopener noreferrer' }
            ));
        }
        actionBtns.push(this.a(
            this.span('', PortfolioI18n.escapeHtml(backLabel.replace(/^←\s*/, ''))) + this.span('', '←'),
            '#/',
            '_self',
            'pf-btn-secondary'
        ));

        let leftCol = this.div(
            coverImage ? 'col-lg-6' : 'col-lg-9',
            backBtn +
            metaBadges +
            this.div('pf-eyebrow mb-3', PortfolioI18n.escapeHtml(eyebrow)) +
            this.h1(headlineHtml, 'fw-bold mb-3', { style: 'font-size: clamp(2.3rem, 4.5vw, 4rem);' }) +
            this.p(PortfolioI18n.escapeHtml(lead), 'fs-5 text-secondary mb-3') +
            (sublead ? this.p(PortfolioI18n.escapeHtml(sublead), 'text-muted mb-3') : '') +
            (stack ? this.p(this.small(PortfolioI18n.escapeHtml(stack), 'text-muted fw-semibold'), 'mb-4') : '') +
            this.div('d-flex flex-wrap gap-3 mt-4', actionBtns.join(''))
        );

        let rightCol = coverImage
            ? this.div('col-lg-6', this.img(coverImage, PortfolioI18n.escapeHtml(coverAlt || ''), 'pf-detail-cover'))
            : '';

        return this.element(
            'section',
            { class: 'py-5' },
            this.div('container pf-container py-3', this.div('row g-5 align-items-center', leftCol + rightCol))
        );
    }

    projectBannerBar(title, subtitle = '') {
        if (!title) return '';
        return this.element(
            'section',
            { class: 'pf-detail-bar py-4' },
            this.div(
                'container pf-container d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2',
                this.strong(PortfolioI18n.escapeHtml(title), 'fs-4') +
                (subtitle ? this.span('small opacity-75', PortfolioI18n.escapeHtml(subtitle)) : '')
            )
        );
    }

    projectChallengeApproach({ challengeLabel, challenge, approachLabel, approach }) {
        if (!challenge && !approach) return '';
        let cols = '';
        if (challenge) {
            cols += this.div('col-md-6', this.div('pf-detail-feature',
                this.small(PortfolioI18n.escapeHtml(challengeLabel)) +
                this.p(PortfolioI18n.escapeHtml(challenge), 'mt-2 mb-0')
            ));
        }
        if (approach) {
            cols += this.div('col-md-6', this.div('pf-detail-feature',
                this.small(PortfolioI18n.escapeHtml(approachLabel)) +
                this.p(PortfolioI18n.escapeHtml(approach), 'mt-2 mb-0')
            ));
        }
        return this.element(
            'section',
            { class: 'py-4' },
            this.div('container pf-container', this.div('row g-3', cols))
        );
    }

    videoPlayerSection(title, videoUrl) {
        let parsed = PortfolioI18n.parseVideoUrl(videoUrl);
        if (!parsed) return '';

        let mediaHtml = '';
        if (parsed.type === 'iframe') {
            mediaHtml = this.div(
                'ratio ratio-16x9 pf-detail-video-box',
                this.element('iframe', {
                    src: parsed.src,
                    title: PortfolioI18n.escapeHtml(title),
                    allow: 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture',
                    allowfullscreen: true
                })
            );
        } else if (parsed.type === 'video') {
            mediaHtml = this.div(
                'ratio ratio-16x9 pf-detail-video-box',
                this.element('video', { controls: true, preload: 'metadata', class: 'w-100 h-100' },
                    this.element('source', { src: parsed.src })
                )
            );
        } else {
            mediaHtml = this.a(
                '<i class="bi bi-play-circle me-2"></i>' + PortfolioI18n.escapeHtml(title) + ' ↗',
                parsed.src,
                '_blank',
                'pf-btn-primary',
                { rel: 'noopener noreferrer' }
            );
        }

        return this.element(
            'section',
            { class: 'py-5' },
            this.div(
                'container pf-container',
                this.h2(PortfolioI18n.escapeHtml(title), 'h3 fw-bold mb-4') + mediaHtml
            )
        );
    }

    projectFeatureGrid({ eyebrow, title, introText, features = [] }) {
        if (!features.length && !introText) return '';
        let colClass = features.length === 3 ? 'col-md-4' : 'col-md-6';
        let cards = features.map(f =>
            this.div(colClass, this.div('pf-detail-feature',
                (f.code ? this.small(PortfolioI18n.escapeHtml(f.code)) : '') +
                this.h3(PortfolioI18n.escapeHtml(f.title)) +
                this.p(PortfolioI18n.escapeHtml(f.desc))
            ))
        ).join('');

        return this.element(
            'section',
            { class: 'py-5' },
            this.div(
                'container pf-container',
                (eyebrow ? this.div('pf-eyebrow mb-2', PortfolioI18n.escapeHtml(eyebrow)) : '') +
                (title ? this.h2(PortfolioI18n.escapeHtml(title), 'pf-section-title mb-3') : '') +
                (introText ? this.p(PortfolioI18n.escapeHtml(introText), 'text-muted fs-6 mb-4', { style: 'max-width: 820px;' }) : '') +
                this.div('row g-3 mt-1', cards)
            )
        );
    }

    projectPillarsSection({ eyebrow, title, pillars = [] }) {
        if (!pillars.length) return '';
        let cols = pillars.map(p =>
            this.div('col-md-4', this.div('pf-detail-feature',
                this.h3(PortfolioI18n.escapeHtml(p.title), 'mt-0') +
                this.p(PortfolioI18n.escapeHtml(p.desc))
            ))
        ).join('');

        return this.element(
            'section',
            { class: 'pf-detail-pillars py-5' },
            this.div(
                'container pf-container',
                (eyebrow ? this.div('pf-eyebrow mb-2', PortfolioI18n.escapeHtml(eyebrow)) : '') +
                (title ? this.h2(PortfolioI18n.escapeHtml(title), 'pf-section-title mb-4') : '') +
                this.div('row g-3', cols)
            )
        );
    }

    disclaimerBox(text) {
        if (!text) return '';
        return this.div(
            'container pf-container py-4',
            this.p(PortfolioI18n.escapeHtml(text), 'small text-muted text-center mb-0')
        );
    }
}
