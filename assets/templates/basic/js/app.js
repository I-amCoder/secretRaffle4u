'use strict';

$( document ).ready(function() {
  //preloader js code
  $(".preloader").delay(300).animate({
    "opacity" : "0"
    }, 300, function() {
    $(".preloader").css("display","none");
  });
});

// mobile menu js
$(".navbar-collapse>ul>li>a, .navbar-collapse ul.sub-menu>li>a").on("click", function() {
  const element = $(this).parent("li");
  if (element.hasClass("open")) {
    element.removeClass("open");
    element.find("li").removeClass("open");
  }
  else {
    element.addClass("open");
    element.siblings("li").removeClass("open");
    element.siblings("li").find("li").removeClass("open");
  }
});

// wow js init
new WOW().init();

// main wrapper calculator
var bodySelector = document.querySelector('body');
var header = document.querySelector('.header');
var footer = document.querySelector('.footer');
(function(){
  if(bodySelector.contains(header) && bodySelector.contains(footer)){
    var headerHeight = document.querySelector('.header').clientHeight;
    var footerHeight = document.querySelector('.footer').clientHeight;

    // if header isn't fixed to top
    var totalHeight = parseInt( headerHeight, 10 ) + parseInt( footerHeight, 10 ) + 'px'; 
    
    // if header is fixed to top
    // var totalHeight = parseInt( footerHeight, 10 ) + 'px'; 
    var minHeight = '100vh';
    document.querySelector('.main-wrapper').style.minHeight = `calc(${minHeight} - ${totalHeight})`;
  }
})();

$(function () {
  $('[data-toggle="tooltip"]').tooltip({
    boundary: 'window'
  })
});

// with short level
$('[data-countdown]').each(function() {
  var $this = $(this), finalDate = $(this).data('countdown');
  $this.countdown(finalDate).on('update.countdown', function(event) {
    var format = '%D days %H hr : %M mn : %S sec';
    $(this).html(event.strftime(format));
  }).on('finish.countdown', function(event) {
    var expireData = $(this).data('title');
    $(this).html(expireData).parent().addClass('disabled');
  });
});

// with Level
$('[data-clock]').each(function() {
  var $this = $(this), finalDate = $(this).data('clock');
  $this.countdown(finalDate)
  .on('update.countdown', function(event) {
    var format = ''+'<div><span>%D</span><p>days</p></div>'+'<div><span>%H</span><p>hours</p></div>'+'<div><span>%M</span><p>minutes</p></div>'+'<div><span>%S</span><p>seconds</p></div>';
    $(this).html(event.strftime(format));
  })
  .on('finish.countdown', function(event) {
    var expireData = $(this).data('title');
    $(this).html(expireData).addClass('disabled');
  });
});


var $jackpotCountdown = $('.jackpot-countdown.jc_1');
  if ($jackpotCountdown.length) {
    $jackpotCountdown.each(function() {
      var jc_year = parseInt( $(this).attr("data-year"));
      if( !jc_year ) jc_year = 1;
      var jc_month = parseInt( $(this).attr("data-month"));
      if( !jc_month ) jc_month = 1;
      var jc_day = parseInt( $(this).attr("data-day"));
      if( !jc_day ) jc_day = 1;
      var jc_hour = parseInt( $(this).attr("data-hour"));
      if( !jc_hour ) jc_hour = 1;
      var jc_minute = parseInt( $(this).attr("data-minute"));
      if( !jc_minute ) jc_minute = 1;

      $jackpotCountdown.syotimer({
        year: jc_year,
        month: jc_month,
        day: jc_day,
        hour: jc_hour,
        minute: jc_minute,
      }); 
    }); 
  }
/* ==============================
					slider area
================================= */

// table-slider js 
$('.table-slider').slick({
  autoplay: true,
  autoplaySpeed: 2000,
  dots: false,
  infinite: true,
  speed: 300,
  slidesToShow: 6,
  arrows: false,
  slidesToScroll: 1,
  cssEase: 'cubic-bezier(0.645, 0.045, 0.355, 1.000)',
  vertical: true,
  speed: 1000,
  autoplaySpeed: 1000,
});