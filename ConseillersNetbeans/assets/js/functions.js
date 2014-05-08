function ajax_send(target, datas, return_to_div) {
	$(document).ready(function() {
		if (datas === '') {
			datas = '{}';
		}
		var obj = $.parseJSON(datas);
		$.ajax({
			type: 'POST',
			url: target,
			data: obj
		}).done(function(data) {
			if (typeof return_to_div !== 'undefined') {
				$(return_to_div).html(data);
			}
		});
	});
}

function showHideElement(element) {
	$(document).ready(function() {
		if (typeof $(element).css('display') === 'undefined' || $(element).css('display') === 'none') {
			$(element).fadeIn(200);
		} else {
			$(element).stop().fadeOut(200);
		}
	});
}
