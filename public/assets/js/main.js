(function ($) {
  "use strict";
  /*=================================
      JS Index Here
  ==================================*/

  /**************************************
   ***** 01. Lenis & Gsap Basic Activation *****
   **************************************/
  gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

  // Button bounce

  if ($(".btn-trigger").length > 0) {
    gsap.set(".btn-bounce", { y: -100, opacity: 0 });
    var mybtn = gsap.utils.toArray(".btn-bounce");
    mybtn.forEach((btn) => {
      var $this = $(btn);
      gsap.to(btn, {
        scrollTrigger: {
          trigger: $this.closest(".btn-trigger"),
          start: "top center",
          markers: false,
        },
        duration: 1,
        ease: "bounce.out",
        y: 0,
        opacity: 1,
      });
    });
  } // Button bounce End

  // Fade Animation

  if ($(".fade_bottom").length > 0) {
    gsap.set(".fade_bottom", { y: 100, opacity: 0 });
    const fadeArray = gsap.utils.toArray(".fade_bottom");
    fadeArray.forEach((item, i) => {
      let fadeTl = gsap.timeline({
        scrollTrigger: {
          trigger: item,
          start: "top center+=400",
        },
      });
      fadeTl.to(item, {
        y: 0,
        opacity: 1,
        ease: "power2.out",
        duration: 1.5,
        stagger: {
          each: 0.2,
        },
      });
    });
  }

  if ($(".fade_left").length > 0) {
    gsap.set(".fade_left", { x: -100, opacity: 0 });
    const fadeleftArray = gsap.utils.toArray(".fade_left");
    fadeleftArray.forEach((item, i) => {
      let fadeTl = gsap.timeline({
        scrollTrigger: {
          trigger: item,
          start: "top center+=100",
        },
      });
      fadeTl.to(item, {
        x: 0,
        opacity: 1,
        ease: "power2.out",
        duration: 2.5,
      });
    });
  }

  if ($(".fade_right").length > 0) {
    gsap.set(".fade_right", { x: 100, opacity: 0 });
    const faderightArray = gsap.utils.toArray(".fade_right");
    faderightArray.forEach((item, i) => {
      let fadeTl = gsap.timeline({
        scrollTrigger: {
          trigger: item,
          start: "top center+=100",
        },
      });
      fadeTl.to(item, {
        x: 0,
        opacity: 1,
        ease: "power2.out",
        duration: 2.5,
      });
    });
  }

  // Fade Animation End

  // Title Anim

  let splitTitleLines = gsap.utils.toArray(".title-anim");

  splitTitleLines.forEach((splitTextLine) => {
    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: splitTextLine,
        start: "top 90%",
        end: "bottom 60%",
        scrub: false,
        markers: false,
        toggleActions: "play none none none",
      },
    });

    const itemSplitted = new SplitText(splitTextLine, { type: "words, lines" });
    gsap.set(splitTextLine, { perspective: 400 });
    itemSplitted.split({ type: "lines" });
    tl.from(itemSplitted.lines, {
      duration: 1,
      delay: 0.3,
      opacity: 0,
      rotationX: -80,
      force3D: true,
      transformOrigin: "top center -50",
      stagger: 0.1,
    });
  });

  // Title Animation End

  // Title Animation

  if ($(".char-animation").length > 0) {
    let char_come = gsap.utils.toArray(".char-animation");
    char_come.forEach((splitTextLine) => {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: splitTextLine,
          start: "top 90%",
          end: "bottom 60%",
          scrub: false,
          markers: false,
          toggleActions: "play none none none",
        },
      });

      const itemSplitted = new SplitText(splitTextLine, {
        type: "chars, words",
      });
      gsap.set(splitTextLine, { perspective: 300 });
      itemSplitted.split({ type: "chars, words" });
      tl.from(itemSplitted.chars, {
        duration: 1,
        delay: 0.5,
        x: 100,
        autoAlpha: 0,
        stagger: 0.05,
      });
    });
  }

  let text_animation = gsap.utils.toArray(".move-anim");

  if (text_animation) {
    text_animation.forEach((splitTextLine) => {
      var delay_value = 0.1;
      if (splitTextLine.getAttribute("data-delay")) {
        delay_value = splitTextLine.getAttribute("data-delay");
      }
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: splitTextLine,
          start: "top 85%",
          duration: 1,
          scrub: false,
          markers: false,
          toggleActions: "play none none none",
        },
      });

      const itemSplitted = new SplitText(splitTextLine, {
        type: "lines",
      });
      gsap.set(splitTextLine, {
        perspective: 400,
      });
      itemSplitted.split({
        type: "lines",
      });
      tl.from(itemSplitted.lines, {
        duration: 1,
        delay: delay_value,
        opacity: 0,
        rotationX: -80,
        force3D: true,
        transformOrigin: "top center -50",
        stagger: 0.1,
      });
    });
  }

  // GSAP Fade Animation
  let fadeArray_items = document.querySelectorAll(".fade-anim");
  if (fadeArray_items.length > 0) {
    const fadeArray = gsap.utils.toArray(".fade-anim");
    // gsap.set(fadeArray, {opacity:0})
    fadeArray.forEach((item, i) => {
      var fade_direction = "bottom";
      var onscroll_value = 1;
      var duration_value = 1.15;
      var fade_offset = 50;
      var delay_value = 0.15;
      var ease_value = "power2.out";

      if (item.getAttribute("data-offset")) {
        fade_offset = item.getAttribute("data-offset");
      }
      if (item.getAttribute("data-duration")) {
        duration_value = item.getAttribute("data-duration");
      }

      if (item.getAttribute("data-direction")) {
        fade_direction = item.getAttribute("data-direction");
      }
      if (item.getAttribute("data-on-scroll")) {
        onscroll_value = item.getAttribute("data-on-scroll");
      }
      if (item.getAttribute("data-delay")) {
        delay_value = item.getAttribute("data-delay");
      }
      if (item.getAttribute("data-ease")) {
        ease_value = item.getAttribute("data-ease");
      }

      let animation_settings = {
        opacity: 0,
        ease: ease_value,
        duration: duration_value,
        delay: delay_value,
      };

      if (fade_direction == "top") {
        animation_settings["y"] = -fade_offset;
      }
      if (fade_direction == "left") {
        animation_settings["x"] = -fade_offset;
      }

      if (fade_direction == "bottom") {
        animation_settings["y"] = fade_offset;
      }

      if (fade_direction == "right") {
        animation_settings["x"] = fade_offset;
      }

      if (onscroll_value == 1) {
        animation_settings["scrollTrigger"] = {
          trigger: item,
          start: "top 85%",
        };
      }
      gsap.from(item, animation_settings);
    });
  }

  /**************************************
   ***** 02. Back To Top *****
   **************************************/
  const btt = document.querySelector(".scrollToTop");

  // Add click functionality to scroll to the top
  btt.addEventListener("click", (e) => {
    e.preventDefault(); // Prevent default link behavior
    gsap.to(window, { duration: 1, scrollTo: 0 });
  });

  // Set initial styles
  gsap.set(btt, { autoAlpha: 0, y: 50 });

  // Animate the button visibility on scroll
  gsap.to(btt, {
    autoAlpha: 1,
    y: 0,
    scrollTrigger: {
      trigger: "body",
      start: "top -20%",
      end: "top -20%",
      toggleActions: "play none reverse none",
    },
  });

  /**************************************
   ***** 03. Preloader *****
   **************************************/
  $(window).on("load", function () {
    $(".preloader").delay(800).fadeOut("slow");
    $(".vs-hero").addClass("animate-elements");

    // Check if preloader exists and handle close event
    $(".preloader").length &&
      $(".preloaderCls").on("click", function (e) {
        e.preventDefault();
        $(".preloader").hide();
      });
  });

  /**************************************
   ***** 04. Data Scroll Inview Animation *****
   **************************************/
  const elements = document.querySelectorAll("[data-scroll]");
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-inview");
        } else {
          entry.target.classList.remove("is-inview");
        }
      });
    },
    {
      threshold: 0.1, // Adjusts when the element is considered "in view"
    }
  );
  elements.forEach((element) => observer.observe(element));

  /**************************************
   ***** 05. Data Navbar Stick *****
   **************************************/
  const tl = gsap.timeline({
    scrollTrigger: {
      trigger: "#navbars",
      start: "top+=300", // Trigger animation when scrolled 200px down
      end: "+=1",
      toggleActions: "play none none none",
      scrub: 1,
      duration: 0.2, // Duration of the animation
    },
  });
  // Initially hide the element
  gsap.set("#navbars", { opacity: 0, visibility: "hidden", y: -100 });
  // Animate to make it visible and slide down smoothly
  tl.to("#navbars", {
    opacity: 1,
    visibility: "visible",
    y: 0, // Slide down to its original position
    duration: 0.2, // Duration of the animation
    ease: "power2.out", // Smooth easing effect
  });

  /**************************************
   ***** 06. Reveal Image Animation *****
   **************************************/
  if ($(".reveal").length) {
    let revealContainers = document.querySelectorAll(".reveal");
    revealContainers.forEach((container) => {
      let image = container.querySelector("img");
      let tl = gsap.timeline({
        scrollTrigger: {
          trigger: container,
          toggleActions: "play none none none",
        },
      });
      tl.set(container, { autoAlpha: 1 });
      tl.from(container, 1.5, {
        xPercent: -100,
        ease: Power2.out,
      });
      tl.from(image, 1.5, {
        xPercent: 100,
        scale: 1.3,
        delay: -1.5,
        ease: Power2.out,
      });
    });
  }

  /**************************************
   ***** 07. Mobile Menu Activation *****
   **************************************/
  $.fn.vsmobilemenu = function (options) {
    var opt = $.extend(
      {
        menuToggleBtn: ".vs-menu-toggle",
        bodyToggleClass: "vs-body-visible",
        subMenuClass: "vs-submenu",
        subMenuParent: "vs-item-has-children",
        subMenuParentToggle: "vs-active",
        meanExpandClass: "vs-mean-expand",
        appendElement: '<span class="vs-mean-expand"></span>',
        subMenuToggleClass: "vs-open",
        toggleSpeed: 400,
      },
      options
    );

    return this.each(function () {
      var menu = $(this); // Select menu

      // Menu Show & Hide
      function menuToggle() {
        menu.toggleClass(opt.bodyToggleClass);

        // collapse submenu on menu hide or show
        var subMenu = "." + opt.subMenuClass;
        $(subMenu).each(function () {
          if ($(this).hasClass(opt.subMenuToggleClass)) {
            $(this).removeClass(opt.subMenuToggleClass);
            $(this).css("display", "none");
            $(this).parent().removeClass(opt.subMenuParentToggle);
          }
        });
      }

      // Class Set Up for every submenu
      menu.find("li").each(function () {
        var submenu = $(this).find("ul");
        submenu.addClass(opt.subMenuClass);
        submenu.css("display", "none");
        submenu.parent().addClass(opt.subMenuParent);
        submenu.prev("a").append(opt.appendElement);
        submenu.next("a").append(opt.appendElement);
      });

      // Toggle Submenu
      function toggleDropDown($element) {
        if ($($element).next("ul").length > 0) {
          $($element).parent().toggleClass(opt.subMenuParentToggle);
          $($element).next("ul").slideToggle(opt.toggleSpeed);
          $($element).next("ul").toggleClass(opt.subMenuToggleClass);
        } else if ($($element).prev("ul").length > 0) {
          $($element).parent().toggleClass(opt.subMenuParentToggle);
          $($element).prev("ul").slideToggle(opt.toggleSpeed);
          $($element).prev("ul").toggleClass(opt.subMenuToggleClass);
        }
      }

      // Submenu toggle Button
      var expandToggler = "." + opt.meanExpandClass;
      $(expandToggler).each(function () {
        $(this).on("click", function (e) {
          e.preventDefault();
          toggleDropDown($(this).parent());
        });
      });

      // Menu Show & Hide On Toggle Btn click
      $(opt.menuToggleBtn).each(function () {
        $(this).on("click", function () {
          menuToggle();
        });
      });

      // Hide Menu On out side click
      menu.on("click", function (e) {
        e.stopPropagation();
        menuToggle();
      });

      // Stop Hide full menu on menu click
      menu.find("div").on("click", function (e) {
        e.stopPropagation();
      });
    });
  };
  $(".vs-menu-wrapper").vsmobilemenu();

  /**************************************
   ***** 08. Set Background Image *****
   **************************************/
  if ($("[data-bg-src]").length > 0) {
    $("[data-bg-src]").each(function () {
      var src = $(this).attr("data-bg-src");
      $(this)
        .css("background-image", "url(" + src + ")")
        .addClass("background-image")
        .removeAttr("data-bg-src");
    });
  }

  /**************************************
   ***** 11. Ajax Dynamic Post Submission Form *****
   **************************************/
  // function ajaxContactForm(selectForm) {
  //   var form = selectForm;
  //   var invalidCls = "is-invalid";
  //   var $email = '[name="email"]';
  //   var $validation =
  //     '[name="name"],[name="email"],[name="phone"],[name="message"]'; // Remove [name="subject"]
  //   var formMessages = $(selectForm).next(".form-messages");

  //   function sendContact() {
  //     var formData = $(form).serialize();
  //     var valid;
  //     valid = validateContact();
  //     if (valid) {
  //       jQuery
  //         .ajax({
  //           url: $(form).attr("action"),
  //           data: formData,
  //           type: "POST",
  //         })
  //         .done(function (response) {
  //           // Make sure that the formMessages div has the 'success' class.
  //           formMessages.removeClass("error");
  //           formMessages.addClass("success");
  //           // Set the message text.
  //           formMessages.text(response);
  //           // Clear the form.
  //           $(form + ' input:not([type="submit"]),' + form + " textarea").val(
  //             ""
  //           );
  //         })
  //         .fail(function (data) {
  //           // Make sure that the formMessages div has the 'error' class.
  //           formMessages.removeClass("success");
  //           formMessages.addClass("error");
  //           // Set the message text.
  //           if (data.responseText !== "") {
  //             formMessages.html(data.responseText);
  //           } else {
  //             formMessages.html(
  //               "Oops! An error occurred and your message could not be sent."
  //             );
  //           }
  //         });
  //     }
  //   }

  //   function validateContact() {
  //     var valid = true;
  //     var formInput;
  //     function unvalid($validation) {
  //       $validation = $validation.split(",");
  //       for (var i = 0; i < $validation.length; i++) {
  //         formInput = form + " " + $validation[i];
  //         if (!$(formInput).val()) {
  //           $(formInput).addClass(invalidCls);
  //           valid = false;
  //         } else {
  //           $(formInput).removeClass(invalidCls);
  //           valid = true;
  //         }
  //       }
  //     }
  //     unvalid($validation);

  //     if (
  //       !$(form + " " + $email).val() ||
  //       !$(form + " " + $email)
  //         .val()
  //         .match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)
  //     ) {
  //       $(form + " " + $email).addClass(invalidCls);
  //       valid = false;
  //     } else {
  //       $(form + " " + $email).removeClass(invalidCls);
  //       valid = true;
  //     }
  //     return valid;
  //   }

  //   $(form).on("submit", function (element) {
  //     element.preventDefault();
  //     sendContact();
  //   });
  // }
  // ajaxContactForm(".ajax-contact");

  /**************************************
   ***** 12. Popup Sidebar Canvas Menu *****
   **************************************/
  function popupSideMenu($sideMenu, $sideMunuOpen, $sideMenuCls, $toggleCls) {
    // Sidebar Popup
    $($sideMunuOpen).on("click", function (e) {
      e.preventDefault();
      $($sideMenu).addClass($toggleCls);
    });
    $($sideMenu).on("click", function (e) {
      e.stopPropagation();
      $($sideMenu).removeClass($toggleCls);
    });
    var sideMenuChild = $sideMenu + " > div";
    $(sideMenuChild).on("click", function (e) {
      e.stopPropagation();
      $($sideMenu).addClass($toggleCls);
    });
    $($sideMenuCls).on("click", function (e) {
      e.preventDefault();
      e.stopPropagation();
      $($sideMenu).removeClass($toggleCls);
    });
  }
  popupSideMenu(
    ".sidemenu-wrapper",
    ".sideMenuToggler",
    ".sideMenuCls",
    "show"
  );

  /**************************************
   ***** 13. Popup Search Box *****
   **************************************/
  function popupSarchBox($searchBox, $searchOpen, $searchCls, $toggleCls) {
    $($searchOpen).on("click", function (e) {
      e.preventDefault();
      $($searchBox).addClass($toggleCls);
    });
    $($searchBox).on("click", function (e) {
      e.stopPropagation();
      $($searchBox).removeClass($toggleCls);
    });
    $($searchBox)
      .find("form")
      .on("click", function (e) {
        e.stopPropagation();
        $($searchBox).addClass($toggleCls);
      });
    $($searchCls).on("click", function (e) {
      e.preventDefault();
      e.stopPropagation();
      $($searchBox).removeClass($toggleCls);
    });
  }
  popupSarchBox(
    ".popup-search-box",
    ".searchBoxTggler",
    ".searchClose",
    "show"
  );

  /**************************************
   ***** 14. Magnific Popup *****
   **************************************/
  $(".popup-image").magnificPopup({
    type: "image",
    gallery: {
      enabled: true,
    },
  });

  /* magnificPopup video view */
  $(".popup-video").magnificPopup({
    type: "iframe",
  });

  /**************************************
   ***** 15. WoW Js Animation *****
   **************************************/
  var wow = new WOW({
    boxClass: "wow",
    animateClass: "wow-animated",
    offset: 0,
    mobile: false,
    live: true,
    scrollContainer: null,
    resetAnimation: false,
  });
  wow.init();

  /**************************************
   ***** 16. Indicator Position *****
   **************************************/
  function setPos(element) {
    var indicator = element.siblings(".indicator"),
      btnWidth = element.css("width"),
      btnHiehgt = element.css("height"),
      btnLeft = element.position().left,
      btnTop = element.position().top;
    element.addClass("active").siblings().removeClass("active");
    indicator.css({
      left: btnLeft + "px",
      top: btnTop + "px",
      width: btnWidth,
      height: btnHiehgt,
    });
  }

  $(".login-tab a").each(function () {
    var link = $(this);
    if (link.hasClass("active")) setPos(link);
    link.on("mouseover", function () {
      setPos($(this));
    });
  });

  /**************************************
   ***** 17. Color Plate Js *****
   **************************************/
  if ($(".vs-color-plate").length) {
    var oldValue = $("#plate-color").val();
    $("#plate-color").on("change", function (e) {
      var color = e.target.value;
      $("body").css("--theme-color", color);
    });

    $("#plate-reset").on("click", function () {
      $("body").css("--theme-color", "");
      $("#plate-color").val(oldValue);
    });

    $("#plate-toggler").on("click", function () {
      $(".vs-color-plate").toggleClass("open");
    });
  }

  /**************************************
   ***** 18. Quantity Increase and Decrease *****
   **************************************/
  $(".quantity-plus").each(function () {
    $(this).on("click", function (e) {
      e.preventDefault();
      var $qty = $(this).closest(".quantity-container").find(".qty-input");
      var currentVal = parseInt($qty.val());
      if (!isNaN(currentVal)) {
        $qty.val(formatNumber(currentVal + 1));
      }
    });
  });
  $(".quantity-minus").each(function () {
    $(this).on("click", function (e) {
      e.preventDefault();
      var $qty = $(this).closest(".quantity-container").find(".qty-input");
      var currentVal = parseInt($qty.val());
      if (!isNaN(currentVal) && currentVal > 1) {
        $qty.val(formatNumber(currentVal - 1));
      }
    });
  });
  // Function to format the number with leading zeros
  function formatNumber(num) {
    return num.toString().padStart(2, "0");
  }

  /**************************************
   ***** 19. Woocommerce Toggle *****
   **************************************/
  // Ship To Different Address
  $("#ship-to-different-address-checkbox").on("change", function () {
    if ($(this).is(":checked")) {
      $("#ship-to-different-address").next(".shipping_address").slideDown();
    } else {
      $("#ship-to-different-address").next(".shipping_address").slideUp();
    }
  });

  // Login Toggle
  $(".woocommerce-form-login-toggle a").on("click", function (e) {
    e.preventDefault();
    $(".woocommerce-form-login").slideToggle();
  });

  // Coupon Toggle
  $(".woocommerce-form-coupon-toggle a").on("click", function (e) {
    e.preventDefault();
    $(".woocommerce-form-coupon").slideToggle();
  });

  // Woocommerce Shipping Method
  $(".shipping-calculator-button").on("click", function (e) {
    e.preventDefault();
    $(this).next(".shipping-calculator-form").slideToggle();
  });

  // Woocommerce Payment Toggle
  $('.wc_payment_methods input[type="radio"]:checked')
    .siblings(".payment_box")
    .show();
  $('.wc_payment_methods input[type="radio"]').each(function () {
    $(this).on("change", function () {
      $(".payment_box").slideUp();
      $(this).siblings(".payment_box").slideDown();
    });
  });

  // Woocommerce Rating Toggle
  $(".rating-select .stars a").each(function () {
    $(this).on("click", function (e) {
      e.preventDefault();
      $(this).siblings().removeClass("active");
      $(this).parent().parent().addClass("selected");
      $(this).addClass("active");
    });
  });

  /**************************************
   ***** 20. Woocommerce color Swatch *****
   **************************************/
  document.addEventListener("DOMContentLoaded", function () {
    const swatches = document.querySelectorAll(".swatch");

    // Add click event to each swatch
    swatches.forEach((swatch) => {
      swatch.addEventListener("click", function () {
        // Remove 'active' class from all swatches
        swatches.forEach((s) => s.classList.remove("active"));

        // Add 'active' class to the clicked swatch
        this.classList.add("active");
      });
    });
  });

  /**************************************
   ***** 21. Rainge Slider Price Quantity *****
   **************************************/
  $("#slider-range").slider({
    range: true,
    min: 30,
    max: 150,
    values: [30, 570],
    slide: function (event, ui) {
      $("#minAmount").text(ui.values[0] + "$");
      $("#maxAmount").text(ui.values[1] + "$");
    },
  });
  $("#minAmount").text("$" + $("#slider-range").slider("values", 0));
  $("#maxAmount").text("$" + $("#slider-range").slider("values", 1));

  /**************************************
   ***** 22. Countdown JS *****
   **************************************/
  $.fn.countdown = function () {
    this.each(function () {
      var $this = $(this),
        offerDate = new Date($this.data("offer-date")).getTime();

      function findElement(selector) {
        return $this.find(selector);
      }

      var interval = setInterval(function () {
        var now = new Date().getTime(),
          timeDiff = offerDate - now,
          days = Math.floor(timeDiff / 864e5),
          hours = Math.floor((timeDiff % 864e5) / 36e5),
          minutes = Math.floor((timeDiff % 36e5) / 6e4),
          seconds = Math.floor((timeDiff % 6e4) / 1e3);

        days < 10 && (days = "0" + days),
          hours < 10 && (hours = "0" + hours),
          minutes < 10 && (minutes = "0" + minutes),
          seconds < 10 && (seconds = "0" + seconds);

        if (timeDiff < 0) {
          clearInterval(interval);
          $this.addClass("expired");
          findElement(".message").css("display", "block");
        } else {
          findElement(".day").html(days);
          findElement(".hour").html(hours);
          findElement(".minute").html(minutes);
          findElement(".seconds").html(seconds);
        }
      }, 1000);
    });
  };
  $(".offer-counter").length && $(".offer-counter").countdown();

  /**************************************
   ***** 23. Newsletter Popup *****
   **************************************/
  document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById("popup");

    if (popup) {
      // Function to handle scroll event
      function onScroll() {
        // Only show the popup if the screen width is larger than 'lg'
        if (window.innerWidth >= 1440 && window.scrollY > 300) {
          // 1024px represents large devices (lg)
          // Show the popup when user scrolls down past the threshold
          popup.style.display = "flex";
          // Remove the scroll event listener after showing the popup (optional)
          window.removeEventListener("scroll", onScroll);
        }
      }

      // Add the scroll event listener
      window.addEventListener("scroll", onScroll);

      // Close the popup when the close button is clicked
      const closeBtn = document.getElementById("close-popup");
      if (closeBtn) {
        closeBtn.addEventListener("click", function () {
          popup.style.display = "none";
        });
      }

      // Close the popup when the "No thanks" link is clicked
      const noThanks = document.querySelector(".no-thanks");
      if (noThanks) {
        noThanks.addEventListener("click", function () {
          popup.style.display = "none";
        });
      }
    }
  });

  /**************************************
   ***** 24. Image Parallax Animation *****
   **************************************/
  gsap.utils.toArray(".vs-gsap-img-parallax").forEach(function (container) {
    let image = container.querySelector("img");

    let tl = gsap.timeline({
      scrollTrigger: {
        trigger: container,
        scrub: 0.5,
      },
    });
    tl.from(image, {
      yPercent: -30,
      ease: "none",
    }).to(image, {
      yPercent: 30,
      ease: "none",
    });
  });

  /**************************************
   ***** 25. Custom Ecommerce Category Menu *****
   **************************************/
  document.addEventListener("DOMContentLoaded", () => {
    // Select all menu wrappers
    const menuWrappers = document.querySelectorAll(".menu-wrapper");

    // Loop through each menu wrapper
    menuWrappers.forEach((wrapper) => {
      const menuToggle = wrapper.querySelector(".menu-toggle");
      const menuList = wrapper.querySelector(".menu-list");
      const menuItems = wrapper.querySelectorAll(".menu-item");

      // GSAP timeline for each menu
      const tl = gsap.timeline({ paused: true, reversed: true }); // Start in reversed state

      // Animate the menu list (fade-in and slide up)
      tl.to(menuList, {
        opacity: 1,
        visibility: "visible",
        y: "0%", // Move up to original position
        duration: 0.5,
        ease: "power2.out",
      }).to(
        menuItems,
        {
          opacity: 1,
          y: 0, // Move to original position
          duration: 0.5,
          ease: "power2.out",
          stagger: 0.1, // Slight delay between each item
        },
        "<" // Start items animation at the same time as the menu list animation
      );

      // Toggle dropdown menu on click
      menuToggle.addEventListener("click", (e) => {
        e.stopPropagation(); // Prevent the event from bubbling up to the document
        menuToggle.classList.toggle("active"); // Toggle active state
        if (tl.reversed()) {
          tl.play(); // Play animation for opening
          tl.reversed(false); // Mark timeline as not reversed
        } else {
          tl.reverse(); // Reverse animation for closing
          tl.reversed(true); // Mark timeline as reversed
        }
      });

      // Close menu when clicking outside the menu-wrapper
      document.addEventListener("click", (e) => {
        if (!wrapper.contains(e.target)) {
          if (!tl.reversed()) {
            // Only reverse if menu is open
            tl.reverse(); // Close menu
            tl.reversed(true); // Mark timeline as reversed
            menuToggle.classList.remove("active"); // Remove active class
          }
        }
      });
    });
  });

  /**************************************
   ***** 26. Scroll Animation *****
   **************************************/
  // Initialize GSAP scroll-triggered animations for elements with specific attributes
  function initializeScrollAnimations() {
    // Select all elements with the "it-scroll-element" class
    const scrollElements = document.querySelectorAll(".it-scroll-element");

    // Loop through each element and configure animations based on its attributes
    scrollElements.forEach((element) => {
      // Retrieve data attributes or set default values
      const speed =
        parseFloat(element.getAttribute("data-it-scroll-speed")) || 0.8; // Animation duration (default 0.8s)
      const yMovement =
        parseInt(element.getAttribute("data-it-scroll-y"), 10) || 250; // Vertical movement distance (default 250px)

      // Apply GSAP animation with ScrollTrigger
      gsap.from(element, {
        scrollTrigger: {
          trigger: element, // Use the element itself as the scroll trigger
          toggleActions: "play none none none", // Trigger animation on scroll in
          start: "top bottom", // Animation starts when the top of the element hits the bottom of the viewport
          end: "bottom top", // Animation ends when the bottom of the element hits the top of the viewport
          scrub: 0.5, // Smoothens animation based on scroll progress
          pin: false, // Disable pinning by default for flexibility
          markers: false, // Set to true for debugging markers if needed
        },
        y: yMovement, // Vertical movement based on the data attribute
        duration: speed, // Animation speed from data attribute
        ease: "power2.out", // Smooth easing for natural animation flow
      });
    });
  }
  // Initialize animations after the DOM is fully loaded
  document.addEventListener("DOMContentLoaded", initializeScrollAnimations);

  /**************************************
   ***** 27. Image Move Parallax *****
   **************************************/
  function initParallaxEffect() {
    // Select all elements with the "it-parallax-background" class
    const parallaxElements = document.querySelectorAll(
      ".it-parallax-background"
    );
    // Loop through each element and configure parallax effect based on data attributes
    parallaxElements.forEach((element) => {
      const parallaxSpeed =
        parseFloat(element.getAttribute("data-it-parallax-speed")) || 0.3; // Default speed is 0.3
      // Apply GSAP parallax animation with ScrollTrigger
      gsap.to(element, {
        scrollTrigger: {
          trigger: element, // Use the element itself as the scroll trigger
          start: "top bottom", // Start parallax effect as it enters the viewport
          end: "bottom top", // End when it leaves the viewport
          scrub: true, // Smooth parallax effect that follows scroll
          markers: false, // Set to true for debugging markers if needed
        },
        y: (i, target) => -(target.offsetHeight * parallaxSpeed), // Vertical movement for parallax
        ease: "none", // Linear easing for a natural parallax feel
      });
    });
  }
  // Initialize parallax effect after the DOM is fully loaded
  document.addEventListener("DOMContentLoaded", initParallaxEffect);

  /**************************************
   ***** 28. Background Position and Overlay Scroll *****
   **************************************/
  const quoteLayout = document.querySelector(".bg-position");
  if (quoteLayout) {
    // Register GSAP ScrollTrigger
    // Animate the background position for parallax effect
    gsap.to(".bg-position", {
      backgroundPosition: "50% 100%", // Vertical scroll parallax
      ease: "none",
      scrollTrigger: {
        trigger: ".bg-position",
        start: "top bottom",
        end: "bottom top",
        scrub: true, // Smooth animation tied to scroll
      },
    });

    // Check if .overlay exists
    const overlay = document.querySelector(".bg-position .overlay");
    if (overlay) {
      // Animate the overlay color change if it exists
      gsap.to(".bg-position .overlay", {
        backgroundColor: "rgba(255, 62, 1, 0.2)", // Change to red while keeping opacity
        ease: "none",
        scrollTrigger: {
          trigger: ".bg-position",
          start: "top bottom",
          end: "bottom top",
          scrub: true,
        },
      });
    }
  }

  // End Script
  $(document).ready(function () {
    $(".destination-gallery, .sidebar-gallery").magnificPopup({
      delegate: "a",
      type: "image",
      tLoading: "Loading image #%curr%...",
      mainClass: "mfp-img-mobile",
      gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0, 1],
      },
      image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
        titleSrc: function (item) {
          return (
            item.el.attr("title") +
            ` <a href="https://www.facebook.com/profile.php?id=100069384085540" target="_blank" style="color: #f7921f;" rel="noopener noreferrer">&nbsp;Click Here</a>`
          );
        },
      },
    });
  });

  const partnerSlider = document.querySelector(".partner-slider");
  if (partnerSlider) {
    const swiper = new Swiper(partnerSlider, {
      loop: true,
      // speed: 2500,
      // autoplay: {
      //   delay: 0,
      //   disableOnInteraction: false,
      // },
      // centeredSlides: true,
      // freeMode: true,
      // slidesOffsetBefore: 0,
      // slidesOffsetAfter: 0,
      // allowTouchMove: true,

      breakpoints: {
        0: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 50,
        },
        1024: {
          slidesPerView: 4,
          spaceBetween: 60,
        },
        1200: {
          slidesPerView: 5,
          spaceBetween: 80,
        },
      },
    });
  }

  const instagramSlider = document.querySelector(".instagram-slider");
  if (instagramSlider) {
    const swiper = new Swiper(instagramSlider, {
      slidesPerView: 1,
      spaceBetween: 0,
      loop: true,
      speed: 4000,
      autoplay: {
        delay: 0,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      allowTouchMove: false,
      breakpoints: {
        576: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 3,
        },
        1024: {
          slidesPerView: 4,
        },
        1200: {
          slidesPerView: 5,
        },
      },
    });
  }

  const tourPackageSlider = document.querySelector(".tour-package-slider");
  const tourPackagePrev = document.querySelector(".tour-packages-prev");
  const tourPackageNext = document.querySelector(".tour-packages-next");

  if (tourPackageSlider && tourPackagePrev && tourPackageNext) {
    const swiper = new Swiper(tourPackageSlider, {
      slidesPerView: 1,
      spaceBetween: 30,
      slidesPerGroup: 1,
      loop: true,
      speed: 1000,
      navigation: {
        prevEl: tourPackagePrev,
        nextEl: tourPackageNext,
      },
      breakpoints: {
        1200: {
          slidesPerView: 3,
        },
        768: {
          slidesPerView: 2,
        },
      },
      on: {
        init() {
          tourPackagePrev.classList.add("active");
        },
        slideNextTransitionStart() {
          tourPackageNext.classList.add("active");
          tourPackagePrev.classList.remove("active");
        },
        slidePrevTransitionStart() {
          tourPackagePrev.classList.add("active");
          tourPackageNext.classList.remove("active");
        },
      },
    });
  }

  const testimonialThumbnailSlider = document.querySelector(
    ".testimonial-thumbnail-slider"
  );
  const testimonialContentSlider = document.querySelector(
    ".testimonial-content-slider"
  );

  if (testimonialThumbnailSlider && testimonialContentSlider) {
    const thumbnailSlider = new Swiper(testimonialThumbnailSlider, {
      spaceBetween: 10,
      slidesPerView: 1,
      watchSlidesProgress: true,
      loop: true,
      effect: "fade",
      fadeEffect: { crossFade: true },
      speed: 1000,
    });

    const contentSlider = new Swiper(testimonialContentSlider, {
      spaceBetween: 10,
      slidesPerView: 1,
      loop: true,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      thumbs: {
        swiper: thumbnailSlider,
      },
    });
  }

  const currentYearHTML = document.querySelectorAll(".current-year");
  if (currentYearHTML.length > 0) {
    const currentYear = new Date().getFullYear();
    currentYearHTML.forEach((el) => {
      el.textContent = currentYear;
    });
  }

  $("#select-division").selectmenu();
  $("#guest-dropdown").selectmenu();

  $(function () {
    $('input[name="searchDate"]').daterangepicker(
      {
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        minYear: 1025,
        maxYear: parseInt(moment().format("YYYY"), 10) + 12,
        locale: {
          format: "MM/DD/YYYY",
        },
      },
      function (start, end, label) {
        $("#search-date").val(start.format("MM/DD/YYYY"));
      }
    );

    $("#search-date").on("click", function () {
      $(this).val("");
    });
  });
  // End Script
})(jQuery);

