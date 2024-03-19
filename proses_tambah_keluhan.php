<?php
include "Connection.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nis_user = $_SESSION['nis_user']; // Mengambil nis_user dari sesi
    $id = $_POST['id'];
    $no_pc = $_POST['no_pc'];
    $tanggal_keluhan = $_POST['tanggal_keluhan'];
    $permasalahan = $_POST['permasalahan'];
    $pergantian = $_POST['pergantian'];
    $paraf = $_POST['paraf'];

    // Query untuk menambahkan data keluhan ke dalam tabel info_keluhan
    $sql = "INSERT INTO info_keluhan (nis_user, no_pc, tanggal_keluhan, permasalahan, pergantian, paraf) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($host, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $nis_user, $no_pc, $tanggal_keluhan, $permasalahan, $pergantian, $paraf);
    
    // Eksekusi statement
    if (mysqli_stmt_execute($stmt)) {
        // Redirect ke halaman sebelumnya setelah berhasil menambahkan data
        header("Location: dataPerbaikan.php?id=$idRuangan&no=$no_pc");
        exit();
    } else {
        echo "Terjadi kesalahan. Silakan coba lagi.";
    }

    // Tutup statement
    mysqli_stmt_close($stmt);
}

// Tutup koneksi
mysqli_close($host);