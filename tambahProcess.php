<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $query_count = 'SELECT COUNT(no_pc) AS total_pc FROM pc_info';
    $result_count = mysqli_query($host, $query_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $next_no_pc = $row_count['total_pc'] + 1;
    
    $no_ruangan = $_POST["no_ruangan"];
    $processor = $_POST["processor"];
    $ram = $_POST["ram"];
    $disk = $_POST["disk"];
    $monitor = $_POST["monitor"];
    $graphic = $_POST["graphic"];
    $mouse = $_POST["mouse"];
    $keyboard = $_POST["keyboard"];

    // Tambahkan data ke database
    $query_insert = "INSERT INTO pc_info (no_pc, no_ruangan, processor, ram, penyimpanan, monitor, graphic, mouse, keyboard) 
                     VALUES ('$next_no_pc', '$no_ruangan', '$processor', '$ram', '$disk', '$monitor', '$graphic', '$mouse', '$keyboard')";

    $result_insert = mysqli_query($host, $query_insert);

    if ($result_insert) {
        // Redirect ke index.php
        header("Location: index.php");
        exit(); // Penting: pastikan untuk keluar setelah header("Location") agar script berhenti di sini
    } else {
        echo "Error: " . mysqli_error($host);
    }
}