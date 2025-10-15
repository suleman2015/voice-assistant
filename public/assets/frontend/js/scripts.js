function initScrollToTop(thresholdPercent = 0.2) {
  const btn = document.querySelector('.scroll-to-top');
  if (!btn) return;

  const getThreshold = () =>
    document.documentElement.scrollHeight * thresholdPercent;

  // Toggle visibility on scroll
  window.addEventListener('scroll', () => {
    const scrollY = window.pageYOffset;
    btn.classList.toggle('show', scrollY > getThreshold());
  });

  // Smooth scroll to top on click
  btn.addEventListener('click', () => {
    window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
  });
}

// Example usage:
document.addEventListener('DOMContentLoaded', () => {
  initScrollToTop(0.2);
});


// Call this after your DOM is ready
$(function () {
  const $popup = $('.cookie-popup');

  // Hide initially
  $popup.hide();

  // Show if no consent yet
  if (!localStorage.getItem('cookieConsent')) {
    $popup.fadeIn(200);
  }

  // Accept cookies
  $popup.on('click', '.accept-btn', function (e) {
    e.preventDefault();
    localStorage.setItem('cookieConsent', 'true');
    $popup.fadeOut(200);
  });

  // Decline cookies
  $popup.on('click', '.decline-btn', function (e) {
    e.preventDefault();
    $popup.fadeOut(200);
  });
});


$(function () {
  // ====== SCROLL BEHAVIOR ======
  var lastScrollTop = 0;
  $(window).on('scroll', function () {
    var st = $(this).scrollTop();
    var vh = $(window).height();

    if (st === 0 || st < vh * 0.7) {
      $('.main-header').removeClass('slide-up slide-down');
    } else if (lastScrollTop > st) {
      $('.main-header')
        .removeClass('slide-up')
        .addClass('slide-down');
    } else {
      $('.main-header')
        .removeClass('slide-down')
        .addClass('slide-up');
    }

    lastScrollTop = st <= 0 ? 0 : st;
  });

  // ====== MOBILE MENU TOGGLE ======
  $('.mobile-toggle').on('click', function (e) {
    e.stopPropagation();
    $('.mobile_menu').toggleClass('open');
  });

  // CLOSE MOBILE MENU ON OUTSIDE CLICK
  $(document).on('click', function (e) {
    if (!$(e.target).closest('.mobile_menu, .mobile-toggle').length) {
      $('.mobile_menu').removeClass('open');
    }
  });

  // ====== DROPDOWN TOGGLE (MOBILE) ======
  $('.dropdown-toggle-btn').on('click', function (e) {
    e.stopPropagation();
    var $box = $(this)
      .closest('li')
      .children('.dropdown-menu-box');
    $box.toggleClass('open closed');
    // switch +/–
    $(this).text($box.hasClass('open') ? '−' : '+');
  });

  // CLOSE SUBMENU WHEN LINK CLICKED
  $('.dropdown-menu-box a').on('click', function () {
    var $parentBox = $(this).closest('.dropdown-menu-box');
    $parentBox
      .addClass('closed')
      .removeClass('open');
    $parentBox
      .siblings('.menu-item-wrapper')
      .find('.dropdown-toggle-btn').text('+');
  });
});


$(function () {
  var $input = $('#podcast_search');
  var $suggestList = $('#suggestionList');

  // Slide down on focus or when typing (if non-empty)
  $input.on('focus input', function () {
    if ($(this).val().trim()) {
      $suggestList.stop(true, true).slideDown(200);
    }
  });

  // If input cleared, slide up
  $input.on('input', function () {
    if (!$(this).val().trim()) {
      $suggestList.stop(true, true).slideUp(200);
    }
  });

  // Click outside → slide up
  $(document).on('click', function (e) {
    if (!$(e.target).closest('#podcast_search, #suggestionList').length) {
      $suggestList.stop(true, true).slideUp(200);
    }
  });
});
