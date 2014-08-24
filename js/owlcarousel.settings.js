/**
 * @file
 * Initiate Owl Carousel.
 */

(function($) {

  Drupal.behaviors.owlcarousel = {
    attach: function(context, settings) {


      console.log(settings.owlcarousel_id);
      console.log(settings);

      var owlcarousel_settings = settings.owlcarousel;
      //var owlcarousel_settings = {items:1};
      if ($("." + settings.owlcarousel_id + ' .view-content').length > 0) {
        $("." + settings.owlcarousel_id + ' .view-content').owlCarousel(owlcarousel_settings);
      }
      else {
        $("." + settings.owlcarousel_id).owlCarousel(owlcarousel_settings);
      }


      //for (var carousel in settings.owlcarousel) {
      //  // Carousel instance.
      //  var owl = $('#' + carousel);
      //
      //  // lazyLoad support.
      //  if (settings.owlcarousel[carousel].settings.lazyLoad) {
      //    var images = owl.find('img');
      //
      //    $.each(images, function(i, image) {
      //      $(image).attr('data-src', $(image).attr('src'));
      //    });
      //
      //    images.addClass('owl-lazy');
      //  }
      //
      //  // Attach instance settings.
      //  owl.owlCarousel(settings.owlcarousel[carousel].settings);
      //}
    }
  };

}(jQuery));
