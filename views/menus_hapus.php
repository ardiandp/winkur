<?php
 $conn = new mysqli("localhost", "dev", "terserah", "winkur");
$id = intval($_GET['id']);
$conn->query("DELETE FROM menus WHERE id = $id");
header("Location: ?page=views/menus.php");
exit();
