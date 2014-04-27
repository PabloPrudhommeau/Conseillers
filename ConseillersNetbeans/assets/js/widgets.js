$(document).ready(function() {
	$("ul.widget-global-feature-list").parent().append("<span></span>");
	$("ul.widget-global-feature li span").hover(function() {
		$(this).parent().find("ul.widget-global-feature-list").slideDown('fast').show();
		$(this).parent().hover(function() {
		}, function() {
			$(this).parent().find("ul.widget-global-feature-list").slideUp('slow');
		});
	}).hover(function() {
		$(this).addClass("subhover");
	}, function() {
		$(this).removeClass("subhover");
	});
});