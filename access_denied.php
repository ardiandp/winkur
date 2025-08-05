<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <h1 class="text-danger"><i class="fas fa-ban"></i> 403</h1>
                        <h3>Akses Ditolak</h3>
                        <p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>
                        <a href="main.php?page=views/dashboard.php" class="btn btn-primary">
                            <i class="fas fa-home"></i> Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>