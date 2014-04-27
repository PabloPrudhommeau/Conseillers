$(document).ready(function(){
	$('.menu li a').on('mouseover',function(){
		$(this).stop(true,false).animate({
			backgroundColor : "#00b4db",
			color : "#ffffff"
		},300);
	});
	$('.menu li a').on('mouseout',function(){
		$(this).stop(true,false).animate({
			backgroundColor : "#000000",
			color : "#808080"
		},300);
	});
});