<?php 
use yii\helpers\Html;
?>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* ========================================
           VARIABLES - دارک و لایت مود
           ======================================== */
        :root {
            /* لایت مود (پیش‌فرض) */
            --sidebar-bg: #1a1a2e;
            --sidebar-hover: #16213e;
            --sidebar-active: #0f3460;
            --sidebar-text: rgba(255,255,255,0.7);
            --sidebar-text-active: #ffffff;
            
            --header-bg: #ffffff;
            --header-text: #333333;
            --header-shadow: 0 2px 10px rgba(0,0,0,0.1);
            
            --body-bg: #f0f2f5;
            --body-text: #333333;
            
            --card-bg: #ffffff;
            --card-border: #e9ecef;
            --card-shadow: 0 2px 10px rgba(0,0,0,0.05);
            
            --table-bg: #ffffff;
            --table-stripe: #F0F2F5;
            --table-border: #dee2e6;
            --table-hover: #f1f3f5;
            
            --input-bg: #ffffff;
            --input-border: #ced4da;
            --input-text: #495057;
            --input-focus: #80bdff;
            
            --primary-color: #e94560;
            --primary-hover: #c73e54;
            
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            
            --border-color: #e9ecef;
            --shadow-color: rgba(0,0,0,0.1);
            
            --transition-speed: 0.3s;
        }

        /* ========================================
           دارک مود
           ======================================== */
        [data-theme="dark"] {
            --sidebar-bg: #0d0d1a;
            --sidebar-hover: #1a1a2e;
            --sidebar-active: #16213e;
            --sidebar-text: rgba(255,255,255,0.6);
            --sidebar-text-active: #ffffff;
            
            --header-bg: #1a1a2e;
            --header-text: #e0e0e0;
            --header-shadow: 0 2px 10px rgba(0,0,0,0.5);
            
            --body-bg: #0d0d1a;
            --body-text: #e0e0e0;
            
            --card-bg: #1a1a2e;
            --card-border: #2d2d44;
            --card-shadow: 0 2px 10px rgba(0,0,0,0.3);
            
            --table-bg: #1a1a2e;
            --table-stripe: #22223a;
            --table-border: #2d2d44;
            --table-hover: #2a2a42;
            
            --input-bg: #2d2d44;
            --input-border: #3d3d5a;
            --input-text: #e0e0e0;
            --input-focus: #e94560;
            
            --border-color: #2d2d44;
            --shadow-color: rgba(0,0,0,0.5);
            
            --primary-color: #e94560;
            --primary-hover: #ff6b81;
        }

        .table > :not(caption) > * > *{
            background: var(--table-stripe);
            border-bottom: 2px solid var(--table-border);
            color: var(--body-text);
        }


        /* ========================================
           استایل‌های عمومی
           ======================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'IRANSans', 'Tahoma', sans-serif;
            background: var(--body-bg);
            color: var(--body-text);
            overflow-x: hidden;
            transition: background var(--transition-speed), color var(--transition-speed);
        }

        /* ========================================
           سایدبار
           ======================================== */
        .admin-sidebar {
            position: fixed;
            top: 0;
            right: 0;
            width: 260px;
            height: 100vh;
            background: var(--sidebar-bg);
            color: #fff;
            z-index: 1050;
            transition: all var(--transition-speed) ease;
            overflow-y: auto;
            box-shadow: 2px 0 15px var(--shadow-color);
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .admin-sidebar::-webkit-scrollbar-track {
            background: var(--sidebar-bg);
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }

        /* لوگو */
        .sidebar-brand {
            padding: 25px 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 10px;
        }

        .sidebar-brand a {
            color: #fff;
            text-decoration: none;
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar-brand i {
            color: var(--primary-color);
            font-size: 28px;
        }

        .sidebar-brand small {
            display: block;
            font-size: 12px;
            color: rgba(255,255,255,0.5);
            margin-top: 5px;
            font-weight: 300;
        }

        /* منو */
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            margin: 5px 10px;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 10px;
            transition: all var(--transition-speed) ease;
            font-size: 14px;
            font-weight: 500;
            position: relative;
        }

        

        .sidebar-menu li a i {
            width: 22px;
            font-size: 18px;
            text-align: center;
        }

        .sidebar-menu li a:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text-active);
            transform: translateX(-5px);
        }

        .sidebar-menu li a.active {
            background: var(--sidebar-active);
            color: var(--sidebar-text-active);
            box-shadow: 0 4px 15px rgba(233, 69, 96, 0.3);
        }

        .sidebar-menu li a.active::before {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 30px;
            background: var(--primary-color);
            border-radius: 0 5px 5px 0;
        }

        .sidebar-menu .menu-label {
            padding: 15px 18px 8px;
            font-size: 11px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.3);
            font-weight: 600;
            letter-spacing: 1px;
        }

        .sidebar-menu .badge-count {
            background: var(--primary-color);
            color: #fff;
            font-size: 11px;
            padding: 2px 10px;
            border-radius: 20px;
            margin-right: auto;
        }

        /* دکمه دارک/لایت در سایدبار */
        .theme-toggle-sidebar {
            margin: 20px 15px;
            padding: 12px;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: all var(--transition-speed) ease;
            color: var(--sidebar-text);
        }

        .theme-toggle-sidebar:hover {
            background: var(--sidebar-hover);
            border-color: var(--primary-color);
        }

        .theme-toggle-sidebar .toggle-label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
        }

        .theme-toggle-sidebar .toggle-switch {
            width: 44px;
            height: 24px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            position: relative;
            transition: all var(--transition-speed) ease;
        }

        .theme-toggle-sidebar .toggle-switch::after {
            content: '';
            position: absolute;
            top: 2px;
            right: 2px;
            width: 20px;
            height: 20px;
            background: #fff;
            border-radius: 50%;
            transition: all var(--transition-speed) ease;
        }

        [data-theme="dark"] .theme-toggle-sidebar .toggle-switch {
            background: var(--primary-color);
        }

        [data-theme="dark"] .theme-toggle-sidebar .toggle-switch::after {
            right: 22px;
        }

        /* ========================================
           محتوای اصلی
           ======================================== */
        .admin-content {
            margin-right: 260px;
            min-height: 100vh;
            transition: all var(--transition-speed) ease;
        }

        /* هدر */
        .admin-header {
            background: var(--header-bg);
            padding: 18px 30px;
            box-shadow: var(--header-shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1040;
            transition: all var(--transition-speed) ease;
        }

        .admin-header .page-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--header-text);
            margin: 0;
            transition: color var(--transition-speed);
        }

        .admin-header .page-title i {
            color: var(--primary-color);
            margin-left: 10px;
        }

        .admin-header .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-header .header-actions .theme-toggle-header {
            background: none;
            border: 1px solid var(--border-color);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--header-text);
            cursor: pointer;
            font-size: 18px;
            transition: all var(--transition-speed) ease;
        }

        .admin-header .header-actions .theme-toggle-header:hover {
            background: var(--primary-color);
            color: #fff;
            border-color: var(--primary-color);
        }

        .admin-header .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-header .user-info .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
        }

        .admin-header .user-info .username {
            font-weight: 500;
            color: var(--header-text);
            transition: color var(--transition-speed);
        }

        .admin-header .user-info .logout {
            color: var(--danger-color);
            text-decoration: none;
            font-size: 20px;
            transition: all var(--transition-speed) ease;
        }

        .admin-header .user-info .logout:hover {
            transform: scale(1.1);
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 24px;
            color: var(--header-text);
            cursor: pointer;
            padding: 5px 10px;
            transition: color var(--transition-speed);
        }

        /* بدنه */
        .admin-body {
            padding: 25px 30px;
        }

        /* بریدکرامب */
        .admin-breadcrumb {
            background: transparent;
            padding: 0 0 15px 0;
            margin: 0;
            font-size: 14px;
        }

        .admin-breadcrumb li a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .admin-breadcrumb .breadcrumb-item.active {
            color: var(--body-text);
        }

        /* کارت‌ها */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            transition: all var(--transition-speed) ease;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-color);
            padding: 15px 20px;
        }

        /* جدول */
        .table {
            color: var(--body-text);
        }

        .table thead th {
            background: var(--table-stripe);
            border-bottom: 2px solid var(--table-border);
            color: var(--body-text);
        }

        .table tbody td {
            border-bottom: 1px solid var(--table-border);
        }

        .table tbody tr:hover {
            background: var(--table-hover);
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background: var(--table-stripe);
        }

        /* فرم‌ها */
        .form-control, .form-select {
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: var(--input-text);
            transition: all var(--transition-speed) ease;
        }

        .form-control:focus, .form-select:focus {
            background: var(--input-bg);
            border-color: var(--input-focus);
            color: var(--input-text);
            box-shadow: 0 0 0 0.2rem rgba(233, 69, 96, 0.25);
        }

        .form-control::placeholder {
            color: var(--input-text);
            opacity: 0.6;
        }

        .form-label {
            color: var(--body-text);
        }

        /* دکمه‌ها */
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        /* ========================================
           واکنش‌گرا
           ======================================== */
        @media (max-width: 768px) {
            .admin-sidebar {
                right: -280px;
                width: 280px;
            }

            .admin-sidebar.open {
                right: 0;
            }

            .admin-content {
                margin-right: 0;
            }

            .mobile-toggle {
                display: block;
            }

            .admin-header .page-title {
                font-size: 16px;
            }

            .admin-header .user-info .username {
                display: none;
            }

            .admin-body {
                padding: 15px;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1045;
            }

            .sidebar-overlay.active {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .sidebar-overlay {
                display: none !important;
            }
        }

        /* ========================================
           انیمیشن‌ها
           ======================================== */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ========================================
           استایل اسکرول
           ======================================== */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--body-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-hover);
        }
    </style>
</head>