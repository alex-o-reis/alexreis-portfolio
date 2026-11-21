/**
 * PortfolioShell — Controla cabecalho, rodape, navegacao por secao e troca de idioma PT/EN/ES.
 */
const PortfolioShell = {
    _profile: null,

    init() {
        PortfolioI18n.init();
        this.bindEvents();
        this.syncTexts();

        PortfolioI18n.onChange(() => {
            this.syncTexts();
            if (this._profile) {
                this.syncProfile(this._profile);
            }
            if (HomeController.activeInstance) {
                HomeController.activeInstance.renderView();
            } else if (ProjectDetailController.activeInstance) {
                ProjectDetailController.activeInstance.renderView();
            }
        });
    },

    syncProfile(profile) {
        if (!profile) return;
        this._profile = profile;
        jQuery('#pf-brand-name').text(profile.short_name || profile.full_name || 'Alex Reis');
        jQuery('#pf-brand-sub').text(PortfolioI18n.pick(profile.role_subtitle, 'ENGINEERING / LEADERSHIP'));
        jQuery('#pf-footer-copy').text('© ' + new Date().getFullYear() + ' ' + (profile.full_name || 'Alex de Oliveira Reis'));
    },

    syncTexts() {
        const currentLang = PortfolioI18n.getLang();
        jQuery('[data-i18n]').each(function() {
            const key = jQuery(this).attr('data-i18n');
            jQuery(this).text(PortfolioI18n.t(key));
        });
        jQuery('.pf-lang-btn').removeClass('active');
        jQuery('.pf-lang-btn[data-lang="' + currentLang + '"]').addClass('active');
    },

    closeMobileNav() {
        const navEl = document.getElementById('pfNavbar');
        if (navEl && navEl.classList.contains('show') && typeof bootstrap !== 'undefined') {
            const inst = bootstrap.Collapse.getInstance(navEl) || new bootstrap.Collapse(navEl, { toggle: false });
            inst.hide();
        }
    },

    bindEvents() {
        const self = this;

        jQuery(document).off('click.pfLang').on('click.pfLang', '.pf-lang-btn', function() {
            const next = jQuery(this).attr('data-lang');
            PortfolioI18n.setLang(next);
            self.closeMobileNav();
        });

        jQuery(document).off('click.pfNav').on('click.pfNav', '.pf-nav-link[data-section]', function(e) {
            e.preventDefault();
            const sectionId = jQuery(this).attr('data-section');
            self.closeMobileNav();

            const currentHash = window.location.hash || '#/';
            if (currentHash === '#/' || currentHash === '#' || currentHash === '') {
                const el = document.getElementById(sectionId);
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth' });
                }
            } else {
                HomeController.pendingScrollSection = sectionId;
                window.location.hash = '#/';
            }
        });

        jQuery(document).off('click.pfTop').on('click.pfTop', '#pf-back-top, #pf-brand-link', function(e) {
            self.closeMobileNav();
            const currentHash = window.location.hash || '#/';
            if (currentHash === '#/' || currentHash === '#' || currentHash === '') {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    }
};
