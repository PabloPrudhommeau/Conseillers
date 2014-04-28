//Menu fonctionnalités
$(document).ready(function() {
	$("ul.widget-menu-feature").hover(function() {
		$(this).find("ul.widget-menu-feature-list").slideDown(100);
		$(this).hover(function() {
		}, function() {
			$(this).parent().find("ul.widget-menu-feature-list").stop().slideUp(100);
		});
	});
	$('.widget-menu-feature-list li').hover(function(){
			$(this).stop().animate({
				backgroundColor : "#b1d6d6"
			}, 100);
		}, function(){
			$(this).stop().animate({
				backgroundColor : "#ccc"
			},100);
		});
});

//Menu principal
$(document).ready(function(){
	$('ul.widget-menu-main li a').on('mouseover',function(){
		$(this).stop(true,false).animate({
			color : "#ffffff"
		},300);
	});
	$('ul.widget-menu-main li a').on('mouseout',function(){
		$(this).stop(true,false).animate({
			color : "#808080"
		},300);
	});
});