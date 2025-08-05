<?php
$pageTitle = "Tambah Barang";
$breadcrumbs = [
    ['name' => 'Dashboard', 'url' => 'dashboard.php', 'active' => false],
    ['name' => 'Master Data', 'url' => 'barang.php', 'active' => false],
    ['name' => 'Tambah Barang', 'url' => 'barang_create.php', 'active' => true]
];
require '../includes/header.php';
require '../config/database.php';

// Data untuk dropdown kategori dan satuan
$kategoriOptions = ['Dapur', 'Konsumsi', 'ATK', 'Kebersihan', 'Elektronik'];
$satuanOptions = ['pcs', 'kg', 'liter', 'rim', 'pack', 'unit'];
?>

<div class="row">
    <div class="col-md-8">
        <div class="card card-custom">
            <div class="card-header card-header-custom">
                <h5 class="card-title mb-0 text-white">Form Tambah Barang</h5>
            </div>
            <div class="card-body">
                <form action="process_barang.php?action=create" method="POST">
                    <div class="mb-3">
                        <label for="nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori">
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($kategoriOptions as $kategori): ?>
                                    <option value="<?= htmlspecialchars($kategori) ?>"><?= htmlspecialchars($kategori) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stok_awal" class="form-label">Stok Awal</label>
                            <input type="number" class="form-control" id="stok_awal" name="stok_awal" value="0" min="0">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <select class="form-select" id="satuan" name="satuan" required>
                                <option value="">-- Pilih Satuan --</option>
                                <?php foreach ($satuanOptions as $satuan): ?>
                                    <option value="<?= htmlspecialchars($satuan) ?>"><?= htmlspecialchars($satuan) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="barang.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary-custom">Simpan Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card card-custom">
            <div class="card-header card-header-custom">
                <h5 class="card-title mb-0 text-white">Petunjuk</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Nama Barang</strong>: Masukkan nama lengkap barang
                    </li>
                    <li class="list-group-item">
                        <strong>Kategori</strong>: Pilih kategori yang sesuai (opsional)
                    </li>
                    <li class="list-group-item">
                        <strong>Stok Awal</strong>: Masukkan jumlah stok awal (default 0)
                    </li>
                    <li class="list-group-item">
                        <strong>Satuan</strong>: Pilih satuan barang (wajib diisi)
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>