$(document).ready(function () {
    var typingTimer;
    var doneTypingInterval = 1500;


    $('#email').keyup(function () {
       clearTimeout(typingTimer);
       typingTimer =setTimeout(doneTyping, doneTypingInterval);
    });

    $('#email').keydown(function () {
        clearTimeout(typingTimer);
    })

    $('#password').keyup(function () {
        clearTimeout(typingTimer);
        typingTimer =setTimeout(doneTyping, 1000);
    });

    $('#password').keydown(function () {
        clearTimeout(typingTimer);
    })
})

function doneTyping() {
    var route = $('#request-form').data('route');
    var form_request = $('#request-form');
    $('.warning').remove();

    $.ajax({
        type: 'POST',
        url: route,
        data: form_request.serialize(),
        success: function(Response) {
            console.log(Response);

            if(Response.success) {
                $('#password').css('border', '1px solid green');
                $('#email').css('border', '1px solid green');

                $("#submit-button").css('opacity', '1');

                    $('#submit-button').click(function () {
                        form_request.submit();
                    })
            }

            if(Response.email) {
                $('#invalid-mail-feedback').append('<p class="warning">' +Response.email+ '</p>');
                $('#submit-button').click(function (e) {
                    e.preventDefault();
                })

                $("#submit-button").css('opacity', '0.6');
                $('#email').css('border', '1px solid red');
            }

            if(Response.password) {
                $('#invalid-password-feedback').append('<p class="warning">' +Response.password + '</p>');
                $('#submit-button').click(function (e) {
                    e.preventDefault();
                })

                $("#submit-button").css('opacity', '0.6');
                $('#password').css('border', '1px solid red');
            }

        }
    });
}
