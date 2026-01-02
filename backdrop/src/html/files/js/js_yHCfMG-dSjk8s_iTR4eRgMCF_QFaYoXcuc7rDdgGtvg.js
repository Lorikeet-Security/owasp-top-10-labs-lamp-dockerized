(function ($) {

/**
 * Attach handlers to evaluate the strength of any password fields.
 */
Backdrop.behaviors.passwordStrength = {
  attach: function (context, settings) {
    $('input[data-password-strength]', context).once('password-strength', function () {
      var $passwordInput = $(this);
      var passwordStrengthSettings = $passwordInput.data('passwordStrength');
      var passwordMeter = '<span class="password-strength"><span class="password-strength-title">' + passwordStrengthSettings.labels.strengthTitle + '</span><span class="password-strength-text" aria-live="assertive"></span><span class="password-indicator"><span class="indicator"></span></span></span>';
      $passwordInput.wrap('<span class="password-strength-wrapper"></span>').after(passwordMeter);
      var $innerWrapper = $passwordInput.parent();
      var $indicatorBar = $innerWrapper.find('.indicator');
      var $strengthText = $innerWrapper.find('.password-strength-text');
      var $strengthWrapper = $innerWrapper.find('.password-strength');

      // Check the password strength.
      var passwordCheck = function () {
        // Evaluate the password strength.
        var result = Backdrop.evaluatePasswordStrength($passwordInput.val(), passwordStrengthSettings);

        // Adjust the length of the strength indicator.
        $indicatorBar.css('width', result.strength + '%');

        // Update the strength indication text.
        $strengthText.html(passwordStrengthSettings.labels[result.level]);

        // Give a class to the strength.
        $strengthWrapper.attr('class', 'password-strength ' + result.level);
      };

      // Monitor keyup and blur events.
      // Blur must be used because a mouse paste does not trigger keyup.
      $passwordInput.on('keyup focus blur', passwordCheck).triggerHandler('blur');
    });
  }
};

/**
 * Attach handlers to evaluate the strength of any password fields.
 */
Backdrop.behaviors.passwordToggle = {
  attach: function (context, settings) {
    $('input[data-password-toggle]', context).once('password-toggle', function () {
      var $passwordInput = $(this);
      var passwordToggleSettings = $passwordInput.data('passwordToggle');
      var $passwordToggle = $('<a href="#" class="password-toggle" />').text(passwordToggleSettings.toggleShowTitle);

      // Use the same wrapper as the password strength indicator, if it's
      // already been added by the above behavior.
      if ($passwordInput.parent().is('.password-strength-wrapper')) {
        var $passwordWrapper = $passwordInput.parent().addClass('password-toggle-wrapper');
      }
      else {
        var $passwordWrapper = $passwordInput.wrap('<span class="password-toggle-wrapper"></span>').parent();
      }

      $passwordWrapper.addClass('password-hidden');
      $passwordInput.after($passwordToggle);

      var passwordToggle = function (e) {
        var showPassword = $passwordWrapper.is('.password-hidden');
        if (showPassword) {
          // Set the element to text and set the toggle to be "Hide".
          $passwordInput.attr('type', 'text');
          $passwordWrapper.removeClass('password-hidden').addClass('password-shown');
          $passwordToggle.text(passwordToggleSettings.toggleHideTitle);
        }
        else {
          // Set the element to password and set the toggle to be "Show".
          $passwordInput.attr('type', 'password');
          $passwordWrapper.removeClass('password-shown').addClass('password-hidden');
          $passwordToggle.text(passwordToggleSettings.toggleShowTitle);
        }
        e.preventDefault();
      };

      $passwordToggle.on('click', passwordToggle);
      if (passwordToggleSettings.toggleDefault === 'show') {
        $passwordToggle.triggerHandler('click');
      }

      // When submitting the form, convert back to a password field for the
      // sake of password managers.
      $($passwordInput[0].form).on('submit', function() {
        if ($passwordWrapper.is('.password-shown')) {
          $passwordToggle.triggerHandler('click');
        }
      });
    });

  }
};

/**
 * Attach handlers to password confirmation elements.
 */
Backdrop.behaviors.passwordConfirm = {
  attach: function (context, settings) {
    $('input[data-password-confirm]', context).once('password-confirm', function () {
      var $confirmInput = $(this);
      var $innerWrapper = $confirmInput.parent();
      var $outerWrapper = $innerWrapper.parent();
      var passwordConfirmSettings = $confirmInput.data('passwordConfirm');

      // Add the password confirmation layer.
      $outerWrapper.find('input.password-confirm').wrap('<span class="password-confirm-wrapper"></span>').after('<span class="password-match"><span class="password-match-title">' + passwordConfirmSettings.confirmTitle + '</span><span class="password-match-text"></span></span>').addClass('confirm-parent');
      var $passwordInput = $outerWrapper.find('input.password-field');
      var $matchResult = $outerWrapper.find('span.password-match');

      // Check that password and confirmation inputs match.
      var passwordCheckMatch = function () {

        if ($confirmInput.val()) {
          var success = $passwordInput.val() === $confirmInput.val();

          // Remove the previous styling if any exists.
          if (this.confirmClass) {
            $matchResult.removeClass(this.confirmClass);
          }

          // Fill in the success message and set the class accordingly.
          this.confirmClass = success ? 'match' : 'mismatch';
          $matchResult.addClass(this.confirmClass).find('.password-match-text').html(passwordConfirmSettings['confirm' + (success ? 'Success' : 'Failure')]);
        }
        else {
          this.confirmClass = 'empty';
          $matchResult.addClass(this.confirmClass);
        }
      };

      // Monitor keyup and blur events.
      // Blur must be used because a mouse paste does not trigger keyup.
      $passwordInput.on('keyup blur', passwordCheckMatch);
      $confirmInput.on('keyup blur', passwordCheckMatch).triggerHandler('blur');
    });
  }
};

/**
 * Evaluate the strength of a user's password.
 *
 * Returns the estimated strength and the relevant output message.
 */
Backdrop.evaluatePasswordStrength = function (password, settings) {
  var strength = 0;
  var level = 'empty';
  var data = settings.data;
  var config = settings.config;
  var username = data.username;
  var email = data.email;
  var hasLowercase = /[a-z]+/.test(password);
  var hasUppercase = /[A-Z]+/.test(password);
  var hasNumbers = /[0-9]+/.test(password);
  var hasPunctuation = /[^a-zA-Z0-9]+/.test(password);

  // If there is a username or email field on the page, compare the password to
  // that; otherwise use the value from the database.
  var usernameBox = $('input.username');
  if (usernameBox.length > 0) {
    username = usernameBox.val();
  }
  var emailBox = $('input.form-email');
  if (emailBox.length > 0) {
    email = emailBox.val();
  }

  // The strength estimator is adapted from the "naive strength estimation"
  // found in https://dropbox.tech/security/zxcvbn-realistic-password-strength-estimation.
  //
  // Strength is best measured as entropy. A more random password has a higher
  // entropy, and, therefore, is harder to guess. The naive strength estimation
  // looks like this:
  //
  // n: password length
  // c: password cardinality: the size of the symbol space
  //    (26 for lowercase letters only, 62 for a mix of lower+upper+numbers)
  // entropy = n * lg(c)
  //
  // This equation gives the entropy in units of "bits" (per symbol) because it
  // is using a logarithm of base 2. It's the number of times a space of
  // possible passwords can be cut in half. The length of a password has much
  // more influence on the entropy (that is, strength) than the diversity of
  // symbols. For example, "correcthorsebatterystaple" is a stronger password
  // than "aaAA11!!" even though the latter has a higher cardinality (symbol
  // diversity).

  // Calculate the number of unique character sets within a string.
  var cardinality = (hasLowercase * 26) + (hasUppercase * 26) + (hasNumbers * 10) + (hasPunctuation * 33);

  // Assign strength based on the level of entropy within the password, times
  // its length. Again, adapted from zxcvbn.
  strength = (Math.log(cardinality) / Math.log(2)) * password.length + 1;

  // Adjust the strength so that we hit our desired password length for each
  // threshold. As computers improve, the recommended minimum length increases.
  strength = strength * config.strengthModifier;

  // Check if password is the same as the username or email.
  if (password !== '') {
    password = password.toLowerCase();
    username = username.toLowerCase();
    email = email.toLowerCase();

    if (password === username || password === email) {
      strength = 5;
    }
  }

  // Based on the strength, work out what text should be shown by the password strength meter.
  if (strength >= 90) {
    level = 'strong';
  }
  else if (strength > 70) {
    level = 'good';
  }
  else if (strength > 50) {
    level = 'fair';
  }
  else if (strength > 0) {
    level = 'weak';
  }

  // Cap at 100 and round to the nearest integer.
  strength = parseInt(Math.min(strength, 100));

  // Assemble the final message.
  return { strength: strength, level: level };
};

/**
 * Field instance settings screen: force the 'Display on registration form'
 * checkbox checked whenever 'Required' is checked.
 */
Backdrop.behaviors.fieldUserRegistration = {
  attach: function (context, settings) {
    var $checkbox = $('form#field-ui-field-edit-form input#edit-instance-settings-user-register-form');

    if ($checkbox.length) {
      $('input#edit-instance-required', context).once('user-register-form-checkbox', function () {
        $(this).on('change', function (e) {
          if ($(this).prop('checked')) {
            $checkbox.prop('checked', true);
          }
        });
      });

    }
  }
};

})(jQuery);
;
(function ($) {

"use strict";

/**
 * Attaches sticky table headers.
 */
Backdrop.behaviors.tableHeader = {
  attach: function (context) {
    if (!$.support.positionFixed) {
      return;
    }
    var $tables = $(context).find('table.sticky-enabled:not(.sticky-processed)').addClass('sticky-processed');
    for (var i = 0, il = $tables.length; i < il; i++) {
      TableHeader.tables.push(new TableHeader($tables[i]));
    }
  }
};

function scrollValue(position) {
  return document.documentElement[position] || document.body[position];
}

// Helper method to loop through tables and execute a method.
function forTables(method, arg) {
  var tables = TableHeader.tables;
  for (var i = 0, il = tables.length; i < il; i++) {
    tables[i][method](arg);
  }
}

function tableHeaderResizeHandler() {
  forTables('recalculateSticky');
}

var scrollTimer;
function tableHeaderOnScrollHandler() {
  clearTimeout(scrollTimer);
  scrollTimer = setTimeout(function() {
    forTables('onScroll');
  }, 50);
}

function tableHeaderOffsetChangeHandler() {
  // Compute the new offset value.
  TableHeader.computeOffsetTop();
  forTables('stickyPosition', TableHeader.offsetTop);
}

// Bind event that need to change all tables.
$(window).on({
  /**
   * Bind only one event to take care of calling all scroll callbacks.
   */
  'scroll.TableHeader': tableHeaderOnScrollHandler
});

/**
 * When resizing table width and offset top can change, recalculate everything.
 */
Backdrop.optimizedResize.add(tableHeaderResizeHandler);

// Bind to custom Backdrop events.
$(document).on({
  /**
   * Recalculate columns width when window is resized and when show/hide
   * weight is triggered.
   */
  'columnschange.TableHeader': tableHeaderResizeHandler,

  /**
   * Offset value vas changed by a third party script.
   */
  'offsettopchange.TableHeader': tableHeaderOffsetChangeHandler
});

/**
 * Constructor for the tableHeader object. Provides sticky table headers.
 * TableHeader will make the current table header stick to the top of the page
 * if the table is very long.
 *
 * Fire a custom "offsettopchange" event to make TableHeader compute the
 * new offset value from the "data-offset-top" attributes of relevant elements.
 *
 * @param table
 *   DOM object for the table to add a sticky header to.*
 * @constructor
 */
function TableHeader(table) {
  var $table = $(table);
  this.$originalTable = $table;
  this.$originalHeader = $table.children('thead');
  this.$originalHeaderCells = this.$originalHeader.find('> tr > th');
  this.displayWeight = null;

  this.$originalTable.addClass('sticky-table');
  this.tableHeight = $table[0].clientHeight;
  this.tableOffset = this.$originalTable.offset();

  // React to columns change to avoid making checks in the scroll callback.
  this.$originalTable.on('columnschange', {tableHeader: this}, function (e, display) {
    var tableHeader = e.data.tableHeader;
    if (tableHeader.displayWeight === null || tableHeader.displayWeight !== display) {
      tableHeader.recalculateSticky();
    }
    tableHeader.displayWeight = display;
  });

  // Create and display sticky header.
  this.createSticky();
}

/**
 * Store the state of TableHeader.
 */
$.extend(TableHeader, {
   /**
    * This will store the state of all processed tables.
    *
    * @type {Array}
    */
   tables: [],

   /**
    * Cache of computed offset value.
    *
    * @type {Number}
    */
   offsetTop: 0,

  /**
   * Sum all [data-offset-top] values and cache it.
   */
  computeOffsetTop: function () {
    var $offsets = $('[data-offset-top]').not('.sticky-header');
    var value, sum = 0;
    for (var i = 0, il = $offsets.length; i < il; i++) {
      value = parseInt($offsets[i].getAttribute('data-offset-top'), 10);
      sum += !isNaN(value) ? value : 0;
    }
    this.offsetTop = sum;
    return sum;
  }
});

/**
 * Extend TableHeader prototype.
 */
$.extend(TableHeader.prototype, {
  /**
   * Minimum height in pixels for the table to have a sticky header.
   */
  minHeight: 100,

  /**
   * Absolute position of the table on the page.
   */
  tableOffset: null,

  /**
   * Absolute position of the table on the page.
   */
  tableHeight: null,

  /**
   * Boolean storing the sticky header visibility state.
   */
  stickyVisible: false,

  /**
   * Create the duplicate header.
   */
  createSticky: function () {
    // Clone the table header so it inherits original jQuery properties.
    var $stickyHeader = this.$originalHeader.clone(true);
    // Hide the table to avoid a flash of the header clone upon page load.
    this.$stickyTable = $('<table class="sticky-header"/>')
      .css({
        visibility: 'hidden',
        position: 'fixed',
        top: '0px'
      })
      .append($stickyHeader)
      .insertBefore(this.$originalTable);

    this.$stickyHeaderCells = $stickyHeader.find('> tr > th');

    // Initialize all computations.
    this.recalculateSticky();
  },

  /**
   * Set absolute position of sticky.
   *
   * @param offsetTop
   * @param offsetLeft
   */
  stickyPosition: function (offsetTop, offsetLeft) {
    var css = {};
    if (!isNaN(offsetTop) && offsetTop !== null) {
      css.top = offsetTop + 'px';
    }
    if (!isNaN(offsetLeft) && offsetTop !== null) {
      css.left = offsetLeft + 'px';
    }
    return this.$stickyTable.css(css);
  },

  /**
   * Returns true if sticky is currently visible.
   */
  checkStickyVisible: function () {
    var scrollTop = scrollValue('scrollTop');
    var tableTop = this.tableOffset.top - TableHeader.offsetTop;
    var tableBottom = tableTop + this.tableHeight;
    var visible = false;

    if (tableTop < scrollTop && scrollTop < (tableBottom - this.minHeight)) {
      visible = true;
    }

    this.stickyVisible = visible;
    return visible;
  },

  /**
   * Check if sticky header should be displayed.
   *
   * This function is throttled to once every 250ms to avoid unnecessary calls.
   */
  onScroll: function () {
    // Track horizontal positioning relative to the viewport.
    this.stickyPosition(null, scrollValue('scrollLeft'));
    this.$stickyTable.css('visibility', this.checkStickyVisible() ? 'visible' : 'hidden');
  },

  /**
   * Event handler: recalculates position of the sticky table header.
   */
  recalculateSticky: function () {
    // Update table size.
    this.tableHeight = this.$originalTable[0].clientHeight;

    // Update offset.
    TableHeader.computeOffsetTop();
    this.tableOffset = this.$originalTable.offset();
    var leftOffset = parseInt(this.$originalTable.offset().left);
    this.stickyPosition(TableHeader.offsetTop, leftOffset);

    // Update columns width.
    var $that = null;
    var $stickyCell = null;
    var display = null;
    // Resize header and its cell widths.
    // Only apply width to visible table cells. This prevents the header from
    // displaying incorrectly when the sticky header is no longer visible.
    for (var i = 0, il = this.$originalHeaderCells.length; i < il; i++) {
      $that = $(this.$originalHeaderCells[i]);
      $stickyCell = this.$stickyHeaderCells.eq($that.index());
      display = $that.css('display');
      if (display !== 'none') {
        $stickyCell.css({'width': $that.width(), 'display': display});
      }
      else {
        $stickyCell.css('display', 'none');
      }
    }
    this.$stickyTable.css('width', this.$originalTable.width());
  }
});

// Calculate the table header positions on page load.
window.setTimeout(function() {
  $(window).triggerHandler('scroll.TableHeader');
}, 100);

// Expose constructor in the public space.
Backdrop.TableHeader = TableHeader;

}(jQuery));
;
(function ($) {

/**
 * Toggle the visibility of a fieldset using smooth animations.
 */
Backdrop.toggleFieldset = function (fieldset) {
  var $fieldset = $(fieldset);
  if ($fieldset.is('.collapsed')) {
    var $content = $('> .fieldset-wrapper', fieldset).hide();
    var insideDialog = Boolean($fieldset.parents('.ui-dialog-content').length);
    $fieldset
      .removeClass('collapsed')
      .find('> legend span.fieldset-legend-prefix').html(Backdrop.t('Hide'));
    $content.slideDown({
      duration: 'fast',
      easing: 'linear',
      complete: function () {
        $fieldset.trigger({ type: 'collapsed', value: false });
        $(window).triggerHandler('resize');
        Backdrop.optimizedResize.trigger();
        if (insideDialog === false) {
          Backdrop.collapseScrollIntoView(fieldset);
        }
        fieldset.animating = false;
      }
    });
  }
  else {
    $('> .fieldset-wrapper', fieldset).slideUp('fast', function () {
      $fieldset
        .addClass('collapsed')
        .find('> legend span.fieldset-legend-prefix').html(Backdrop.t('Show'));
      $fieldset.trigger({ type: 'collapsed', value: true });
      $(window).triggerHandler('resize');
      Backdrop.optimizedResize.trigger();
      fieldset.animating = false;
    });
  }
};

/**
 * Scroll a given fieldset into view as much as possible.
 */
Backdrop.collapseScrollIntoView = function (node) {
  var h = document.documentElement.clientHeight || document.body.clientHeight || 0;
  var offset = document.documentElement.scrollTop || document.body.scrollTop || 0;
  var posY = $(node).offset().top;
  if (posY + node.offsetHeight > h + offset) {
    if (node.offsetHeight > h) {
      node.scrollIntoView({behavior: "smooth"});
    }
    else {
      node.scrollIntoView({behavior: "smooth", block: "end"});
    }
  }
};

Backdrop.behaviors.collapse = {
  attach: function (context, settings) {
    var hasHash = location.hash && location.hash != '#' && $(window).find(location.hash).length;
    $('fieldset.collapsible', context).once('collapse', function () {
      var $fieldset = $(this);
      // Expand fieldset if there are errors inside, or if it contains an
      // element that is targeted by the URI fragment identifier.
      var anchor = hasHash ? ', ' + location.hash : '';
      if ($fieldset.find('.error' + anchor).length) {
        $fieldset.removeClass('collapsed');
      }

      var summary = $('<span class="summary"></span>');
      $fieldset.
        on('summaryUpdated', function () {
          var text = $fieldset.backdropGetSummary();
          summary.html(text ? text : '');
        })
        .trigger('summaryUpdated');

      // Turn the legend into a clickable link, but retain span.fieldset-legend
      // for CSS positioning.
      var $legend = $('> legend .fieldset-legend', this);

      $('<span class="fieldset-legend-prefix element-invisible"></span>')
        .append($fieldset.hasClass('collapsed') ? Backdrop.t('Show') : Backdrop.t('Hide'))
        .prependTo($legend)
        .after(document.createTextNode(' '));

      // .wrapInner() does not retain bound events.
      var $link = $('<a class="fieldset-title" href="#"></a>')
        .prepend($legend.contents())
        .appendTo($legend)
        .on('click', function () {
          var fieldset = $fieldset.get(0);
          // Don't animate multiple times.
          if (!fieldset.animating) {
            fieldset.animating = true;
            Backdrop.toggleFieldset(fieldset);
          }
          return false;
        });

      $legend.append(summary);
    });
  }
};

})(jQuery);
;
/**
 * @file
 * Attaches behaviors for the Redirect module.
 */
