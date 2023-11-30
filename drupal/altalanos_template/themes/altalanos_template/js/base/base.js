/**
* Global Scripts
**/

(function ($, Drupal, drupalSettings) {
    var targetElement;
    document.addEventListener('keyup', (e) => {

        if (e.keyCode == 9) {
            if (targetElement != $(e.target).parent() && $(e.target).parent().hasClass("visually-hidden") || $(e.target).parent().hasClass("comment__permalink")) {
                targetElement = $(e.target).parent();
                $(targetElement).addClass("make-visible");
                $(e.target).parent().css("display", "flex");
            } else {
                if ($(targetElement).hasClass("make-visible")) {
                    $(targetElement).removeClass("make-visible");
                }
            }
        }
    });
})(jQuery, Drupal, drupalSettings);