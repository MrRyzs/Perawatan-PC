<?php
    include 'connection.php';

    // Mengambil jumlah data PC
    $query_count = 'SELECT COUNT(no_pc) AS total_pc FROM pc_info';
    $result_count = mysqli_query($host, $query_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $next_no_pc = $row_count['total_pc'] + 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah PC</title>
    <!-- Bootstrap CSS -->
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
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="infoUser.php">Profile</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<div class="container mt-5">
    <form action="tambahProcess.php" method="post">
        <div class="mb-3">
            <label for="no_pc" class="form-label">No. PC</label>
            <input type="text" class="form-control" id="no_pc" name="no_pc" placeholder="<?= $next_no_pc ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="no_ruangan" class="form-label">No. Ruangan</label>
            <select class="form-select" id="no_ruangan" name="no_ruangan" required>
                <option disabled selected>Pilih Ruangan</option>
                <optgroup label="Lab Lantai 4">
                    <option value="401">Ruang 401</option>
                    <option value="402">Ruang 402</option>
                    <option value="403">Ruang 403</option>
                    <option value="404">Ruang 404</option>
                    <option value="405">Ruang 405</option>
                    <option value="406">Ruang 406</option>
                    <option value="407">Ruang 407</option>
                </optgroup>
            </select>
        </div>
        <div class="mb-3">
            <label for="processor" class="form-label">Processor</label>
            <input type="text" class="form-control" id="processor" name="processor" required>
        </div>
        <div class="mb-3">
            <label for="ram" class="form-label">RAM</label>
            <input type="text" class="form-control" id="ram" name="ram" required>
        </div>
        <div class="mb-3">
            <label for="disk" class="form-label">Disk</label>
            <input type="text" class="form-control" id="disk" name="disk" required>
        </div>
        <div class="mb-3">
            <label for="monitor" class="form-label">Monitor</label>
            <input type="text" class="form-control" id="monitor" name="monitor" required>
        </div>
        <div class="mb-3">
            <label for="graphic" class="form-label">GPU</label>
            <input type="text" class="form-control" id="graphic" name="graphic" required>
        </div>
        <div class="mb-3">
            <label for="mouse" class="form-label">Mouse</label>
            <input type="text" class="form-control" id="mouse" name="mouse" required>
        </div>
        <div class="mb-3">
            <label for="keyboard" class="form-label">Keyboard</label>
            <input type="text" class="form-control" id="keyboard" name="keyboard" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5+UO4ZoUpBn4EtWUGbhLylz2QrMBNOXktxDlO5lB" crossorigin="anonymous"></script>
</body>
</html>
