$(document).ready(function(){        

    // CLICK TO SCROLL TO #ID
    $('a[href^="#"]').on('click', function(event) {
        var target = $( $(this).attr('href') );
        if( target.length ) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 2000);
        }
    });
    
    

    var hamburger = $('#menu-icon');
        hamburger.click(function() {
        hamburger.toggleClass('active');
        return false;
    });
     $("#menu-icon").click(function(){
        $(".site_nav").slideToggle();
    });  
     $("nav.site_nav ul li:nth-child(2)").click(function(){
        $("nav.site_nav ul li:nth-child(2) ul").slideToggle();
     });
});

   


