jQuery(document).ready(function() {
    jQuery("label#menuOpen").click(function () {
        jQuery(this).toggleClass('menu-button-open');
        jQuery('nav#mobile').toggleClass('show-mobile-menu');
        jQuery('header#header #logo, #wrapper, footer').toggleClass('move-content-left');
        jQuery('header#header .header-icons').toggleClass('move-icons-left');
    });

    jQuery("nav#mobile .mobile-arrow").click(function () {
        jQuery(this).prev('.sub-menu').slideToggle();
    });

    jQuery("nav#mobile .userArrow").click(function () {
        jQuery('ul#user-sub-menu').slideToggle();
    });

    jQuery("nav#desktop .sub-arrow").click(function () {
        jQuery(this).prev('.sub-menu').slideToggle();
    });

    jQuery(window).scroll( function() {
       if(jQuery(window).scrollTop() > 50) {
           jQuery('#header').addClass('header-background');
           if( jQuery('.category-top').length > 0 ) {
               jQuery('.category-top').addClass('hug-header');
           }
       } else {
           jQuery('#header').removeClass('header-background');
           if( jQuery('.category-top').length > 0 ) {
               jQuery('.category-top').removeClass('hug-header');
           }
       }
    });

    jQuery('#open-sub-video-cats').click(function() {
        jQuery('#select-sub-category').slideToggle();
    });

    jQuery('a[href*="#"]').not('[href="#"]').not('[href="#0"]').click(function(event) {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = jQuery(this.hash);
            target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                event.preventDefault();
                if( (target.selector == '#comments' && jQuery('#wpvs-video-reviews-container').length > 0) || (target.selector == '#respond') ) {} else {
                    jQuery('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                }

            }
        }
    });
});

jQuery(window).resize(wpvs_reset_main_menu);

function wpvs_reset_main_menu() {
    if(jQuery(window).width() >= 768) {
        jQuery('ul#user-sub-menu').slideUp();
    }
}
