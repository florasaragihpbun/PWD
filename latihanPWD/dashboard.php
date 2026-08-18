<?php

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Dashboard</title>

    <link
        rel="stylesheet"
        href="css/style.css"
    >

</head>

<body>

<h1>Dashboard</h1>

<p>
    Selamat datang,
    <?= htmlspecialchars($_SESSION['username']) ?>
</p>

<a href="mahasiswa/index.php">
    Data Mahasiswa
</a>

<a href="logout.php">
    Logout
</a>

</body>

</html>