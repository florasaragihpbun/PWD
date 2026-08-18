<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit;
}

include "../config/koneksi.php";

$sql = "
    SELECT
        mahasiswa.id,
        mahasiswa.nim,
        mahasiswa.nama,
        mahasiswa.jenis_kelamin,
        mahasiswa.email,
        jurusan.nama_jurusan

    FROM mahasiswa

    JOIN jurusan
        ON mahasiswa.id_jurusan = jurusan.id

    ORDER BY mahasiswa.id DESC
";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Data Mahasiswa</title>

    <link
        rel="stylesheet"
        href="../css/style.css"
    >

</head>

<body>

<h1>Data Mahasiswa</h1>

<a href="tambah.php">
    + Tambah Mahasiswa
</a>

<table border="1">

    <thead>

        <tr>

            <th>No</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Email</th>
            <th>Jurusan</th>
            <th>Aksi</th>

        </tr>

    </thead>

    <tbody>

    <?php

    $no = 1;

    while ($row = mysqli_fetch_assoc($result)):

    ?>

        <tr>

            <td><?= $no++ ?></td>

            <td>
                <?= htmlspecialchars($row['nim']) ?>
            </td>

            <td>
                <?= htmlspecialchars($row['nama']) ?>
            </td>

            <td>
                <?= htmlspecialchars($row['jenis_kelamin']) ?>
            </td>

            <td>
                <?= htmlspecialchars($row['email']) ?>
            </td>

            <td>
                <?= htmlspecialchars($row['nama_jurusan']) ?>
            </td>

            <td>

                <a href="edit.php?id=<?= $row['id'] ?>">
                    Edit
                </a>

                |

                <a
                    href="hapus.php?id=<?= $row['id'] ?>"
                    onclick="return confirm('Yakin ingin menghapus?')"
                >
                    Hapus
                </a>

            </td>

        </tr>

    <?php endwhile; ?>

    </tbody>

</table>

</body>

</html>