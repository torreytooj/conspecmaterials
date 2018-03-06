/*global jQuery:false */
jQuery(document).ready(function() {
	"use strict";
	var touched=false;
	jQuery(".nav").on('touchstart', 'li .dropdown-toggle', function (e) {	touched=true; });
	jQuery("html").on('mousemove', function (e) { touched=false; });

	jQuery("html").on('click', updatePreviousTouched );

	jQuery(".nav").on('click', 'li .dropdown-toggle', function (e) {
		updatePreviousTouched(e);
		if( touched ) {	
			if (jQuery(this).data('clicked_once')) {
				jQuery(this).data('clicked_once', false);
				return true;
			} else {
				e.preventDefault();
				jQuery(this).trigger("mouseenter"); 
				jQuery(this).data('clicked_once', true);
				
			}
		}
		touched=false;
	});	
	
	var previous_touched;
	function updatePreviousTouched(e) {
		if( typeof previous_touched != 'undefined' && previous_touched != null && !previous_touched.is( jQuery(e.target) ) ) {
			previous_touched.data('clicked_once', false);
		}
		previous_touched=jQuery(e.target);
	}

});

/*global jQuery:false */
jQuery(document).ready(function() {
	"use strict";	
    functions();
    scaleWithGridFront();
    mega_menu();
});


function functions() {

	jQuery("#searchform #searchsubmit").addClass("btn btn-primary btn-sm");
	jQuery('.widget_search #s,.widget_product_search #s').addClass("form-control input-sm");
	jQuery('.widget select').addClass("form-control");
	jQuery(".form-submit #submit").addClass("btn btn-primary").removeAttr("id");
    jQuery('.price_slider_amount button').removeClass("button").addClass("btn btn-sm btn-default");
    //jQuery('.group_table a.button').removeClass("button").addClass("btn btn-xs btn-default");
    jQuery('.woo_compare_widget_button_container a').removeClass("woo_compare_button_go woo_compare_widget_button_go").addClass("btn btn-sm btn-primary");
    
	//clearfix for columns
	jQuery('<div class="clearfix"></div>').insertAfter(".col-md-4.one-column:nth-child(3n)");
    jQuery('<div class="clearfix"></div>').insertAfter(".col-md-3.one-column:nth-child(4n)");
    jQuery('<div class="clearfix"></div>').insertAfter(".post-widget .col-md-6:nth-child(2n)");
    jQuery('<div class="clearfix"></div>').insertAfter(".post-widget .col-md-4:nth-child(3n)");
    jQuery('<div class="clearfix"></div>').insertAfter(".post-widget .col-md-3:nth-child(4n)");
    //clearfix for columns END

    jQuery('strong .wl-add-to-single').removeClass("button").addClass('btn').addClass('btn-default').addClass('btn-sm');
    
    jQuery(".gallery-item .gallery-icon a").each(function() {
    
		jQuery(this).addClass("thumbnail");
	
	});

    jQuery(".ttip").tooltip();	

	jQuery('.ttip-top').tooltip({
		content: function () { return jQuery(this).attr('title') },
		position: {
			my: "center bottom-5",
			at: "center top",
			using: function( position, feedback ) {
			jQuery( this ).css( position );
			jQuery( "<div>" )
			.addClass( "arrow bottom" )
			.addClass( feedback.vertical )
			.addClass( feedback.horizontal )
			.appendTo( this );
			}
		}
	});
	
	jQuery('.ttip-right').tooltip({
		content: function () { return jQuery(this).attr('title') },
		position: {
			my: "left+5 left",
			at: "right center",
			using: function( position, feedback ) {
			jQuery( this ).css( position );
			jQuery( "<div>" )
			.addClass( "arrow left" )
			.addClass( feedback.vertical )
			.addClass( feedback.horizontal )
			.appendTo( this );
			}
		}
	});
	
	jQuery('.ttip-bottom').tooltip({
		content: function () { return jQuery(this).attr('title') },
		position: {
			my: "center top+5",
			at: "center bottom",
			using: function( position, feedback ) {
			jQuery( this ).css( position );
			jQuery( "<div>" )
			.addClass( "arrow top" )
			.addClass( feedback.vertical )
			.addClass( feedback.horizontal )
			.appendTo( this );
			}
		}
	});
	
	jQuery('.ttip-left').tooltip({
		content: function () { return jQuery(this).attr('title') },
		position: {
			my: "right-5 center",
			at: "left center",
			using: function( position, feedback ) {
			jQuery( this ).css( position );
			jQuery( "<div>" )
			.addClass( "arrow right" )
			.addClass( feedback.vertical )
			.addClass( feedback.horizontal )
			.appendTo( this );
			}
		}
	});
	
    jQuery(".callout-btn").each(function() {
	    var contentHeight = jQuery(this).prev('.callout-content').height();
	    jQuery(this).css({height: contentHeight});	
	});
	
    jQuery('.widget_product_categories ul > li > ul.children').before('<span class="toggle">[+]</span>');
 
    var current_cat = jQuery('.widget_product_categories ul > li.current-cat, .widget_product_categories ul > li.current-cat-parent');
    
    current_cat.children('.toggle').html("[-]");
    current_cat.children('ul').slideDown().addClass('opened');
    
    
    jQuery('.widget_product_categories ul > li > ul.children').each(function() {
        jQuery(this).parent().children('.toggle').toggle(function() {
			if(jQuery(this).parent().children('ul').hasClass('opened')){
			jQuery(this).html("[+]");
			jQuery(this).parent().children('ul').slideUp();
			jQuery(this).parent().children('ul').removeClass('opened').addClass('closed');
			}else{
			jQuery(this).html("[-]");
			jQuery(this).parent().children('ul').slideDown();
			jQuery(this).parent().children('ul').removeClass('closed').addClass('opened');
			}
        }, function() {
			if(jQuery(this).parent().children('ul').hasClass('closed')){
			jQuery(this).html("[-]");
			jQuery(this).parent().children('ul').slideDown();
			jQuery(this).parent().children('ul').removeClass('closed').addClass('opened');
			}else{
			jQuery(this).html("[+]");
			jQuery(this).parent().children('ul').slideUp();
			jQuery(this).parent().children('ul').removeClass('opened').addClass('closed');
		}
        });    
    });
    
    // contact form 7
	jQuery(".wpcf7 .wpcf7-submit").addClass("btn-primary").addClass("btn");
	jQuery(".wpcf7 input").addClass("form-control");
	jQuery(".wpcf7 input[type=submit]").removeClass("form-control");
	jQuery(".wpcf7 input[type=checkbox]").removeClass("form-control");
	jQuery(".wpcf7 input[type=radio]").removeClass("form-control");
	jQuery(".wpcf7 input[type=file]").removeClass("form-control");
	jQuery(".wpcf7 input[type=range]").removeClass("form-control");
	jQuery(".wpcf7 textarea").addClass("form-control");
	jQuery(".wpcf7 select").addClass("form-control");

};

