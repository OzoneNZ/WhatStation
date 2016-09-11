app.factory('mapsFactory', [ '$http', function ($http) {

    var mapsFactory = {};
    var urlBase = 'https://maps.googleapis.com/maps/api/geocode/json';
    var paramsBase = {
        key: 'AIzaSyCbQ5EG2Zn8vYfvhze0jaokopjKYKlMGTw'
    };


    /**
     *  Reverse-geocode a set of coordinates
     */
    mapsFactory.reverseGeocode = function (coords, successCallback, errorCallback) {
        // Inject API key and coordinates
        var params = {
            key: paramsBase.key,
            latlng: coords.latitude + ',' + coords.longitude
        };

        // Request reverse-geocoding from Google Maps API
        $http.get(urlBase, { params: params }).then(
            function success(response) {
                var address = {
                    region: '',
                    country: ''
                };

                if (response.data.status == "OK") {
                    for (var result in response.data.results) {
                        result = response.data.results[result];

                        for (var component in result.address_components) {
                            component = result.address_components[component];

                            // Detect region
                            if (component.types.indexOf('administrative_area_level_1') != -1) {
                                address.region = component.long_name;
                            }

                            // Detect country
                            if (component.types.indexOf('country') != -1) {
                                address.country = component.long_name;
                            }
                        }
                    }

                    // Inject our response, send back
                    response.data = address;
                    successCallback(response);    
                } else {
                    return errorCallback(response);
                }
            },

            function error(response) {
                errorCallback(response);
            }
        );
    };


    return mapsFactory;

}]);
