// JavaScript Document

$('document').ready(function()
{ 
var data = $("#login-form").serialize();
    $("#btn-login").click(function() {
    $.ajax({
    
    type : 'POST',
    url  : 'http://www.merchantcouriers.co.zw/driver/serverside/login.php',
    data : data,
    beforeSend: function()
    { 
     $("#error").fadeOut();
     $("#btn-login").html('Please wait ...');
    },
    success :  function(data)
         {      
        if(data=="1"){
         
         $("#error").fadeIn(1000, function(){
           
           
           $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Sorry account email has been taken!</div>');
           
           $("#btn-login").html('Create Program3');
          
         });
                    
        }
        else if(data=="Program Created")
        {
         
         $("#btn-login").html('<img src="btn-ajax-loader.gif" class="" /> &nbsp; loading ...');
		 $("#error").html('<div class="alert alert-success"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp;Church created successifully</div>');
		 window.location="orders.html";
         //setTimeout('$("#reset-form").fadeOut(500, function(){ $(".signin-form").load("login.html"); }); ',5000);
         
        }
		
		 else if(data=="Query could not execute"){
         
         $("#error").fadeIn(1000, function(){
           
           
           $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp;Sorry we can not create a church at the moment please try again</div>');
            //$("#btn-login").html('Create Program2');
                     
         });
		 }
		 else if(data=="Invalid password"){
         
         $("#error").fadeIn(1000, function(){
           
           
           $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp;Sorry wrong password please try again</div>');
            //$("#saveChurch").html('Create Program1');
                     
         });
		 }
		 
		 else if(data=="Nothing has been posted"){
         
         $("#error").fadeIn(1000, function(){
           
           
           $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp;Sorry nothing has been sent to the server please try again</div>');
            //$("#saveChurch").html('Create Program1');
                     
         });
		 }
		
        else{
          
         $("#error").fadeIn(1000, function(){
           
      $("#error").html('<div class="alert alert-danger"><span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+data+' !</div>');
           
         //$("#saveChurch").html('Create Program0');
          
         });
           
        }
         
    }
    
	});
  
	

     });  
}); 
