$(document).ready(function(){
  $('.lazy').slick({
    centerMode: false,
    lazyLoad: 'ondemand',
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: false,
    arrows: true,
    prevArrow: '<button type="button" class="slick-prev custom-arrow" aria-label="Previous slide"></button>',
    nextArrow: '<button type="button" class="slick-next custom-arrow" aria-label="Next slide"></button>',
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 2,
          arrows: true,
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          arrows: true,
          autoplay: true
        }
      }
    ]
  });
});
