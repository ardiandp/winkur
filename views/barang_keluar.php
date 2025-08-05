<?php


// Koneksi database
$conn = new mysqli("localhost", "dev", "terserah", "winkur");

// Query untuk mendapatkan data barang keluar dengan join ke tabel barang dan divisi
$query = "SELECT 
            bk.id,
            b.nama_barang,
            d.nama_divisi,
            bk.jumlah,
            b.satuan,
            bk.tanggal_keluar
          FROM barang_keluar bk
          JOIN barang b ON bk.barang_id = b.id
          JOIN divisi d ON bk.divisi_id = d.id
          ORDER BY bk.tanggal_keluar DESC";

$result = $conn->query($query);
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Barang Keluar</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Barang Keluar</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Keluar</th>
                            <th>Nama Barang</th>
                            <th>Divisi</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while ($row = $result->fetch_assoc()): 
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d/m/Y', strtotime($row['tanggal_keluar'])) ?></td>
                            <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                            <td><?= htmlspecialchars($row['nama_divisi']) ?></td>
                            <td class="text-right"><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($row['satuan']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

<!-- DataTables JavaScript -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Indonesian.json'
        },
        columnDefs: [
            { "orderable": false, "targets": [0] } // Nonaktifkan sorting untuk kolom No
        ],
        order: [[1, 'desc']] // Urutkan berdasarkan tanggal descending
    });
});
</script>

<?php $conn->close(); ?>