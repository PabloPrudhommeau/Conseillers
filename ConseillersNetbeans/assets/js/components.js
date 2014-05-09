//Menu fonctionnalités
$(document).ready(function() {
	$("ul.widget-menu-feature").hover(function() {
		$(this).find("ul.widget-menu-feature-list").slideDown(100);
		$(this).hover(function() {
		}, function() {
			$(this).parent().find("ul.widget-menu-feature-list").stop().slideUp(100);
		});
	});
	$('.widget-menu-feature-list li').hover(function() {
		$(this).stop().animate({
			backgroundColor: "#dcf1ce"
		}, 100);
	}, function() {
		$(this).stop().animate({
			backgroundColor: "#ddd"
		}, 100);
	});
});

//Menu principal
$(document).ready(function() {
	$('ul.widget-menu-main li a').on('mouseover', function() {
		$(this).stop(true, false).animate({
			color: "#ffffff"
		}, 300);
	});
	$('ul.widget-menu-main li a').on('mouseout', function() {
		$(this).stop(true, false).animate({
			color: "#808080"
		}, 300);
	});
});

//Widget Bouton 
$(document).ready(function() {
	$(document).on('click', '.widget-button-default, .widget-button-classic, .widget-button-advanced', function() {
		var action = decodeURIComponent($(this).attr('action'));
		eval(action);
	});
});

$(document).ready(function() {
	$(document).on('mouseover', '.deletable-row', function() {
		$(this).find('.delete-button').fadeIn(200);
	});
	$(document).on('mouseout', '.deletable-row', function() {
		$(this).find('.delete-button').stop().fadeOut(200);
	});
});
