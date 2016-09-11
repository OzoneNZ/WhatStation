app.factory('apiFactory', [ '$http', function ($http) {

    var urlBase = '/api';
    var apiFactory = {};


    /**
     *  Fetch genre list
     */
    apiFactory.getGenres = function () {
        return $http.get(urlBase + '/genres');
    };


    /**
     *  Fetch region list
     */
    apiFactory.getRegions = function () {
        return $http.get(urlBase + '/regions');
    };


    /**
     *  Fetch station list
     */
    apiFactory.getStations = function () {
        return $http.get(urlBase + '/stations');
    };


    /**
     *  Fetch specific station information
     */
    apiFactory.getStation = function (name) {
        return $http.get(urlBase + '/stations/' + name);
    };


    /**
     *  Fetch WhatStation statistics
     */
    apiFactory.getStatistics = function () {
        return $http.get(urlBase + '/statistics');
    };


    return apiFactory;

}]);
