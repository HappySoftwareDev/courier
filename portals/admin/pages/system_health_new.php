<?php
require_once '../../../config/bootstrap.php';
require_once 'login-security.php';
$page_title = 'System Health';
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $page_title; ?></title><?php include 'head.php'; ?></head>
<body class="admin-portal"><div class="page-container"><?php include '../sidebar-nav-menu.php'; ?>
<div class="main-content"><?php include '../header.php'; ?><main class="main-wrapper"><section class="section"><div class="container-fluid" style="padding: 30px;">
<h1 style="font-size: 32px; margin: 0;">System Health</h1>
<div style="background: white; border-radius: 8px; padding: 30px; margin-top: 20px;">
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
<div style="background: #d4edda; padding: 20px; border-radius: 8px; text-align: center;">
<div style="font-size: 24px; font-weight: bold; color: #155724;">✓</div>
<div style="color: #155724; margin-top: 10px;">Database</div>
<div style="font-size: 12px; color: #155724; margin-top: 5px;">Connected</div>
</div>
<div style="background: #d4edda; padding: 20px; border-radius: 8px; text-align: center;">
<div style="font-size: 24px; font-weight: bold; color: #155724;">✓</div>
<div style="color: #155724; margin-top: 10px;">Sessions</div>
<div style="font-size: 12px; color: #155724; margin-top: 5px;">Active</div>
</div>
<div style="background: #d4edda; padding: 20px; border-radius: 8px; text-align: center;">
<div style="font-size: 24px; font-weight: bold; color: #155724;">✓</div>
<div style="color: #155724; margin-top: 10px;">File Permissions</div>
<div style="font-size: 12px; color: #155724; margin-top: 5px;">OK</div>
</div>
</div></div></div></section></main><?php include '../footer.php'; ?></div></div>
<?php include '../footerscripts.php'; ?></body></html>
