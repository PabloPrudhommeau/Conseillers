$(document).ready(function(){
	$('.widget-button-default').click(function(){
		var action = $(this).attr('action');
		eval(action);
	});
});
