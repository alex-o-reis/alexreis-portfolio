/**
 * PortfolioModel — Camada de acesso REST ao kore-api com cache em memoria.
 */
class PortfolioModel {
    static _portfolioCache = null;
    static _projectCache = {};

    static getPortfolio(forceRefresh = false) {
        let deferred = jQuery.Deferred();

        if (!forceRefresh && PortfolioModel._portfolioCache) {
            deferred.resolve(PortfolioModel._portfolioCache);
            return deferred.promise();
        }

        Model.get('portfolio')
            .done(function(res) {
                PortfolioModel._portfolioCache = res;
                deferred.resolve(res);
            })
            .fail(function(xhr) {
                deferred.reject(xhr);
            });

        return deferred.promise();
    }

    static getProject(slug, forceRefresh = false) {
        let deferred = jQuery.Deferred();

        if (!forceRefresh && PortfolioModel._projectCache[slug]) {
            deferred.resolve(PortfolioModel._projectCache[slug]);
            return deferred.promise();
        }

        Model.get('projects/' + encodeURIComponent(slug))
            .done(function(res) {
                PortfolioModel._projectCache[slug] = res;
                deferred.resolve(res);
            })
            .fail(function(xhr) {
                deferred.reject(xhr);
            });

        return deferred.promise();
    }

    static clearCache() {
        PortfolioModel._portfolioCache = null;
        PortfolioModel._projectCache = {};
    }
}
