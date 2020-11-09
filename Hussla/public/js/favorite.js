$(document).ready(function () {
    var click_count = 0;



   $('#add-to-favorite').on('click', function (e) {
     if (click_count >= 1) {
         e.preventDefault();
     } else {
         var route = $('#add-favorite').data('route');
         var form_request = $('#add-favorite');
         console.log(click_count);
         click_count++

         $.ajax({
             type: "POST",
             url: route,
             data: form_request.serialize(),
             success: function(response) {
                 console.log(response);
             }
         })

         $('#added-tag').text('Added To Favorites!');
     }
   })
})
