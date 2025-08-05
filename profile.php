<?php
$pageTitle = "Profil Pengguna";
$breadcrumbs = [
    ['name' => 'Dashboard', 'url' => 'dashboard.php', 'active' => false],
    ['name' => 'Profil', 'url' => 'profile.php', 'active' => true]
];
require_once __DIR__ . '/includes/header.php';

// Ambil data user dari database
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT u.*, b.nama_bagian, r.role_name 
                       FROM users u
                       LEFT JOIN bagian b ON u.bagian_id = b.id
                       LEFT JOIN roles r ON u.roles_id = r.id
                       WHERE u.id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Proses update profil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    
    try {
        // Validasi email unik
        if ($email != $user['email']) {
            $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            $checkStmt->bind_param("s", $email);
            $checkStmt->execute();
            if ($checkStmt->get_result()->num_rows > 0) {
                throw new Exception("Email sudah digunakan oleh pengguna lain");
            }
        }
        
        // Jika ingin ganti password
        if (!empty($newPassword)) {
            if (md5($currentPassword) !== $user['password']) {
                throw new Exception("Password saat ini salah");
            }
            
            if ($newPassword !== $confirmPassword) {
                throw new Exception("Konfirmasi password tidak sesuai");
            }
            
            $hashedPassword = md5($newPassword);
            $updateStmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
            $updateStmt->bind_param("sssi", $name, $email, $hashedPassword, $userId);
        } else {
            $updateStmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $updateStmt->bind_param("ssi", $name, $email, $userId);
        }
        
        if ($updateStmt->execute()) {
            $_SESSION['success'] = "Profil berhasil diperbarui";
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            // Refresh halaman untuk menampilkan perubahan
            header("Location: profile.php");
            exit();
        } else {
            throw new Exception("Gagal memperbarui profil");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
}
?>

<div class="row">
    <div class="col-md-8">
        <div class="card card-custom">
            <div class="card-header card-header-custom">
                <h5 class="card-title mb-0 text-white">Informasi Profil</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Bagian/Divisi</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($user['nama_bagian'] ?? 'Tidak ada data') ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($user['role_name'] ?? 'Tidak ada data') ?>" readonly>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h5 class="mb-3">Ganti Password</h5>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="new_password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" name="update_profile" class="btn btn-primary-custom">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card card-custom">
            <div class="card-header card-header-custom">
                <h5 class="card-title mb-0 text-white">Foto Profil</h5>
            </div>
            <div class="card-body text-center">
                <div class="mb-3">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($user['name']) ?>&background=3498db&color=fff&size=150" 
                         class="rounded-circle" width="150" height="150" alt="Foto Profil">
                </div>
                <button class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-camera me-2"></i>Ubah Foto
                </button>
                <p class="text-muted mt-2 mb-0">Format: JPG, PNG maks. 2MB</p>
            </div>
        </div>
        
        <div class="card card-custom mt-4">
            <div class="card-header card-header-custom">
                <h5 class="card-title mb-0 text-white">Aktivitas Terakhir</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Login terakhir
                        <span class="text-muted"><?= date('d M Y H:i') ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        IP Address
                        <span class="text-muted"><?= $_SERVER['REMOTE_ADDR'] ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Perangkat
                        <span class="text-muted"><?= $_SERVER['HTTP_USER_AGENT'] ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>