<?php
require_once __DIR__ . '/config/database.php';
//require_once __DIR__ . '/../functions.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? '';
$response = ['success' => false, 'message' => ''];

try {
    switch ($action) {
        case 'get':
            // Ambil data menu untuk edit
            $id = $_GET['id'] ?? 0;
            $stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $response['success'] = true;
                $response['data'] = $result->fetch_assoc();
            } else {
                $response['message'] = 'Menu tidak ditemukan';
            }
            break;
            
        case 'create':
            // Tambah menu baru
            $name = $_POST['name'] ?? '';
            $url = $_POST['url'] ?? null;
            $icon = $_POST['icon'] ?? null;
            $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
            $ordering = (int)($_POST['ordering'] ?? 0);
            $is_active = (int)($_POST['is_active'] ?? 1);
            
            $stmt = $conn->prepare("INSERT INTO menu (name, url, icon, parent_id, ordering, is_active) 
                                  VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssii", $name, $url, $icon, $parent_id, $ordering, $is_active);
            
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Menu berhasil ditambahkan';
            } else {
                $response['message'] = 'Gagal menambahkan menu: ' . $stmt->error;
            }
            break;
            
        case 'update':
            // Update menu
            $id = $_POST['id'] ?? 0;
            $name = $_POST['name'] ?? '';
            $url = $_POST['url'] ?? null;
            $icon = $_POST['icon'] ?? null;
            $parent_id = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;
            $ordering = (int)($_POST['ordering'] ?? 0);
            $is_active = (int)($_POST['is_active'] ?? 1);
            
            $stmt = $conn->prepare("UPDATE menu SET 
                                  name = ?, 
                                  url = ?, 
                                  icon = ?, 
                                  parent_id = ?, 
                                  ordering = ?, 
                                  is_active = ?,
                                  updated_at = NOW()
                                  WHERE id = ?");
            $stmt->bind_param("ssssiii", $name, $url, $icon, $parent_id, $ordering, $is_active, $id);
            
            if ($stmt->execute()) {
                $response['success'] = true;
                $response['message'] = 'Menu berhasil diperbarui';
            } else {
                $response['message'] = 'Gagal memperbarui menu: ' . $stmt->error;
            }
            break;
            
        case 'delete':
            // Hapus menu
            $id = $_GET['id'] ?? 0;
            
            // Cek apakah menu punya children
            $checkStmt = $conn->prepare("SELECT COUNT(*) as child_count FROM menu WHERE parent_id = ?");
            $checkStmt->bind_param("i", $id);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result()->fetch_assoc();
            
            if ($checkResult['child_count'] > 0) {
                $response['message'] = 'Tidak bisa menghapus menu yang memiliki submenu';
            } else {
                $stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
                $stmt->bind_param("i", $id);
                
                if ($stmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = 'Menu berhasil dihapus';
                } else {
                    $response['message'] = 'Gagal menghapus menu: ' . $stmt->error;
                }
            }
            break;
            
        default:
            $response['message'] = 'Aksi tidak valid';
    }
} catch (Exception $e) {
    $response['message'] = 'Terjadi kesalahan: ' . $e->getMessage();
}

echo json_encode($response);