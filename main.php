<?php
require 'config/database.php';
// Include middleware cek login
require_once 'cek_login.php';
function checkPermission($role_id, $page) {
    $conn = new mysqli("localhost", "dev", "terserah", "winkur");
    
    // Ambil nama file dari URL
    $page_name = basename($page, '.php');
    
    $query = "SELECT p.can_view 
              FROM permissions p
              JOIN menus m ON p.menu_id = m.id
              WHERE p.role_id = ? AND m.url LIKE ? AND p.can_view = 1
              LIMIT 1";
    
    $stmt = $conn->prepare($query);
    $search_page = "%{$page_name}%";
    $stmt->bind_param("is", $role_id, $search_page);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $conn->close();
    return $result->num_rows > 0;
}

// Contoh penggunaan:


function buildMenu($role_id) {
         $conn = new mysqli("localhost", "dev", "terserah", "winkur");
    
    $menu = [];
    $query = "SELECT m.*, p.can_view 
              FROM menus m
              JOIN permissions p ON m.id = p.menu_id
              WHERE p.role_id = ? AND m.is_active = 1 AND p.can_view = 1
              ORDER BY m.order ASC";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $role_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        if ($row['parent_id'] === null) {
            $menu[$row['id']] = $row;
            $menu[$row['id']]['children'] = [];
        } else {
            $menu[$row['parent_id']]['children'][] = $row;
        }
    }
    
    $conn->close();
    return $menu;
}
/**
 * Main template loader dengan routing via URL parameter
 */

// Fungsi untuk membersihkan path
function sanitize_path($path) {
    // Hapus karakter berbahaya
    $path = str_replace(['../', '..\\', '%2e%2e', '%2e'], '', $path);
    
    // Hanya izinkan alphanumeric, garis miring, titik, dan underscore
    $path = preg_replace('/[^a-zA-Z0-9\/\.\_\-]/', '', $path);
    
    return $path;
}

// Ambil parameter page dari URL
$requested_page = isset($_GET['page']) ? sanitize_path($_GET['page']) : 'views/dashboard.php';

// Daftar halaman yang diizinkan
$allowed_pages = [
    'views/dashboard.php',
    'views/produk.php',
    'views/roles.php',
    'views/users.php',
    'views/menus.php',
    'views/permisions.php',
    'views/menus_hapus.php',
    'views/divisi.php',
    'views/barang.php',
    'views/request_barang.php',
    'views/user_request_barang.php',
    'views/profile.php',
    'views/barang_keluar.php',
    'views/hapus_user.php',
    // Tambahkan halaman lain yang diizinkan di sini
];

// Cek apakah halaman yang diminta valid
if (!in_array($requested_page, $allowed_pages)) {
    $requested_page = 'views/dashboard.php';
}

// Ekstrak judul halaman dari nama file
$page_title = ucfirst(str_replace(['views/', '.php'], '', $requested_page));
$active_menu = str_replace(['views/', '.php'], '', $requested_page);

// Fungsi untuk load template
function load_template($page_title, $active_menu, $content_view) {
    // Start output buffering
    ob_start();
    
    // Include header
    require_once 'layout/header.php';
    
    // Include sidebar
    require_once 'layout/sidebar.php';
    
    // Start main content
    echo '<div class="main-content">';
    
    // Include the content view
    if (file_exists($content_view)) {
        require_once $content_view;
    } else {
        echo '<div class="alert alert-danger">Halaman tidak ditemukan!</div>';
    }
    
    // End main content
    echo '</div>';
    
    // Include footer
    require_once 'layout/footer.php';
    
    // End output buffering and flush
    ob_end_flush();
}

// Load template
load_template($page_title, $active_menu, $requested_page);