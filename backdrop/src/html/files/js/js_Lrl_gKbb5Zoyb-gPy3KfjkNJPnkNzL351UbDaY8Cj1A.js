/**
 * @file
 * Hides the releases radio elements if only one release is available.
 */
(function ($) {

"use strict";

Backdrop.behaviors.installerSelectReleases = {
  attach: function (context, settings) {
    $('.installer-browser-releases-wrapper').hide();
    $('.installer-browser-selected-release').show();

    $('.installer-browser-show-releases-link').on('click', function (e) {
      var target = $(this).attr('rel');
      $('.installer-browser-release-' + target).show();
      $('.installer-browser-selected-release-' + target).hide();
      e.preventDefault();
      e.stopPropagation();
    })
  }
};

})(jQuery);
;
(function ($) {

"use strict";

/**
 * Add buttons to messages to allow users to dismiss them.
 */
Backdrop.behaviors.dismiss = {
  attach: function (context, settings) {

    $('.messages a.dismiss').on('click', function(event) {
      event.preventDefault();

      $(this).parent().fadeOut('fast', function() {
        if ($('.l-messages').children(':visible').length == 0) {
          $('.l-messages').hide();
        }
      });
    });

  }
};

})(jQuery);
;
