function assign_new_student(name, first_name){
	$(document).ready(function(){
		$.ajax({
			type: "POST",
			url: "/EducationService/AssignNewStudent/",
			data: "name="+name+"&first_name="+first_name
		}).done(function(data){
			alert(data);
		});
	});
}