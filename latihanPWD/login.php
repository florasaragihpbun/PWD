<?php
session_start();

include "config/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $username
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if ($password == $user['password']) {

            $_SESSION['username'] = $user['username'];

            header("Location: dashboard.php");
            exit;

        } else {

            $error = "Password salah";

        }

    } else {

        $error = "Username tidak ditemukan";

    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - Aplikasi Mahasiswa</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="login-container">

    <h1>Login</h1>

    <form action="login.php" method="POST" id="loginForm">

        <label>Username</label>

        <input
            type="text"
            name="username"
            id="username"
        >

        <label>Password</label>

        <input
            type="password"
            name="password"
            id="password"
        >

        <button type="submit">
            Login
        </button>

    </form>

</div>

<script src="js/script.js"></script>

</body>
</html>