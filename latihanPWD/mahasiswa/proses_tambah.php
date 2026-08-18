<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

$nim = $_POST['nim'];
$nama = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$email = $_POST['email'];
$id_jurusan = $_POST['id_jurusan'];

if (
    empty($nim) ||
    empty($nama) ||
    empty($id_jurusan)
) {

    die("Data tidak lengkap.");

}

$sql = "
    INSERT INTO mahasiswa
    (
        nim,
        nama,
        jenis_kelamin,
        email,
        id_jurusan
    )
    VALUES (?, ?, ?, ?, ?)
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ssssi",
    $nim,
    $nama,
    $jenis_kelamin,
    $email,
    $id_jurusan
);

mysqli_stmt_execute($stmt);

header("Location: index.php");

exit;

?>