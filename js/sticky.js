jQuery(document).ready(function() {  
	var stickyNavTop = jQuery('#mainNav').offset().top;  
	var stickyNav = function(){  
		var scrollTop = jQuery(window).scrollTop();  

		if (scrollTop > stickyNavTop) {   
			jQuery('#mainNav').addClass('sticky');  
		} else {  
			jQuery('#mainNav').removeClass('sticky');   
		}  
	};  

	stickyNav();  

	jQuery(window).scroll(function() {  
		stickyNav();  
	});  
}); 