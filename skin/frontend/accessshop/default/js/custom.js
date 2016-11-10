   jQuery(document).ready(function() {
     	
  jQuery('.owl-carousel').owlCarousel({
    loop:true,
    margin:0,
    nav:true,
    autoplay:true,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    autoplaySpeed: 1000,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
});
//var owl = $("#owl-demo");
 
  // owl.owlCarousel({
      // items : 10, //10 items above 1000px browser width
      // itemsDesktop : [1000,4], //5 items between 1000px and 901px
      // itemsDesktopSmall : [900,3], // betweem 900px and 601px
      // itemsTablet: [600,2], //2 items between 600 and 0
      // itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
  // });


jQuery('.fourpice .owl-carousel1').owlCarousel({
   loop:true,
    margin:-70,
   nav:true,
   autoplay:true,
   //autoplayTimeout:3000,
   autoplayHoverPause:true,
   autoplaySpeed: 1000,
   responsive:{
       0:{
           items:1
       },
       600:{
           items:2
       },
       1000:{
           items:4
       }
   }
});

    });
    
    
