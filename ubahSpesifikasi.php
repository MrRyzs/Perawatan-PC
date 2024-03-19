<?php
include "Connection.php";

if (isset($_GET['id'])) {
    $noPc = $_GET['id'];

    // Fetch PC details from the database using the ID
    $sql = "SELECT * FROM pc_info WHERE no_pc = ?";
    $stmt = mysqli_prepare($host, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $noPc);
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            $result = mysqli_stmt_get_result($stmt);

            if ($result) {
                if ($row = mysqli_fetch_assoc($result)) {
                    // Fetch PC details from the result set
                    $no_ruangan = $row['no_ruangan'];
                    $processor = $row['processor'];
                    $ram = $row['ram'];
                    $disk = $row['penyimpanan'];
                    $monitor = $row['monitor'];
                    $graphic = $row['graphic'];
                    $mouse = $row['mouse'];
                    $keyboard = $row['keyboard'];

                    if (isset($_POST['submit'])) {
                        // Update PC details based on the form input
                        $no_ruangan = $_POST["no_ruangan"];
                        $processor = $_POST["processor"];
                        $ram = $_POST["ram"];
                        $disk = $_POST["disk"];
                        $monitor = $_POST["monitor"];
                        $graphic = $_POST["graphic"];
                        $mouse = $_POST["mouse"];
                        $keyboard = $_POST["keyboard"];

                        $update = mysqli_prepare($host, "UPDATE pc_info SET no_ruangan=?, processor=?, ram=?, penyimpanan=?, monitor=?, graphic=?, mouse=?, keyboard=? WHERE no_pc=?");
                        
                        // Bind the parameters
                        mysqli_stmt_bind_param($update, "sssssssss", $no_ruangan, $processor, $ram, $disk, $monitor, $graphic, $mouse, $keyboard, $noPc);

                        if ($update && mysqli_stmt_execute($update)) {
                            header('location: index.php');
                            exit;
                        } else {
                            echo 'Gagal: ' . mysqli_error($host);
                        }
                    }
                } else {
                    echo "Debugging: No rows found for PC No: \"$noPc\"";
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit PC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Ubah Spesifikasi PC No. <?= $noPc ?></h1>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="no_pc" value="<?= $noPc ?>">
            
            <div class="mb-3">
                <label for="no_ruangan" class="form-label">No. Ruangan:</label>
                <input type="text" name="no_ruangan" class="form-control" value="<?= $no_ruangan ?>" required>
            </div>
            <div class="mb-3">
                <label for="processor" class="form-label">Processor:</label>
                <input type="text" name="processor" class="form-control" value="<?= $processor ?>" required>
            </div>
            <div class="mb-3">
                <label for="ram" class="form-label">RAM:</label>
                <input type="text" name="ram" class="form-control" value="<?= $ram ?>" required>
            </div>
            <div class="mb-3">
                <label for="disk" class="form-label">Disk:</label>
                <input type="text" name="disk" class="form-control" value="<?= $disk ?>" required>
            </div>
            <div class="mb-3">
                <label for="monitor" class="form-label">Monitor:</label>
                <input type="text" name="monitor" class="form-control" value="<?= $monitor ?>" required>
            </div>
            <div class="mb-3">
                <label for="graphic" class="form-label">Graphic:</label>
                <input type="text" name="graphic" class="form-control" value="<?= $graphic ?>" required>
            </div>
            <div class="mb-3">
                <label for="mouse" class="form-label">Mouse:</label>
                <input type="text" name="mouse" class="form-control" value="<?= $mouse ?>" required>
            </div>
            <div class="mb-3">
                <label for="keyboard" class="form-label">Keyboard:</label>
                <input type="text" name="keyboard" class="form-control" value="<?= $keyboard ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Update PC</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
