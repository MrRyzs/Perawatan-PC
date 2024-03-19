<?php
include "Connection.php";

session_start(); // Mulai sesi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirimkan dari form
    $nisOrEmail = $_POST["nis_user"];
    $password = $_POST["password_user"];

    // Query untuk mendapatkan informasi pengguna berdasarkan NIS atau Email
    $query = "SELECT * FROM info_user WHERE nis_user = ? OR email_user = ?";
    $stmt = mysqli_prepare($host, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $nisOrEmail, $nisOrEmail);
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            $result = mysqli_stmt_get_result($stmt);

            if ($result) {
                if ($row = mysqli_fetch_assoc($result)) {
                    // Ambil hashed password dari database
                    $hashedPasswordFromDatabase = $row['password_user'];

                    // Verifikasi password
                    if (password_verify($password, $hashedPasswordFromDatabase)) {
                        // Password cocok, atur sesi dan lakukan tindakan setelah login
                        $_SESSION["nis_user"] = $row["nis_user"];
                        $_SESSION["role_user"] = $row["role_user"];

                        // Redirect ke halaman setelah login
                        header("location: index.php");
                        exit;
                    } else {
                        $error = "Invalid password";
                    }
                } else {
                    $error = "User not found";
                }
            } else {
                $error = "Error in fetching results: " . mysqli_error($host);
            }
        } else {
            $error = "Error in executing statement: " . mysqli_error($host);
        }

        mysqli_stmt_close($stmt);
    } else {
        $error = "Error in preparing SQL statement: " . mysqli_error($host);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="border p-4">
                    <h1 class="text-center mb-4">Login</h1>

                    <?php
                    if (isset($error)) {
                        echo "<div class='alert alert-danger' role='alert'>$error</div>";
                    }
                    ?>

                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="nis_user" class="form-label">NIS or Email:</label>
                            <input type="text" class="form-control" id="nis_user" name="nis_user" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_user" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password_user" name="password_user" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
