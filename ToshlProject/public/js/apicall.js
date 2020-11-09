$(document).ready(function () {

    $('#category-checker').on('click', function() {
        var route = "https://api.toshl.com/categories";
        var schema = {
            "async" : true,
            "crossDomain" : true,
            "cache" : false,
            "url" : route,
            "dataType" : "jsonp",
            "method" : "GET",

            "headers" : {
                "accept" : "application/json",
                "Access-Control-Allow-Origin" : "*",
            }
        }

        $.ajax(schema).done(function (response) {
                console.log(response)
        })

    });

});