// Odometer Counter
function initOdometer() {
  $("[data-count]").each(function () {
    var $counterItem = $(this);

    // Check if the element is in the viewport
    $counterItem.isInViewport(function (status) {
      if (status === "entered") {
        // Find the .odometer inside this element and animate
        $counterItem.each(function () {
          var el = this;
          el.innerHTML = el.getAttribute("data-count");
        });
      }
    });
  });
}
initOdometer();
const serviceNavLinks = document.querySelectorAll(
  ".service-content-box .nav-link"
);

// if (serviceNavLinks && serviceNavLinks.length > 0) {
//   serviceNavLinks.forEach((link) => {
//     link.addEventListener("click", () => {
//       initOdometer();
//     });
//   });
// }

// Odometer Counter End

// Store dependencies in variables
const sliderContainer = document.querySelector(".exclusive-gallery-slider");
const sliderPagination = document.querySelector(
  ".exclusive-gallery-slider-pagination"
);

if (sliderContainer && sliderPagination) {
  const swiper = new Swiper(sliderContainer, {
    loop: true,
    centeredSlides: true,
    slidesPerView: 1,
    spaceBetween: 20,
    // effect: "coverflow",
    speed: 2000,
    autoplay: {
      delay: 1500,
      disableOnInteraction: false,
    },
    pagination: {
      el: sliderPagination,
      clickable: true,
    },
    breakpoints: {
      576: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 30,
      },
      1300: {
        slidesPerView: 2,
        spaceBetween: 40,
      },
    },
  });
}

