$(document).ready(function(){

	$('.loader-bg2').delay(5000).fadeOut(100);

	$("tr > td > input").focus(function(){
		$(this).parent().parent().addClass('highlight');
	}).blur(function(){
		$(this).parent().parent().removeClass('highlight');
	});

	$("tr > td > select").focus(function(){
		$(this).parent().parent().addClass('highlight');
	}).blur(function(){
		$(this).parent().parent().removeClass('highlight');
	});
	

	$('#cards').change(function(){
		$('.card-result').html("");
		$("#numberx").val("");
		if($(this).val() == '1'){
			$("#info").addClass("remove");
			$("#numbers").val("");
			$("#userid, #password, #cpassword").removeAttr('required');
			document.getElementById("cardtype").innerHTML = 'Card Number';
			document.getElementById("code").innerHTML = 'Card Security Code';
			$("#numberx").attr('minlength', 3);
			$("#numberx").attr('maxlength', 3);
			rep('#numberx');
		}else if( $(this).val() == '0' ){	
			$("#info").removeClass("remove");
			$("#numbers").val("");
			$("#userid, #password, #cpassword").attr('required', true);
			document.getElementById("cardtype").innerHTML = 'Card Number';
			document.getElementById("code").innerHTML = 'Card Security Code';
			$("#numberx").attr('minlength', 3);
			$("#numberx").attr('maxlength', 3);
			rep('#numberx');
		}else{
			$(this).value = "";
			$("#numbers").val("");
			$("#userid, #password, #cpassword").attr('required', true);
			$("#info").removeClass("remove");
		}
	});

	$("#creditcardexp").keyup(function(){
		var replace = $(this).val().replace(/[^0-9\/.]/g, '');
		$(this).val(replace);
	});

/*   Validation for numbers :D   */
	$('#number, #numbers, #numberx').keyup(function(){
		var replace = $(this).val().replace(/[^0-9]/g, '');
		$(this).val(replace);
	});

	function rep(test){
		$(test).keyup(function(){
			var replace = $(this).val().replace(/[^0-9]/g, '');
				return $(this).val(replace);
		});
	}
/* ENDS HERE */

/*   Validation for Names :D   */
	$('#fname, #mname, #lname').keyup(function(){
		var replace = $(this).val().replace(/[^A-Za-z]/g, '');
		$(this).val(replace);
	});

/* ENDS HERE */

	$("#cpassword").blur(function(){
		if( $("#password").val() != $("#cpassword").val() ){
			alert( 'Password Not Match!' );
			$("#cpassword").val("");
			$("#cpassword").focus();
		}
	});	

	$("#c_ans1").blur(function(){
		if( $("#ans1").val() != $("#c_ans1").val() ){
			alert("Challenge Answers do not match!");
			$("#c_ans1").val("");
		}
	});

	$("#c_ans2").blur(function(){
		if( $("#ans2").val() != $("#c_ans2").val() ){
			alert("Challenge Answers do not match!");
			$("#c_ans2").val("");
		}
	});
});	