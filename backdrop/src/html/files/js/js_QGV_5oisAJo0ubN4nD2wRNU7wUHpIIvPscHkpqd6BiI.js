/**
 * @file layout.admin.js
 *
 * Behaviors for editing a layout.
 */

(function ($) {

"use strict";

/**
 * Behavior for showing a list of layouts.
 *
 * Detect flexbox support for displaying our list of layouts with vertical
 * height matching for each row of layout template icons.
 */
Backdrop.behaviors.gridFloatFallback = {
  attach: function() {
    var $body = $('body');
    if (!$body.hasClass('grid-float-fallback-processed') && !Backdrop.featureDetect.flexbox()) {
      $('head').append('<link rel="stylesheet" type="text/css" href="/core/modules/layout/css/grid-float.css">');
      $body.addClass('grid-float-fallback-processed');
    }
  }
};

})(jQuery);
;
/**
 * @file
 * Attaches behaviors for the Contextual module.
 */

(function ($) {

Backdrop.contextualLinks = Backdrop.contextualLinks || {};

/**
 * Attaches outline behavior for regions associated with contextual links.
 */
Backdrop.behaviors.contextualLinks = {
  attach: function (context) {
    $('.contextual-links-wrapper', context).once('contextual-links', function () {
      var $wrapper = $(this);
      var $region = $wrapper.closest('.contextual-links-region');
      var $links = $wrapper.find('ul.contextual-links');
      var $trigger = $('<a class="contextual-links-trigger" href="#" />').text(Backdrop.t('Configure')).on('click',
        function () {
          $links.stop(true, true).slideToggle(100);
          $wrapper.toggleClass('contextual-links-active');
          return false;
        }
      );

      // Attach hover behavior to trigger and ul.contextual-links.
      $trigger.add($links).on('mouseenter', function () {
        $region.addClass('contextual-links-region-active');
      });
      $trigger.add($links).on('mouseleave', function () {
        $region.removeClass('contextual-links-region-active');
      });

      // Hide the contextual links when user clicks a link or rolls out of the
      // .contextual-links-region.
      $region.on('mouseleave click', Backdrop.contextualLinks.mouseleave);
      $region.on('mouseenter', function() {
        $trigger.addClass('contextual-links-trigger-active');
      });
      $region.on('mouseleave', function() {
        $trigger.removeClass('contextual-links-trigger-active');
      });

      // Prepend the trigger.
      $wrapper.prepend($trigger);
    });

    /**
     * Adjusts trigger positions in contextual links to avoid overlaps.
     */
    function adjustContextualLinks() {
      // Get all wrappers anywhere on the page and some info about each.
      var allWrappers = [];
      $('.contextual-links-wrapper', context).each(function() {
        allWrappers.push({
          '$wrapper': $(this),
          'regionOffsetBottom': $(this).parent().offset().top + $(this).parent().height(),
          'hShift': 0,
          'vShift': 0
        });
      });

      // Reset margins on all wrappers.
      allWrappers.forEach(function(info) {
        info.$wrapper.css('margin', '0');
      });

      // Recalculate margins to avoid collisions.
      var dir = $('html').attr('dir');
      const hSize = 28; // width of trigger wrapper
      const vSize = 19; // height of trigger wrapper
      var n = allWrappers.length;
      for (let i = 0; i < n; i++) {
        var follower = allWrappers[i];
        // Compare follower against all of its predecessors in the list (any of
        // which may have already been adjusted).
        for (let j = 0; j < i; j++) {
          var leader = allWrappers[j];
          // Adjust the position of follower if necessary to avoid collision
          // with leader.
          var leaderOffset = leader.$wrapper.offset();
          var followerOffset = follower.$wrapper.offset();
          // Check vertical overlap.
          if (!(followerOffset.top >= leaderOffset.top && followerOffset.top < leaderOffset.top + vSize)) {
            continue;
          }
          if (dir == 'ltr') {
            // Check horizontal overlap.
            if (followerOffset.left >= leaderOffset.left - hSize && followerOffset.left < leaderOffset.left + hSize) {
              // We have a collision; shift the follower down if there's room,
              // otherwise left.
              if (followerOffset.top + 2 * vSize <= follower.regionOffsetBottom) {
                // Shift down
                follower.vShift += vSize;
                follower.$wrapper.css('margin-top', follower.vShift);
              }
              else {
                // Shift left and start a new column.
                follower.vShift = 0;
                follower.hShift += hSize;
                follower.$wrapper.css('margin-top', follower.vShift);
                follower.$wrapper.css('margin-right', follower.hShift);
              }
            }
          }
          else { // rtl
            // Check horizontal overlap.
            if (followerOffset.left > leaderOffset.left - hSize && followerOffset.left <= leaderOffset.left + hSize) {
              // We have a collision; shift the follower down if there's room,
              // otherwise right.
              if (followerOffset.top + 2 * vSize <= follower.regionOffsetBottom) {
                // Shift down
                follower.vShift += vSize;
                follower.$wrapper.css('margin-top', follower.vShift);
              }
              else {
                // Shift right and start a new column.
                follower.vShift = 0;
                follower.hShift += hSize;
                follower.$wrapper.css('margin-top', follower.vShift);
                follower.$wrapper.css('margin-left', follower.hShift);
              }
            }
          }
        }
      }
    }
    $(document).ready(adjustContextualLinks);

    // Usually Backdrop.optimizedResize() would be used for a window resize
    // event, but this potentially expensive operation should be limited to
    // firing infrequently, so Backdrop.debounce() is used here instead.
    $(window).on('resize', Backdrop.debounce(adjustContextualLinks, 500));
  }
};

/**
 * Disables outline for the region contextual links are associated with.
 */
Backdrop.contextualLinks.mouseleave = function () {
  $(this)
    .find('.contextual-links-active').removeClass('contextual-links-active')
    .find('ul.contextual-links').hide();
};

})(jQuery);
;
(function ($) {

"use strict";

/**
 * Process elements with the .dropbutton class on page load.
 */
Backdrop.behaviors.dropButton = {
  attach: function (context, settings) {
    var $dropbuttons = $(context).find('.dropbutton-wrapper').once('dropbutton');
    if ($dropbuttons.length) {
      // Adds the delegated handler that will toggle dropdowns on click.
      var $body = $('body').once('dropbutton-click');
      if ($body.length) {
        $body.on('click', '.dropbutton-toggle', dropbuttonClickHandler);
      }
      // Initialize all buttons.
      for (var i = 0, il = $dropbuttons.length; i < il; i++) {
        DropButton.dropbuttons.push(new DropButton($dropbuttons[i], settings.dropbutton));
      }
    }
  }
};

/**
 * Set the min-width of dropbuttons (and their parent) to handle all of the
 * link widths.
 */
Backdrop.behaviors.dropButtonWidths = {
  attach: function(context, settings) {
    function adjustDropButtonWidths() {
      var $dropbutton = $(this);

      // Get widest item width.
      var widestItem = 0, $item;
      $dropbutton.find('li:hidden').each(function() {
        // Use a clone element to avoid altering element CSS properties.
        $item = $(this).clone().insertAfter($(this)).show().css('visibility', 'hidden');
        widestItem = Math.max($item.outerWidth(), widestItem);
        $item.remove();
      });

      // Set dropbutton list (<ul>) as wide as its widest child.
      $dropbutton.find('.dropbutton').css('min-width', widestItem + 'px');

      // Set parent element min-width, like <td class="operations"> to prevent
      // overflow issue (See #2806).
      $dropbutton.parent().css('min-width', $dropbutton.find('.dropbutton-widget').outerWidth() + 'px');
    }

    // Get the font size and family for an element in a dropbutton if one
    // exists. If none exist, then we don't need to do any processing.
    var $link = $('.dropbutton li a').first();
    if ($link.length == 0) {
      return;
    }
    var fontSize = $link.css('font-size');
    var fontList = $link.css('font-family').split(', ');
    var actualFont = fontList.find(font => document.fonts.check(fontSize + ` ${font}`));

    // Calculate dropbutton elements width once the font is loaded.
    Backdrop.isFontLoaded(actualFont, function() {
      $(context).find('.dropbutton-wrapper').once('dropbutton-width', adjustDropButtonWidths);
    });

  }
};

/**
 * Delegated callback for opening and closing dropbutton secondary actions.
 */
function dropbuttonClickHandler (e) {
  e.preventDefault();
  $(e.target).closest('.dropbutton-wrapper').toggleClass('open');
}

/**
 * A DropButton presents an HTML list as a button with a primary action.
 *
 * All secondary actions beyond the first in the list are presented in a
 * dropdown list accessible through a toggle arrow associated with the button.
 *
 * @param DOMElement dropbutton
 *   A DOM element.
 *
 * @param {Object} settings
 *   A list of options including:
 *    - {String} title: The text inside the toggle link element. This text is
 *      hidden from visual UAs.
 */
function DropButton (dropbutton, settings) {
  // Merge defaults with settings.
  var options = $.extend({'title': Backdrop.t('List additional actions')}, settings);
  var $dropbutton = $(dropbutton);
  this.$dropbutton = $dropbutton;
  this.$list = $dropbutton.find('.dropbutton');
  // Find actions and mark them.
  this.$actions = this.$list.find('li').addClass('dropbutton-action');

  // Add the special dropdown only if there are hidden actions.
  if (this.$actions.length > 1) {
    // Identify the first element of the collection.
    var $primary = this.$actions.slice(0,1);
    // Identify the secondary actions.
    var $secondary = this.$actions.slice(1);
    $secondary.addClass('secondary-action');
    // Add toggle link.
    $primary.after(Backdrop.theme('dropbuttonToggle', options));
    // Bind mouse events.
    this.$dropbutton
      .addClass('dropbutton-multiple')
      .on({
        /**
         * Adds a timeout to close the dropdown on mouseleave.
         */
        'mouseleave.dropbutton': $.proxy(this.hoverOut, this),
        /**
         * Clears timeout when mouseout of the dropdown.
         */
        'mouseenter.dropbutton': $.proxy(this.hoverIn, this),
        /**
         * Similar to mouseleave/mouseenter, but for keyboard navigation.
         */
        'focusout.dropbutton': $.proxy(this.focusOut, this),
        'focusin.dropbutton': $.proxy(this.focusIn, this)
      });
  }
  else {
    this.$dropbutton.addClass('dropbutton-single');
  }
}

/**
 * Extend the DropButton constructor.
 */
$.extend(DropButton, {
  /**
   * Store all processed DropButtons.
   *
   * @type {Array}
   */
  dropbuttons: []
});

/**
 * Extend the DropButton prototype.
 */
$.extend(DropButton.prototype, {
  /**
   * Toggle the dropbutton open and closed.
   *
   * @param {Boolean} show
   *   (optional) Force the dropbutton to open by passing true or to close by
   *   passing false.
   */
  toggle: function (show) {
    var isBool = typeof show === 'boolean';
    show = isBool ? show : !this.$dropbutton.hasClass('open');
    this.$dropbutton.toggleClass('open', show);
  },

  hoverIn: function () {
    // Clear any previous timer we were using.
    if (this.timerID) {
      window.clearTimeout(this.timerID);
    }
  },

  hoverOut: function () {
    // Wait half a second before closing.
    this.timerID = window.setTimeout($.proxy(this, 'close'), 500);
  },

  open: function () {
    this.toggle(true);
  },

  close: function () {
    this.toggle(false);
  },

  focusOut: function(e) {
    this.hoverOut.call(this, e);
  },

  focusIn: function(e) {
    this.hoverIn.call(this, e);
  }
});

/**
 * A toggle is an interactive element often bound to a click handler.
 *
 * @param {Object} options
 *   - {String} title: (optional) The HTML anchor title attribute and
 *     text for the inner span element.
 *
 * @return {String}
 *   A string representing a DOM fragment.
 */
Backdrop.theme.prototype.dropbuttonToggle = function (options) {
  return '<li class="dropbutton-toggle"><button type="button" role="button"><span class="dropbutton-arrow"><span class="visually-hidden">' + options.title + '</span></span></button></li>';
};

// Expose constructor in the public space.
Backdrop.DropButton = DropButton;

})(jQuery);
;
