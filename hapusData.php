<?php
include "Connection.php";

// Pastikan ada parameter 'id' yang dikirimkan melalui GET
if (isset($_GET['id'])) {
    $noPc = $_GET['id'];

    // Query SQL untuk menghapus data PC
    $sql = "DELETE FROM pc_info WHERE no_pc = ?";
    $stmt = mysqli_prepare($host, $sql);

    if ($stmt) {
        // Bind parameter ke query
        mysqli_stmt_bind_param($stmt, "s", $noPc);

        // Eksekusi query
        $success = mysqli_stmt_execute($stmt);

        // Periksa hasil eksekusi
        if ($success) {
            echo "Data PC dengan No. PC $noPc berhasil dihapus.";
        } else {
            echo "Gagal menghapus data PC: " . mysqli_error($host);
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error in preparing SQL statement: " . mysqli_error($host);
    }
}