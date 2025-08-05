<?php
require_once __DIR__ . '/../config/database.php';

function redirect($url) {
    header("Location: $url");
    exit();
}

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        redirect('login.php');
    }
}

function getUserRole() {
    return $_SESSION['role_id'] ?? null;
}

function getBarangList($conn) {
    $result = $conn->query("SELECT * FROM barang");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getBagianList($conn) {
    $result = $conn->query("SELECT * FROM bagian");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getRolesList($conn) {
    $result = $conn->query("SELECT * FROM roles");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getMenuByRole($conn, $roleId) {
    $stmt = $conn->prepare("SELECT m.* FROM menu m 
                          JOIN menu_role mr ON m.id = mr.menu_id 
                          WHERE mr.role_id = ? 
                          ORDER BY m.ordering");
    $stmt->bind_param("i", $roleId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Hash password menggunakan bcrypt (seperti Laravel)
 */
function bcrypt($password, $cost = 10) {
    return password_hash($password, PASSWORD_BCRYPT, ['cost' => $cost]);
}

/**
 * Verifikasi password yang dihash dengan bcrypt
 */
function verifyBcrypt($password, $hashedPassword) {
    return password_verify($password, $hashedPassword);
}
?>