/**
 *  Stations list controller
 */
app.controller('regionsListController', [ '$scope', '$state', 'apiFactory', function ($scope, $state, api) {

    // Region list
    $scope.regions = [];

    // Fetch region list from API
    api.getRegions().then(
        function success(response) {
            $scope.regions = response.data;
        }
    );

    // Invoked when a specific region is clicked/tapped
    $scope.regionClicked = function (region) {
        // Navigate to stations list, pass region
        $state.go('stations', { region: region });
    };

}]);
