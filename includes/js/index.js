jQuery(document).ready(function(){


	jQuery('.social ul li').hover(function(){
		jQuery(this).addClass('expanded');
		jQuery("i",this).addClass('animated zoomOut');
		
		jQuery(".hiden-social",this).addClass('social-apear');
		
		
	},function(){
		jQuery(this).removeClass('expanded');
		jQuery("i",this).removeClass('animated zoomOut');
		jQuery(".hiden-social",this).removeClass('social-apear');
	});

});