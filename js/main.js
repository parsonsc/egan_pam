// STICKY HEADER 
$(function() {
    var header = $(".site_header");
    $(window).scroll(function() {    
        var scroll = $(window).scrollTop();
    
        if (scroll >= 500) {
            header.addClass("sticky");
        } else {
            header.removeClass("sticky");
        }
    });
});
// END STICKY HEADER

// MOBILE MENU HAMBURGER
  var hamburger = $('#menu-icon');
  hamburger.click(function() {
      hamburger.toggleClass('active');
      return false;
  });
  $("#menu-icon").click(function(){
      $("header.site_header nav").slideToggle();
  });
// END HAMBURGER

// SMOOTH SCROLL ANCHOR
$(function() {
  $('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top - 140
        }, 1000);
        return false;
      }
    }
  });
});
// END SMOOTH SCROLL ANCHOR

// EQUAL HEIGHTS
  equalheight = function(container){
  var currentTallest = 0,
       currentRowStart = 0,
       rowDivs = new Array(),
       $el,
       topPosition = 0;
   $(container).each(function() {
     $el = $(this);
     $($el).height('auto')
     topPostion = $el.position().top;

     if (currentRowStart != topPostion) {
       for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
         rowDivs[currentDiv].height(currentTallest);
       }
       rowDivs.length = 0; // empty the array
       currentRowStart = topPostion;
       currentTallest = $el.height();
       rowDivs.push($el);
     } else {
       rowDivs.push($el);
       currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
    }
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
   });
  }

  $(window).load(function() {
    equalheight('');
  });
  $(window).resize(function(){
    equalheight('');
  });

  // $('.grid_copy > .absolute').each(function() {
  //   $(this).parent().height('+=' + $(this).height());
  //   $(this).css('position', 'absolute');
  // });
// END EQUAL HEIGHTS


// WAYPOINTS
  // hide our element on page load         
  $('.post').waypoint(function() {
    $('.post').addClass('fadeInLeft');

  }, {offset: '75%' });

function onScrollInit( items, trigger ) {
  items.each( function() {
    var osElement = $(this),
        osAnimationClass = osElement.attr('data-os-animation'),
        osAnimationDelay = osElement.attr('data-os-animation-delay');
      
        osElement.css({
          '-webkit-animation-delay':  osAnimationDelay,
          '-moz-animation-delay':     osAnimationDelay,
          'animation-delay':          osAnimationDelay
        });

        var osTrigger = ( trigger ) ? trigger : osElement;
        
        osTrigger.waypoint(function() {
          osElement.addClass('animated').addClass(osAnimationClass);
          },{
              triggerOnce: true,
              offset: '65%'
        });
  });
}

 onScrollInit( $('.os-animation') );
 onScrollInit( $('.staggered-animation'), $('.staggered-animation-container') );
// END WAYPOINTS

$(document).ready(function() {
  $('ul#filter a').click(function() {
    $(this).css('outline','none');
    $('ul#filter .current').removeClass('current');
    $(this).parent().addClass('current');
    
    var filterVal = $(this).text().toLowerCase().replace(' ','-');
        
    if(filterVal == 'all') {
      $('ul#portfolio li.hidden').fadeIn('slow').removeClass('hidden');
    } else {
      $('ul#portfolio li').each(function() {
        if(!$(this).hasClass(filterVal)) {
          $(this).fadeOut('normal').addClass('hidden');
        } else {
          $(this).fadeIn('slow').removeClass('hidden');
        }
      });
    }
    
    return false;
  });
});