/**
 *  Station controller
 */
app.controller('homeController', [
    '$scope', 'apiFactory',
    function ($scope, api) {

    // Statistics object
    $scope.statistics = {
        frequencies: 0,
        stations: 0,
        regions: 0
    };

    // Fetch statistics from API
    api.getStatistics().then(
        function success(response) {
            $scope.statistics = response.data
        }
    );

}]);
