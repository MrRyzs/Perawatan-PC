<?php
include "Connection.php";

if (isset($_GET['id'])) {
    $roomId = $_GET['id'];
    $sql = "SELECT * FROM pc_info WHERE no_ruangan = ?";
?>

<!<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruangan <?= $roomId ?></title>
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
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
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
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <button type="button" class="btn btn-outline-light me-2" onclick="window.location.href='tambahPc.php'">Tambah PC</button>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="infoUser.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php
                include "Connection.php";
                $sql = "SELECT * FROM pc_info where no_ruangan = " . $roomId;
                $show = mysqli_query($host, $sql);
                while ($e = mysqli_fetch_array($show)){
            ?>

            <div class="col">
                <div class="card h-100">  
                    <div class="card-header">
                        <b class="card-title" style="float:right; align-item:center; margin-top: 8px;">PC No. <?= $e['no_pc'] ?></b>

                        <div class="btn-group">
                            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="ubahSpesifikasi.php?id=<?= $e['no_pc'] ?>">Ubah Spesifikasi</a></li>
                                <li><a type="button" class="dropdown-item" onclick="hapusData('<?= $e['no_pc'] ?>')">Hapus Data</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a href="dataPerbaikan.php?id=<?= $roomId?>&&no=<?= $e['no_pc'] ?>" type="button" class="dropdown-item">Kartu Perawatan</a></li>
                                <li><span class="navbar-text"><a class="dropdown-item" href='laporKeluhan.php?no=<?= $e['no_pc'] ?>&&id=<?= $roomId ?>'">Lapor Keluhan</a></span></li>
                            </ul>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            Processor <?= $e['processor']?>
                        </li>
                        <li class="list-group-item">
                            Ram = <?= $e['ram']?> GB
                        </li>
                        <li class="list-group-item">
                            Disk = <?= $e['penyimpanan']?>
                        </li>
                        <li class="list-group-item">
                            Monitor = <?= $e['monitor']?>
                        </li>
                        <li class="list-group-item">
                            GPU = <?= $e['graphic']?>
                        </li>
                        <li class="list-group-item">
                            Mouse = <?= $e['mouse']?>
                        </li>
                        <li class="list-group-item">
                            Keyboard = <?= $e['keyboard']?>
                        </li>
                    </ul>
                </div>
            </div>
            <?php
                }
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script>
        // Fungsi untuk menghapus data PC
        function hapusData(noPc) {
            var confirmation = confirm("Apakah Anda yakin ingin menghapus data PC No. " + noPc + "?");

            if (confirmation) {
                // Redirect ke halaman untuk menghapus data
                window.location.href = "hapusData.php?id=" + noPc;
            }
        }
    </script>
</body>
</html>