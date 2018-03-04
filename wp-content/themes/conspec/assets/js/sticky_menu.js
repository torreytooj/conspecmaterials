/*global jQuery:false */
jQuery(document).ready(function() {
	"use strict";	
    sticky_menu();
});

function sticky_menu() {
    
    jQuery('.header').affix({
        offset: { top: jQuery('.sticky_menu').offset().top}
    });
    
    jQuery('.header-middle').affix({
        offset: { top: jQuery('.sticky_menu').offset().top+100}
    });

};