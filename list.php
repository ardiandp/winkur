<?php
$pageTitle = "Manajemen Menu";
$breadcrumbs = [
    ['name' => 'Dashboard', 'url' => 'dashboard.php', 'active' => false],
    ['name' => 'Pengaturan', 'url' => '#', 'active' => false],
    ['name' => 'Manajemen Menu', 'url' => 'menu.php', 'active' => true]
];
require_once __DIR__ . '/includes/header.php';

// Ambil semua menu dengan informasi parent
$query = "SELECT m.*, p.name as parent_name 
          FROM menu m
          LEFT JOIN menu p ON m.parent_id = p.id
          ORDER BY m.parent_id, m.ordering";
$result = $conn->query($query);
$menus = $result->fetch_all(MYSQLI_ASSOC);

// Ambil menu parent untuk dropdown
$parentMenus = $conn->query("SELECT id, name FROM menu WHERE parent_id IS NULL")->fetch_all(MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card card-custom">
            <div class="card-header card-header-custom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 text-white">Daftar Menu</h5>
                    <button class="btn btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#addMenuModal">
                        <i class="fas fa-plus me-2"></i>Tambah Menu
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>URL</th>
                                <th>Icon</th>
                                <th>Parent</th>
                                <th>Order</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($menus as $menu): ?>
                            <tr>
                                <td><?= $menu['id'] ?></td>
                                <td><?= htmlspecialchars($menu['name']) ?></td>
                                <td><?= htmlspecialchars($menu['url'] ?? '-') ?></td>
                                <td>
                                    <?php if ($menu['icon']): ?>
                                        <i class="<?= htmlspecialchars($menu['icon']) ?>"></i>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($menu['parent_name'] ?? '-') ?></td>
                                <td><?= $menu['ordering'] ?></td>
                                <td>
                                    <span class="badge bg-<?= $menu['is_active'] ? 'success' : 'danger' ?>">
                                        <?= $menu['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-menu" 
                                            data-id="<?= $menu['id'] ?>"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editMenuModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-menu" 
                                            data-id="<?= $menu['id'] ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Menu -->
<div class="modal fade" id="addMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Menu Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addMenuForm" method="POST" action="process_menu.php?action=create">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Menu</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL</label>
                        <input type="text" class="form-control" name="url" placeholder="contoh: dashboard.php">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon</label>
                        <input type="text" class="form-control" name="icon" placeholder="contoh: fas fa-home">
                        <small class="text-muted">Gunakan class icon dari Font Awesome</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Parent Menu</label>
                        <select class="form-select" name="parent_id">
                            <option value="">-- Tanpa Parent --</option>
                            <?php foreach ($parentMenus as $parent): ?>
                                <option value="<?= $parent['id'] ?>"><?= htmlspecialchars($parent['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ordering</label>
                            <input type="number" class="form-control" name="ordering" value="0" min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="is_active">
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Menu -->
<div class="modal fade" id="editMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editMenuForm" method="POST" action="process_menu.php?action=update">
                <input type="hidden" name="id" id="editMenuId">
                <div class="modal-body">
                    <!-- Konten sama dengan modal tambah, akan diisi via JS -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Handle edit button click
    $('.edit-menu').click(function() {
        const menuId = $(this).data('id');
        $.ajax({
            url: 'process_menu.php?action=get&id=' + menuId,
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const menu = response.data;
                    $('#editMenuId').val(menu.id);
                    
                    // Isi form edit
                    let modalBody = `
                        <div class="mb-3">
                            <label class="form-label">Nama Menu</label>
                            <input type="text" class="form-control" name="name" value="${menu.name}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">URL</label>
                            <input type="text" class="form-control" name="url" value="${menu.url || ''}" placeholder="contoh: dashboard.php">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Icon</label>
                            <input type="text" class="form-control" name="icon" value="${menu.icon || ''}" placeholder="contoh: fas fa-home">
                            <small class="text-muted">Gunakan class icon dari Font Awesome</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Parent Menu</label>
                            <select class="form-select" name="parent_id">
                                <option value="">-- Tanpa Parent --</option>`;
                    
                    // Tambahkan opsi parent menu
                    <?php foreach ($parentMenus as $parent): ?>
                        if (<?= $parent['id'] ?> != menu.id) { // Hindari memilih diri sendiri sebagai parent
                            modalBody += `<option value="<?= $parent['id'] ?>" ${menu.parent_id == <?= $parent['id'] ?> ? 'selected' : ''}>
                                <?= htmlspecialchars($parent['name']) ?>
                            </option>`;
                        }
                    <?php endforeach; ?>
                    
                    modalBody += `</select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ordering</label>
                                <input type="number" class="form-control" name="ordering" value="${menu.ordering}" min="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="is_active">
                                    <option value="1" ${menu.is_active == 1 ? 'selected' : ''}>Aktif</option>
                                    <option value="0" ${menu.is_active == 0 ? 'selected' : ''}>Nonaktif</option>
                                </select>
                            </div>
                        </div>`;
                    
                    $('#editMenuForm .modal-body').html(modalBody);
                }
            }
        });
    });

    // Handle delete button click
    $('.delete-menu').click(function() {
        const menuId = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin menghapus menu ini?')) {
            $.ajax({
                url: 'process_menu.php?action=delete&id=' + menuId,
                method: 'GET',
                success: function(response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        alert(result.message);
                        location.reload();
                    } else {
                        alert(result.message);
                    }
                }
            });
        }
    });

    // Inisialisasi DataTable
    $('.datatable').DataTable({
        responsive: true,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        }
    });
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>