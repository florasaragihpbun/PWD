<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

$jurusan = mysqli_query(
    $conn,
    "SELECT * FROM jurusan"
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Tambah Mahasiswa</title>

    <link
        rel="stylesheet"
        href="../css/style.css"
    >

</head>

<body>

<h1>Tambah Mahasiswa</h1>

<form
    action="proses_tambah.php"
    method="POST"
    id="mahasiswaForm"
>

    <label>NIM</label>

    <input
        type="text"
        name="nim"
        id="nim"
    >

    <label>Nama</label>

    <input
        type="text"
        name="nama"
        id="nama"
    >

    <label>Jenis Kelamin</label>

    <input
        type="radio"
        name="jenis_kelamin"
        value="L"
    >
    Laki-laki

    <input
        type="radio"
        name="jenis_kelamin"
        value="P"
    >
    Perempuan

    <label>Email</label>

    <input
        type="email"
        name="email"
        id="email"
    >

    <label>Jurusan</label>

    <select
        name="id_jurusan"
        id="id_jurusan"
    >

        <option value="">
            -- Pilih Jurusan --
        </option>

        <?php while ($row = mysqli_fetch_assoc($jurusan)): ?>

            <option value="<?= $row['id'] ?>">

                <?= htmlspecialchars($row['nama_jurusan']) ?>

            </option>

        <?php endwhile; ?>

    </select>

    <button type="submit">
        Simpan
    </button>

</form>

<script src="../js/script.js"></script>

</body>

</html>