/**
 *  Station controller
 */
app.controller('stationController', [
    '$scope', '$stateParams', '$window', 'apiFactory', 'wikiFactory',
    function ($scope, $stateParams, $window, api, wikipedia) {

    // Station object
    $scope.station = {
        name: $stateParams.station,
        description: '',
        wiki_url: ''
    };

    // Track whether the full Wikipedia description is shown
    $scope.description = '';
    $scope.isDescTruncated = false;

    // Fetch station information from API
    api.getStation($scope.station.name).then(
        function success(response) {
            $scope.station = response.data;

            // Fetch Wikipedia information extract
            if ($scope.station.wiki_title) {
                wikipedia.getDescription($scope.station.wiki_title,
                    function success(response) {
                        $scope.station.description = response.data.extract;
                        $scope.station.wiki_url = response.data.article_url;

                        $scope.toggleDescTruncated();
                        $scope.highlightFrequencies();
                    }
                );
            }
        },

        function error(response) {
            report("Unable to fetch station information.");
        }
    );

    // Joins an array of frequencies into a single string
    $scope.getFrequencies = function (region, city) {
        var frequencies = $scope.station.region_frequencies[region][city];
        var list = [];

        for (var frequency in frequencies) {
            var frequency = frequencies[frequency];
            list.push(frequency.frequency + " " + frequency.band);
        }

        return list.join(', ');
    };

    // Checks if a region or city were passed, expands relevant frequencies
    $scope.highlightFrequencies = function () {
        // Extract our parameters
        var frequencies = $scope.station.region_frequencies;
        var region = $stateParams.region;
        var city = $stateParams.city;

        // Check if the station has frequencies for the region
        if (region && frequencies.hasOwnProperty(region)) {
            var element = '#region-' + $scope.slugify(region);
            $(element).collapse('toggle');
            $('html,body').animate({scrollTop: $(element).offset().top});

            // Check if the station has frequencies for the specific
            if (city && frequencies[region].hasOwnProperty(city)) {
                // TODO: Implement highlighting of <h4> elements
            }
        }
    };

    // Used to 'slugify' a string, make it safe for use in HTML IDs/classes
    $scope.slugify = function (string) {
        return string.replace(/\s/g, '');
    };

    // Called when the station banner is clicked
    $scope.stationClicked = function () {
        if (confirm("Are you sure you want to visit " + $scope.station.web_url + "?")) {
            $window.open($scope.station.web_url, '_blank');
        }
    };

    // Called when the description is tapped
    $scope.toggleDescTruncated = function () {
        $scope.isDescTruncated = !$scope.isDescTruncated;

        if ($scope.isDescTruncated) {
            $scope.description = $scope.station.description.substr(0, 300) + '...';
        } else {
            $scope.description = $scope.station.description;
        }
    };

    // Called when the Wikipedia article is tapped
    $scope.wikiClicked = function () {
        if (confirm("Are you sure you want to visit the Wikipedia article?")) {
            $window.open($scope.station.wiki_url, '_blank');
        }
    };

}]);