(function ($) {

"use strict";

Backdrop.behaviors.redirectFieldsetSummaries = {
  attach: function (context) {
    $('fieldset.redirect-list', context).backdropSetSummary(function (context) {
      if ($('table.redirect-list tbody td.empty', context).length) {
        return Backdrop.t('No redirects');
      }
      else {
        var redirects = $('table.redirect-list tbody tr', context).length;
        return Backdrop.formatPlural(redirects, '1 redirect', '@count redirects');
      }
    });
  }
};

})(jQuery);
;
/**
 * @file
 * Attaches behaviors for the User module.
 */
(function ($) {

Backdrop.behaviors.userFieldsetSummaries = {
  // Provide the vertical tab summaries.
  attach: function (context) {
    var $context = $(context);

    // Account settings.
    $context.find('fieldset#edit-account-settings').backdropSetSummary(function() {
      var vals = [];

      // Status.
      var status = $context.find('input[name="status"]:checked').parent().find('label').text();
      vals.push(status.trim());

      // Roles.
      var roles = [];
      var $checkedRoles = $context.find('input[name^="roles"]:not([disabled]):checked');
      $checkedRoles.each(function() {
        roles.push($(this).parent().find('label').text().trim());
      });
      if (roles.length) {
        var rolesText = Backdrop.t('Roles:') + ' ' + roles.join(', ');
      }
      else {
        var rolesText = Backdrop.t('No roles');
      }
      vals.push(rolesText);

      return Backdrop.checkPlain(vals.join(', '));
    });

    // Personalization.
    $context.find('fieldset#edit-personalization').backdropSetSummary(function() {
      var vals = [];

      // Signature.
      var $signature = $context.find('textarea[name="signature[value]"]');
      if ($signature.length && $signature.val().length) {
        var signatureText = Backdrop.t('Signature');
      }
      else {
        var signatureText = Backdrop.t('No signature');
      }
      vals.push(signatureText);

      // Picture.
      var $pictureNew = $context.find('input[name="files[picture_upload]"]');
      var $pictureExisting = $context.find('.user-picture');
      if (($pictureNew.length && $pictureNew.val().length) || $pictureExisting.length) {
        var pictureText = Backdrop.t('Picture');
      }
      else {
        var pictureText = Backdrop.t('No picture');
      }
      vals.push(pictureText);

      return Backdrop.checkPlain(vals.join(', '));
    });

    // Region and language.
    $context.find('fieldset#edit-region-language').backdropSetSummary(function() {
      var vals = [];

      // Timezone.
      var $timezone = $context.find('select[name="timezone"]');
      if ($timezone.length && $timezone.val().length) {
        var timezoneText = Backdrop.t('Time zone:') + ' ' + $.trim($timezone.find(':selected').text());
        vals.push(timezoneText);
      }

      // Language.
      var $language = $context.find('input[name="language"]:checked');
      if ($language.length) {
        var languageText = Backdrop.t('Language:') + ' ' + $.trim($language.parent().find('label').text());
        vals.push(languageText);
      }

      return Backdrop.checkPlain(vals.join(', '));
    });

    // Contact form.
    $context.find('fieldset#edit-contact').backdropSetSummary(function() {
      if ($context.find('input[name="contact"]:checked').length) {
        return Backdrop.t('Enabled');
      }
      else {
        return Backdrop.t('Disabled');
      }
    });
  }
};

})(jQuery);
;
