$(document).ready(function() {

    $(".owl-carousel").slick({
          slidesToShow: 4,
          slidesToScroll: 1,
          loop:true,
          autoplay:true,
          autoplaySpeed:3000,
          infinite: true,
          pauseOnHover:true,
          swipe: true,
          arrows: false,
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 4,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 900,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1
              }
            }
          ]
    });
  });