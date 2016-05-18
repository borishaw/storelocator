$(document).ready(function(){
	
		try {
		
			$(".main").fullpage({
				anchors: ['slide1', 'slide2', 'slide3', 'slide4'],
				css3: true,
				scrollOverflow: true,
				navigation: true,
				normalScrollElementTouchThreshold: 1,
				afterLoad: function(anchorLink, index)
				{
						
					    $.fn.fullpage.reBuild();
						
						if(anchorLink == "slide4"){
							
							$('.header-logo').show();
							
						}else{
							
							if($('.homepage').width() >= '1024'){
								
								//alert("Greater" + $('.homepage').width());
								$('.header-logo').hide();
							
							}else{
								
								//alert("Lower" + $('.homepage').width());
								$('.header-logo').show();
								
							}
							
						}
						
				}
			});
		
		} catch(e) { }
				
		try {
		
			$('.products-cont ul').mixItUp();
		
		}
		
		catch(e) { }
		
		if ( ($('body').hasClass('contact')) || ($('body').hasClass('about') )) {
		
			$(window).scroll(function (event) {
				if ( $(window).scrollTop() > 70 ) {
					$('header').addClass('fixed');
				} else {
					$('header').removeClass('fixed');
				}
			});
		
		}
		
		$('.products-sel a').on('click', function(e) {
		
			e.preventDefault();
			$('.products-sel a').removeClass('button');
			pClass = $(this).data('filter');
			$(this).addClass('button');
			$('.products-cont ul').mixItUp('filter', pClass);
		
		});
		
		$('.facts').on('click', function() {
			var data = $(this).data('product');
			$.fancybox.open('img/nutri-facts/n-facts-'+data+'.jpg', {'closeBtn':true,'closeClick':true});
		});
		
		$('.product-link').on('click', function() {
			$('button.overlay-close').click();
		});
	
		$('.facts').on('click', function() {
			var data = $(this).data('product');
			$.fancybox.open('img/nutri-facts/n-facts-'+data+'.jpg', {'closeBtn':true,'closeClick':true});
		});
		
});

function closeOverlay(){
	
	$('button.overlay-close').click();
	
}