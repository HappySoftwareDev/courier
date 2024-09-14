$(document).ready(function(){
	var form = $("#bdo-form");
	form.ajaxForm({
		beforeSend: function(){
			$('.loader-bg').removeClass('remove');
		},

		success: function(){
			$('#bdo-form').trigger("reset");
		},

		complete: function(response){
			if( response.responseText == "success" ){
				window.location.href = "success";
			}else if( response.responseText == "failed" ){
				alert("Error!");
			}else if( response.responseText == "error_occured"){
				alert("An Error Occured");
			}
		}

	});


});

