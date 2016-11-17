jQuery(document).ready(function() {

	jQuery('.owl-carousel').owlCarousel({
		loop : true,
		margin : 0,
		nav : true,
		autoplay : true,
		autoplayTimeout : 3000,
		autoplayHoverPause : true,
		autoplaySpeed : 1000,
		responsive : {
			0 : {
				items : 1
			},
			600 : {
				items : 1
			},
			1000 : {
				items : 1
			}
		}
	});
	jQuery('.owl-bannerWarp').owlBanner({
		loop : true,
		margin : 10,
		nav : false,
		autoplay : true,
		autoplayTimeout : 3000,
		autoplayHoverPause : true,
		autoplaySpeed : 1000,
		responsive : {
			0 : {
				items : 1
			},
			600 : {
				items : 3
			},
			1000 : {
				items : 4
			}
		}
	});
	var owl = jQuery('.owl-bannerWarp');
	owl.owlBanner();
	jQuery('.customNextBtn').click(function() {
		owl.trigger('next.owl.carousel');
	});
	jQuery('.customPrevBtn').click(function() {
		owl.trigger('prev.owl.carousel', [300]);
	})
});

// jQuery('.fourpice .owl-carousel1').owlCarousel({
// loop:true,
// margin:-70,
// nav:true,
// autoplay:true,
// //autoplayTimeout:3000,
// autoplayHoverPause:true,
// autoplaySpeed: 1000,
// responsive:{
// 0:{
// items:1
// },
// 600:{
// items:2
// },
// 1000:{
// items:4
// }
// }
// });


