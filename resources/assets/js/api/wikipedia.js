app.factory('wikiFactory', [ '$http', function ($http) {

    var wikiFactory = {};
    var urlBase = 'https://en.wikipedia.org/w/api.php';
    var pageUrlBase = 'https://en.wikipedia.org/?curid=';
    var paramsBase = {
        action: 'query',
        exintro: '',
        explaintext: '',
        format: 'json',
        origin: '*',
        prop: 'extracts'
    };


    /**
     *  Fetch station description
     */
    wikiFactory.getDescription = function (article, successCallback, errorCallback) {
        paramsBase.titles = article;
        $http.get(urlBase, { params: paramsBase }).then(
            function success(response) {
                // Check a matching page was found
                var pages = response.data.query.pages;
                for (var page in pages) {
                    page = pages[page];

                    // Inject our extracted data into the response
                    response.data.extract = page.extract;
                    response.data.article_url = pageUrlBase + page.pageid;

                    // Call success function
                    return successCallback(response);
                }

                // No matching pages found, error out
                errorCallback(response);
            },

            function error(response) {
                errorCallback(response);
            }
        );
    };


    return wikiFactory;

}]);
