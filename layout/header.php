<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - <?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></title>
    
    <!-- Bootstrap 4 CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 56px;
        }
        
        body {
            padding-top: var(--header-height);
            padding-left: var(--sidebar-width);
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background-color: #343a40;
            padding-top: var(--header-height);
            z-index: 1000;
            transition: all 0.3s;
        }
        
        .main-header {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--header-height);
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            z-index: 1001;
            transition: all 0.3s;
        }
        
        .main-content {
            padding: 20px;
            margin-top: 20px;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .sidebar-menu li a {
            display: block;
            padding: 12px 20px;
            color: #c2c7d0;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu li a:hover {
            color: #fff;
            background-color: rgba(255,255,255,.1);
        }
        
        .sidebar-menu li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .sidebar-menu li.active a {
            color: #fff;
            background-color: rgba(255,255,255,.1);
        }
        
        .brand-link {
            display: block;
            padding: 15px 20px;
            background-color: #343a40;
            color: #fff;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.2rem;
            position: fixed;
            top: 0;
            left: 0;
            width: var(--sidebar-width);
            height: var(--header-height);
            z-index: 1002;
        }
        
        @media (max-width: 768px) {
            body {
                padding-left: 0;
            }
            
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-header {
                left: 0;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
        }

        /* Tambahkan ini ke bagian CSS yang sudah ada */
.sidebar-collapse .sidebar {
    transform: translateX(-100%);
}

.sidebar-collapse .main-header {
    left: 0;
    width: 100%;
}

@media (min-width: 768px) {
    .sidebar-collapse .sidebar {
        transform: translateX(0);
    }
    
    .sidebar-collapse .main-header {
        left: var(--sidebar-width);
        width: calc(100% - var(--sidebar-width));
    }
}
    </style>
</head>
<body>
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
        <span>AdminPanel</span>
    </a>
    
    <!-- Main Header -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
    <i class="fas fa-bars"></i>
</a>
            </li>
        </ul>
        
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="main.php?page=views/profile" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="logout.php" class="dropdown-item">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>