<?php
// Koneksi database
$conn = new mysqli("localhost", "dev", "terserah", "winkur");

// Proses simpan permissions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['simpan_permissions'])) {
    $role_id = intval($_POST['role_id']);
    
    // Hapus permissions lama untuk role ini
    $conn->query("DELETE FROM permissions WHERE role_id = $role_id");
    
    // Simpan permissions baru
    if (isset($_POST['permissions']) && is_array($_POST['permissions'])) {
        foreach ($_POST['permissions'] as $menu_id => $perms) {
            $menu_id = intval($menu_id);
            $can_view = isset($perms['view']) ? 1 : 0;
            $can_create = isset($perms['create']) ? 1 : 0;
            $can_edit = isset($perms['edit']) ? 1 : 0;
            $can_delete = isset($perms['delete']) ? 1 : 0;
            
            $query = "INSERT INTO permissions (role_id, menu_id, can_view, can_create, can_edit, can_delete) 
                     VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiiiii", $role_id, $menu_id, $can_view, $can_create, $can_edit, $can_delete);
            $stmt->execute();
        }
    }
    
   // header("Location: permissions.php?role_id=$role_id");
    echo "<script>window.location.href = '?page=views/permisions.php&role_id=$role_id';</script>";
    exit();
}

// Ambil semua role untuk dropdown
$roles = $conn->query("SELECT * FROM roles ORDER BY name");

// Ambil role_id yang dipilih (default role pertama)
$selected_role_id = isset($_GET['role_id']) ? intval($_GET['role_id']) : ($roles->num_rows > 0 ? $roles->fetch_assoc()['id'] : 0);
$roles->data_seek(0); // Reset pointer hasil query

// Ambil semua menu
$menus = $conn->query("SELECT * FROM menus ORDER BY parent_id, `order`");

// Ambil permissions untuk role yang dipilih
$permissions = [];
$perms_result = $conn->query("SELECT * FROM permissions WHERE role_id = $selected_role_id");
while ($perm = $perms_result->fetch_assoc()) {
    $permissions[$perm['menu_id']] = $perm;
}
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Permissions</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Set Hak Akses</h6>
        </div>
        <div class="card-body">
            <!-- Form Pilih Role -->
            <form method="GET" class="mb-4">
                <div class="form-row">
                    <div class="col-md-6">
                        <select name="role_id" class="form-control" onchange="this.form.submit()">
                            <?php while ($role = $roles->fetch_assoc()): ?>
                            <option value="main.php?page=views/permisions.php&role_id=<?= $role['id'] ?>" <?= $role['id'] == $selected_role_id ? 'selected' : '' ?>>
                                <a href="main.php?page=views/permisions.php&role_id=<?= $role['id'] ?>">
                                    <?= htmlspecialchars($role['name']) ?>
                                </a>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
            </form>

            <!-- Form Permissions -->
            <form method="POST">
                <input type="hidden" name="role_id" value="<?= $selected_role_id ?>">
                
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th class="text-center">View</th>
                                <th class="text-center">Create</th>
                                <th class="text-center">Edit</th>
                                <th class="text-center">Delete</th>
                                <th class="text-center">Select All</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($menu = $menus->fetch_assoc()): 
                                $perm = $permissions[$menu['id']] ?? [
                                    'can_view' => 0,
                                    'can_create' => 0,
                                    'can_edit' => 0,
                                    'can_delete' => 0
                                ];
                            ?>
                            <tr>
                                <td>
                                    <?= !empty($menu['parent_id']) ? '-- ' : '' ?>
                                    <?= htmlspecialchars($menu['name']) ?>
                                    <?= !empty($menu['icon']) ? ' <i class="'.htmlspecialchars($menu['icon']).'"></i>' : '' ?>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="permissions[<?= $menu['id'] ?>][view]" 
                                           <?= $perm['can_view'] ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="permissions[<?= $menu['id'] ?>][create]" 
                                           <?= $perm['can_create'] ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="permissions[<?= $menu['id'] ?>][edit]" 
                                           <?= $perm['can_edit'] ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" name="permissions[<?= $menu['id'] ?>][delete]" 
                                           <?= $perm['can_delete'] ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-outline-secondary select-all" 
                                            data-menu-id="<?= $menu['id'] ?>">
                                        <i class="fas fa-check-square"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="text-right mt-3">
                    <button type="submit" name="simpan_permissions" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Permissions
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Fungsi untuk select all permissions per menu
document.querySelectorAll('.select-all').forEach(button => {
    button.addEventListener('click', function() {
        const menuId = this.getAttribute('data-menu-id');
        const checkboxes = document.querySelectorAll(`input[name^="permissions[${menuId}]"]`);
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        
        checkboxes.forEach(cb => {
            cb.checked = !allChecked;
        });
    });
});
</script>

<?php $conn->close(); ?>