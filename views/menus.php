<?php
// Koneksi database
$conn = new mysqli("localhost", "dev", "terserah", "winkur");

// Proses CRUD Menu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tambah_menu'])) {
        // Tambah menu baru
        $parent_id = !empty($_POST['parent_id']) ? intval($_POST['parent_id']) : NULL;
        $name = $conn->real_escape_string($_POST['name']);
        $icon = $conn->real_escape_string($_POST['icon'] ?? '');
        $url = $conn->real_escape_string($_POST['url'] ?? '');
        $order = intval($_POST['order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        $query = "INSERT INTO menus (parent_id, name, icon, url, `order`, is_active) 
                 VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isssii", $parent_id, $name, $icon, $url, $order, $is_active);
        $stmt->execute();
    }
    elseif (isset($_POST['edit_menu'])) {
        // Update menu
        $id = intval($_POST['id']);
        $parent_id = !empty($_POST['parent_id']) ? intval($_POST['parent_id']) : NULL;
        $name = $conn->real_escape_string($_POST['name']);
        $icon = $conn->real_escape_string($_POST['icon'] ?? '');
        $url = $conn->real_escape_string($_POST['url'] ?? '');
        $order = intval($_POST['order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        $query = "UPDATE menus SET 
                 parent_id = ?, name = ?, icon = ?, url = ?, `order` = ?, is_active = ? 
                 WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isssiii", $parent_id, $name, $icon, $url, $order, $is_active, $id);
        $stmt->execute();
    }
    
    //header("Location: menus.php");
    echo "<script>
        alert('Data berhasil disimpan!');
        window.location.href = '?page=views/menus.php';
    </script>";
    exit();
}

// Proses hapus menu
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    $conn->query("DELETE FROM menus WHERE id = $id");
    header("Location: menus.php");
    exit();
}

// Ambil data menu utama (parent)
$parent_menus = $conn->query("SELECT * FROM menus WHERE parent_id IS NULL ORDER BY `order` ASC");

// Ambil semua menu untuk dropdown parent
$all_menus = $conn->query("SELECT * FROM menus ORDER BY `order` ASC");

// Ambil semua menu dengan informasi parent untuk ditampilkan
$query = "SELECT m1.*, m2.name as parent_name 
          FROM menus m1 
          LEFT JOIN menus m2 ON m1.parent_id = m2.id 
          ORDER BY m1.parent_id, m1.`order` ASC";
$menus_result = $conn->query($query);
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Menu</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Menu</h6>
        </div>
        <div class="card-body">
            <!-- Form Tambah/Edit Menu -->
            <form method="POST" class="mb-4">
                <?php if (isset($_GET['edit'])): 
                    $edit_id = intval($_GET['edit']);
                    $edit_data = $conn->query("SELECT * FROM menus WHERE id = $edit_id")->fetch_assoc();
                ?>
                    <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
                    <div class="form-row">
                        <div class="col-md-3">
                            <select name="parent_id" class="form-control">
                                <option value="">-- Menu Utama --</option>
                                <?php while ($menu = $all_menus->fetch_assoc()): 
                                    if ($menu['id'] == $edit_id) continue; // Skip diri sendiri
                                ?>
                                <option value="<?= $menu['id'] ?>" <?= $menu['id'] == $edit_data['parent_id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($menu['name']) ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="name" class="form-control" placeholder="Nama Menu" 
                                   value="<?= htmlspecialchars($edit_data['name']) ?>" required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="icon" class="form-control" placeholder="Icon Font Awesome" 
                                   value="<?= htmlspecialchars($edit_data['icon']) ?>">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="url" class="form-control" placeholder="URL" 
                                   value="<?= htmlspecialchars($edit_data['url']) ?>">
                        </div>
                        <div class="col-md-1">
                            <input type="number" name="order" class="form-control" placeholder="Urutan" 
                                   value="<?= $edit_data['order'] ?>">
                        </div>
                        <div class="col-md-1">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" 
                                       <?= $edit_data['is_active'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="is_active">Aktif</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" name="edit_menu" class="btn btn-warning btn-block">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="menus.php" class="btn btn-secondary btn-block mt-1">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="form-row">
                        <div class="col-md-3">
                            <select name="parent_id" class="form-control">
                                <option value="">-- Menu Utama --</option>
                                <?php while ($menu = $all_menus->fetch_assoc()): ?>
                                <option value="<?= $menu['id'] ?>"><?= htmlspecialchars($menu['name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="name" class="form-control" placeholder="Nama Menu" required>
                        </div>
                        <div class="col-md-2">
                            <input type="text" name="icon" class="form-control" placeholder="Icon Font Awesome">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="url" class="form-control" placeholder="URL">
                        </div>
                        <div class="col-md-1">
                            <input type="number" name="order" class="form-control" placeholder="Urutan" value="0">
                        </div>
                        <div class="col-md-1">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" checked>
                                <label class="form-check-label" for="is_active">Aktif</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" name="tambah_menu" class="btn btn-primary btn-block">
                                <i class="fas fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            </form>

            <!-- Tabel Daftar Menu -->
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th>Nama Menu</th>
                            <th>Parent</th>
                            <th>Icon</th>
                            <th>URL</th>
                            <th width="5%">Urutan</th>
                            <th width="5%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($menu = $menus_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $menu['id'] ?></td>
                            <td><?= htmlspecialchars($menu['name']) ?></td>
                            <td><?= !empty($menu['parent_name']) ? htmlspecialchars($menu['parent_name']) : '-' ?></td>
                            <td><?= !empty($menu['icon']) ? '<i class="'.htmlspecialchars($menu['icon']).'"></i>' : '-' ?></td>
                            <td><?= !empty($menu['url']) ? htmlspecialchars($menu['url']) : '-' ?></td>
                            <td><?= $menu['order'] ?></td>
                            <td class="text-center">
                                <?= $menu['is_active'] ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Nonaktif</span>' ?>
                            </td>
                            <td class="text-center">
                                <a href="menus.php?edit=<?= $menu['id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="?page=views/menus_hapus.php&id=<?= $menu['id'] ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Yakin hapus menu ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $conn->close(); ?>