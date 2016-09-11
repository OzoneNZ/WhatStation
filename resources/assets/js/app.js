/**
 *  Error alert function (global)
 */
function report(text) {
    var message = "Oh no, WhatStation hit a snag!\n\n";
    message += "Message: " + text + "\n\n";
    message += "Try again in a few minutes.";

    alert(message);
    window.location = "/";
}


/**
 *  Application routes
 */
app.config([ '$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise('/');

    $stateProvider

    // Index page
    .state('/', {
        url: '/',
        templateUrl: 'views/home.html',
        controller: 'homeController'
    })

    // Geolocation
    .state('locate', {
        url: '/locate',
        templateUrl: 'views/locate.html',
        controller: 'locateController'
    })

    // Region list
    .state('regions', {
        url: '/regions',
        templateUrl: 'views/regions.html',
        controller: 'regionsListController'
    })

    // Station list
    .state('stations', {
        url: '/stations/:region',
        templateUrl: 'views/stations.html',
        controller: 'stationsListController'
    })

    // Station view
    .state('station', {
        url: '/stations/:station/:region/:city',
        templateUrl: 'views/station.html',
        controller: 'stationController'
    });

}]);


/**
 *  Navigation controller
 */
app.controller('navigationController', [ '$scope', function ($scope) {

    // Invoked when the application state (route) is changed
    $scope.$on('$stateChangeStart', function() {
        $('.navbar-collapse').collapse('hide');
    });

}]);
