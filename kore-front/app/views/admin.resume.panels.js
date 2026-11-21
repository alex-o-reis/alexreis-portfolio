/**
 * AdminResumePanels — Modulos CRUD Bootstrap 5 para Experiencias, Skills,
 * Formacao/Cursos e Perfil/Senha.
 */
const AdminResumePanels = {
    SKILL_CATEGORIES: [
        { key: 'architecture', label: 'Arquitetura & BPM' },
        { key: 'backend', label: 'Back-end & APIs' },
        { key: 'frontend', label: 'Front-end' },
        { key: 'mobile', label: 'Mobile' },
        { key: 'data', label: 'Dados & Cloud' },
        { key: 'ai', label: 'IA Aplicada' },
        { key: 'practices', label: 'Práticas & Liderança' }
    ],

    esc(s) {
        return PortfolioI18n.escapeHtml(s);
    },

    // =========================================================================
    // 1. EXPERIENCIAS PROFISSIONAIS
    // =========================================================================
    renderExperiences(items = []) {
        const rows = items.map(e => {
            const role = (e.role && (e.role.pt || e.role.en)) || '';
            const period = (e.period_label && (e.period_label.pt || e.period_label.en)) || '';
            const vis = e.is_visible ? AdminRenderer.badge('Visível', 'success') : AdminRenderer.badge('Oculta', 'warning');
            return `
                <tr>
                    <td class="text-muted small fw-bold">#${e.display_order}</td>
                    <td>
                        <div class="fw-bold">${this.esc(e.company)}</div>
                        <div class="small text-muted">${this.esc(role)}</div>
                    </td>
                    <td class="small text-nowrap">${this.esc(period)}</td>
                    <td>${vis}</td>
                    <td class="text-nowrap">
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-primary btn-edit-exp" data-id="${e.id}"><i class="bi bi-pencil"></i></button>
                            <button type="button" class="btn btn-outline-danger btn-del-exp" data-id="${e.id}" data-name="${this.esc(e.company)}"><i class="bi bi-trash"></i></button>
                        </div>
                    </td>
                </tr>`;
        }).join('');

        const table = AdminRenderer.tableCard({
            title: 'Experiências Profissionais',
            subtitle: 'Defina a ordem de exibição na linha do tempo do portfólio.',
            addBtnId: 'btn-add-exp',
            addBtnLabel: 'Nova Experiência',
            headers: ['Ordem', 'Empresa / Cargo', 'Período', 'Status', 'Ações'],
            rowsHtml: rows
        });

        const modal = `
        <div class="modal fade" id="modal-exp" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content border-0 shadow rounded-4">
                    <form id="form-exp">
                        <div class="modal-header border-bottom">
                            <h5 class="modal-title fw-bold" id="modal-exp-title">Nova Experiência</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <input type="hidden" id="exp-id">
                            <div class="alert alert-danger d-none small py-2" id="exp-form-error"></div>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label small fw-bold">Empresa *</label>
                                    <input type="text" class="form-control" id="exp-company" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Ordem</label>
                                    <input type="number" class="form-control" id="exp-order" value="1">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Período (PT) *</label>
                                    <input type="text" class="form-control" id="exp-period-pt" placeholder="SET/2020 — ATUAL" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Período (EN)</label>
                                    <input type="text" class="form-control" id="exp-period-en" placeholder="SEP/2020 — PRESENT">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Período (ES)</label>
                                    <input type="text" class="form-control" id="exp-period-es" placeholder="SEP/2020 — ACTUAL">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Cargo (PT) *</label>
                                    <input type="text" class="form-control" id="exp-role-pt" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Cargo (EN)</label>
                                    <input type="text" class="form-control" id="exp-role-en">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Cargo (ES)</label>
                                    <input type="text" class="form-control" id="exp-role-es">
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold">Descrição (PT)</label>
                                    <textarea class="form-control" id="exp-desc-pt" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Descrição (EN)</label>
                                    <textarea class="form-control" id="exp-desc-en" rows="3"></textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold">Descrição (ES)</label>
                                    <textarea class="form-control" id="exp-desc-es" rows="3"></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Tags PT (vírgula)</label>
                                    <input type="text" class="form-control form-control-sm" id="exp-tags-pt" placeholder="C#, Azure, BPM">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Tags EN (vírgula)</label>
                                    <input type="text" class="form-control form-control-sm" id="exp-tags-en">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Tags ES (vírgula)</label>
                                    <input type="text" class="form-control form-control-sm" id="exp-tags-es">
                                </div>
                                <div class="col-12 d-flex gap-4">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="exp-current">
                                        <label class="form-check-label small fw-semibold" for="exp-current">Emprego atual</label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="exp-visible" checked>
                                        <label class="form-check-label small fw-semibold" for="exp-visible">Visível no portfólio</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-dark px-4" id="btn-save-exp">Salvar Experiência</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>`;

        return table + modal;
    },

    bindExperiences(items, onReload) {
        const openModal = function(exp = null) {
            jQuery('#exp-form-error').addClass('d-none');
            if (exp) {
                jQuery('#modal-exp-title').text('Editar Experiência: ' + exp.company);
                jQuery('#exp-id').val(exp.id);
                jQuery('#exp-company').val(exp.company || '');
                jQuery('#exp-order').val(exp.display_order || 0);
                jQuery('#exp-period-pt').val((exp.period_label && exp.period_label.pt) || '');
                jQuery('#exp-period-en').val((exp.period_label && exp.period_label.en) || '');
                jQuery('#exp-period-es').val((exp.period_label && exp.period_label.es) || '');
                jQuery('#exp-role-pt').val((exp.role && exp.role.pt) || '');
                jQuery('#exp-role-en').val((exp.role && exp.role.en) || '');
                jQuery('#exp-role-es').val((exp.role && exp.role.es) || '');
                jQuery('#exp-desc-pt').val((exp.description && exp.description.pt) || '');
                jQuery('#exp-desc-en').val((exp.description && exp.description.en) || '');
                jQuery('#exp-desc-es').val((exp.description && exp.description.es) || '');
                jQuery('#exp-tags-pt').val(((exp.tags && exp.tags.pt) || []).join(', '));
                jQuery('#exp-tags-en').val(((exp.tags && exp.tags.en) || []).join(', '));
                jQuery('#exp-tags-es').val(((exp.tags && exp.tags.es) || []).join(', '));
                jQuery('#exp-current').prop('checked', !!exp.is_current);
                jQuery('#exp-visible').prop('checked', !!exp.is_visible);
            } else {
                jQuery('#modal-exp-title').text('Nova Experiência');
                jQuery('#form-exp')[0].reset();
                jQuery('#exp-id').val('');
                jQuery('#exp-order').val(items.length + 1);
                jQuery('#exp-visible').prop('checked', true);
            }
            UI.showModal('#modal-exp');
        };

        jQuery('#btn-add-exp').off('click').on('click', () => openModal(null));
        jQuery('.btn-edit-exp').off('click').on('click', function() {
            const id = parseInt(jQuery(this).data('id'), 10);
            const found = items.find(x => x.id === id);
            if (found) openModal(found);
        });
        jQuery('.btn-del-exp').off('click').on('click', function() {
            const id = parseInt(jQuery(this).data('id'), 10);
            if (!confirm(`Remover experiência "${jQuery(this).data('name')}"?`)) return;
            AdminModel.deleteExperience(id)
                .done(() => onReload('Experiência removida com sucesso.'))
                .fail(xhr => AdminView.notify(AdminView.extractError(xhr), 'danger'));
        });

        jQuery('#form-exp').off('submit').on('submit', function(e) {
            e.preventDefault();
            const id = jQuery('#exp-id').val();
            const payload = {
                company: jQuery('#exp-company').val().trim(),
                display_order: parseInt(jQuery('#exp-order').val() || '0', 10),
                period_label_pt: jQuery('#exp-period-pt').val().trim(),
                period_label_en: jQuery('#exp-period-en').val().trim(),
                period_label_es: jQuery('#exp-period-es').val().trim(),
                role_pt: jQuery('#exp-role-pt').val().trim(),
                role_en: jQuery('#exp-role-en').val().trim(),
                role_es: jQuery('#exp-role-es').val().trim(),
                description_pt: jQuery('#exp-desc-pt').val().trim(),
                description_en: jQuery('#exp-desc-en').val().trim(),
                description_es: jQuery('#exp-desc-es').val().trim(),
                tags_pt: jQuery('#exp-tags-pt').val().trim(),
                tags_en: jQuery('#exp-tags-en').val().trim(),
                tags_es: jQuery('#exp-tags-es').val().trim(),
                is_current: jQuery('#exp-current').is(':checked') ? 1 : 0,
                is_visible: jQuery('#exp-visible').is(':checked') ? 1 : 0
            };

            const req = id ? AdminModel.updateExperience(id, payload) : AdminModel.createExperience(payload);
            req.done(function() {
                UI.hideModal('#modal-exp');
                onReload(id ? 'Experiência atualizada com sucesso.' : 'Experiência cadastrada com sucesso.');
            }).fail(function(xhr) {
                jQuery('#exp-form-error').removeClass('d-none').text(AdminView.extractError(xhr));
            });
        });
    },

    // =========================================================================
    // 2. SKILLS / COMPETENCIAS
    // =========================================================================
    renderSkills(items = []) {
        const rows = items.map(s => {
            const namePt = (s.name && s.name.pt) || '';
            const nameEn = (s.name && s.name.en) || '';
            const catPt = (s.category && s.category.pt) || s.category_key;
            const vis = s.is_visible ? AdminRenderer.badge('Visível', 'success') : AdminRenderer.badge('Oculta', 'warning');
            return `
                <tr>
                    <td class="text-muted small fw-bold">#${s.display_order}</td>
                    <td>
                        <div class="fw-bold">${this.esc(namePt)}</div>
                        ${nameEn !== namePt ? `<div class="small text-muted">${this.esc(nameEn)}</div>` : ''}
                    </td>
                    <td><span class="badge text-bg-light border text-dark">${this.esc(catPt)}</span></td>
                    <td>${vis}</td>
                    <td class="text-nowrap">
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-primary btn-edit-skill" data-id="${s.id}"><i class="bi bi-pencil"></i></button>
                            <button type="button" class="btn btn-outline-danger btn-del-skill" data-id="${s.id}" data-name="${this.esc(namePt)}"><i class="bi bi-trash"></i></button>
                        </div>
                    </td>
                </tr>`;
        }).join('');

        const catOpts = this.SKILL_CATEGORIES.map(c => `<option value="${c.key}">${this.esc(c.label)}</option>`).join('');

        const table = AdminRenderer.tableCard({
            title: 'Competências Técnicas (Skills)',
            subtitle: 'Organizadas automaticamente por categoria na seção Base Técnica.',
            addBtnId: 'btn-add-skill',
            addBtnLabel: 'Nova Skill',
            headers: ['Ordem', 'Competência', 'Categoria', 'Status', 'Ações'],
            rowsHtml: rows
        });

        const modal = `
        <div class="modal fade" id="modal-skill" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content border-0 shadow rounded-4">
                    <form id="form-skill">
                        <div class="modal-header border-bottom">
                            <h5 class="modal-title fw-bold" id="modal-skill-title">Nova Skill</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <input type="hidden" id="skill-id">
                            <div class="alert alert-danger d-none small py-2" id="skill-form-error"></div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Nome (PT) *</label>
                                <input type="text" class="form-control" id="skill-name-pt" required>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label small fw-bold">Nome (EN)</label>
                                    <input type="text" class="form-control" id="skill-name-en" placeholder="Igual ao PT">
                                </div>
                                <div class="col-6">
                                    <label class="form-label small fw-bold">Nome (ES)</label>
                                    <input type="text" class="form-control" id="skill-name-es" placeholder="Igual ao PT">
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-8">
                                    <label class="form-label small fw-bold">Categoria</label>
                                    <select class="form-select" id="skill-cat">${catOpts}</select>
                                </div>
                                <div class="col-4">
                                    <label class="form-label small fw-bold">Ordem</label>
                                    <input type="number" class="form-control" id="skill-order" value="1">
                                </div>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="skill-visible" checked>
                                <label class="form-check-label small fw-semibold" for="skill-visible">Visível no portfólio</label>
                            </div>
                        </div>
                        <div class="modal-footer border-top">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-dark px-4">Salvar Skill</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>`;

        return table + modal;
    },

    bindSkills(items, onReload) {
        const openModal = function(sk = null) {
            jQuery('#skill-form-error').addClass('d-none');
            if (sk) {
                jQuery('#modal-skill-title').text('Editar Skill');
                jQuery('#skill-id').val(sk.id);
                jQuery('#skill-name-pt').val((sk.name && sk.name.pt) || '');
                jQuery('#skill-name-en').val((sk.name && sk.name.en) || '');
                jQuery('#skill-name-es').val((sk.name && sk.name.es) || '');
                jQuery('#skill-cat').val(sk.category_key || 'architecture');
                jQuery('#skill-order').val(sk.display_order || 0);
                jQuery('#skill-visible').prop('checked', !!sk.is_visible);
            } else {
                jQuery('#modal-skill-title').text('Nova Skill');
                jQuery('#form-skill')[0].reset();
                jQuery('#skill-id').val('');
                jQuery('#skill-order').val(items.length + 1);
                jQuery('#skill-visible').prop('checked', true);
            }
            UI.showModal('#modal-skill');
        };

        jQuery('#btn-add-skill').off('click').on('click', () => openModal(null));
        jQuery('.btn-edit-skill').off('click').on('click', function() {
            const id = parseInt(jQuery(this).data('id'), 10);
            const found = items.find(x => x.id === id);
            if (found) openModal(found);
        });
        jQuery('.btn-del-skill').off('click').on('click', function() {
            const id = parseInt(jQuery(this).data('id'), 10);
            if (!confirm(`Remover skill "${jQuery(this).data('name')}"?`)) return;
            AdminModel.deleteSkill(id)
                .done(() => onReload('Skill removida com sucesso.'))
                .fail(xhr => AdminView.notify(AdminView.extractError(xhr), 'danger'));
        });

        jQuery('#form-skill').off('submit').on('submit', function(e) {
            e.preventDefault();
            const id = jQuery('#skill-id').val();
            const payload = {
                name_pt: jQuery('#skill-name-pt').val().trim(),
                name_en: jQuery('#skill-name-en').val().trim(),
                name_es: jQuery('#skill-name-es').val().trim(),
                category_key: jQuery('#skill-cat').val(),
                display_order: parseInt(jQuery('#skill-order').val() || '0', 10),
                is_visible: jQuery('#skill-visible').is(':checked') ? 1 : 0
            };
            const req = id ? AdminModel.updateSkill(id, payload) : AdminModel.createSkill(payload);
            req.done(function() {
                UI.hideModal('#modal-skill');
                onReload(id ? 'Skill atualizada com sucesso.' : 'Skill cadastrada com sucesso.');
            }).fail(function(xhr) {
                jQuery('#skill-form-error').removeClass('d-none').text(AdminView.extractError(xhr));
            });
        });
    },

    // =========================================================================
    // 3. FORMACAO & CURSOS
    // =========================================================================
    renderEducation(items = []) {
        const rows = items.map(ed => {
            const title = (ed.title && ed.title.pt) || '';
            const typeBadge = ed.item_type === 'degree'
                ? AdminRenderer.badge('Graduação', 'primary')
                : AdminRenderer.badge('Curso', 'info');
            const vis = ed.is_visible ? AdminRenderer.badge('Visível', 'success') : AdminRenderer.badge('Oculto', 'warning');
            return `
                <tr>
                    <td class="text-muted small fw-bold">#${ed.display_order}</td>
                    <td>${typeBadge}</td>
                    <td>
                        <div class="fw-bold">${this.esc(title)}</div>
                        <div class="small text-muted">${this.esc(ed.institution)}${ed.period_label ? ' · ' + this.esc(ed.period_label) : ''}</div>
                    </td>
                    <td>${vis}</td>
                    <td class="text-nowrap">
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-outline-primary btn-edit-edu" data-id="${ed.id}"><i class="bi bi-pencil"></i></button>
                            <button type="button" class="btn btn-outline-danger btn-del-edu" data-id="${ed.id}" data-name="${this.esc(title)}"><i class="bi bi-trash"></i></button>
                        </div>
                    </td>
                </tr>`;
        }).join('');

        const table = AdminRenderer.tableCard({
            title: 'Formação Acadêmica & Cursos Complementares',
            subtitle: 'Gerencie graduações, especializações e cursos exibidos no portfólio.',
            addBtnId: 'btn-add-edu',
            addBtnLabel: 'Novo Item',
            headers: ['Ordem', 'Tipo', 'Título / Instituição', 'Status', 'Ações'],
            rowsHtml: rows
        });

        const modal = `
        <div class="modal fade" id="modal-edu" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content border-0 shadow rounded-4">
                    <form id="form-edu">
                        <div class="modal-header border-bottom">
                            <h5 class="modal-title fw-bold" id="modal-edu-title">Nova Formação / Curso</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body p-4">
                            <input type="hidden" id="edu-id">
                            <div class="alert alert-danger d-none small py-2" id="edu-form-error"></div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Tipo</label>
                                    <select class="form-select" id="edu-type">
                                        <option value="degree">Graduação / Acadêmico</option>
                                        <option value="course">Curso Complementar</option>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold">Instituição *</label>
                                    <input type="text" class="form-control" id="edu-institution" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold">Período</label>
                                    <input type="text" class="form-control" id="edu-period" placeholder="1998–2002">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Título (PT) *</label>
                                    <input type="text" class="form-control" id="edu-title-pt" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Título (EN)</label>
                                    <input type="text" class="form-control" id="edu-title-en">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Título (ES)</label>
                                    <input type="text" class="form-control" id="edu-title-es">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Detalhes (PT)</label>
                                    <textarea class="form-control form-control-sm" id="edu-details-pt" rows="2"></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Detalhes (EN)</label>
                                    <textarea class="form-control form-control-sm" id="edu-details-en" rows="2"></textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small fw-bold">Detalhes (ES)</label>
                                    <textarea class="form-control form-control-sm" id="edu-details-es" rows="2"></textarea>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small fw-bold">Ordem</label>
                                    <input type="number" class="form-control" id="edu-order" value="1">
                                </div>
                                <div class="col-md-9 d-flex align-items-end">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="edu-visible" checked>
                                        <label class="form-check-label small fw-semibold" for="edu-visible">Visível no portfólio</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-dark px-4">Salvar Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>`;

        return table + modal;
    },

    bindEducation(items, onReload) {
        const openModal = function(ed = null) {
            jQuery('#edu-form-error').addClass('d-none');
            if (ed) {
                jQuery('#modal-edu-title').text('Editar Formação / Curso');
                jQuery('#edu-id').val(ed.id);
                jQuery('#edu-type').val(ed.item_type || 'degree');
                jQuery('#edu-institution').val(ed.institution || '');
                jQuery('#edu-period').val(ed.period_label || '');
                jQuery('#edu-title-pt').val((ed.title && ed.title.pt) || '');
                jQuery('#edu-title-en').val((ed.title && ed.title.en) || '');
                jQuery('#edu-title-es').val((ed.title && ed.title.es) || '');
                jQuery('#edu-details-pt').val((ed.details && ed.details.pt) || '');
                jQuery('#edu-details-en').val((ed.details && ed.details.en) || '');
                jQuery('#edu-details-es').val((ed.details && ed.details.es) || '');
                jQuery('#edu-order').val(ed.display_order || 0);
                jQuery('#edu-visible').prop('checked', !!ed.is_visible);
            } else {
                jQuery('#modal-edu-title').text('Nova Formação / Curso');
                jQuery('#form-edu')[0].reset();
                jQuery('#edu-id').val('');
                jQuery('#edu-order').val(items.length + 1);
                jQuery('#edu-visible').prop('checked', true);
            }
            UI.showModal('#modal-edu');
        };

        jQuery('#btn-add-edu').off('click').on('click', () => openModal(null));
        jQuery('.btn-edit-edu').off('click').on('click', function() {
            const id = parseInt(jQuery(this).data('id'), 10);
            const found = items.find(x => x.id === id);
            if (found) openModal(found);
        });
        jQuery('.btn-del-edu').off('click').on('click', function() {
            const id = parseInt(jQuery(this).data('id'), 10);
            if (!confirm(`Remover "${jQuery(this).data('name')}"?`)) return;
            AdminModel.deleteEducation(id)
                .done(() => onReload('Item removido com sucesso.'))
                .fail(xhr => AdminView.notify(AdminView.extractError(xhr), 'danger'));
        });

        jQuery('#form-edu').off('submit').on('submit', function(e) {
            e.preventDefault();
            const id = jQuery('#edu-id').val();
            const payload = {
                item_type: jQuery('#edu-type').val(),
                institution: jQuery('#edu-institution').val().trim(),
                period_label: jQuery('#edu-period').val().trim(),
                title_pt: jQuery('#edu-title-pt').val().trim(),
                title_en: jQuery('#edu-title-en').val().trim(),
                title_es: jQuery('#edu-title-es').val().trim(),
                details_pt: jQuery('#edu-details-pt').val().trim(),
                details_en: jQuery('#edu-details-en').val().trim(),
                details_es: jQuery('#edu-details-es').val().trim(),
                display_order: parseInt(jQuery('#edu-order').val() || '0', 10),
                is_visible: jQuery('#edu-visible').is(':checked') ? 1 : 0
            };
            const req = id ? AdminModel.updateEducation(id, payload) : AdminModel.createEducation(payload);
            req.done(function() {
                UI.hideModal('#modal-edu');
                onReload(id ? 'Formação atualizada com sucesso.' : 'Formação cadastrada com sucesso.');
            }).fail(function(xhr) {
                jQuery('#edu-form-error').removeClass('d-none').text(AdminView.extractError(xhr));
            });
        });
    },

    // =========================================================================
    // 4. PERFIL, CONTATO & SENHA
    // =========================================================================
    renderProfile(p = {}) {
        const lang = p.languages || {};
        const role = p.role_subtitle || {};
        const loc = p.location || {};
        const avail = p.availability || {};

        return `
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h2 class="h5 fw-bold mb-1">Dados de Perfil &amp; Contato</h2>
                    <p class="small text-muted mb-4">Informações exibidas no topo, rodapé e seção de contato do portfólio.</p>
                    <form id="form-profile">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nome Completo</label>
                                <input type="text" class="form-control" id="prof-full-name" value="${this.esc(p.full_name || '')}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nome Curto (Logo)</label>
                                <input type="text" class="form-control" id="prof-short-name" value="${this.esc(p.short_name || '')}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Subtítulo (PT)</label>
                                <input type="text" class="form-control form-control-sm" id="prof-role-pt" value="${this.esc(role.pt || '')}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Subtítulo (EN)</label>
                                <input type="text" class="form-control form-control-sm" id="prof-role-en" value="${this.esc(role.en || '')}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Subtítulo (ES)</label>
                                <input type="text" class="form-control form-control-sm" id="prof-role-es" value="${this.esc(role.es || '')}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">E-mail</label>
                                <input type="email" class="form-control" id="prof-email" value="${this.esc(p.email || '')}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Telefone</label>
                                <input type="text" class="form-control" id="prof-phone" value="${this.esc(p.phone || '')}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">URL WhatsApp</label>
                                <input type="url" class="form-control" id="prof-whatsapp" value="${this.esc(p.whatsapp_url || '')}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">URL GitHub</label>
                                <input type="url" class="form-control" id="prof-github" value="${this.esc(p.github_url || '')}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">URL LinkedIn</label>
                                <input type="url" class="form-control" id="prof-linkedin" value="${this.esc(p.linkedin_url || '')}" placeholder="https://www.linkedin.com/in/...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Website</label>
                                <input type="url" class="form-control" id="prof-website" value="${this.esc(p.website_url || '')}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Localização (PT)</label>
                                <input type="text" class="form-control form-control-sm" id="prof-loc-pt" value="${this.esc(loc.pt || '')}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Localização (EN)</label>
                                <input type="text" class="form-control form-control-sm" id="prof-loc-en" value="${this.esc(loc.en || '')}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Localização (ES)</label>
                                <input type="text" class="form-control form-control-sm" id="prof-loc-es" value="${this.esc(loc.es || '')}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Idiomas (PT)</label>
                                <input type="text" class="form-control form-control-sm" id="prof-lang-pt" value="${this.esc(lang.pt || '')}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Idiomas (EN)</label>
                                <input type="text" class="form-control form-control-sm" id="prof-lang-en" value="${this.esc(lang.en || '')}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Idiomas (ES)</label>
                                <input type="text" class="form-control form-control-sm" id="prof-lang-es" value="${this.esc(lang.es || '')}">
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Disponibilidade (PT)</label>
                                <input type="text" class="form-control form-control-sm" id="prof-avail-pt" value="${this.esc(avail.pt || '')}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Disponibilidade (EN)</label>
                                <input type="text" class="form-control form-control-sm" id="prof-avail-en" value="${this.esc(avail.en || '')}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Disponibilidade (ES)</label>
                                <input type="text" class="form-control form-control-sm" id="prof-avail-es" value="${this.esc(avail.es || '')}">
                            </div>
                            <div class="col-12 pt-2">
                                <button type="submit" class="btn btn-dark px-4 fw-semibold">
                                    <i class="bi bi-check-lg me-1"></i>Salvar Perfil
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h2 class="h5 fw-bold mb-1"><i class="bi bi-key me-1"></i>Alterar Senha Admin</h2>
                    <p class="small text-muted mb-3">Recomendado alterar a senha padrão <code>admin123</code> antes de publicar.</p>
                    <form id="form-password">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Senha Atual</label>
                            <input type="password" class="form-control" id="pwd-current" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nova Senha (mín. 6)</label>
                            <input type="password" class="form-control" id="pwd-new" minlength="6" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" id="pwd-confirm" minlength="6" required>
                        </div>
                        <button type="submit" class="btn btn-outline-dark w-100 fw-semibold">Atualizar Senha</button>
                    </form>
                </div>
            </div>
        </div>`;
    },

    bindProfile(profile, onReload) {
        jQuery('#form-profile').off('submit').on('submit', function(e) {
            e.preventDefault();
            const payload = {
                full_name: jQuery('#prof-full-name').val().trim(),
                short_name: jQuery('#prof-short-name').val().trim(),
                role_subtitle_pt: jQuery('#prof-role-pt').val().trim(),
                role_subtitle_en: jQuery('#prof-role-en').val().trim(),
                role_subtitle_es: jQuery('#prof-role-es').val().trim(),
                email: jQuery('#prof-email').val().trim(),
                phone: jQuery('#prof-phone').val().trim(),
                whatsapp_url: jQuery('#prof-whatsapp').val().trim(),
                github_url: jQuery('#prof-github').val().trim(),
                linkedin_url: jQuery('#prof-linkedin').val().trim(),
                website_url: jQuery('#prof-website').val().trim(),
                location_pt: jQuery('#prof-loc-pt').val().trim(),
                location_en: jQuery('#prof-loc-en').val().trim(),
                location_es: jQuery('#prof-loc-es').val().trim(),
                availability_pt: jQuery('#prof-avail-pt').val().trim(),
                availability_en: jQuery('#prof-avail-en').val().trim(),
                availability_es: jQuery('#prof-avail-es').val().trim(),
                languages: {
                    pt: jQuery('#prof-lang-pt').val().trim(),
                    en: jQuery('#prof-lang-en').val().trim(),
                    es: jQuery('#prof-lang-es').val().trim()
                }
            };
            AdminModel.updateProfile(payload)
                .done(() => onReload('Perfil atualizado com sucesso.'))
                .fail(xhr => AdminView.notify(AdminView.extractError(xhr), 'danger'));
        });

        jQuery('#form-password').off('submit').on('submit', function(e) {
            e.preventDefault();
            const cur = jQuery('#pwd-current').val();
            const next = jQuery('#pwd-new').val();
            const conf = jQuery('#pwd-confirm').val();
            if (next !== conf) {
                AdminView.notify('A confirmação da nova senha não confere.', 'danger');
                return;
            }
            AdminModel.changePassword(cur, next)
                .done(function() {
                    jQuery('#form-password')[0].reset();
                    AdminView.notify('Senha alterada com sucesso.', 'success');
                })
                .fail(xhr => AdminView.notify(AdminView.extractError(xhr), 'danger'));
        });
    }
};
