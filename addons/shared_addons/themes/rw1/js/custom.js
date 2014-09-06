

/* Header  */

$(document).ready(function(){
	$("header").sticky({topSpacing:0});
});

/* Navigation Menu */

ddlevelsmenu.setup("ddtopmenubar", "topbar");


/* Dropdown Select */

/* Navigation (Select box) */

// Create the dropdown base

$("<select />").appendTo(".navis");

// Create default option "Go to..."

$("<option />", {
   "selected": "selected",
   "value"   : "",
   "text"    : "Menu"
}).appendTo(".navis select");

// Populate dropdown with menu items

$(".navi a").each(function() {
 var el = $(this);
 $("<option />", {
     "value"   : el.attr("href"),
     "text"    : el.text()
 }).appendTo(".navis select");
});

$(".navis select").change(function() {
  window.location = $(this).find("option:selected").val();
});


/* Revolution Slider JS */

var api;
	jQuery(document).ready(function() {
		 api =  jQuery('.banner').revolution(
						{
							delay:7000,
							
							startheight:800,
							
							onHoverStop:"on",						// Stop Banner Timet at Hover on Slide on/off

							hideThumbs:300,

							navigationType:"none",					//bullet, thumb, none, both		(No Thumbs In FullWidth Version !)
							navigationArrows:"verticalcentered",		//nexttobullets, verticalcentered, none
							navigationStyle:"round",				//round,square,navbar

							touchenabled:"on",						// Enable Swipe Function : on/off
							
							navOffsetHorizontal:0,
							navOffsetVertical:20,

							stopAtSlide:-1,
							stopAfterLoops:-1,

							shadow:0,								//0 = no Shadow, 1,2,3 = 3 Different Art of Shadows  (No Shadow in Fullwidth Version !)
							fullWidth:"on"							// Turns On or Off the Fullwidth Image Centering in FullWidth Modus
						});
	});
	
/* Service */

$('.service-one-icon').waypoint(function(down) {
	$(this).addClass('animation');
	$(this).addClass('flipInX');
}, { offset: '50%' });


$('.service-content').waypoint(function(down) {
	$(this).addClass('animation');
	$(this).addClass('fadeInDown');
}, { offset: '70%' });

$('.service-content-left').waypoint(function(down) {
	$(this).addClass('animation');
	$(this).addClass('bounceInLeft');
}, { offset: '70%' });

$('.service-content-right').waypoint(function(down) {
	$(this).addClass('animation');
	$(this).addClass('bounceInRight');
}, { offset: '70%' });

/*  Carousel */

$('.carousel').carousel({
  interval:6000
}) ;


/* Feature */

$('.feature-one-image').waypoint(function(down) {
	$(this).addClass('animation');
	$(this).addClass('bounceInLeft');
}, { offset: '70%' });

$('.feature-one-content').waypoint(function(down) {
	$(this).addClass('animation');
	$(this).addClass('bounceInRight');
}, { offset: '70%' });

$('.feature-two-content').waypoint(function(down) {
	$(this).addClass('animation');
	$(this).addClass('bounceInLeft');
}, { offset: '70%' });

$('.feature-two-image').waypoint(function(down) {
	$(this).addClass('animation');
	$(this).addClass('bounceInRight');
}, { offset: '70%' });

/* prettyPhoto Gallery */

jQuery(".prettyphoto").prettyPhoto({
   overlay_gallery: false, social_tools: false
});
 
/* Product */

$('.product-one-image').waypoint(function(down) {
	$(this).addClass('animation');
	$(this).addClass('fadeInDown');
}, { offset: '70%' });

$('.product-two-image').waypoint(function(down) {
	$(this).addClass('animation');
	$(this).addClass('bounceIn');
}, { offset: '70%' });
	
/* About Us */

$('.img-responsive').waypoint(function(down) {
	$(this).addClass('animation');
	$(this).addClass('rotateIn');
}, { offset: '70%' });


/* Pricing */

$('.td-icon').waypoint(function(down) {
	$(this).addClass('animation');
	$(this).addClass('bounceInLeft');
}, { offset: '550' });


/* Scroll to Top */

$(".top").hide();

$(function(){
	$(window).scroll(function(){
		if ($(this).scrollTop()>300)
		{
			$('.top').slideDown();
		} 
		else
		{
			$('.top').slideUp();
		}
});

$('.top a').click(function (e) {
  e.preventDefault();
  $('body,html').animate({scrollTop: 0}, 500);
});


});	