<?php


// Koneksi database
$conn = new mysqli("localhost", "dev", "terserah", "winkur");

// Ambil data user yang login
$user_id = $_SESSION['user_id'];
$query = "SELECT u.*, r.name as role_name, d.nama_divisi 
          FROM users u
          JOIN roles r ON u.role_id = r.id
          LEFT JOIN divisi d ON u.divisi_id = d.id
          WHERE u.id = $user_id";
$user = $conn->query($query)->fetch_assoc();

// Proses update profil
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    
    // Jika ada password baru
    if (!empty($_POST['new_password'])) {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Verifikasi password lama
        if (password_verify($current_password, $user['password'])) {
            if ($new_password === $confirm_password) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $query = "UPDATE users SET 
                         full_name = '$full_name', 
                         email = '$email', 
                         password = '$hashed_password',
                         updated_at = CURRENT_TIMESTAMP
                         WHERE id = $user_id";
            } else {
                $error = "Password baru tidak cocok!";
            }
        } else {
            $error = "Password saat ini salah!";
        }
    } else {
        $query = "UPDATE users SET 
                 full_name = '$full_name', 
                 email = '$email',
                 updated_at = CURRENT_TIMESTAMP
                 WHERE id = $user_id";
    }
    
    if (!isset($error)) {
        $conn->query($query);
        $success = "Profil berhasil diperbarui!";
        // Refresh data user
        $user = $conn->query($query)->fetch_assoc();
    }
}
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profil Saya</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Akun</h6>
        </div>
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="full_name">Nama Lengkap</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                   value="<?= htmlspecialchars($user['full_name']) ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Role</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($user['role_name']) ?>" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label>Divisi</label>
                            <input type="text" class="form-control" 
                                   value="<?= !empty($user['nama_divisi']) ? htmlspecialchars($user['nama_divisi']) : '-' ?>" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label>Status Akun</label>
                            <input type="text" class="form-control" 
                                   value="<?= $user['is_active'] ? 'Aktif' : 'Nonaktif' ?>" readonly>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <h5 class="mb-3">Ubah Password</h5>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="current_password">Password Saat Ini</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="new_password">Password Baru</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="confirm_password">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <small>
                        <i class="fas fa-info-circle"></i> Kosongkan field password jika tidak ingin mengubah password
                    </small>
                </div>
                
                <button type="submit" name="update_profile" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>

<?php $conn->close(); ?>