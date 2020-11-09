$(document).ready(function () {
    $("#parameter").keyup(function() {
        if($(this).val().length == 3 ) {
            var route = $('#search-data').data('route');
            var search_request = $('#search-data')
            $('.show-something').remove();
            $('hr').remove();
            $('#submit-data').remove();
            $.ajax({
                type: "GET",
                url: route,
                data: search_request.serialize(),
                success: function (Response) {
                    console.log(Response);


                    if(Response.users) {

                       for(var i = 0; i < Response.users.data.length; i++) {

                               $('#search-data-business').append('<p class="show-something"><a href="/view/profile/'+ Response.users.data[i].id +'">'
                                   +Response.users.data[i].businessname + ' <i class="fas fa-angle-double-right"></i></a> </p><p class="show-something">'
                                   +Response.users.data[i].businessaddress+ '</p><hr>');

                       }

                       $('#submit-data-button').append('<a class="submit-data" id="submit-data">See all results</a>');

                       $('#submit-data').click(function () {
                           search_request.submit();
                       })
                    }
                }
            })
        }
    })
})
