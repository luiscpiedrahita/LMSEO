jQuery(document).ready(function($) {
	var waypoints = $('#handler-first').waypoint(
		function(direction) {
			notify(this.element.id + ' hit 25% from top of window') 
		}, {
	 	offset: '25%'
	});
	/*-------------------------------------------------------------*/
	//				Element Animation
	/*------------------------------------------------------------*/
	//return jQuery.waypoints('viewportHeight') - jQuery(this).height() + 100;
		
	jQuery(' .portfolio_shortcode, .zp-grid-wrapper').waypoint(function() {
			jQuery(this).addClass('zp_start_animation');		
	}, {
		offset:'100%'
	});
	
	// Animation to service box
	jQuery('.special-services-box').waypoint(function() {
		var children = jQuery(".special-services-box");
		var index = 0;
	
		function addClassToNextChild() {
			if (index == children.length) return;
			children.eq(index++).addClass("zp_start_animation");
			window.setTimeout(addClassToNextChild, 500);
		}
		addClassToNextChild();
	}, {
		offset:'100%'
	});	

	// Animation to team box
	jQuery('.team').waypoint(function() {
		var children = jQuery(".team");
		var index = 0;
	
		function addClassToNextChild() {
			if (index == children.length) return;
			children.eq(index++).addClass("zp_start_animation");
			window.setTimeout(addClassToNextChild, 500);
		}
		addClassToNextChild();
	}, {
		offset:'100%'
	});		
	
	//// Animation to Columns
	jQuery('.columns').waypoint(function() {
		var children = jQuery(".columns");
		var index = 0;
	
		function addClassToNextChild() {
			if (index == children.length) return;
			children.eq(index++).addClass("zp_start_animation");
			window.setTimeout(addClassToNextChild, 500);
		}
		addClassToNextChild();
	}, {
		offset:'100%'
	});
	jQuery("html").addClass("js-columns-ready");
});

