<?php
//require_once __DIR__ . '/includes/header.php';
//require_once __DIR__ . '/includes/functions.php';

//// Hanya admin yang bisa mendaftarkan user baru
//checkLogin();
//if (getUserRole() != 2) {
//    redirect('dashboard.php');
//}
require 'config/database.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = bcrypt($_POST['password']);
    $roleId = $_POST['role_id'];
    $bagianId = $_POST['bagian_id'];
    
    try {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, roles_id, bagian_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $roleId, $bagianId]);
        
        $_SESSION['success'] = "User berhasil didaftarkan";
        redirect('master/users.php');
    } catch (PDOException $e) {
        $_SESSION['error'] = "Gagal mendaftarkan user: " . $e->getMessage();
    }
}

// Ambil data roles dan bagian untuk dropdown
$roles = [];
try {
    $roles = getRolesList($conn);
} catch (Error $e) {
    $_SESSION['error'] = "Gagal mendapatkan roles: " . $e->getMessage();
}
$bagian = [];
try {
    $bagian = getBagianList($conn);
} catch (Error $e) {
    $_SESSION['error'] = "Gagal mendapatkan bagian: " . $e->getMessage();
}
?>

<div class="container mt-4">
    <h2>Tambah User Baru</h2>
    
    <div class="card card-custom mt-4">
        <div class="card-body">
            <form method="POST">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role_id" class="form-select" required>
                            <option value="">Pilih Role</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"><?= $role['role_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Bagian/Divisi</label>
                    <select name="bagian_id" class="form-select" required>
                        <option value="">Pilih Bagian</option>
                        <?php foreach ($bagian as $b): ?>
                            <option value="<?= $b['id'] ?>"><?= $b['nama_bagian'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <button type="submit" name="register" class="btn btn-primary-custom">Daftarkan User</button>
            </form>
        </div>
    </div>
</div>

<?php //require_once __DIR__ . '/includes/footer.php'; ?>

