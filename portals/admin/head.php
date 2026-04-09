<!-- ========== Admin Head Metadata & Stylesheets ========= -->
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />

<!-- ========== All CSS files linkup ========= -->
<!-- Bootstrap 5 from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />

<!-- LineIcons from CDN -->
<link rel="stylesheet" href="https://cdn.lineicons.com/4.0/lineicons.css" />

<!-- Material Design Icons from CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.min.css" />

<!-- Admin Custom Styles -->
<link rel="stylesheet" href="assets/css/main.css" />

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />

<!-- Firebase for notifications -->
<script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.9.0/firebase-messaging.js"></script>

<style>
    /* Admin Portal Custom Styles */
    body.admin-portal {
        display: flex;
        min-height: 100vh;
        background-color: #f5f6fa;
    }
    
    .page-container {
        display: flex;
        width: 100%;
        min-height: 100vh;
    }
    
    .sidebar-nav-wrapper {
        width: 250px;
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        background: white;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
        transition: transform 0.3s;
        z-index: 1000;
    }
    
    @media (max-width: 768px) {
        .sidebar-nav-wrapper {
            transform: translateX(-100%);
        }
        
        .sidebar-nav-wrapper.active {
            transform: translateX(0);
        }
    }
    
    .main-content {
        margin-left: 250px;
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    
    @media (max-width: 768px) {
        .main-content {
            margin-left: 0;
        }
    }
    
    .main-wrapper {
        flex: 1;
        padding: 30px 20px;
        overflow-y: auto;
    }
    
    .header {
        background: white;
        border-bottom: 1px solid #e0e0e0;
        padding: 15px 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }
    
    .card-stats {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .card-stats:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }
    
    .footer {
        margin-top: auto;
        padding: 20px;
        border-top: 1px solid #e0e0e0;
        background: white;
        font-size: 12px;
        color: #999;
    }
    
    .sidebar-toggle {
        display: none;
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
    }
    
    @media (max-width: 768px) {
        .sidebar-toggle {
            display: block;
        }
    }
    
    .search-box {
        display: flex;
        background: #f0f0f0;
        border-radius: 5px;
        padding: 0 10px;
    }
    
    .search-field {
        flex: 1;
        border: none;
        background: transparent;
        padding: 10px;
        outline: none;
    }
    
    .notification-item, .message-item, .profile-item {
        position: relative;
        margin-left: 20px;
    }
    
    .notification-icon, .message-icon, .profile-btn {
        background: none;
        border: none;
        color: #666;
        cursor: pointer;
        position: relative;
        font-size: 20px;
        transition: color 0.3s;
    }
    
    .notification-icon:hover, .message-icon:hover, .profile-btn:hover {
        color: #667eea;
    }
    
    .notification-counter, .message-counter {
        position: absolute;
        top: -5px;
        right: -8px;
        background: #e74c3c;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }
    
    .notification-dropdown, .message-dropdown, .profile-dropdown {
        position: absolute;
        top: 100%;
        right: 0;
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        width: 300px;
        margin-top: 10px;
        z-index: 1000;
    }
    
    .profile-dropdown {
        width: 200px;
    }
    
    .notification-header, .message-header {
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .notification-list, .message-list {
        list-style: none;
        padding: 0;
        margin: 0;
        max-height: 300px;
        overflow-y: auto;
    }
    
    .notification-list li, .message-list li {
        border-bottom: 1px solid #f0f0f0;
    }
    
    .notification-list a, .message-list a {
        display: block;
        padding: 12px 15px;
        color: #333;
        text-decoration: none;
        transition: background 0.3s;
    }
    
    .notification-list a:hover, .message-list a:hover {
        background: #f5f5f5;
    }
    
    .profile-dropdown-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        color: #333;
        text-decoration: none;
        transition: background 0.3s;
    }
    
    .profile-dropdown-item:hover {
        background: #f5f5f5;
    }
    
    .profile-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
    }
    
    .profile-name {
        margin: 0 10px;
        font-weight: 500;
    }
</style>
