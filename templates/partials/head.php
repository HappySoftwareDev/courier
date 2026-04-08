<?php
/**
 * Head Partial
 * 
 * Common <head> content for all layouts.
 */
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="<?php echo APP_NAME; ?> - Courier and Logistics Service">
<meta name="author" content="WGroos">

<!-- Favicon -->
<link rel="icon" type="image/png" href="<?php echo baseUrl('/img/favicon.png'); ?>">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Main Stylesheet -->
<link rel="stylesheet" href="<?php echo baseUrl('/css/style.css'); ?>">

<!-- CSRF Token Meta Tag -->
<meta name="csrf-token" content="<?php echo AuthMiddleware::generateCSRFToken(); ?>">

<!-- Additional styles can be loaded per-page -->
<?php if (!empty($customStyles)): ?>
    <?php echo $customStyles; ?>
<?php endif; ?>


