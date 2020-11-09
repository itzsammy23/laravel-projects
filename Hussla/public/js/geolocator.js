$(document).ready(function () {
    let GOOGLE_MAP_API_KEY = 'AIzaSyAwRUZ1icGWiaWI6F79NJ0MxbArjDo65Z4';
    var latitude_diff, location;

    $('#ranger').text($('#slider').val());
    $('#radius-param').val($('#slider').val());

    $('#slider').on('input', function () {
        $('#ranger').text($('#slider').val());
        $('#radius-param').val($('#slider').val());
    })

    function getAddress(latitude, longitude) {
        $.ajax('https://maps.googleapis.com/maps/api/geocode/json?latlng='
            + latitude + ',' + longitude + '&key=' +GOOGLE_MAP_API_KEY)
            .then(
                function success(response) {
                    console.log('User address data is ', response)
                    console.log(response.results[0].address_components[2].short_name)
                    $('#radiuslocation').val(response.results[0].address_components[2].short_name)
                    $('#setradius').submit();
                },

                function fail(status) {
                    //console.log('Request failed, Returned status of ', status)
                    alert('Request to get location failed');
                }
            )
    }

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function success(position) {
                        console.log('latitude', position.coords.latitude,
                            'longitude', position.coords.longitude);
                        getAddress(position.coords.latitude, position.coords.longitude);
                        latitude_diff = $('#slider').val() / ((2 * Math.PI * 6400) / 360);
                        location = latitude_diff + position.coords.latitude;
                        getAddress(location, position.coords.longitude)

                    },

                    function error(error_message) {
                        //console.log('Error retrieving location ', error_message);
                        alert('Error retrieving location');
                    }
                );
            } else {
                    //console.log("Geolocator not supported");
                    alert('Location not supported');
            }
}

    $('#radius').on('click', getLocation);
});
