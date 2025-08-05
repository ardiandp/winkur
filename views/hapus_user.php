<?php
// Koneksi ke database
$conn = new mysqli("localhost", "dev", "terserah", "winkur");

// Proses hapus user
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM users WHERE id = $id";
    if ($conn->query($query) === TRUE) {
        echo "<script>
            alert('User berhasil dihapus!');
            window.history.back();
            window.location.reload();
        </script>";
    } else {
        echo "<script>alert('Gagal menghapus user: " . $conn->error . "');</script>";
    }
    $conn->close();
}
?>

