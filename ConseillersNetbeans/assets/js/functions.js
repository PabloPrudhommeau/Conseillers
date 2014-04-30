function ajax_send(target, datas){
	$(document).ready(function(){
		var obj = $.parseJSON(datas);
		$.ajax({
			type: 'POST',
			url: target,
			data: obj
		}).done(function(data){
			alert(data);
		});
	});
}