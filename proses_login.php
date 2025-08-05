<?php
session_start();
require_once __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Menggunakan MD5 untuk testing
    
    try {
        // Cari user berdasarkan email
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user) {
            // Verifikasi password (MD5)
            if ($password === $user['password']) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role_id'] = $user['roles_id'];
                $_SESSION['bagian_id'] = $user['bagian_id'];
                
                // Redirect ke dashboard jika berhasil
                header("Location: dashboard.php");
                exit();
            } else {
                $_SESSION['error'] = "Password salah";
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Email tidak ditemukan";
            header("Location: index.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Terjadi kesalahan sistem: " . $e->getMessage();
        header("Location: index.php");
        exit();
    }
} else {
    // Jika akses langsung ke file ini tanpa POST, redirect ke index
    header("Location: index.php");
    exit();
}
?>