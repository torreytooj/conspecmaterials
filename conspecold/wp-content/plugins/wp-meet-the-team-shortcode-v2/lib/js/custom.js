jQuery(function($) {
	$('.wpmtp-social a').tooltip();

	$(".wpmtp-icon-show-image .wpmtp-post-image").mouseenter(function() {
	    $(this).find(".wpmtp-social-hover").fadeIn(400);
	  }).mouseleave(function(){
	    $(this).find(".wpmtp-social-hover").fadeOut(300);
	  });
});