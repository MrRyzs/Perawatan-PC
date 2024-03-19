<?php
include "connection.php";
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nis_user'])) {
    // Redirect to the login page if not logged in
    header('location: login.php');
    exit;
}

// Fetch the user's name from the database
$nis_user = $_SESSION['nis_user'];
$query = "SELECT nama_user FROM info_user WHERE nis_user = ?";
$stmt = mysqli_prepare($host, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $nis_user);
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            if ($row) {
                $nama_user = $row['nama_user'];
            } else {
                // Handle the case where user data is not found
                $nama_user = "User";
            }
        } else {
            // Handle the case where fetching result fails
            $nama_user = "User";
        }
    } else {
        // Handle the case where executing statement fails
        $nama_user = "User";
    }

    mysqli_stmt_close($stmt);
} else {
    // Handle the case where preparing SQL statement fails
    $nama_user = "User";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Perawatan PC</title>
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
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="infoUser.php">Profile</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <button type="button" class="btn btn-outline-light me-2" onclick="window.location.href='tambahPc.php'">Tambah PC</button>
                </span>
                <span class="navbar-text">
                    <button type="button" class="btn btn-outline-light me-2" onclick="window.location.href='logout.php'">Logout</button>
                </span>
            </div>
        </div>
    </nav>

    <main class="container mt-5">
        <?php 
            if($nama_user == null){
                echo "<h1>Welcome, User</h1>";
            } else {
                echo "<h1>Welcome, $nama_user</h1>";
            }
        ?>

        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php
                $sql = "SELECT no_ruangan, COUNT(no_pc) as jml_pc FROM pc_info GROUP BY no_ruangan";
                $show = mysqli_query($host, $sql);
                while ($e = mysqli_fetch_array($show)){
            ?>
            <div class="col">
                <div class="card h-100">  
                    <div class="card-body">
                        <h5 class="card-title">Ruang <?= $e['no_ruangan'] ?></h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Jumlah PC : <?= $e['jml_pc'] ?></li>
                    </ul>
                    <div class="card-body">
                        <a href="ruangan.php?id=<?= $e['no_ruangan'] ?>" class="btn btn-info">Ruangan</a>
                    </div>
                </div>
            </div>
            <?php
                }
            ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>