<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

$id = $_GET['id'];

$sql = "
    DELETE FROM mahasiswa
    WHERE id = ?
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

header("Location: index.php");

exit;

?>