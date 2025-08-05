<?php
// Koneksi database
$conn = new mysqli("localhost", "dev", "terserah", "winkur");

// Proses tambah user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_user'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $conn->real_escape_string($_POST['email']);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $role_id = intval($_POST['role_id']);
    $is_active = intval($_POST['is_active']);

    $divisi_id = isset($_POST['divisi_id']) ? intval($_POST['divisi_id']) : null;

    if (!empty($username) && !empty($_POST['password'])) {
        $query = "INSERT INTO users (username, password, email, full_name, role_id,divisi_id ,is_active, created_at, updated_at) 
                 VALUES ('$username', '$password', '$email', '$full_name', $role_id,$divisi_id, $is_active, NOW(), NOW())";
        $conn->query($query);
    }
    //header("Location: users.php");
    echo "<script>
        alert('Data berhasil disimpan!');
        window.location.href = '?page=views/users.php';
    </script>";

    exit();
}

// Ambil data users
$query = "SELECT u.id, u.username, u.email, u.full_name, r.name as role_name, u.is_active, d.nama_divisi as divisi_name 
          FROM users u 
          JOIN roles r ON u.role_id = r.id 
          LEFT JOIN divisi d ON u.divisi_id = d.id 
          ORDER BY u.id DESC";
$users_result = $conn->query($query);

// Ambil data roles untuk dropdown
$roles_query = "SELECT * FROM roles ORDER BY name";
$roles_result = $conn->query($roles_query);
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Users</h1>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahUserModal">
            <i class="fas fa-plus"></i> Tambah User
        </button>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Users</h6>
        </div>
        <div class="card-body">
            <!-- Tabel Daftar User -->
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Nama Lengkap</th>
                            <th>Role</th>
                            <th width="10%">Divisi</th>
                            <th>Aktif</th>
                            <th width="8%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = $users_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['role_name']); ?></td>
                             <td><?php echo htmlspecialchars($user['divisi_name']); ?></td>
                            <td><?php echo $user['is_active'] ? 'Ya' : 'Tidak'; ?></td>
                            <td>
                                <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                <a href="views/hapus_user.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="tambahUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="full_name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select class="form-control" id="role_id" name="role_id" required>
                            <option value="">Pilih Role</option>
                            <?php while ($role = $roles_result->fetch_assoc()): ?>
                            <option value="<?php echo $role['id']; ?>"><?php echo htmlspecialchars($role['name']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="divisi_id">Divisi</label>
                        <select class="form-control" id="divisi_id" name="divisi_id" required>
                            <option value="">Pilih Divisi</option>
                            <?php $divisi_result = $conn->query("SELECT * FROM divisi"); ?>
                            <?php while ($divisi = $divisi_result->fetch_assoc()): ?>
                            <option value="<?php echo $divisi['id']; ?>"><?php echo htmlspecialchars($divisi['nama_divisi']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="is_active">Aktif</label>
                        <select class="form-control" id="is_active" name="is_active" required>
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                    <button type="submit" name="tambah_user" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $conn->close(); ?>
