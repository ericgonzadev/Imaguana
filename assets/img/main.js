(function ($, window, document, undefined) {
    'use strict';
    
	$(document).ready(function() {		

	  	// Parallax Background
	  	jQuery('.contact-parallax').parallax;

	  	// Owl Carousel		
		jQuery("#ws-items-carousel").owlCarousel({
			items :4,		
			navigation : true
		});

		// Products Carousel 
		jQuery("#ws-products-carousel").owlCarousel({
			navigation : true,
			slideSpeed : 300,
			paginationSpeed : 400,
			singleItem:true
		});	
		
		// Page Loader
	    jQuery("#preloader").delay(1500).fadeOut(500);       	
		 
		// Scroll Reveal
		window.sr = new scrollReveal();

		// Hover Dropdown
		
		
		// Hero Image	
		jQuery("#ws-hero").show().revolution({
			sliderType:"hero",
			jsFileLocation:"assets/js/plugins/revolution/js/",
			fullScreenOffsetContainer:".ws-header-static,.ws-topbar",
			sliderLayout:"fullscreen",
			dottedOverlay:"none",
			delay:9000,
			navigation: {
			},
			responsiveLevels:[1240,1024,778,480],
			gridwidth:[1240,1024,778,480],
			gridheight:[600,500,400,300],
			lazyType:"none",
			parallax: {
				type:"mouse",
				origo:"slidercenter",
				speed:1000,
				levels:[2,3,4,5,6,7,12,16,10,50],
			},
			shadow:0,
			spinner:"off",
			autoHeight:"off",
			disableProgressBar:"on",
			hideThumbsOnMobile:"off",
			hideSliderAtLimit:0,
			hideCaptionAtLimit:0,
			hideAllCaptionAtLilmit:0,
			debugMode:false,
			fallbacks: {
				simplifyAll:"off",
				disableFocusListener:false,
			}
		});
		
		// Hero FullScreen	
		jQuery("#ws-hero-fullscreen").show().revolution({
			sliderType:"hero",
			jsFileLocation:"assets/js/plugins/revolution/js/",
			fullScreenOffsetContainer:".ws-topbar",
			sliderLayout:"fullscreen",
			dottedOverlay:"none",
			delay:9000,
			navigation: {
			},
			responsiveLevels:[1240,1024,778,480],
			gridwidth:[1240,1024,778,480],
			gridheight:[600,500,400,300],
			lazyType:"none",
			parallax: {
				type:"mouse",
				origo:"slidercenter",
				speed:1000,
				levels:[2,3,4,5,6,7,12,16,10,50],
			},
			shadow:0,
			spinner:"off",
			autoHeight:"off",
			disableProgressBar:"on",
			hideThumbsOnMobile:"off",
			hideSliderAtLimit:0,
			hideCaptionAtLimit:0,
			hideAllCaptionAtLilmit:0,
			debugMode:false,
			fallbacks: {
				simplifyAll:"off",
				disableFocusListener:false,
			}
		});	

		// Fullscreen Slider
		jQuery("#ws-fullscreen-slider").revolution({
			sliderType:"standard",
			fullScreenOffsetContainer:".ws-topbar",
			sliderLayout:"fullscreen",
			delay:9000,
			navigation: {
				arrows:{enable:true}				
			},			
			gridwidth:1230,
			spinner:"off",
			disableProgressBar:"on",
			gridheight:720		
		});	

		// Fullwidth
		jQuery("#ws-fullwidth-slider").revolution({
			sliderType:"standard",
			fullScreenOffsetContainer:".ws-topbar",
			sliderLayout:"fullscreen",
			delay:9000,
			navigation: {
				arrows:{enable:true}				
			},			
			gridwidth:1230,
			spinner:"off",
			disableProgressBar:"on",
			fullWidth:"on",
			forceFullWidth:"on",
			gridheight:500		
		});	

		// 3D Parallax Slider	
	    jQuery("#ws-3d-parallax").show().revolution({
	        sliderType: "hero",
	        fullScreenOffsetContainer:".ws-topbar, .ws-header-static",
	        jsFileLocation: "assets/js/plugins/revolution/js/",            
	        sliderLayout: "fullscreen",
	        dottedOverlay: "none",
	        delay: 9000,
	        navigation: {},
	        responsiveLevels: [1240, 1024, 778, 480],
	        visibilityLevels: [1240, 1024, 778, 480],
	        gridwidth: [1400, 1240, 778, 480],
	        gridheight: [768, 768, 960, 720],
	        lazyType: "none",
	        parallax: {
	            type: "3D",
	            origo: "slidercenter",
	            speed: 1000,
	            levels: [5, 10, 15, 20, 25, 30, 5, 0, 45, 50, 47, 48, 49, 50, 51, 55],
	            ddd_shadow: "off",
	            ddd_bgfreeze: "off",
	            ddd_overflow: "hidden",
	            ddd_layer_overflow: "visible",
	            ddd_z_correction: 65,
	        },
	        spinner: "off",
	        autoHeight: "off",
	        disableProgressBar: "on",
	        hideThumbsOnMobile: "off",
	        hideSliderAtLimit: 0,
	        hideCaptionAtLimit: 0,
	        hideAllCaptionAtLilmit: 0,
	        debugMode: false,
	        fallbacks: {
	            simplifyAll: "off",
	            disableFocusListener: false,
	        }
	    });    

    });

})(jQuery, window, document);