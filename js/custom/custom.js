(function ($) {
  // A: initVars.
  var wHeight;
  var documentWidth;
  var mobileSafari;
  var ratio;
  var zoomed;

  var YTdeferred = $.Deferred();
  window.onYouTubeIframeAPIReady = function() {
    YTdeferred.resolve(window.YT);
  };

  var tag = document.createElement('script');
  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

  // document ready
  $(document).ready(function($) {
    initVars();

    $('.video .player').each(function(e) {
      var player;
      var id = $(this).data('youtube');

      $(this).click(function(e) {
        e.preventDefault();

        $(this).closest('.video').addClass('playing');

        player = new YT.Player($(this)[0], {
          height: '100%',
          width: '100%',
          videoId: id,
          playerVars: {
            //controls: 0,
            autoplay: 1
          },
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });
      });
    })
  });

  function onPlayerReady(event) {
    var embedCode = event.target.getVideoEmbedCode();
    //event.target.playVideo();
    /*if (document.getElementById('embed-code')) {
     document.getElementById('embed-code').innerHTML = embedCode;
     }*/
  }

  function onPlayerStateChange(event) {

  }

  /**
   * Function to bind on each page load...
   */
  $(window).load(function($) {
    // 1: FadeIn.
    fadeIn();

    // 2: initTouch
    initTouch();

    // 3: initMenu.
    initMenu();

    // 4: svgFill.
    svgFill();

    // 1: initHomeAnimation.
    initHomeAnimation();

    // 5: initScroll.
    initScroll();

    // 6: initFormActions.
    initFormActions();

    // 7: initResize.
    initResize();

    // 10: Overlays.
    initOverlays();

    initCarousels();

    // 8: initInternalScrolls.
    initInternalScrolls();

    // 9: Selectric.
    initSelectric();

    //2: RecipeOverview.
    initRecipesOverview();

    // 11: FastClick.
    initFastClick();
  });

  /**
   * Behavior to apply homepage specific animations.
   *
   */
  Drupal.behaviors.triggerHomepageFunctionalities = {
    attach: function (context, $settings) {
      $('.front').once('triggerHomepageFunctionalities', function() {
        // 1: initHomeAnimation.
        initHomeAnimation();

        //2: RecipeOverview.
        initRecipesOverview();
      });
    }
  };

  /**
   * Behaviors to apply on Crumble pages.
   *
   */
  Drupal.behaviors.triggerCrumblesFunctionalities = {
    attach: function (context, settings) {
      $('body.crumbles').once('triggerCrumblesFunctionalities', function () {
        // 1: initCrumble.
        initRandomCrumble();
      });
    }
  };

  /**
   * Behaviors to apply on Carousel.
   *
   */
  /*Drupal.behaviors.triggerCarouselFunctionalities = {
    attach: function (context, settings) {
      $('body.receptdetail').once('triggerCarouselFunctionalities', function () {
        initCarousels();
      });
    }
  };*/

  /**
   * Behaviors to apply on Product overview.
   *
   */
  Drupal.behaviors.triggerProductOverviewFunctionalities = {
    attach: function (context, settings) {
      $('.page-our-biscuits').once('triggerProductOverviewFunctionalities', function () {
        initProductsOverview();
      });
    }
  };

  /**
   * Behaviors to apply on Product detail.
   *
   */
  Drupal.behaviors.triggerProductFunctionalities = {
    attach: function (context, settings) {
      $('.node-type-product').once('triggerProductFunctionalities', function () {
        initRecipesOverview();
      });
    }
  };

  /**
   * Behaviors to apply on Recipe overview.
   *
   */
  Drupal.behaviors.triggerRecipeOverviewFunctionalities = {
    attach: function (context, settings) {
      $('.page-recipes ').once('triggerRecipeOverviewFunctionalities', function () {
        initRecipesOverview();
        //initRecipeFilters();
      });
    }
  };

  Drupal.behaviors.triggerRecipeDetailFunctionalities = {
    attach: function (context, settings) {
      $('.receptdetail, .productdetail').once('triggerRecipeDetailFunctionalities', function () {
        window.fbAsyncInit = function(){
          FB.init({
            appId: Drupal.settings.facebook_app_id, status: true, cookie: true, xfbml: true });
        };
        (function(d, debug){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
          if(d.getElementById(id)) {return;}
          js = d.createElement('script'); js.id = id;
          js.async = true;js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
          ref.parentNode.insertBefore(js, ref);}(document, /*debug*/ false));
        function postToFeed(title, desc, url, image){
          var obj = {method: 'feed',link: url, picture: 'http://www.url.com/images/'+image,name: title,description: desc};
          function callback(response){}
          FB.ui(obj, callback);
        }

        $('.btnShare').click(function(){
          elem = $(this);
          postToFeed(elem.data('title'), elem.data('desc'), elem.prop('href'), elem.data('image'));

          return false;
        });
      });
    }
  };

  /**
   * Behaviors to apply on Reservation page.
   *
   */
  Drupal.behaviors.triggerReservationFunctionalities = {
    attach: function (context, settings) {
      $('body.page-booking').once('triggerReservationFunctionalities', function () {
        initReservation();
      });
    }
  };

  /**
   *  Slicing functionalities for referencing.
   *
   */
  // All pages.
  function initVars() {
    wHeight = $(window).height();

    // First check to see if the platform is an iPhone or iPod
    if (/iP/.test(navigator.platform) && /Safari/i.test(navigator.userAgent)) {
      mobileSafari = true;
    }
  }
  function fadeIn() {
    TweenLite.to($('body'), 1, {opacity: 1, ease: Power2.easeOut});
  }
  function initMenu() {
    $('#sidemenu').css('height', window.innerHeight + 'px');

    $('#icon-menu').click(function (e) {
      e.preventDefault();
      $('#sidemenu').addClass('open');
    });

    $('#sidemenu .icon-close').click(function (e) {
      e.preventDefault();
      $('#sidemenu').removeClass('open');
    });

    // Annoying as fuck
    // Thanks for that, mister senior
    if($('body').hasClass('front')) {
      if($(window).width() < 728) {
        TweenLite.to($('#sidemenu'), 1, {ease: Power2.easeOut, css:{"transform": "translate3d(65px, 0px, 0px)"}});
        TweenLite.to($('#sidemenu'), 1, {delay: 1, ease: Power2.easeOut, css:{"transform": "translate3d(0px, 0px, 0px)"}});
      }
    }

    $(document).mouseup(function (e) {
      var container = $('#sidemenu');
      if ($('#sidemenu').hasClass('open')) {
        if (!container.is(e.target) && container.has(e.target).length === 0) {
          $('#sidemenu').removeClass('open');
        }
      }
    });

    $('#header .langswitcher .langswitcher-current a').click(function (e) {
      e.preventDefault();
      if ($('#header .langswitcher').hasClass('open')) {
        $('#header .langswitcher .langswitcher-dropdown').slideUp(150);
        $('#header .langswitcher').removeClass('open');
      } else {
        $('#header .langswitcher .langswitcher-dropdown').slideDown(150);
        $('#header .langswitcher').addClass('open');
      }
    });
  }
  function svgFill() {
    $('img.svg').each(function () {
      var $img = $(this);
      var imgID = $img.attr('id');
      var imgClass = $img.attr('class');
      var imgURL = $img.attr('src');

      $.get(imgURL, function (data) {
        // Get the SVG tag, ignore the rest
        var $svg = $(data).find('svg');

        // Add replaced image's ID to the new SVG
        if (typeof imgID !== 'undefined') {
          $svg = $svg.attr('id', imgID);
        }
        // Add replaced image's classes to the new SVG
        if (typeof imgClass !== 'undefined') {
          $svg = $svg.attr('class', imgClass + ' replaced-svg');
        }

        // Remove any invalid XML tags as per http://validator.w3.org
        $svg = $svg.removeAttr('xmlns:a');

        // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
        if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
          $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
        }

        // Replace image with new SVG
        $img.replaceWith($svg);

      }, 'xml');
    });
  }
  function initScroll() {
    var scrolled, scrollD2, scrollD4, prevFrontIndex, currentFrontIndex, largest;

    var crumbleBefore = $('.crumbles-left');
    var crumbleAfter = $('.crumbles-right');
    var homejules = $('.front .quote .background');
    var homepager = $('.front .homepager');
    var frontSections = [];

    if (homepager.length) {
      $('.front .section').each(function (e) {
        frontSections.push($(this));
      });

      largest = frontSections[0];
      currentFrontIndex = prevFrontIndex = largest.data('pageindex');
      $('.front .homepager .hpage[data-pageindex="' + currentFrontIndex + '"]').addClass('active');
    }

    $(window).scroll(function (e) {
      scrolled = $(window).scrollTop();
      wHeight = window.innerHeight;
      scrollD2 = scrolled / 2;
      scrollD4 = scrolled / 4;
      scrollD1_2 = scrolled / 1.2 - scrolled;
      scrollD1_5 = scrolled / 1.5 - scrolled;

      if (crumbleBefore.length && crumbleAfter.length) {
        crumbleBefore.css({"transform": "translate3d(0px, " + (scrollD1_2) + "px, 0px)"});
        crumbleAfter.css({"transform": "translate3d(0px, " + (scrollD1_5) + "px, 0px)"});
      }

      if (homejules.length && (scrollD4 < 250 && scrollD4 > 0)) {
        homejules.css({"transform": "translate3d(0px, " + (-scrollD4) + "px, 0px)"});
      }

      if (homepager.length) {
        for (var i = 0; i < frontSections.length; i++) {
          if (frontSections[i].fracs().visible > largest.fracs().visible) {
            largest = frontSections[i];
          }
        }

        currentFrontIndex = largest.data('pageindex');

        if (currentFrontIndex !== prevFrontIndex) {
          $('.front .homepager .hpage').removeClass('active');
          $('.front .homepager .hpage[data-pageindex="' + currentFrontIndex + '"]').addClass('active');
          prevFrontIndex = currentFrontIndex;
        }
      }

      $('#sidemenu').css('height', window.innerHeight + 'px'); // Fix voor iOS gap onder menu
    });
  }
  function initFormActions() {
    /*$(".form-type-file input:file").change(function () {
      var fileName = $(this).val().replace("C:\\fakepath\\", "");
      $(this).closest('.form-type-file').find('.filename').html(fileName);
    });*/

    $(".selectbuttons .selectbutton").click(function (e) {
      e.preventDefault();
      $(this).closest(".selectbuttons").find(".selectbutton").removeClass("active");
      $(this).addClass("active");
      var selectedvalue = $(this).data('value');
      $(this).closest(".selectbuttons").find("input[type='hidden']").val(selectedvalue);
    });

    $('.submit').click(function (e) {
      e.preventDefault();
      if(checkFormErrors($(this).closest('form'))) {
        if ($(this).closest('form').hasClass('webform-client-form')) {
          $('input.webform-submit').trigger('mousedown');
        }
        else {
          if ($(this).closest('form').find('input.form-submit').hasClass('ajax-processed')) {
            $(this).closest('form').find('input.form-submit').trigger('mousedown');
          }
          else {
            $(this).closest('form').submit();
          }
        }
      }
    });
  }
  function initResize() {
    $(window).resize(function () {
      wHeight = $(window).height();
      $('.front .section.homehead').height(wHeight + 'px');
      $('.front .section.quote').height(wHeight + 'px');

      $('#sidemenu').css('height', window.innerHeight + 'px');
    });
  }
  function initInternalScrolls() {
    $('a.internal').click(function (e) {
      e.preventDefault();
      $('html, body').animate({
        scrollTop: $($(this).data('target')).offset().top
      }, 'slow');
    });
  }
  function initSelectric() {
    $('.selectrify').selectric();
  }

  // Homepage.
  function initHomeAnimation() {
    var wWidth;

    var bottom_maxXOffset, bottom_maxYOffset, bottom_maxRotYOffset, bottom_maxRotXOffset;
    var bottom_xOffset, bottom_yOffset, bottom_rotYOffset, bottom_rotXOffset;

    var text_maxXOffset, text_maxYOffset, text_maxRotYOffset, text_maxRotXOffset;
    var text_xOffset, text_yOffset, text_rotYOffset, text_rotXOffset;

    var top_maxXOffset, top_maxYOffset, top_maxRotYOffset, top_maxRotXOffset;
    var top_xOffset, top_yOffset, top_rotYOffset, top_rotXOffset;

    var top2_maxXOffset, top2_maxYOffset, top2_maxRotYOffset, top2_maxRotXOffset;
    var top2_xOffset, top2_yOffset, top2_rotYOffset, top2_rotXOffset;

    var topAnim;
    var centerAnim;
    var bottomAnim;

    $('.front .section.homehead').height(wHeight + 'px');
    $('.front .section.quote').height(wHeight + 'px');

    TweenLite.to($('.front .homehead .homeheadcontent h1'), 1, {
      opacity: 1,
      ease: Power2.easeOut,
      force3D: true
    });
    TweenLite.to($('.front .homehead .homeheadcontent .anim-bottom'), 2, {
      transform: 'scale3d(1,1,1)',
      ease: Power2.easeOut,
      force3D: true
    });
    TweenLite.to($('.front .homehead .homeheadcontent .anim-top-2'), 2.5, {
      transform: 'scale3d(1,1,1)',
      ease: Power2.easeOut,
      force3D: true
    });
    TweenLite.to($('.front .homehead .homeheadcontent .anim-top'), 3, {
      transform: 'scale3d(1,1,1)',
      ease: Power2.easeOut,
      force3D: true,
      onComplete: initMouseAnimation
    });


    /*$('.front .homehead .homeheadcontent').mouseout(function(e) {
     $(this).find('.anim-bottom').addClass('reset');
     $(this).find('h1').addClass('reset');
     $(this).find('.anim-top-2').addClass('reset');
     $(this).find('.anim-top').addClass('reset');
     });*/
  }

  // Crumble page.
  function initRandomCrumble() {
    if ($('body').hasClass('crumbles')) {
      var rndLeft = randomIntFromInterval(1,3)
      var rndRight = randomIntFromInterval(1,3);
      var rndMid = randomIntFromInterval(1,2);

      $('body').append('<div class="crumbles-left crumbles-left-'+rndLeft+'"></div>');
      $('body').append('<div class="crumbles-right crumbles-right-'+rndLeft+'"></div>');

      if(rndMid === 1) {
        $('body').addClass('extracrumb')
      }

      var crumbleBefore = $('.crumbles-left');
      var crumbleAfter = $('.crumbles-right');

      scrolled = $(window).scrollTop();
      wHeight = window.innerHeight;
      scrollD1_2 = scrolled/1.2 - scrolled;
      scrollD1_5 = scrolled/1.5 - scrolled;

      if(crumbleBefore.length && crumbleAfter.length) {
        crumbleBefore.css({"transform": "translate3d(0px, "+(scrollD1_2)+"px, 0px)"});
        crumbleAfter.css({"transform": "translate3d(0px, "+(scrollD1_5)+"px, 0px)"});
      }
    }
  }

  // Carousel.
  function initCarousels() {
    var owl = $(".steps-carousel")
    owl.owlCarousel({
      items: 1,
      margin: 4,
      nav: true,
      navRewind: false
    });

    setCarouselNavigation();

    owl.on('resized.owl.carousel', function (event) {
      setCarouselNavigation();
    });
  }

  // Product overview.
  function initProductsOverview() {
    $('.productlist .product a').mouseover(function (e) {
      $('.productlist .product').addClass('fade');
      $(this).closest('.product').removeClass('fade');
      $(this).closest('.product').addClass('over');
    });

    $('.productlist .product a').mouseout(function (e) {
      $('.productlist .product').removeClass('fade').removeClass('over');
    });
  }

  // Recipe overview.
  function initRecipesOverview() {
    $('.recipelist .recipe a').mouseover(function (e) {
      $('.recipelist .recipe').addClass('fade');
      $(this).closest('.recipe').removeClass('fade');
    });

    $('.recipelist .recipe a').mouseout(function (e) {
      $('.recipelist .recipe').removeClass('fade');
    });
  }
  function initRecipeFilters() {
    $('.filterlist a').click(function (e) {
      e.preventDefault();

      //$('.filterlist a').removeClass('active');
      $(this).toggleClass('active');
    })
  }

  // Reservation.
  function initReservation() {
    if ($('.calendar').length) {
      /*$('.calendar').datepicker(
          $.datepicker.regional['nl']
      );*/
    }

    // This...
    $('input[name="type"]').each ( function() {
      if ($(this).is(':checked')) {
        if ($(this).val() === "jds_workshop") {
          $('.demodetail-reworked').hide();
        }
      }
    });

    // ... Replaces this!
    /*$('input[name="workshopdemo"]').change(function (e) {
      //var selected = $(this).find("input[type='radio']:checked");
      var selected = $(this).val();
      if (selected == "demo") {
        $('.demodetail').slideDown();
      } else {
        $('.demodetail').slideUp();
      }
    });*/
  }

  // Overlays.
  function initOverlays() {
    $('a[data-overlay]').click(function (e) {
      e.preventDefault();
      $('body').addClass('noscroll');
      var overlay = $('.overlays .overlay[data-overlay="' + $(this).data('overlay') + '"]');
      TweenLite.to($('.overlays'), .250, {autoAlpha: 1, display: 'block'});
      TweenLite.to(overlay, .250, {autoAlpha: 1, display: 'block'});
    });

    $('.overlay .icon-close').click(function (e) {
      e.preventDefault();
      $('body').removeClass('noscroll');
      var overlay = $(this).closest('.overlay');
      TweenLite.to($('.overlays'), .250, {autoAlpha: 0, display: 'none'});
      TweenLite.to(overlay, .250, {autoAlpha: 0, display: 'none'});
    });
  }

  function initTouch() {
    if(!isTouchDevice()) {
      $('body').addClass('no-touch');
    }
  }

  function isTouchDevice() {
    return 'ontouchstart' in document.documentElement;
  }

  // Fastclick.
  function initFastClick() {
    var attachFastClick = Origami.fastclick;
    attachFastClick(document.body);
  }

  // Sub-functions.
  function setCarouselNavigation() {
    var imgHeight = $('.steps-carousel .step-img').height();
    $('.steps-carousel .owl-prev').css('top', (imgHeight / 2) - 20);
    $('.steps-carousel .owl-next').css('top', (imgHeight / 2) - 20);
  }
  function randomIntFromInterval(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
  }
  function initMouseAnimation() {
    $('.front .homehead .homeheadcontent').mouseover(function (e) {
      $(this).find('.anim-bottom').removeClass('reset');
      $(this).find('h1').removeClass('reset');
      $(this).find('.anim-top-2').removeClass('reset');
      $(this).find('.anim-top').removeClass('reset');
    });

    //$('.front).mousemove(function(e) {
    $('.front .homehead .homeheadcontent').mousemove(function (e) {
      wWidth = $(window).width();

      var rotXOffset = 300;
      var rotYOffset = 120;

      bottom_maxXOffset = wWidth / 100;
      bottom_maxYOffset = wHeight / 100;
      bottom_maxRotYOffset = wWidth / rotXOffset;
      bottom_maxRotXOffset = wHeight / rotYOffset;
      bottom_xOffset = (e.pageX / 100) - (bottom_maxXOffset / 2);
      bottom_yOffset = (e.pageY / 100) - (bottom_maxYOffset / 2);
      bottom_rotYOffset = (e.pageX / rotXOffset) - (bottom_maxRotYOffset / 2);
      bottom_rotXOffset = (e.pageY / rotYOffset) - (bottom_maxRotXOffset / 2);

      top2_maxXOffset = wWidth / 80;
      top2_maxYOffset = wHeight / 80;
      top2_maxRotYOffset = wWidth / rotXOffset;
      top2_maxRotXOffset = wHeight / rotYOffset;
      top2_xOffset = (e.pageX / 80) - (top2_maxXOffset / 2);
      top2_yOffset = (e.pageY / 80) - (top2_maxYOffset / 2);
      top2_rotYOffset = (e.pageX / rotXOffset) - (top2_maxRotYOffset / 2);
      top2_rotXOffset = (e.pageY / rotYOffset) - (top2_maxRotXOffset / 2);

      top_maxXOffset = wWidth / 10;
      top_maxYOffset = wHeight / 10;
      top_maxRotYOffset = wWidth / rotXOffset;
      top_maxRotXOffset = wHeight / rotYOffset;
      top_xOffset = (e.pageX / 10) - (top_maxXOffset / 2);
      top_yOffset = (e.pageY / 10) - (top_maxYOffset / 2);
      top_rotYOffset = (e.pageX / rotXOffset) - (top_maxRotYOffset / 2);
      top_rotXOffset = (e.pageY / rotYOffset) - (top_maxRotXOffset / 2);

      topAnim = TweenLite.to($(this).find('.anim-top'), 1, {
        ease: Power2.easeOut,
        css: {"transform": "perspective(1000px) translate3d(" + (-top_xOffset) + "px, " + (-top_yOffset) + "px, 0px) rotate3d(0, 1, 0, " + (-top_rotYOffset) + "deg) rotate3d(1, 0, 0, " + top_rotXOffset + "deg)"}
      });
      centerAnim = TweenLite.to($(this).find('.anim-top-2'), 1, {
        ease: Power2.easeOut,
        css: {"transform": "perspective(1000px) translate3d(" + (-top2_xOffset) + "px, " + (-top2_yOffset) + "px, 0px) rotate3d(0, 1, 0, " + (-top2_rotYOffset) + "deg) rotate3d(1, 0, 0, " + top2_rotXOffset + "deg)"}
      });
      bottomAnim = TweenLite.to($(this).find('.anim-bottom'), 1, {
        ease: Power2.easeOut,
        css: {"transform": "perspective(1000px) translate3d(" + (-bottom_xOffset) + "px, " + (-bottom_yOffset) + "px, 0px) rotate3d(0, 1, 0, " + (-bottom_rotYOffset) + "deg) rotate3d(1, 0, 0, " + bottom_rotXOffset + "deg)"}
      });
    });
  }
  function checkFormErrors($form) {
    var validator = new Validator();

    //$('form .formitem').each(function(e) {
    $form.find('.formitem').each(function(e) {
      if($(this).hasClass('required')) {
        if($(this).hasClass('form-type-text') || $(this).hasClass('form-type-password')) {
          if(validator.validateString($(this).find('input'))) {
            $(this).removeClass('has-error').addClass('has-success');
          } else {
            $(this).removeClass('has-success').addClass('has-error');
          }
        }
        if($(this).hasClass('form-type-telephone')) {
          if(validator.validatePhone($(this).find('input'))) {
            $(this).removeClass('has-error').addClass('has-success');
          } else {
            $(this).removeClass('has-success').addClass('has-error');
          }
        }
        if($(this).hasClass('form-type-textarea')) {
          if(validator.validateString($(this).find('textarea'))) {
            $(this).removeClass('has-error').addClass('has-success');
          } else {
            $(this).removeClass('has-success').addClass('has-error');
          }
        }
        if($(this).hasClass('form-type-email')) {
          if(validator.validateEmail($(this).find('input'))) {
            $(this).removeClass('has-error').addClass('has-success');
          } else {
            $(this).removeClass('has-success').addClass('has-error');
          }
        }
        if($(this).hasClass('form-type-checkbox')) {
          if(validator.validateCheckbox($(this).find('input').attr('name'))) {
            $(this).removeClass('has-error').addClass('has-success');
          } else {
            $(this).removeClass('has-success').addClass('has-error');
          }
        }
        if($(this).hasClass('form-type-radio')) {
          if(validator.validateRadioGroup($(this).find('input').attr('name'))) {
            $(this).removeClass('has-error').addClass('has-success');
          } else {
            $(this).removeClass('has-success').addClass('has-error');
          }
        }
        if($(this).hasClass('form-type-file')) {
          if($(this).find('.filename').html() != '') {
            $(this).removeClass('has-error').addClass('has-success');
          } else {
            $(this).removeClass('has-success').addClass('has-error');
          }
        }
      }
    });

    if($('.has-error').length == 0) {
      //$(this).closest('form').submit();
      return true;
    } else {
      return false;
    }
  }

  /**
   * Homepage Mailchimp behavior.
   *
   */
  Drupal.behaviors.triggerMailChimpForm = {
    attach: function (context, settings) {
      /*$('form a.submit', context).on('click', function(e) {
        if ($('#email').val() !== '') {
          //$('.form-submit').trigger('mousedown');
        }
      });*/
    }
  };

  /**
   * Behavior to prevent any action at all for the image grid
   * @type {{attach: Function}}
   */
  Drupal.behaviors.preventClickOnGallery = {
    attach: function(context, settings) {
      $('body.node-type-page', context).once('preventClickOnGallery', function() {
        $('a.imglink').on('click', function(e) {
          e.preventDefault();
        });
      })
    }
  };

  Drupal.behaviors.triggerFileUpload = {
    attach: function(context, settings) {
      if ($('.form-type-file').length) {
        $('.form-managed-file input[type=file]').each(function() {
          var forElement  = $(this).attr('id');
          $(this).parents().find('label').attr('for', forElement);
        });
      }
    }
  };

  /**
   * Drupal behavior for booking-calendar
   */
  Drupal.behaviors.setBookingCalendar = {
    attach: function (context, $settings) {
      // Remove the required fields for starters
      $('fieldset#edit-business').find('.formitem').removeClass('required');

      function validateForm() {
        var isValid = true;
        $('form#jds-confirm-booking-form .form-item').each(function() {
          if ($(this).hasClass('required') && $(this).val() === '' )
            isValid = false;
        });
        return isValid;
      }

      $('#edit-personcount', context).on('keyup change', function(e) {
        if (checkFormErrors($(this).closest('form'))) {
          var person_field  = $('#edit-personcount');
          var personcount   = person_field.val();

          if ((parseInt(person_field.attr('min')) > parseInt(personcount)) || (parseInt(personcount) > parseInt(person_field.attr('max')))) {
            $('#edit-personcount').parent().addClass('has-error');
          }
          else if (!personcount || personcount < 0) {
            $('#edit-personcount').parent().addClass('has-error');
          }
          else {
            setTimeout($('#edit-submit-booking-demo').click(), 1000);
          }
        }
      });

      var formElements = ['email', 'name', 'telephone', 'btw', 'country'];

      $.each(formElements, function(key, value) {
        $('form.jds-confirm-booking-form #' + value).bind('keyup change', function(e) {
          $('input#edit-booking-' + value).val($(this).val());
        });
      });

      $('#edit-booking-type .radioitem input').on('change', function(e) {
        var clicked_element = $(this).attr('id');

        if (clicked_element.indexOf('business') >= 0) {
          $('fieldset#edit-business').find('.formitem input.required').parent().addClass('required');
        }
        if (clicked_element.indexOf('private') >= 0) {
          $('fieldset#edit-business').find('.formitem').removeClass('required');
        }
      });

      $('.selectbutton').on('click', function(e) {
        e.preventDefault();
        $('#booking-hours').children('a.selectbutton').removeClass('active');
        $(this).addClass('active');

        $.each($settings.jds_booking_dates.available_dates, function(key, value) {
          if ($settings.jds_booking_dates.selectedDate === value.date) {
            var linkedNode = value.nid;
            $('input#edit-booking-linked-nid').val(linkedNode);
          }
        });
        $('input#edit-booking-chosen-product').val($(this).attr('data-product'));
      });

      $('a.selectbutton').on('click', function(e) {
        $(this).removeClass('haserror');
        $(this).siblings().removeClass('haserror');
      });

      $('a.tmpsubmit').on('click', function(e) {
        e.preventDefault();
        if ($('#booking-hours').find('a.active').length != 0) {
          $('#booking-hours').children('a.selectbutton').removeClass('haserror');
          $('.step2').slideUp();
          $('.step3').slideDown();

          $('input#edit-confirm-date-submit').trigger('mousedown');
        }
        else {
          $('#booking-hours').children('a.selectbutton').addClass('haserror');
        }
      });

      $('body.page-booking', context).once('setBookingCalendar', function() {

        $('a.infolink').on('click', function(e) {
          e.preventDefault();

          $('.step1').slideDown();
          $('.step2').slideUp();
        });

        function returnDates(array) {
          var newArray = [];

          $.each(array, function(key, value) {
            newArray.push(value.date);
          });

          return newArray;
        }

        // Get the correct dates from the PHP backend
        var all_dates           = $settings.jds_booking_dates.available_dates;
        var booked_dates        = $settings.jds_booking_dates.booked_dates;
        var availabe_dates      = returnDates(all_dates);
        var nonavailable_dates  = returnDates(booked_dates);

        // Build up the calendar, properly + add some functions to pass the value back to Drupal
        $('.calendar').datepicker({
          dateFormat: 'yy-mm-dd',
          minDate: 0,
          prevText: Drupal.t("Prev"),
          nextText: Drupal.t("Next"),
          beforeShowDay: function(date) {
            if($.inArray($.datepicker.formatDate('yy-mm-dd', date), nonavailable_dates) > -1) {
              return [false, 'booked', 'Fully booked'];
            } else if($.inArray($.datepicker.formatDate('yy-mm-dd', date), availabe_dates) > -1) {
              return [true, 'available', 'Available'];
            } else {
              return [false, 'not-available', "Not available"];
            }
          },
          onSelect: function(date) {
            var person_field  = $('#edit-personcount');
            var personcount   = person_field.val();

            if ((parseInt(person_field.attr('min')) > parseInt(personcount)) || (parseInt(personcount) > parseInt(person_field.attr('max')))) {
              $('#edit-personcount').parent().addClass('has-error');
            }
            else if (!personcount || personcount < 0) {
              $('#edit-personcount').parent().addClass('has-error');
            }
            else {
              var selectedProducts = [];

              $.each(all_dates, function (key, value) {
                if (date === value.date) {
                  selectedProducts.push(key);
                }
              });

              $settings.jds_booking_dates.selectedDate      = date;
              $settings.jds_booking_dates.selectedProducts  = selectedProducts;

              $('input#edit-booking-product-ids').val(selectedProducts);
              $('input#edit-booking-date').val(date);
              $('input#edit-booking-persons').val($('#edit-personcount').val());
              $('input#edit-confirm-date-submit').trigger('mousedown');

              $('.step1').slideUp();
              $('.step2').slideDown();
            }
          }
        });

        $('a.finalsubmit').on('click', function(e) {
          $('input#edit-confirm-date-submit').trigger('mousedown');
          e.preventDefault();
          if (validateForm()) {
            // Remove some obsolete fields
            if ($('input[name=booking_type]:checked', '#jds-confirm-booking-form').val() === 'private') {
              $('input#edit-booking-btw').val('');
              $('input#edit-booking-country').val('');
            }

            // Submit the form
            $('input#edit-confirm-date-submit').trigger('mousedown');
          }
          else {
            return;
          }
        });
      });
    }
  };

})(jQuery);
