<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>/public/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=base_url()?>/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?=base_url()?>/public/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?=base_url()?>/public/plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>/public/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Store</b>Panel</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="text-center"><img src="<?=base_url()?>/public/images/logo.png"></p>
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" id="email" class="form-control" placeholder="Email" autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="password" class="form-control" placeholder="Password" autocomplete="off">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <!-- <input type="password" id="password" class="form-control" placeholder="Password" autocomplete="off"> -->
          <div id="recaptcha-container"></div>
          
        </div>
        <div class="row">
          <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
          <!-- /.col -->
          <div class="col-12">
            <button type="button" class="btn loginbtn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <div class="social-auth-links text-center mb-3">
        <p>- OR -</p>
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="<?=base_url()?>/forget-password">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="<?=base_url()?>/register" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?=base_url()?>/public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>/public/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="<?=base_url()?>/public/plugins/sweetalert2/sweetalert2.min.js"></script>

<script src="<?=base_url()?>/public/plugins/toastr/toastr.min.js"></script>
<script type="text/javascript">
	$(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
	$('.loginbtn').click(function() {
		var email = $('#email').val();
		var password = $('#password').val();
		if(email=='')
		{
	      toastr.error('Email field is required.');
	      return false;
		}
		if(password=='')
		{
	      toastr.error('Password field is required.');
	      return false;
		}
		$.post('<?=base_url()?>/logincheck', {email:email, password:password}, function(resp){
			if(resp == 'ok')
			{

				//return false;
				window.location.href = '<?=base_url()?>/dashboard'
			}
			else if(resp == 'notok')
			{
				toastr.error('Account Deactivated, please contact admin.');
	      		return false;
			}
			else
			{
			    	toastr.error('Email or password is mismatch');
	      		return false;
			}
		} )		
    });
}) //on load
</script>
    <!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyCSNGUwzJ0iXTz01MAWsfec5jbTWvbCYC8",
    authDomain: "merchant-booking.firebaseapp.com",
    databaseURL: "https://merchant-booking.firebaseio.com",
    projectId: "merchant-booking",
    storageBucket: "merchant-booking.appspot.com",
    messagingSenderId: "909204433162",
    appId: "1:909204433162:web:8421fcaf404eaf3eccb2f3"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
</script>
 <script> 
   window.onload=function () {
  render();
};
function render() {
    window.recaptchaVerifier=new firebase.auth.RecaptchaVerifier('recaptcha-container');
    recaptchaVerifier.render();
}
</script>

</body>
</html>
