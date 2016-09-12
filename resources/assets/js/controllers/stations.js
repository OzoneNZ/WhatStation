/**
 *  Stations list controller
 */
app.controller('stationsListController', [
    '$scope', '$state', '$stateParams', 'apiFactory',
    function ($scope, $state, $stateParams, api) {

    // Station list
    $scope.stations = [];

    // Filter object
    $scope.filter = {
        name: '',
        genre: ''
    };

    // Genre list
    $scope.genres = [];

    // Region list
    $scope.regions = [];

    // Fetch station list from API
    api.getStations().then(
        function success(response) {
            $scope.stations = response.data;
        },

        function error(response) {
            report("Unable to fetch station list.");
        }
    );

    // Fetch genre list
    api.getGenres().then(
        function success(response) {
            $scope.genres = response.data;
        }
    );

    // Fetch region list
    api.getRegions().then(
        function success(response) {
            $scope.regions = response.data;

            // Check if a region was passed as a parameter, apply it
            if ($stateParams.region) {
                if ($scope.regions.indexOf($stateParams.region) != -1) {
                    $scope.filter.region = $stateParams.region;
                }
            }
        }
    );

    // Clears all filters back to default values
    $scope.clearFilters = function () {
        $scope.filter.name = '';
        $scope.filter.genre = undefined;
        $scope.filter.region = undefined;
    };

    // Filters stations based on form inputs
    $scope.filterStation = function (station) {
        var inputGiven = false;
        var matched = true;

        // Check station name
        if ($scope.filter.name) {
            inputGiven = true;

            // Convert inputs to lowercase for case-insensitive comparison
            var filter = $scope.filter.name.toLowerCase();
            var name = station.name.toLowerCase();

            // Check if the station name contains our search
            if (name.indexOf(filter) == -1) {
                matched = false;
            }
        }

        // Check station genre
        if ($scope.filter.genre) {
            inputGiven = true;
            if (station.genre.name != $scope.filter.genre) {
                matched = false;
            }
        }

        // Check station region
        if ($scope.filter.region) {
            inputGiven = true;
            if (station.regions.indexOf($scope.filter.region) == -1) {
                matched = false;
            }
        }

        // Match if no input was given
        if (!inputGiven) {
            return true;
        } else { // Input was given, check whether a match was found
            if (matched) {
                return true;
            } else {
                return false;
            }
        }
    };

    // Invoked when a specific station is clicked/tapped
    $scope.stationClicked = function (station) {
        // Pack station into parameters
        var params = { station: station.name };

        // Add in the region if one was filtered
        if ($scope.filter.region) {
            params.region = $scope.filter.region;
        }

        // Navigate to station view
        $state.go('station', params);
    };

}]);
