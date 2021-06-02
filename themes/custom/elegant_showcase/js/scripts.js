jQuery(function ($) {
  'use strict';

  (function () {

    $('.partner-carousel').owlCarousel({
      loop: true,
      margin: 15,
      responsive: {
        0: {
          items: 2
        },
        600: {
          items: 3
        },
        1000: {
          items: 6
        }
      }
    });

    // Navigation
    var owl = $('.partner-carousel');
    owl.owlCarousel();

    // Go to the next item
    $('.partner-carousel-navigation .next').on('click', function () {
      owl.trigger('next.owl.carousel');
    });

    // Go to the previous item
    $('.partner-carousel-navigation .prev').on('click', function () {
      owl.trigger('prev.owl.carousel', [300]);
    });


  }());


  $(window).load(function () {
    var is_mobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

    if (is_mobile === false) {
      $.stellar({
        horizontalScrolling: false,
        responsive: true
      });
    }
  });
}); // JQuery end
