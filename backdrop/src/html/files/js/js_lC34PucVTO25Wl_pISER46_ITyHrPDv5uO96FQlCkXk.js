(function ($) {

Backdrop.behaviors.tableSelect = {
  attach: function (context, settings) {
    // Select the inner-most table in case of nested tables.
    $('th.select-all', context).closest('table').once('table-select', Backdrop.tableSelect);
  }
};

Backdrop.tableSelect = function () {
  // Do not add a "Select all" checkbox if there are no rows with checkboxes in the table
  if ($(this).find('td input[type="checkbox"]').length == 0) {
    return;
  }

  // Keep track of the table, which checkbox is checked and alias the settings.
  var table = this, checkboxes, lastChecked;
  var strings = { 'selectAll': Backdrop.t('Select all rows in this table'), 'selectNone': Backdrop.t('Deselect all rows in this table') };
  var updateSelectAll = function (state) {
    // Update table's select-all checkbox (and sticky header's if available).
    $(table).prev('table.sticky-header').addBack().find('th.select-all input[type="checkbox"]').each(function() {
      $(this).attr('title', state ? strings.selectNone : strings.selectAll);
      this.checked = state;
    });
  };

  // Find all <th> with class select-all, and insert the check all checkbox.
  $('th.select-all', table).prepend($('<input type="checkbox" class="form-checkbox" />').attr('title', strings.selectAll)).on('click', function (event) {
    if ($(event.target).is('input[type="checkbox"]')) {
      // Loop through all checkboxes and set their state to the select all checkbox' state.
      checkboxes.each(function () {
        this.checked = event.target.checked;
        // Either add or remove the selected class based on the state of the check all checkbox.
        $(this).closest('tr').toggleClass('selected', this.checked);
      });
      // Update the title and the state of the check all box.
      updateSelectAll(event.target.checked);
    }
  });

  // For each of the checkboxes within the table that are not disabled.
  checkboxes = $('td input[data-tableselect-id]:enabled', table);
  $(table).on('click', checkboxes, function (e) {
    // Either add or remove the selected class based on the state of the check all checkbox.
    $(this).closest('tr').toggleClass('selected', this.checked);

    // If this is a shift click, we need to highlight everything in the range.
    // Also make sure that we are actually checking checkboxes over a range and
    // that a checkbox has been checked or unchecked before.
    if (e.shiftKey && lastChecked && lastChecked != e.target) {
      // We use the checkbox's parent TR to do our range searching.
      Backdrop.tableSelectRange($(e.target).closest('tr')[0], $(lastChecked).closest('tr')[0], e.target.checked);
    }

    // If all checkboxes are checked, make sure the select-all one is checked too, otherwise keep unchecked.
    updateSelectAll((checkboxes.length == $(checkboxes).filter(':checked').length));

    // Keep track of the last checked checkbox.
    lastChecked = e.target;
  });

  // Explicitly update the select-all checkbox at page load time.
  updateSelectAll((checkboxes.length == $(checkboxes).filter(':checked').length));
};

Backdrop.tableSelectRange = function (from, to, state) {
  // We determine the looping mode based on the the order of from and to.
  var mode = from.rowIndex > to.rowIndex ? 'previousSibling' : 'nextSibling';

  // Traverse through the sibling nodes.
  for (var i = from[mode], $i; i; i = i[mode]) {
    // Make sure that we're only dealing with elements.
    if (i.nodeType != 1) {
      continue;
    }

    // Either add or remove the selected class based on the state of the target checkbox.
    $i = $(i);
    $i.toggleClass('selected', state);
    $i.find('input[type="checkbox"]').prop('checked', state);

    if (to.nodeType) {
      // If we are at the end of the range, stop.
      if (i == to) {
        break;
      }
    }
    // A faster alternative to doing $(i).filter(to).length.
    else if ($.filter(to, [i]).r.length) {
      break;
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
