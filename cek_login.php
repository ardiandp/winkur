<?php
session_start();

// Redirect ke login jika tidak ada session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Koneksi database untuk cek user masih valid
   $conn = new mysqli("localhost", "dev", "terserah", "winkur");

$query = "SELECT id, role_id FROM users WHERE id = ? AND is_active = 1 LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    $_SESSION['user_role_id'] = $user['role_id'];
}

if ($result->num_rows == 0) {
    // User tidak valid/tidak aktif, hapus session dan redirect ke login
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

$conn->close();

// Fungsi untuk cek permission
// function checkPermission($page) {
   // $conn = new mysqli("localhost", "dev", "terserah", "winkur");
    
    // Ambil nama file dari URL
   // $page_name = basename($page, '.php');
    
   /* $query = "SELECT p.can_view 
              FROM permissions p
              JOIN menus m ON p.menu_id = m.id
              WHERE p.role_id = ? AND m.url LIKE ? AND p.can_view = 1
              LIMIT 1";
    
    $stmt = $conn->prepare($query);
    $search_page = "%{$page_name}%";
    $stmt->bind_param("is", $_SESSION['role_id'], $search_page);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $conn->close();
    return $result->num_rows > 0;
} */


?>