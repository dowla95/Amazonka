/**
 * JQuery Simple MobileMenu
 * Copyright (c) 2017 Position2 Inc.
 * Licensed under MIT (http://mk_opensource.org/licenses/MIT)
 * https://github.com/Position2/jQuery-Simple-MobileMenu
 */
(function($) {
  var defaults = {
    "hamburgerId": "menu_ham", //Hamburger Id
    "wrapperClass": "sm_menu_outer", //Menu Wrapper Class
    "mk_submenuClass": "mk_submenu", //mk_submenu Class
    "menuStyle": "mk_slide", //Menu Style
    "onMenuLoad": function() { return true; }, //Calls when menu loaded
    "onMenuToggle": function() { return true; } //Calls when menu mk_open/close
  };
  $.fn.simpleMobileMenu = function(options) {
    if (this.length === 0) { return this; }
    var smMenu = {},
        ds = $(this);
    var init = function() {
      smMenu.settings = $.extend({}, defaults, options);
      smMenu.styleClass = smMenu.settings.menuStyle.toLowerCase() === 'mk_slide' ? "mk_slide" : "accordion";
      // Create Wrapper div & hamburger
      createWrapper_Ham();
      // Create Back Menu for each sub menu
      createBackButton();
      // Callback - Menu loaded
      if (typeof smMenu.settings.onMenuLoad == 'function') {
        smMenu.settings.onMenuLoad(ds);
      }
    },
    createWrapper_Ham = function() {
      smMenu.hamburger =  $("<div/>", {
                            "id": smMenu.settings.hamburgerId,
                            "html": "<div class='ham'><span></span><span></span><span></span><span></span></div>"
                          }),
      smMenu.smmOuter = $("<div/>", { "class": smMenu.settings.wrapperClass+" "+smMenu.styleClass });
      ds.appendTo(smMenu.smmOuter);
      smMenu.hamburger.add(smMenu.smmOuter).appendTo($("body"));
    },
    createBackButton = function() {
      smMenu.smmOuter.find("ul." + smMenu.settings.mk_submenuClass).each(function() {
        var dis = $(this),
          disPar = dis.closest("li"),
          disfA = disPar.find("> a"),
          disBack = $("<li/>", {
            "class": "back",
            "html": "<a href='#'>" + disfA.text() + "</a>"
          })
        disPar.addClass("mk_hasChild");
        if(smMenu.settings.menuStyle.toLowerCase() === 'mk_slide') {
          disBack.prependTo(dis);
        }
      });
    },
    toggleMobileMenu = function(e) {
      $("#" + smMenu.settings.hamburgerId).toggleClass("mk_open");
      $("." + smMenu.settings.wrapperClass).toggleClass("mk_active").find("li.mk_active").removeClass("mk_active");
      $("body").toggleClass("mmmk_active");
      // Callback - Menu Toggle
      if (typeof smMenu.settings.onMenuToggle == 'function') {
        smMenu.settings.onMenuToggle(ds, $("#" + smMenu.settings.hamburgerId).hasClass("mk_open"));
      }
    },
    showmk_slidemk_submenu = function(e) {
      $("." + smMenu.settings.wrapperClass).scrollTop(0);
      $(this).parent().addClass("mk_active").siblings().removeClass("mk_active");
    },
    showAccordionmk_submenu  = function(e) {
      e.preventDefault();
      var dis = $(this),
          dispar = $(this).parent(),
          lastmk_active =  dispar.siblings(".mk_active");
      dispar.find("> ."+smMenu.settings.mk_submenuClass).mk_slideToggle(function() {
        if ($(this).is(":visible")) { 
          var offset = dis[0].offsetTop;
          $("." + smMenu.settings.wrapperClass).stop().animate({ scrollTop: offset }, 300);
        }
      });
      lastmk_active.find("ul."+ smMenu.settings.mk_submenuClass).mk_slideUp(function() {
        $(this).find(".mk_hasChild").removeClass("mk_active");
      })
      dispar.toggleClass("mk_active").siblings().removeClass("mk_active");
    },
    goBack = function(e) {
      e.preventDefault();
      $(this).closest("ul." + smMenu.settings.mk_submenuClass).parent().removeClass("mk_active");
    }
    /*Init*/
    init();
    /* mk_open Menu */
    smMenu.hamburger.click(toggleMobileMenu);
    /* Show mk_slide mk_submenu */
    smMenu.smmOuter.filter(".mk_slide").find("li.mk_hasChild > a").click(showmk_slidemk_submenu);
    /* Show Accordion mk_submenu */
    smMenu.smmOuter.filter(".accordion").find("li.mk_hasChild > a").click(showAccordionmk_submenu);
    /* Go Back */
    smMenu.smmOuter.find("li.back a").click(goBack);
  };
})(jQuery)