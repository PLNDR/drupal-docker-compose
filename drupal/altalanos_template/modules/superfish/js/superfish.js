/**
 * @file
 * The Superfish Drupal Behavior to apply the Superfish jQuery plugin to lists.
*/

(function ($, Drupal, drupalSettings) {
  // instance of the Superfish Menu Lib  to access callback functions
  var superFishScript = $.fn.superfish;
  'use strict';

  /**
   * jQuery Superfish plugin.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches the behavior to an applicable <ul> element.
   */
  Drupal.behaviors.superfish = {
    attach: function (context, drupalSettings) {
      // Take a look at each menu to apply Superfish to.
      $.each(drupalSettings.superfish || {}, function (index, options) {
        var $menu = $('ul#' + options.id, context);

        // Check if we are to apply the Supersubs plug-in to it.
        if (options.plugins || false) {
          if (options.plugins.supersubs || false) {
            $menu.supersubs(options.plugins.supersubs);
          }
        }

        // Apply Superfish to the menu.
        $menu.superfish(options.sf);

        // Check if we are to apply any other plug-in to it.
        if (options.plugins || false) {
          if (options.plugins.touchscreen || false) {
            $menu.sftouchscreen(options.plugins.touchscreen);
          }
          if (options.plugins.smallscreen || false) {
            $menu.sfsmallscreen(options.plugins.smallscreen);
          }
          if (options.plugins.supposition || false) {
            $menu.supposition();
          }
        }
      });
    }
  };

  // Click event listener onSuperfish menu items inside nav element
  //The listener was added to NAV element to handel mobile menu
  $(".header nav").on("click", function (e) {
    // preventing event default propagation
    e.preventDefault();
    // checking if the element target is an arrow or a link
    // of this is an arrow this is passed to Superfish Menu Lib 
    // of this is not an arrow the href attr
    if ($(e.target).hasClass("sf-sub-indicator")) {
      if ($(e.target).hasClass('open')) {
        superFishScript.defaults.onHide($(e.target));
      } else {
        superFishScript.defaults.onShow($(e.target));
      }
    } else {
      window.location.href = $(e.target).attr('href');
    }
  });

  //KeyPress event listener on Superfish menu items inside nav element
  //The listener was added to NAV element to handel mobile menu
  $(".header nav").keydown(function (e) {

    // If "Esc" is pressed when navigating the Menu items
    if (e.key === 'Escape') {
      superFishScript.defaults.onHide();
    }
    // Handel "Space" and "Enter" buttons actions
    if (e.keyCode == 13 || e.keyCode == 32) {
      e.preventDefault();
      if ($(e.target).hasClass('sf-sub-indicator')) {
        // Check if the element needs to be opened or closed
        if ($(e.target).hasClass('open')) {
          superFishScript.defaults.onHide($(e.target));
        } else {
          superFishScript.defaults.onShow($(e.target));
        }
      } else if ($(e.target).attr("id") == "superfish-main-toggle") {
        if ($(e.target).hasClass("sf-expanded")) {
          $(e.target).removeClass("sf-expanded");
          $("#superfish-main-accordion").addClass("sf-hidden").removeClass("sf-expanded");
          $("#superfish-main-accordion").css("display", "none");
        } else {
          $(e.target).addClass("sf-expanded");
          $("#superfish-main-accordion").addClass("sf-expanded").removeClass("sf-hidden");
          $("#superfish-main-accordion").css("display", "block");
        }
      } else {
        // Navigate browser window to target element "href"
        window.location.href = $(e.target).attr('href');
      }
    }
  });

  $("li.menuparent ul").attr('aria-hidden', true);
  // add "aria-haspopup" attribute to all menu items that have expandable content

  $("li.menuparent").attr("aria-haspopup", true);
  // add "aria-current='page' to active menu item"

  $("ul.sf-menu a.is-active").attr("aria-current", "page");
  // Hides admin toolbar menu on 'esc' key press

  document.addEventListener("keydown", function (e) {
    if (e.key === 'Escape') {
      if ($('.sf-sub-indicator').hasClass('open')) {
        superFishScript.defaults.onHide();
      }
    }
  });

  // Event listener that check if the click is outside of the Superfish Menu  
  document.addEventListener("click", function (e) {
    if (!$(e.target).parents('.menu.sf-menu').length == 1) {
      superFishScript.defaults.onHide();
    }
  });

})(jQuery, Drupal, drupalSettings);
