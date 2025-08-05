<?php
session_start();
require 'config/database.php';
require 'functions.php';

// Redirect jika belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$currentPage = basename($_SERVER['PHP_SELF']);
$roleId = $_SESSION['role_id'];
$menus = getMenuByRole($conn, $roleId);

// DEBUG: Tampilkan struktur data menu
echo "<pre>";
print_r($menus);
echo "</pre>";
//die(); // Hentikan eksekusi untuk melihat debug
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle : 'Sistem Inventaris' ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }
        
        .sidebar {
            background-color: var(--secondary-color);
            color: white;
            height: 100vh;
            position: fixed;
            width: 250px;
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.2);
        }
        
        .sidebar-menu {
            padding: 0;
            list-style: none;
        }
        
        .sidebar-menu li {
            position: relative;
        }
        
        .sidebar-menu li a {
            color: #b8c7ce;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .sidebar-menu li a:hover {
            color: white;
            background-color: rgba(0, 0, 0, 0.2);
        }
        
        .sidebar-menu li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        .sidebar-menu li.active > a {
            color: white;
            background-color: var(--primary-color);
        }
        
        .main-content {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }
        
        .navbar-custom {
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .card-custom {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        
        .card-custom:hover {
            transform: translateY(-5px);
        }
        
        .card-header-custom {
            background-color: var(--primary-color);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }
        
        .btn-primary-custom {
            background-color: var(--primary-color);
            border: none;
        }
        
        .btn-primary-custom:hover {
            background-color: #2980b9;
        }
        
        .badge-primary-custom {
            background-color: var(--primary-color);
        }
        
        .table-custom th {
            background-color: var(--light-color);
        }
        
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar.active {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header d-flex justify-content-between align-items-center">
                <h4 class="m-0">INVENTARIS</h4>
                <button class="btn d-lg-none" id="sidebarToggle">
                    <i class="fas fa-bars text-white"></i>
                </button>
            </div>
            
            <ul class="sidebar-menu">
                <?php foreach ($menus as $menu): ?>
                    <?php if (is_null($menu['parent_id'])): ?>
                        <?php 
                        $hasChildren = false;
                        foreach ($menus as $child) {
                            if ($child['parent_id'] == $menu['id']) {
                                $hasChildren = true;
                                break;
                            }
                        }
                        ?>
                        
                        <?php if ($hasChildren): ?>
                            <li class="<?= $currentPage == $menu['url'] ? 'active' : '' ?>">
                                <a href="#submenu-<?= $menu['id'] ?>" data-bs-toggle="collapse">
                                    <?php if ($menu['icon']): ?>
                                        <i class="<?= $menu['icon'] ?>"></i>
                                    <?php endif; ?>
                                    <?= $menu['name'] ?>
                                    <i class="fas fa-angle-down float-end mt-1"></i>
                                </a>
                                <ul class="collapse list-unstyled" id="submenu-<?= $menu['id'] ?>">
                                    <?php foreach ($menus as $child): ?>
                                        <?php if ($child['parent_id'] == $menu['id']): ?>
                                            <li class="<?= $currentPage == $child['url'] ? 'active' : '' ?>">
                                                <a href="<?= $child['url'] ?>">
                                                    <?php if ($child['icon']): ?>
                                                        <i class="<?= $child['icon'] ?>"></i>
                                                    <?php endif; ?>
                                                    <?= $child['name'] ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="<?= $currentPage == $menu['url'] ? 'active' : '' ?>">
                                <a href="<?= $menu['url'] ?>">
                                    <?php if ($menu['icon']): ?>
                                        <i class="<?= $menu['icon'] ?>"></i>
                                    <?php endif; ?>
                                    <?= $menu['name'] ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-custom mb-4">
                <div class="container-fluid">
                    <button class="btn d-none d-lg-block" id="sidebarToggle-lg">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <div class="d-flex align-items-center ms-auto">
                        <div class="dropdown">
                            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://via.placeholder.com/40" alt="User" class="rounded-circle me-2">
                                <span class="d-none d-sm-inline"><?= $_SESSION['name'] ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                                <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            
            <!-- Page Content -->
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0"><?= isset($pageTitle) ? $pageTitle : 'Dashboard' ?></h2>
                    <?php if (isset($breadcrumbs)): ?>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <?php foreach ($breadcrumbs as $crumb): ?>
                                    <li class="breadcrumb-item <?= $crumb['active'] ? 'active' : '' ?>">
                                        <?php if (!$crumb['active']): ?>
                                            <a href="<?= $crumb['url'] ?>"><?= $crumb['name'] ?></a>
                                        <?php else: ?>
                                            <?= $crumb['name'] ?>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </nav>
                    <?php endif; ?>
                </div>
                
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= $_SESSION['success'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $_SESSION['error'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>