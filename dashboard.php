<?php
$pageTitle = "Dashboard";
$breadcrumbs = [
    ['name' => 'Dashboard', 'url' => 'dashboard.php', 'active' => true]
];
require_once __DIR__ . '/includes/header.php';
?>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card card-custom">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Barang</h6>
                        <h3 class="mb-0">125</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 p-3 rounded">
                        <i class="fas fa-boxes text-primary fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card card-custom">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Permintaan Hari Ini</h6>
                        <h3 class="mb-0">8</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded">
                        <i class="fas fa-clipboard-list text-success fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card card-custom">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Barang Habis</h6>
                        <h3 class="mb-0">3</h3>
                    </div>
                    <div class="bg-danger bg-opacity-10 p-3 rounded">
                        <i class="fas fa-exclamation-triangle text-danger fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card card-custom">
            <div class="card-header card-header-custom">
                <h5 class="card-title mb-0 text-white">Aktivitas Terakhir</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Piring</td>
                                <td>12</td>
                                <td><span class="badge bg-success">Approved</span></td>
                                <td>2024-10-21</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Gelas</td>
                                <td>20</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td>2024-10-20</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Kopi</td>
                                <td>5</td>
                                <td><span class="badge bg-success">Approved</span></td>
                                <td>2024-10-19</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card card-custom">
            <div class="card-header card-header-custom">
                <h5 class="card-title mb-0 text-white">Stok Minimum</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Galon
                        <span class="badge bg-danger rounded-pill">2</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Teh
                        <span class="badge bg-warning rounded-pill">5</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Kopi
                        <span class="badge bg-warning rounded-pill">8</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>