/**
 *  Locate controller
 */
app.controller('locateController', [
    '$scope', '$state', '$window', 'apiFactory', 'mapsFactory',
    function ($scope, $state, $window, api, maps) {

    // Region list
    $scope.regions = [];

    // Location result
    $scope.location = {
        region: '',
        country: ''
    };

    // State list
    $scope.states = {
        waiting: 0,
        failed: 1,
        located: 2,
        outside: 3
    };

    // Location state
    $scope.state = $scope.states.waiting;

    // Invokes the locate functionality
    $scope.locate = function () {
        // Location state
        $scope.state = $scope.states.waiting;

        // Check whether the client has geolocation support
        if (!navigator.geolocation) {
            $scope.state = $scope.states.unsupported;
        }

        // Attempt to capture Location
        navigator.geolocation.getCurrentPosition(
            function success(position) {
                // Attempt to reverse-geocode the coordinates
                maps.reverseGeocode(
                    position.coords,

                    function success(response) {
                        $scope.location = response.data;

                        // Check the client is inside New Zealand
                        if (response.data.country == 'New Zealand') {
                            // Check that we recognize the region
                            if ($scope.regions.indexOf(response.data.region) != -1) {
                                $scope.state = $scope.states.located;
                                return;
                            }
                        }

                        // Mark as "outside" our supported coverage otherwise
                        $scope.state = $scope.states.outside;
                    },

                    function error(response) {
                        $scope.state = $scope.states.failed;
                    }
                );
            },

            function error(error) {
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        $scope.error = "PERMISSION_DENIED - Access to your location was denied.";
                        break;

                    case error.POSITION_UNAVAILABLE:
                        $scope.error = "POSITION_UNAVAILABLE - Your position is unavailable.";
                        break;

                    case error.TIMEOUT:
                        $scope.error = "TIMEOUT - Maximum locate time was exceeded.";
                        break;

                    case error.UNKNOWN_ERROR:
                        $scope.error = "UNKNOWN_ERROR - We weren't able to locate you.";
                        break;
                }

                $scope.state = $scope.states.failed;
                $scope.$apply();
            },

            { timeout: 10000 }
        );
    };

    // Fetch region list from API
    api.getRegions().then(
        function success(response) {
            $scope.regions = response.data;

            // Run a location attempt
            $scope.locate();
        }
    );


    // Invoked when the "view station results" button is tapped
    $scope.viewStations = function () {
        $state.go('stations', { region: $scope.location.region });
    };

}]);
