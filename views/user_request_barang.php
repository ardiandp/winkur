<?php
// Koneksi database
$conn = new mysqli("localhost", "dev", "terserah", "winkur");

// Proses tambah request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_request'])) {
    $divisi_id = intval($_SESSION['divisi_id']);
    $barang_id = intval($_POST['barang_id']);
    $jumlah = intval($_POST['jumlah']);
    $status = 'Pending'; // Status default
    if ($divisi_id > 0 && $barang_id > 0 && $jumlah > 0) {
        $query = "INSERT INTO request_barang (divisi_id, barang_id, jumlah, status) 
                 VALUES ($divisi_id, $barang_id, $jumlah, '$status')";
        if ($conn->query($query) === TRUE) {
           // echo "<script>alert('Data berhasil disimpan!');</script>";
        } else {
            echo "<script>alert('Gagal menyimpan data: " . $conn->error . "');</script>";
        }
    }
   // header("Location: request_barang.php");
    echo "<script>  
        alert('Data berhasil disimpan!');
        window.location.href = '?page=views/user_request_barang.php';
    </script>";
    exit();
}

// Proses update status
if (isset($_GET['update_status'])) {
    $id = intval($_GET['id']);
    $new_status = $conn->real_escape_string($_GET['status']);
    
    $allowed_status = ['Pending', 'Disetujui', 'Ditolak', 'Diproses', 'Selesai'];
    if (in_array($new_status, $allowed_status)) {
        $conn->query("UPDATE request_barang SET status = '$new_status' WHERE id = $id");
    }
     // header("Location: request_barang.php");
    echo "<script>  
        alert('Data berhasil disimpan!');
        window.location.href = '?page=views/user_request_barang.php';
    </script>";
    exit();
}

// Ambil data request barang dengan join ke tabel divisi dan barang
$query = "SELECT rb.*, d.nama_divisi, b.nama_barang, b.satuan 
          FROM request_barang rb
          JOIN divisi d ON rb.divisi_id = d.id
          JOIN barang b ON rb.barang_id = b.id
          ORDER BY rb.created_at DESC";
$result = $conn->query($query);

// Ambil data divisi untuk dropdown
$divisi = $conn->query("SELECT * FROM divisi ORDER BY nama_divisi");

// Ambil data barang untuk dropdown
$barang = $conn->query("SELECT * FROM barang ORDER BY nama_barang");
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Request Barang</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Request Barang</h6>
        </div>
        <div class="card-body">
            <!-- Form Tambah Request -->
            <form method="POST" class="mb-4" action="">
                <div class="form-row">
                    <div class="col-md-3">
                        <select name="divisi_id" class="form-control" required disabled>
                            <?php
                            $user_id = $_SESSION['user_id'];
                            $query = "SELECT d.nama_divisi 
                                      FROM users u 
                                      JOIN divisi d ON u.divisi_id = d.id 
                                      WHERE u.id = $user_id";
                            $result = $conn->query($query);
                            if ($result && $row = $result->fetch_assoc()): ?>
                                <option value="<?= $_SESSION['divisi_id'] ?>"> <?= htmlspecialchars($row['nama_divisi']) ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="barang_id" class="form-control" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php while ($b = $barang->fetch_assoc()): ?>
                            <option value="<?= $b['id'] ?>" data-satuan="<?= htmlspecialchars($b['satuan']) ?>">
                                <?= htmlspecialchars($b['nama_barang']) ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="jumlah" class="form-control" placeholder="Jumlah" min="1" required>
                        <small id="satuanText" class="form-text text-muted"></small>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" name="tambah_request" class="btn btn-primary btn-block">
                            <i class="fas fa-plus"></i> Request
                        </button>
                    </div>
                </div>
            </form>

            <!-- Tabel Daftar Request -->
                                
<table class="table table-bordered" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th width="5%">ID</th>
            <th>Divisi</th>
            <th>Barang</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Tanggal Request</th>
            <th width="15%">Aksi</th>
        </tr>
    </thead>
    <tbody>
       
    <?php  $request_barang = $conn->query("SELECT rb.*, d.nama_divisi, b.nama_barang, b.satuan 
          FROM request_barang rb
          JOIN divisi d ON rb.divisi_id = d.id
          JOIN barang b ON rb.barang_id = b.id
          WHERE rb.divisi_id = " . $_SESSION['divisi_id'] . "
          ORDER BY rb.created_at DESC");
    while ($row = $request_barang->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['nama_divisi']) ?></td>
            <td><?= htmlspecialchars($row['nama_barang']) ?></td>
            <td><?= number_format($row['jumlah'], 0, ',', '.') ?> <?= htmlspecialchars($row['satuan']) ?></td>
            <td>
                <span class="badge badge-<?= 
                    $row['status'] == 'Disetujui' ? 'success' : 
                    ($row['status'] == 'Ditolak' ? 'danger' : 
                    ($row['status'] == 'Selesai' ? 'primary' : 'warning')) ?>">
                    <?= $row['status'] ?>
                </span>
            </td>
            <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
            <td><a href="hapus_request.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a></td>
        </tr>
      <?php endwhile; ?>
      
    </tbody>
</table>


        </div>
    </div>
</div>

<script>
// Menampilkan satuan barang yang dipilih
$(document).ready(function() {
    $('select[name="barang_id"]').change(function() {
        var satuan = $(this).find('option:selected').data('satuan');
        $('#satuanText').text('Satuan: ' + satuan);
    });
});
</script>

<?php $conn->close(); ?>