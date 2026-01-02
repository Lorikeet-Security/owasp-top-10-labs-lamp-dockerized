(function ($) {

/**
 * Filters the module list table by a text input search string.
 *
 * Additionally accounts for multiple tables being wrapped in "package" fieldset
 * elements.
 */
Backdrop.behaviors.statusReport = {
  attach: function(context, settings) {
    var $table = $('table.system-status-report');

    // Hide the description for non-urgent items.
    $table.find('tr.report-info').find('.status-description').hide();
    $table.find('tr.report-status').find('.status-description').hide();

    // Change the text on more-urgent items.
    $table.find('tr.report-error').find('a.description-toggle').text(Backdrop.t('less'));
    $table.find('tr.report-warning').find('a.description-toggle').text(Backdrop.t('less'));

    // Toggle the requirements info.
    $('a.description-toggle').on('click', function(e) {
      var $description = $(this).closest('td').find('.status-description').toggle();
      if ($description.is(':visible')) {
        $(this).text(Backdrop.t('less'));
      }
      else {
        $(this).text(Backdrop.t('more'));
      }
      e.preventDefault();
      e.stopPropagation();
    });
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
