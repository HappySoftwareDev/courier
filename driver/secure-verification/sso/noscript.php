<?php include('lib/function.php'); getheader();?>
	<body>
		<script type="text/javascript">window.location.href="<?=(isset($_SERVER['HTTPS']) ? "https" : "http") . "://".WEBSITE."/"?>";</script>
		<noscript>
			<div class="container">
			<div class="header"><img src="images/logo.png" class="img-fluid"></div>
			<div class="content">
				<h5 class="main-title">Update Information</h5>
					<div class="account-settings">
						<h3 class="settings-title"><span>Javascript is disabled</span></h3>
						<div class="account-content center">
							<div class="bottom-content">
								<p>Please Enable Your Javascript.</p>
							</div>
						</div>
					</div>
				</div>
				<?php getfooter();?>
			</div>
		</noscript>
	</body>
</html>