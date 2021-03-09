'use strict';

(function($) {
  $(document).ready(function() {
    // Reload the cart
    if (woofc_vars.reload == 'yes') {
      woofc_cart_reload();
    }
  });

  // Auto show
  $(document.body).on('added_to_cart', function() {
    if ($('body').hasClass('woofc-body-show') ||
        (woofc_vars.auto_show === 'yes')) {
      setTimeout(function() {
        woofc_show_cart();
      }, 100);
    }
  });

  $(document.body).on('wc_fragments_loaded', function() {
    woofc_cart_loaded();
  });

  $(document.body).on('wc_fragments_refreshed', function() {
    woofc_cart_loaded();
  });

  // Manual show
  if (woofc_vars.manual_show != '') {
    $(document).on('click touch', woofc_vars.manual_show, function(e) {
      woofc_toggle_cart();
      e.preventDefault();
    });
  }

  // Qty minus & plus
  $(document).
      on('click touch', '.woofc-item-qty-plus, .woofc-item-qty-minus',
          function() {
            // get values
            var $qty = $(this).
                    closest('.woofc-item-qty').
                    find('.qty'),
                qty_val = parseFloat($qty.val()),
                max = parseFloat($qty.attr('max')),
                min = parseFloat($qty.attr('min')),
                step = $qty.attr('step');

            // format values
            if (!qty_val || qty_val === '' || qty_val === 'NaN') {
              qty_val = 0;
            }

            if (max === '' || max === 'NaN') {
              max = '';
            }

            if (min === '' || min === 'NaN') {
              min = 0;
            }

            if (step === 'any' || step === '' || step === undefined ||
                parseFloat(step) === 'NaN') {
              step = 1;
            } else {
              step = parseFloat(step);
            }

            // change the value
            if ($(this).is('.woofc-item-qty-plus')) {
              if (max && (
                  max == qty_val || qty_val > max
              )) {
                $qty.val(max);
              } else {
                $qty.val((qty_val + step).toFixed(woofc_decimal_places(step)));
              }
            } else {
              if (min && (
                  min == qty_val || qty_val < min
              )) {
                $qty.val(min);
              } else if (qty_val > 0) {
                $qty.val((qty_val - step).toFixed(woofc_decimal_places(step)));
              }
            }

            // trigger change event
            $qty.trigger('change');

            // trigger

          });

  // Qty on change
  $(document).on('change', '.woofc-area input.qty', function() {
    var item_key = $(this).attr('name');
    var item_qty = $(this).val();
    woofc_update_qty(item_key, item_qty);
  });

  // Qty validate
  var t = false;
  $(document).on('focus', '.woofc-area input.qty', function() {
    var thisQty = $(this);
    var thisQtyMin = thisQty.attr('min');
    var thisQtyMax = thisQty.attr('max');

    if ((
        thisQtyMin == null
    ) || (
        thisQtyMin == ''
    )) {
      thisQtyMin = 1;
    }

    if ((
        thisQtyMax == null
    ) || (
        thisQtyMax == ''
    )) {
      thisQtyMax = 1000;
    }

    t = setInterval(
        function() {
          if ((
              thisQty.val() < thisQtyMin
          ) || (
              thisQty.val().length == 0
          )) {
            thisQty.val(thisQtyMin);
          }
          if (thisQty.val() > thisQtyMax) {
            thisQty.val(thisQtyMax);
          }
        }, 500);
  });

  $(document).on('blur', '.woofc-area input.qty', function() {
    if (t != false) {
      window.clearInterval(t);
      t = false;
    }

    var item_key = $(this).attr('name');
    var item_qty = $(this).val();
    woofc_update_qty(item_key, item_qty);
  });

  // Remove item
  $('body').
      on('click touch', '.woofc-area .woofc-item-remove', function() {
        var item_key = $(this).attr('data-key');
        var item_name = $(this).attr('data-name');

        if (item_key === undefined) {
          item_key = $(this).closest('.woofc-item').attr('data-key');
        }

        if (item_name === undefined) {
          item_name = $(this).closest('.woofc-item').attr('data-name');
        }

        $(this).closest('.woofc-item').addClass('woofc-item-removing');
        woofc_remove_item(item_key, item_name);
        $(this).closest('.woofc-item').slideUp();
      });

  $(document).on('click touch', '.woofc-overlay', function() {
    woofc_hide_cart();
  });

  $(document).on('click touch', '.woofc-close', function() {
    woofc_hide_cart();
  });

  $(document).on('click touch', '.woofc-continue-url', function() {
    var url = $(this).attr('data-url');

    woofc_hide_cart();

    if (url != '') {
      window.location.href = url;
    }
  });

  $(document).on('click touch', '.woofc-empty-cart', function() {
    woofc_cart_loading();

    var data = {
      action: 'woofc_empty_cart',
      security: woofc_vars.nonce,
    };

    $.post(woofc_vars.ajaxurl, data, function(response) {
      woofc_cart_reload();
    });
  });

  // Count button
  $(document).on('click touch', '.woofc-count', function(e) {
    woofc_toggle_cart();
    e.preventDefault();
  });

  // Menu item
  $(document).on('click touch', '.woofc-menu-item a', function(e) {
    if (woofc_vars.cart_url != '') {
      window.location.href = woofc_vars.cart_url;
    } else {
      woofc_toggle_cart();
    }

    e.preventDefault();
  });

  // Cart
  $(document).on('click touch', '.woofc-cart, .woofc-btn', function(e) {
    woofc_toggle_cart();

    e.preventDefault();
  });

  // Cart link
  $(document).on('click touch', '.woofc-cart-link a', function(e) {
    if (woofc_vars.cart_url != '') {
      window.location.href = woofc_vars.cart_url;
    } else {
      woofc_toggle_cart();
    }

    e.preventDefault();
  });

  $(document).on('click', '.woofc-item-undo a', function(e) {
    e.preventDefault();
    woofc_cart_loading();

    var undo_key = $('body').attr('woofc-undo-key');
    var data = {
      action: 'woofc_undo_remove',
      item_key: undo_key,
      security: woofc_vars.nonce,
    };

    $.post(woofc_vars.ajaxurl, data, function(response) {
      woofc_cart_reload();
    });

    $('body').attr('woofc-undo-key', '');
    $('body').attr('woofc-undo-name', '');
  });
})(jQuery);

