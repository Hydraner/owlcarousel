/**
 * @file
 * Initiate Owl Carousel.
 */

(function($) {

  Drupal.behaviors.owlcarousel = {
    attach: function(context, settings) {

      for (owlcarousel_id in settings.owlcarousel) {
        // Initialize object.
        var owl = $("." + owlcarousel_id);
        if ($("." + owlcarousel_id + ' .view-content').length > 0) {
          owl = $("." + owlcarousel_id + ' .view-content');
        }

        // LazyLoad support.
        //if (settings.owlcarousel[owlcarousel_id].lazyLoad) {
        //  var images = owl.find('img');
        //  $.each(images, function (i, image) {
        //    $(image).attr('data-src', $(image).attr('src'));
        //  });
        //
        //  images.addClass('lazyOwl');
        //}

        // Attach settings.
        owl.owlCarousel(settings.owlcarousel[owlcarousel_id]);
      }

    }
  };

}(jQuery));