// ======================== Slider ====================================
const topPlaceSliderElement = document.querySelector(".top-place-slider");
const topPlaceNext = document.querySelector(".top-place-next");
const topPlacePrev = document.querySelector(".top-place-prev");

// Function to initialize the Swiper slider
function initializeTopPlaceSlider() {
  if (topPlaceSliderElement && topPlaceNext && topPlacePrev) {
    // Initialize Swiper if elements exist
    const topPlaceSlider = new Swiper(topPlaceSliderElement, {
      slidesPerView: 1,
      spaceBetween: 10,
      loop: true,
      navigation: {
        nextEl: topPlaceNext,
        prevEl: topPlacePrev,
      },
      breakpoints: {
        425: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 15,
        },
        1200: {
          slidesPerView: 4,
          spaceBetween: 15,
        },
        1300: {
          slidesPerView: 5,
          spaceBetween: 20,
        },
      },
    });

    // Set initial active button state
    topPlacePrev.classList.add("active");

    // Add event listeners to toggle active states
    topPlaceNext.addEventListener("click", () => {
      topPlaceNext.classList.add("active");
      topPlacePrev.classList.remove("active");
    });

    topPlacePrev.addEventListener("click", () => {
      topPlacePrev.classList.add("active");
      topPlaceNext.classList.remove("active");
    });
  }
}

