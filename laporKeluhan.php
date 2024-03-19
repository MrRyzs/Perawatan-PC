<?php
if (isset($_POST['submit'])) {
    // Pastikan data yang dikirim tidak kosong
    if (!empty($_POST['permasalahan'])) {
        // Dapatkan data dari formulir
        $tanggal_keluhan = $_POST['tanggal_keluhan'];
        $permasalahan = htmlspecialchars($_POST['permasalahan']); // Pastikan data yang dikirim aman dari injeksi XSS
        $pergantian = htmlspecialchars($_POST['pergantian']); // Pastikan data yang dikirim aman dari injeksi XSS
        $paraf = $_POST['paraf'];
        
        // Selanjutnya, lakukan operasi penyimpanan ke database atau sesuai kebutuhan aplikasi Anda
    } else {
        echo "Permasalahan tidak boleh kosong.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Keluhan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 500px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah Data Keluhan</h2>
        <form action="proses_tambah_keluhan.php" method="POST">
            <div class="mb-3">
                <label for="tanggal_keluhan" class="form-label">Tanggal Keluhan</label>
                <input type="date" class="form-control" id="tanggal_keluhan" name="tanggal_keluhan" required>
            </div>
            <div class="mb-3">
                <label for="permasalahan" class="form-label">Permasalahan</label>
                <textarea class="form-control" id="permasalahan" name="permasalahan" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="pergantian" class="form-label">Pergantian Sparepart</label>
                <input type="text" class="form-control" id="pergantian" name="pergantian">
            </div>
            <div class="mb-3">
                <label for="paraf" class="form-label">Paraf</label>
                <input type="text" class="form-control" id="paraf" name="paraf">
            </div>
            <input type="hidden" name="no_pc" value="<?php echo htmlspecialchars($_GET['no']); ?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
