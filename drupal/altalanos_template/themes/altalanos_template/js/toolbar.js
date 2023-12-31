/**
* DO NOT EDIT THIS FILE.
* See the following change record for more information,
* https://www.drupal.org/node/2815083
* @preserve
**/

(function ($, Drupal, drupalSettings) {
  var options = $.extend({
    breakpoints: {
      'toolbar.narrow': '',
      'toolbar.standard': '',
      'toolbar.wide': ''
    }
  }, drupalSettings.toolbar, {
    strings: {
      horizontal: Drupal.t('Horizontal orientation'),
      vertical: Drupal.t('Vertical orientation')
    }
  });
  Drupal.behaviors.toolbar = {
    attach: function attach(context) {
      if (!window.matchMedia('only screen').matches) {
        return;
      }

      once('toolbar', '#toolbar-administration', context).forEach(function (toolbar) {
        var model = new Drupal.toolbar.ToolbarModel({
          locked: JSON.parse(localStorage.getItem('Drupal.toolbar.trayVerticalLocked')),
          activeTab: document.getElementById(JSON.parse(localStorage.getItem('Drupal.toolbar.activeTabID'))),
          height: $('#toolbar-administration').outerHeight()
        });
        Drupal.toolbar.models.toolbarModel = model;
        Object.keys(options.breakpoints).forEach(function (label) {
          var mq = options.breakpoints[label];
          var mql = window.matchMedia(mq);
          Drupal.toolbar.mql[label] = mql;
          mql.addListener(Drupal.toolbar.mediaQueryChangeHandler.bind(null, model, label));
          Drupal.toolbar.mediaQueryChangeHandler.call(null, model, label, mql);
        });
        Drupal.toolbar.views.toolbarVisualView = new Drupal.toolbar.ToolbarVisualView({
          el: toolbar,
          model: model,
          strings: options.strings
        });
        Drupal.toolbar.views.toolbarAuralView = new Drupal.toolbar.ToolbarAuralView({
          el: toolbar,
          model: model,
          strings: options.strings
        });
        Drupal.toolbar.views.bodyVisualView = new Drupal.toolbar.BodyVisualView({
          el: toolbar,
          model: model
        });
        model.trigger('change:isFixed', model, model.get('isFixed'));
        model.trigger('change:activeTray', model, model.get('activeTray'));
        var menuModel = new Drupal.toolbar.MenuModel();
        Drupal.toolbar.models.menuModel = menuModel;
        Drupal.toolbar.views.menuVisualView = new Drupal.toolbar.MenuVisualView({
          el: $(toolbar).find('.toolbar-menu-administration').get(0),
          model: menuModel,
          strings: options.strings
        });
        Drupal.toolbar.setSubtrees.done(function (subtrees) {
          menuModel.set('subtrees', subtrees);
          var theme = drupalSettings.ajaxPageState.theme;
          localStorage.setItem("Drupal.toolbar.subtrees.".concat(theme), JSON.stringify(subtrees));
          model.set('areSubtreesLoaded', true);
        });
        Drupal.toolbar.views.toolbarVisualView.loadSubtrees();
        $(document).on('drupalViewportOffsetChange.toolbar', function (event, offsets) {
          model.set('offsets', offsets);
        });
        model.on('change:orientation', function (model, orientation) {
          $(document).trigger('drupalToolbarOrientationChange', orientation);
        }).on('change:activeTab', function (model, tab) {
          $(document).trigger('drupalToolbarTabChange', tab);
        }).on('change:activeTray', function (model, tray) {
          $(document).trigger('drupalToolbarTrayChange', tray);
        });

        if (Drupal.toolbar.models.toolbarModel.get('orientation') === 'horizontal' && Drupal.toolbar.models.toolbarModel.get('activeTab') === null) {
          Drupal.toolbar.models.toolbarModel.set({
            activeTab: $('.toolbar-bar .toolbar-tab:not(.home-toolbar-tab) a').get(0)
          });
        }

        if (localStorage.getItem("Drupal.toolbar.trayVerticalLocked") == undefined) {
          $('.toolbar-icon-toggle-vertical').click();
          $('.toolbar-icon-toggle-horizontal').click();
        }
        $('.toolbar-icon').show()
        $('.toolbar-tray-horizontal .toolbar-icon').keydown(function (e) {
          if (e.keyCode == 13 || e.keyCode == 32) {
            if ($(this).parent().parent().hasClass('hover-intent')) {
              $(this).parent().parent().removeClass('hover-intent');
            } else {
              $(this).parent().parent().addClass('hover-intent');
            }
          }
        });

        // Handle main (superfish) menu arrow keys
        $('li[class^=sf-depth-]').keydown(function(e) {
          switch (e.keyCode) {
            case 37:
              $(e.target).parent().prev().children('a').focus();
              navPrevAdmin(e);
              break;
            case 39:
              $(e.target).parent().next().children('a').focus();
              navNextAdmin(e);
              break;
            case 40:
              e.preventDefault();
              if ($(e.target).parent().hasClass('menuparent')) {
                $(e.target).children('span').addClass('open');
                $(e.target).children('span').attr('aria-pressed', true);
                $(e.target).parent().children('ul').css('display', 'block');
                $(e.target).parent().children('ul').children('li').first().children('a').focus();
              }
              break;
            default:
              break;
          }
        });

        function navNextAdmin(e) {
          e.preventDefault();
          $(e.target).parent().parent().next().children('.toolbar-box').children('a').focus();
        }

        function navPrevAdmin(e) {
          e.preventDefault();
          $(e.target).parent().parent().prev().children('.toolbar-box').children('a').focus();
        }

        function openSubmenuAdmin(e) {
          if ($(e.target).parent().parent().hasClass('menu-item--expanded')) {
            $(e.target).next().addClass('open');
            $(e.target).parent().parent().addClass('open');
            $(e.target).parent().parent().addClass('hover-intent');
            $(e.target).parent().parent().children('.toolbar-menu').children('.menu-item').first().children('.toolbar-box').children('a').focus();
          }
        }

        // Handle admin menu arrow keys
        $('.menu-item').keydown(function(e) {
          // Handling vertical and horizontal menu separately
          if (localStorage.getItem("Drupal.toolbar.trayVerticalLocked") == undefined) {
            switch (e.keyCode) {
              case 37:
                navPrevAdmin(e);
                break;
              case 39:
                navNextAdmin(e);
                break;
              case 40:
                openSubmenuAdmin(e);
                break;
              default:
                break;
            }
          } else {
            switch (e.keyCode) {
              case 38:
                navPrevAdmin(e);
                break;
              case 39:
                openSubmenuAdmin(e);
                break;
              case 40:
                navNextAdmin(e);
                break;
              default:
                break;
            }
          }
        });

        (function( func ) {
          $.fn.addClass = function(n) {
              this.each(function(i) {
                  var $this = $(this);
                  var prevClasses = this.getAttribute('class');
                  var classNames = $.isFunction(n) ? n(i, prevClasses) : n.toString();
                  $.each(classNames.split(/\s+/), function(index, className) {
                      if( !$this.hasClass(className) ) {
                          func.call( $this, className );
                          $this.trigger('classAdded', className);
                      }
                  });
                  if( prevClasses != this.getAttribute('class') ) $this.trigger('classChanged');
              });
              return this;
          }
        })($.fn.addClass);

        (function( func ) {
          $.fn.removeClass = function(n) {
              this.each(function(i) {
                  var $this = $(this);
                  var prevClasses = this.getAttribute('class');
                  var classNames = $.isFunction(n) ? n(i, prevClasses) : n.toString();
                  $.each(classNames.split(/\s+/), function(index, className) {
                      if( $this.hasClass(className) ) {
                          func.call( $this, className );
                          $this.trigger('classRemoved', className);
                      }
                  });
                  if( prevClasses != this.getAttribute('class') ) $this.trigger('classChanged');
              });
              return this;
          }
        })($.fn.removeClass);

        $(document).on('classRemoved', '.menu-item.menu-item--expanded', function(event, className) {
          $('.menu-item.menu-item--expanded:not(.hover-intent) .toolbar-handle').removeClass('open');
        });
        
        $(document).on('classAdded', '.menu-item.menu-item--expanded', function(event, className) {
          $('.menu-item.menu-item--expanded.hover-intent .toolbar-handle').first().addClass('open');
        });

        $('ul.toolbar-menu li.menu-item a', context).keydown(function (e) {
          if ((e.shiftKey && (e.keyCode || e.which) == 9)) {
            if ($(this).parent('.menu-item').prev().hasClass('menu-item--expanded')) {
              $(this).parent('.menu-item').prev().addClass('hover-intent');
            }
          }
        });

        if (localStorage.getItem("Drupal.toolbar.trayVerticalLocked") == undefined) {
          $('.toolbar-icon-toggle-vertical').click();
          $('.toolbar-icon-toggle-horizontal').click();
        }
        $('.toolbar-icon').show()

        $('ul.toolbar-menu li.menu-item a', context).keydown(function (e) {
          if ((e.shiftKey && (e.keyCode || e.which) == 9)) {
            if ($(this).parent('.menu-item').prev().hasClass('menu-item--expanded')) {
              $(this).parent('.menu-item').prev().addClass('hover-intent');
            }
          }
        });

        $('.toolbar-icon', context).keydown(function (e) {
          if (e.keyCode == 9) {
            $('.main-standardfront-page').focus();
          }
        });

        (function (func) {
          $.fn.addClass = function (n) {
            this.each(function (i) {
              var $this = $(this);
              var prevClasses = this.getAttribute('class');
              var classNames = $.isFunction(n) ? n(i, prevClasses) : n.toString();
              $.each(classNames.split(/\s+/), function (index, className) {
                if (!$this.hasClass(className)) {
                  func.call($this, className);
                  $this.trigger('classAdded', className);
                }
              });
              if (prevClasses != this.getAttribute('class')) $this.trigger('classChanged');
            });
            return this;
          }
        })($.fn.addClass);

        (function (func) {
          $.fn.removeClass = function (n) {
            this.each(function (i) {
              var $this = $(this);
              var prevClasses = this.getAttribute('class');
              var classNames = $.isFunction(n) ? n(i, prevClasses) : n.toString();
              $.each(classNames.split(/\s+/), function (index, className) {
                if ($this.hasClass(className)) {
                  func.call($this, className);
                  $this.trigger('classRemoved', className);
                }
              });
              if (prevClasses != this.getAttribute('class')) $this.trigger('classChanged');
            });
            return this;
          }
        })($.fn.removeClass);

        $(document).on('classRemoved', '.menu-item.menu-item--expanded', function (event, className) {
          $('.menu-item.menu-item--expanded:not(.hover-intent) .toolbar-handle').removeClass('open');
        });

        $(document).on('classAdded', '.menu-item.menu-item--expanded', function (event, className) {
          $('.menu-item.menu-item--expanded.hover-intent .toolbar-handle').first().addClass('open');
        });

        $('.toolbar-icon', context).keydown(function (e) {
          if (e.keyCode == 9) {
            $('.main-standardfront-page').focus();
          }
        });

        $(window).on({
          'dialog:aftercreate': function dialogAftercreate(event, dialog, $element, settings) {
            var $toolbar = $('#toolbar-bar');
            $toolbar.css('margin-top', '0');

            if (settings.drupalOffCanvasPosition === 'top') {
              var height = Drupal.offCanvas.getContainer($element).outerHeight();
              $toolbar.css('margin-top', "".concat(height, "px"));
              $element.on('dialogContentResize.off-canvas', function () {
                var newHeight = Drupal.offCanvas.getContainer($element).outerHeight();
                $toolbar.css('margin-top', "".concat(newHeight, "px"));
              });
            }
          },
          'dialog:beforeclose': function dialogBeforeclose() {
            $('#toolbar-bar').css('margin-top', '0');
          }
        });
      });
    }
  };
  Drupal.toolbar = {
    views: {},
    models: {},
    mql: {},
    setSubtrees: new $.Deferred(),
    mediaQueryChangeHandler: function mediaQueryChangeHandler(model, label, mql) {
      switch (label) {
        case 'toolbar.narrow':
          model.set({
            isOriented: mql.matches,
            isTrayToggleVisible: false
          });

          if (!mql.matches || !model.get('orientation')) {
            model.set({
              orientation: 'vertical'
            }, {
              validate: true
            });
          }

          break;

        case 'toolbar.standard':
          model.set({
            isFixed: mql.matches
          });
          break;

        case 'toolbar.wide':
          model.set({
            orientation: mql.matches && !model.get('locked') ? 'horizontal' : 'vertical'
          }, {
            validate: true
          });
          model.set({
            isTrayToggleVisible: mql.matches
          });
          break;

        default:
          break;
      }
    }
  };

  Drupal.theme.toolbarOrientationToggle = function () {
    return '<div class="toolbar-toggle-orientation"><div class="toolbar-lining">' + '<button class="toolbar-icon" type="button"></button>' + '</div></div>';
  };

  Drupal.AjaxCommands.prototype.setToolbarSubtrees = function (ajax, response, status) {
    Drupal.toolbar.setSubtrees.resolve(response.subtrees);
  };

})(jQuery, Drupal, drupalSettings);