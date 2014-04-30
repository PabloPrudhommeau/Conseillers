function ajax_send(target, datas, return_to_div){
	$(document).ready(function(){
		if(datas === ''){
			datas = '{}';
		}
		var obj = $.parseJSON(datas);
		$.ajax({
			type: 'POST',
			url: target,
			data: obj
		}).done(function(data){
			if(typeof return_to_div !== 'undefined'){
				$(return_to_div).html(data);
			}
		});
	});
}
