<?php
include "Connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nis_user = $_POST["nis_user"];
    $email_user = $_POST["email_user"];
    $password_user = $_POST["password_user"]; // Password yang dimasukkan oleh pengguna

    // Hash password sebelum menyimpan ke database
    $hashedPassword = password_hash($password_user, PASSWORD_DEFAULT);

    // Simpan data pengguna ke database
    $query = "INSERT INTO info_user (nis_user, email_user, password_user, role_user) VALUES (?, ?, ?, 'user')";
    $stmt = mysqli_prepare($host, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sss", $nis_user, $email_user, $hashedPassword);
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Gagal menyimpan data pengguna.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $error = "Error dalam persiapan statement SQL.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Register</h1>
        <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
        <form action="" method="post">
            <div class="mb-3">
                <label for="nis_user" class="form-label">NIS User:</label>
                <input type="text" class="form-control" id="nis_user" name="nis_user" required>
            </div>

            <div class="mb-3">
                <label for="email_user" class="form-label">Email User:</label>
                <input type="email" class="form-control" id="email_user" name="email_user" required>
            </div>

            <div class="mb-3">
                <label for="password_user" class="form-label">Password User:</label>
                <input type="password" class="form-control" id="password_user" name="password_user" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

    