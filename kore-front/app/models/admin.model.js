/**
 * AdminModel — Cliente REST autenticado para gerenciamento do portfolio (Fase 2).
 * Todas as mutacoes limpam o cache de PortfolioModel para refletir imediatamente no site publico.
 */
class AdminModel {
    static checkSession() {
        let token = Model.getToken();
        if (!token) {
            return jQuery.Deferred().reject({ status: 401 }).promise();
        }
        return Model.get('auth/me');
    }

    static logout() {
        return Model.post('auth/logout', {}).always(function() {
            Model.logout();
        });
    }

    static changePassword(currentPassword, newPassword) {
        return Model.post('auth/password', {
            current_password: currentPassword,
            new_password: newPassword
        });
    }

    // --- Projects ---
    static listProjects() {
        return Model.get('projects', { include_hidden: 1 });
    }
    static createProject(payload) {
        return Model.post('projects', payload).done(() => PortfolioModel.clearCache());
    }
    static updateProject(id, payload) {
        return Model.put('projects/' + id, payload).done(() => PortfolioModel.clearCache());
    }
    static deleteProject(id) {
        return Model.delete('projects/' + id).done(() => PortfolioModel.clearCache());
    }

    // --- Experiences ---
    static listExperiences() {
        return Model.get('experiences', { include_hidden: 1 });
    }
    static createExperience(payload) {
        return Model.post('experiences', payload).done(() => PortfolioModel.clearCache());
    }
    static updateExperience(id, payload) {
        return Model.put('experiences/' + id, payload).done(() => PortfolioModel.clearCache());
    }
    static deleteExperience(id) {
        return Model.delete('experiences/' + id).done(() => PortfolioModel.clearCache());
    }

    // --- Skills ---
    static listSkills() {
        return Model.get('skills', { include_hidden: 1 });
    }
    static createSkill(payload) {
        return Model.post('skills', payload).done(() => PortfolioModel.clearCache());
    }
    static updateSkill(id, payload) {
        return Model.put('skills/' + id, payload).done(() => PortfolioModel.clearCache());
    }
    static deleteSkill(id) {
        return Model.delete('skills/' + id).done(() => PortfolioModel.clearCache());
    }

    // --- Education & Courses ---
    static listEducation() {
        return Model.get('education', { include_hidden: 1 });
    }
    static createEducation(payload) {
        return Model.post('education', payload).done(() => PortfolioModel.clearCache());
    }
    static updateEducation(id, payload) {
        return Model.put('education/' + id, payload).done(() => PortfolioModel.clearCache());
    }
    static deleteEducation(id) {
        return Model.delete('education/' + id).done(() => PortfolioModel.clearCache());
    }

    // --- Profile ---
    static getProfile() {
        return Model.get('profile');
    }
    static updateProfile(payload) {
        return Model.put('profile', payload).done(() => PortfolioModel.clearCache());
    }
}