function woofc_decimal_places(num) {
  var match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);

  if (!match) {
    return 0;
  }

  return Math.max(
      0,
      // Number of digits right of decimal point.
      (match[1] ? match[1].length : 0)
      // Adjust for scientific notation.
      - (match[2] ? +match[2] : 0));
}

function woofc_update_qty(cart_item_key, cart_item_qty) {
  woofc_cart_loading();

  var data = {
    action: 'woofc_update_qty',
    cart_item_key: cart_item_key,
    cart_item_qty: cart_item_qty,
    security: woofc_vars.nonce,
  };

  jQuery.post(woofc_vars.ajaxurl, data, function(response) {
    woofc_cart_reload();

    jQuery(document.body).
        trigger('woofc_update_qty', [cart_item_key, cart_item_qty]);
  });
}

function woofc_remove_item(cart_item_key, cart_item_name) {
  woofc_cart_loading();

  var data = {
    action: 'woofc_remove_item',
    cart_item_key: cart_item_key,
    security: woofc_vars.nonce,
  };

  jQuery.post(woofc_vars.ajaxurl, data, function(response) {
    if (!response || !response.fragments) {
      return;
    }

    jQuery(document.body).
        trigger('removed_from_cart', [response.fragments, response.cart_hash]);

    jQuery('body').attr('woofc-undo-key', cart_item_key);
    jQuery('body').attr('woofc-undo-name', cart_item_name);
    woofc_cart_reload();

    jQuery(document.body).
        trigger('woofc_remove_item', [cart_item_key, cart_item_name, response]);
  });
}

function woofc_cart_loading() {
  jQuery('.woofc-area').addClass('woofc-area-loading');
  jQuery('.woofc-count').
      addClass('woofc-count-loading').
      removeClass('woofc-count-shake');

  jQuery(document.body).trigger('woofc_cart_loading');
}

function woofc_cart_reload() {
  var show = false;

  if (jQuery('body').hasClass('woofc-body-show')) {
    show = true;
  }

  jQuery(document.body).trigger('wc_fragment_refresh');

  if (show) {
    woofc_show_cart();
  }

  jQuery(document.body).trigger('woofc_cart_reload');
}

function woofc_cart_loaded() {
  var show = false;

  if (jQuery('body').hasClass('woofc-body-show')) {
    show = true;
  }

  jQuery('.woofc-area').removeClass('woofc-area-loading');
  jQuery('.woofc-count').
      removeClass('woofc-count-loading').
      addClass('woofc-count-shake');

  if (show) {
    woofc_show_cart();
  }

  if ((
      woofc_vars.undo_remove == 'yes'
  ) && (
      jQuery('body').attr('woofc-undo-key') != undefined
  ) && (
      jQuery('body').attr('woofc-undo-key') != ''
  )) {
    var undo_name = 'Item';

    if ((
        jQuery('body').attr('woofc-undo-name') != undefined
    ) && (
        jQuery('body').attr('woofc-undo-name') != ''
    )) {
      undo_name = '"' + jQuery('body').attr('woofc-undo-name') + '"';
    }

    jQuery('.woofc-area-mid').
        prepend(
            '<div class="woofc-item woofc-item-undo"><div class="woofc-item-inner">' +
            woofc_vars.removed_text.replace('%s', undo_name) + ' <a href="#">' +
            woofc_vars.undo_text +
            '</a></div></div>');
  }

  jQuery(document.body).trigger('woofc_cart_loaded');
}

function woofc_perfect_scrollbar() {
  jQuery('.woofc-area .woofc-area-mid').
      perfectScrollbar({suppressScrollX: true, theme: 'wpc'});
}

function woofc_show_cart() {
  jQuery('body').addClass('woofc-body-show');
  jQuery('.woofc-area').addClass('woofc-area-show');
  woofc_perfect_scrollbar();

  jQuery(document.body).trigger('woofc_show_cart');
}

function woofc_hide_cart() {
  jQuery('.woofc-area').removeClass('woofc-area-show');
  jQuery('body').removeClass('woofc-body-show');

  jQuery(document.body).trigger('woofc_hide_cart');
}

function woofc_toggle_cart() {
  if (jQuery('body').hasClass('woofc-body-show')) {
    woofc_hide_cart();
  } else {
    woofc_show_cart();
  }

  jQuery(document.body).trigger('woofc_toggle_cart');
}