function scaleWithGridFront() {
	"use strict";
	var $iframe = jQuery("iframe.scale-with-grid-front"),
	$fluid = jQuery("iframe.scale-with-grid-front").parent();

	$iframe.each(function() {
		jQuery(this)
			.data('aspectRatio', this.height / this.width)
			.removeAttr('height')
			.removeAttr('width');
	});

	jQuery(window).resize(function() {
		var newWidth = $fluid.width();
		$iframe.each(function() {
			var $el = jQuery(this);
			$el.width(newWidth).height(newWidth * $el.data('aspectRatio'));
		});
	}).resize();

}

function mega_menu() {

jQuery('.pull-center > .dropdown-menu').each(function() {
var dd_width = jQuery(this).width()/2;
var bn_width = jQuery(this).parent('.pull-center').width()/2;
jQuery(this).css({marginLeft:-(dd_width-bn_width)});
});

if ("ontouchstart" in window || navigator.msMaxTouchPoints) {
jQuery('.dropdown-submenu > a').attr( "data-toggle","dropdown" );
jQuery('.animation-dd .dropdown > .dropdown-menu').hide();
} else {
if ( jQuery(window).width() > 767) {
jQuery('.nav.navbar-nav').find('.dropdown-toggle').addClass('disabled');
}
}

jQuery('section.divider').remove();

if ( jQuery(window).width() > 991) {
jQuery('<div class="clearfix fluid"></div>').insertAfter(".mega-dd-1 section:nth-child(1n)");
jQuery('<div class="clearfix fluid"></div>').insertAfter(".mega-dd-2 section:nth-child(2n)");
jQuery('<div class="clearfix fluid"></div>').insertAfter(".mega-dd-3 section:nth-child(3n)");
jQuery('<div class="clearfix fluid"></div>').insertAfter(".mega-dd-4 section:nth-child(4n)");
} else{
jQuery('<div class="clearfix fluid"></div>').insertAfter(".mega-dd-1 section:nth-child(1n)");
jQuery('<div class="clearfix fluid"></div>').insertAfter(".mega-dd-2 section:nth-child(2n)");
jQuery('<div class="clearfix fluid"></div>').insertAfter(".mega-dd-3 section:nth-child(2n)");
jQuery('<div class="clearfix fluid"></div>').insertAfter(".mega-dd-4 section:nth-child(2n)");

}

}