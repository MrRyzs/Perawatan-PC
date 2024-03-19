<?php
include "Connection.php";

if (isset($_GET['id']) && isset($_GET['no'])) {
    $idRuangan = $_GET['id'];
    $noPc = $_GET['no'];
    $sql = "SELECT * FROM pc_info WHERE no_pc = ?";
    $stmt = mysqli_prepare($host, $sql);
    mysqli_stmt_bind_param($stmt, "s", $noPc);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $pcInfo = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Perawatan Personal Computer (PC)</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS untuk tabel */
        table {
            border-collapse: collapse;
            width: 100%;
            border: 2px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .center{
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Kartu Perawatan PC</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <!-- Tombol Download -->
                    <li class="nav-item">
                        <button id="downloadButton" class="btn btn-primary">Download PDF</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <table id="dataTable" class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th colspan="6">KARTU PERAWATAN PERSONAL COMPUTER (PC)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">NO PC</td>
                    <td colspan="4">: <?= $noPc ?></td>
                </tr>
                <tr>
                    <td colspan="2">RUANG LAB</td>
                    <td colspan="4">: <?= $idRuangan ?></td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="8">SPESIFIKASI PC</td>
                    <td colspan="4">:</td>
                </tr>
                <!-- Detail spesifikasi PC -->
                <tr>
                    <td>Processor</td>
                    <td colspan="3">: <?= $pcInfo['processor'] ?></td>
                </tr>
                <tr>
                    <td>Ram</td>
                    <td colspan="3">: <?= $pcInfo['ram'] ?> GB</td>
                </tr>
                <tr>
                    <td>Disk</td>
                    <td colspan="3">: <?= $pcInfo['penyimpanan'] ?></td>
                </tr>
                <tr>
                    <td>Monitor</td>
                    <td colspan="3">: <?= $pcInfo['monitor'] ?></td>
                </tr>
                <tr>
                    <td>Graphic</td>
                    <td colspan="3">: <?= $pcInfo['graphic'] ?></td>
                </tr>
                <tr>
                    <td>Mouse</td>
                    <td colspan="3">: <?= $pcInfo['mouse'] ?></td>
                </tr>
                <tr>
                    <td>Keyboard</td>
                    <td colspan="3">: <?= $pcInfo['keyboard'] ?></td>
                </tr>
                <tr>
                    <th class="center">NO</th>
                    <th class="center">TANGGAL</th>
                    <th class="center" colspan="2">SERVIS/PERBAIKAN</th>
                    <th class="center">PERGANTIAN SPAREPART</th>
                    <th class="center">PARAF</th>
                </tr>
                <!-- Data keluhan dan perbaikan -->
                <?php
                    $sql = "SELECT * FROM info_keluhan where no_pc = " . $noPc;
                    $show = mysqli_query($host, $sql);
                    $no = 0;
                    while ($e = mysqli_fetch_array($show)){
                ?>
                <tr>
                    <td class="center"><?= $no + 1 ?></td>
                    <td class="center"><?= $e['tanggal_keluhan'] ?></td>
                    <td class="center" colspan="2"><?= $e['permasalahan'] ?></td>
                    <td class="center"><?= $e['pergantian'] ?></td>
                    <td class="center"><?= $e['paraf'] ?></td>
                </tr>
                <?php
                        $no++;
                    }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.0/html2pdf.bundle.min.js"></script>
    <script>
        // Fungsi untuk mendapatkan konten tabel
        function getTableContent() {
            return document.getElementById('dataTable').outerHTML;
        }

        // Fungsi untuk membuat dan mengunduh PDF
        function createAndDownloadPDF() {
            var element = document.getElementById('dataTable');
            var opt = {
                margin:       1,
                filename:     'kartu_perawatan_pc_no_<?= $noPc ?>.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            // Menggunakan html2pdf untuk membuat dan mengunduh PDF
            html2pdf().from(element).set(opt).save();
        }

        // Event listener untuk tombol download
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("downloadButton").addEventListener("click", function() {
                createAndDownloadPDF();
            });
        });
    </script>
</body>
</html>
<?php } ?>
