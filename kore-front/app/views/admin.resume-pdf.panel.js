/**
 * AdminResumePdfPanel — Modulo do Painel Administrativo para gerar, configurar
 * e pre-visualizar o Curriculo em PDF dinamico (Fase 3) a partir do SQLite.
 */
const AdminResumePdfPanel = {
    _state: {
        lang: 'pt',
        include_catalog: true,
        include_featured: true
    },

    buildUrl(endpoint, extra = {}) {
        const base = Model.getBaseUrl() + 'resume/' + endpoint;
        const params = new URLSearchParams(Object.assign({
            lang: this._state.lang,
            include_catalog: this._state.include_catalog ? '1' : '0',
            include_featured: this._state.include_featured ? '1' : '0'
        }, extra));
        return base + '?' + params.toString();
    },

    render() {
        const previewUrl = this.buildUrl('preview');
        const downloadUrl = this.buildUrl('pdf', { inline: '0' });

        return `
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h2 class="h5 fw-bold mb-1"><i class="bi bi-file-earmark-pdf text-danger me-1"></i>Gerador Dinâmico de PDF</h2>
                    <p class="small text-muted mb-4">
                        Gera o currículo no layout executivo padrão utilizando os dados atualizados do banco SQLite (perfil, experiências, skills, formação e projetos).
                    </p>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Idioma do Currículo</label>
                        <select class="form-select" id="pdf-cfg-lang">
                            <option value="pt" ${this._state.lang === 'pt' ? 'selected' : ''}>Português (PT-BR)</option>
                            <option value="en" ${this._state.lang === 'en' ? 'selected' : ''}>English (EN)</option>
                            <option value="es" ${this._state.lang === 'es' ? 'selected' : ''}>Español (ES)</option>
                        </select>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-4 d-flex flex-column gap-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="pdf-cfg-catalog" ${this._state.include_catalog ? 'checked' : ''}>
                            <label class="form-check-label small fw-semibold" for="pdf-cfg-catalog">Incluir Catálogo de Produtos (Pág. 4)</label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="pdf-cfg-featured" ${this._state.include_featured ? 'checked' : ''}>
                            <label class="form-check-label small fw-semibold" for="pdf-cfg-featured">Incluir Páginas de Produtos em Destaque</label>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="${downloadUrl}" id="btn-pdf-download" class="btn btn-dark fw-semibold" download>
                            <i class="bi bi-download me-1"></i>Baixar PDF Dinâmico
                        </a>
                        <a href="${previewUrl}" id="btn-pdf-open-html" target="_blank" rel="noopener" class="btn btn-outline-dark fw-semibold">
                            <i class="bi bi-printer me-1"></i>Abrir em Nova Aba / Imprimir
                        </a>
                        <button type="button" id="btn-pdf-refresh" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-clockwise me-1"></i>Atualizar Pré-visualização
                        </button>
                    </div>

                    <hr class="my-4">
                    <div class="small text-muted">
                        <strong>Dica:</strong> altere seus dados nas abas <em>Projetos</em>, <em>Experiências</em>, <em>Skills</em>, <em>Formação</em> ou <em>Perfil</em> — o PDF é regenerado instantaneamente com numeração de páginas automática.
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <span class="fw-bold small text-uppercase text-muted"><i class="bi bi-eye me-1"></i>Pré-visualização A4 ao vivo</span>
                        <span class="badge text-bg-light border text-dark" id="pdf-preview-badge">${this._state.lang.toUpperCase()}</span>
                    </div>
                    <div class="bg-light" style="height: 820px;">
                        <iframe id="pdf-preview-frame" src="${previewUrl}" style="width:100%;height:100%;border:0;" title="Pré-visualização do Currículo"></iframe>
                    </div>
                </div>
            </div>
        </div>`;
    },

    bind() {
        const self = this;
        const sync = function() {
            self._state.lang = jQuery('#pdf-cfg-lang').val();
            self._state.include_catalog = jQuery('#pdf-cfg-catalog').is(':checked');
            self._state.include_featured = jQuery('#pdf-cfg-featured').is(':checked');

            const previewUrl = self.buildUrl('preview', { _t: Date.now() });
            const downloadUrl = self.buildUrl('pdf', { inline: '0' });

            jQuery('#btn-pdf-download').attr('href', downloadUrl);
            jQuery('#btn-pdf-open-html').attr('href', self.buildUrl('preview'));
            jQuery('#pdf-preview-badge').text(self._state.lang.toUpperCase());
            jQuery('#pdf-preview-frame').attr('src', previewUrl);
        };

        jQuery('#pdf-cfg-lang, #pdf-cfg-catalog, #pdf-cfg-featured').off('change').on('change', sync);
        jQuery('#btn-pdf-refresh').off('click').on('click', sync);
    }
};
