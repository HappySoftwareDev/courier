<!-- head.php - Driver Portal -->
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />

<!-- ========== All CSS files linkup ========= -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/materialdesignicons.min.css" />
<link rel="stylesheet" href="assets/css/main.css" />

<!-- Firebase for notifications -->
<script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-messaging.js"></script>

<!-- Service Worker for Push Notifications -->
<script>
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('../../web_push/firebase-messaging-sw.php').catch(err => console.log(err));
    }
</script>
    
    



