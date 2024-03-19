<?php
include "connection.php";
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['nis_user'])) {
    header('location: login.html');
    exit;
}

// Ambil informasi pengguna dari database
$nisUser = $_SESSION['nis_user'];
$sql = "SELECT * FROM info_user WHERE nis_user = ?";
$stmt = mysqli_prepare($host, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $nisUser);
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            if ($userInfo = mysqli_fetch_assoc($result)) {
                // Mengambil gambar profil dari database
                $imageData = $userInfo['foto_profile'];
            } else {
                echo "Error: No data found.";
            }
        } else {
            echo "Error in fetching results: " . mysqli_error($host);
        }
    } else {
        echo "Error in executing statement: " . mysqli_error($host);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Error in preparing SQL statement: " . mysqli_error($host);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">PC Maintenance</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Pilih Ruangan
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="ruangan.php?id=401">Ruangan 401</a></li>
                            <li><a class="dropdown-item" href="ruangan.php?id=402">Ruangan 402</a></li>
                            <li><a class="dropdown-item" href="ruangan.php?id=403">Ruangan 403</a></li>
                            <li><a class="dropdown-item" href="ruangan.php?id=404">Ruangan 404</a></li>
                            <li><a class="dropdown-item" href="ruangan.php?id=405">Ruangan 405</a></li>
                            <li><a class="dropdown-item" href="ruangan.php?id=406">Ruangan 406</a></li>
                            <li><a class="dropdown-item" href="ruangan.php?id=407">Ruangan 407</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="profile.php">Profile</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-5">
        <h1>Profile</h1>
        <div>
            <?php if (!empty($imageData)) : ?>
                <img src="data:image/jpeg;base64,<?= base64_encode($imageData); ?>" class="card-img-top" alt="Profile Image" style="height: 400px; width: auto;">
            <?php else : ?>
                <p>Error: Gambar tidak ditemukan.</p>
            <?php endif; ?>
        </div>
        <div>
            <p>NIS: <?= $userInfo['nis_user']; ?></p>
            <p>Role: <?= $userInfo['role_user']; ?></p>
            <?php
                if (!empty($userInfo['nama_user'])) {
                    echo "<p>Nama: {$userInfo['nama_user']} </p>";
                } else {
                    echo "<p>Nama: Tidak Diketahui </p>";
                }
            ?>
            <p>Email: <?= $userInfo['email_user']; ?></p>
        </div>
        <a href="editInfoUser.php" class="btn btn-primary">Edit Profile</a>
    </main>

    <footer></footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
