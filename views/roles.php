<?php
// Proses tambah role
  $conn = new mysqli("localhost", "dev", "terserah", "winkur");
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_role'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description'] ?? '');

    if (!empty($name)) {
        $query = "INSERT INTO roles (name, description) VALUES ('$name', '$description')";
        $conn->query($query);
    }
    header("Location: roles.php");
    exit();
}

// Ambil data roles
$query = "SELECT * FROM roles ORDER BY id DESC";
$result = $conn->query($query);
?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Roles</h1>
      
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Roles</h6>
        </div>
        <div class="card-body">
                <!-- Form Tambah Role -->
                <form method="POST" class="mb-4">
                    <div class="form-row">
                        <div class="col-md-4">
                            <input type="text" name="name" class="form-control" placeholder="Nama Role" required>
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="description" class="form-control" placeholder="Deskripsi">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="tambah_role" class="btn btn-primary btn-block">
                                Tambah Role
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Tabel Daftar Role -->
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%">ID</th>
                            <th>Nama Role</th>
                            <th>Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>