// Run the slider
initializeTopPlaceSlider();

// date range picker for Home 3
$(document).ready(function () {
  // Get today's date formatted as "03 Feb 2024"
  function getFormattedDate(date) {
    return moment(date).format("DD MMM YYYY");
  }

  let today = moment();
  let tomorrow = moment().add(1, "days");

  // Initialize Date Range Picker for Check-in
  $("#check-in").daterangepicker(
    {
      singleDatePicker: true,
      autoUpdateInput: true,
      minDate: today,
      locale: {
        format: "DD MMM YYYY",
      },
    },
    function (start) {
      // Set Check-out minDate to selected Check-in date +1 day
      $("#check-out").daterangepicker({
        singleDatePicker: true,
        autoUpdateInput: true,
        minDate: start.add(1, "days"),
        locale: {
          format: "DD MMM YYYY",
        },
      });
    }
  );

  // Initialize Date Range Picker for Check-out
  $("#check-out").daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: true,
    minDate: tomorrow,
    locale: {
      format: "DD MMM YYYY",
    },
  });

  // Set default values
  $("#check-in").val(getFormattedDate(today));
  $("#check-out").val(getFormattedDate(tomorrow));
});

// ======================== Mouse movement Animation ====================================
function setupMouseMoveAnimation() {
  const moveItems = document.querySelectorAll(".move-item");

  if (!moveItems || moveItems.length === 0) {
    return;
  }

  // Set initial position for move-items
  gsap.set(moveItems, { x: 0, y: 0 });

  // Maximum movement in pixels
  const maxMovement = 20;

  moveItems.forEach((item) => {
    item.addEventListener("mousemove", (e) => {
      if (!e) return;

      // Get item size and position
      const rect = item.getBoundingClientRect();
      const mouseX = e.clientX - rect.left;
      const mouseY = e.clientY - rect.top;

      // Calculate movement as a percentage of item size
      const moveX = (mouseX / rect.width - 0.5) * 2 * maxMovement;
      const moveY = (mouseY / rect.height - 0.5) * 2 * maxMovement;

      // Animate only the hovered move-item
      gsap.to(item, {
        x: moveX,
        y: moveY,
        duration: 0.3,
        ease: "power2.out",
      });
    });

    // Reset position when mouse leaves the move-item
    item.addEventListener("mouseleave", () => {
      gsap.to(item, {
        x: 0,
        y: 0,
        duration: 0.5,
        ease: "power2.out",
      });
    });
  });
}

// Run setup on DOMContentLoaded
document.addEventListener("DOMContentLoaded", setupMouseMoveAnimation);

// Also run setup now in case the DOM is already loaded
if (
  document.readyState === "complete" ||
  document.readyState === "interactive"
) {
  setupMouseMoveAnimation();
}
