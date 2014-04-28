$(document).ready(function() {
	$("ul.widget-global-feature").hover(function() {
		$(this).find("ul.widget-global-feature-list").slideDown(100);
		$(this).hover(function() {
		}, function() {
			$(this).parent().find("ul.widget-global-feature-list").stop().slideUp(100);
		});
	})
});