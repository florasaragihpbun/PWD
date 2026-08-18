<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

$id = $_GET['id'];

$sql = "
    SELECT *
    FROM mahasiswa
    WHERE id = ?
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$data = mysqli_fetch_assoc($result);

$jurusan = mysqli_query(
    $conn,
    "SELECT * FROM jurusan"
);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Mahasiswa</title>

    <link
        rel="stylesheet"
        href="../css/style.css"
    >

</head>

<body>

<h1>Edit Mahasiswa</h1>

<form
    action="proses_edit.php"
    method="POST"
>

    <input
        type="hidden"
        name="id"
        value="<?= $data['id'] ?>"
    >

    <label>NIM</label>

    <input
        type="text"
        name="nim"
        value="<?= htmlspecialchars($data['nim']) ?>"
    >

    <label>Nama</label>

    <input
        type="text"
        name="nama"
        value="<?= htmlspecialchars($data['nama']) ?>"
    >

    <label>Email</label>

    <input
        type="email"
        name="email"
        value="<?= htmlspecialchars($data['email']) ?>"
    >

    <label>Jurusan</label>

    <select name="id_jurusan">

        <?php while ($row = mysqli_fetch_assoc($jurusan)): ?>

            <option
                value="<?= $row['id'] ?>"
                <?= $row['id'] == $data['id_jurusan']
                    ? 'selected'
                    : '' ?>
            >

                <?= htmlspecialchars($row['nama_jurusan']) ?>

            </option>

        <?php endwhile; ?>

    </select>

    <button type="submit">
        Update
    </button>

</form>

</body>

</html>