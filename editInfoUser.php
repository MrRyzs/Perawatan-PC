<?php
include "connection.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION['nis_user'])) {
    header('location: login.html');
    exit;
}

// Fetch user information from the database
$nisUser = $_SESSION['nis_user'];
$sql = "SELECT * FROM info_user WHERE nis_user = ?";
$stmt = mysqli_prepare($host, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $nisUser);
    $success = mysqli_stmt_execute($stmt);

    if ($success) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $userInfo = mysqli_fetch_assoc($result);
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

// Handle form submission for updating profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaUser = $_POST["nama_user"];
    $emailUser = $_POST["email_user"];

    // Handle updating password if provided
    $passwordUser = $_POST["password_user"];
    if (!empty($passwordUser)) {
        // Hash the password
        $hashedPassword = password_hash($passwordUser, PASSWORD_DEFAULT);

        // Update password in the database
        $updatePasswordSql = "UPDATE info_user SET password_user = ? WHERE nis_user = ?";
        $updatePasswordStmt = mysqli_prepare($host, $updatePasswordSql);

        if ($updatePasswordStmt) {
            mysqli_stmt_bind_param($updatePasswordStmt, "ss", $hashedPassword, $nisUser);
            $updatePasswordSuccess = mysqli_stmt_execute($updatePasswordStmt);

            if (!$updatePasswordSuccess) {
                echo "Error updating password: " . mysqli_error($host);
            }

            mysqli_stmt_close($updatePasswordStmt);
        } else {
            echo "Error in preparing SQL statement for password update: " . mysqli_error($host);
        }
    }

    // Handle updating foto_profile if provided
    if ($_FILES['foto_profile']['error'] == UPLOAD_ERR_OK) {
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        $fileType = $_FILES['foto_profile']['type'];

        if (in_array($fileType, $allowedTypes)) {
            // Directory to upload files
            $uploadDirectory = 'C:/laragon/www/Perawatan-PC/img/';

            // Move the uploaded file to the designated directory
            $uploadedFilePath = $uploadDirectory . basename($_FILES['foto_profile']['name']);
            
            if (move_uploaded_file($_FILES['foto_profile']['tmp_name'], $uploadedFilePath)) {
                // Read the uploaded file and convert it to base64
                $fotoProfileData = base64_encode(file_get_contents($uploadedFilePath));

                // Update foto_profile in the database
                $updateFotoSql = "UPDATE info_user SET foto_profile = ? WHERE nis_user = ?";
                $updateFotoStmt = mysqli_prepare($host, $updateFotoSql);

                if ($updateFotoStmt) {
                    mysqli_stmt_bind_param($updateFotoStmt, "ss", $fotoProfileData, $nisUser);
                    $updateFotoSuccess = mysqli_stmt_execute($updateFotoStmt);

                    if ($updateFotoSuccess) {
                        // Redirect to infoUser.php after successful update
                        header('location: infoUser.php');
                        exit;
                    } else {
                        echo "Error updating foto_profile in database: " . mysqli_error($host);
                    }

                    mysqli_stmt_close($updateFotoStmt);
                } else {
                    echo "Error in preparing SQL statement for foto_profile update: " . mysqli_error($host);
                }
            } else {
                echo "Error moving uploaded file to destination.";
            }
        } else {
            echo "Invalid file type. Allowed types: JPEG, JPG, PNG.";
        }
    }

    // Update nama_user dan email_user
    $updateSql = "UPDATE info_user SET nama_user = ?, email_user = ? WHERE nis_user = ?";
    $updateStmt = mysqli_prepare($host, $updateSql);

    if ($updateStmt) {
        mysqli_stmt_bind_param($updateStmt, "sss", $namaUser, $emailUser, $nisUser);
        $updateSuccess = mysqli_stmt_execute($updateStmt);

        if ($updateSuccess) {
            header('location: infoUser.php');
            exit;
        } else {
            echo "Error updating profile: " . mysqli_error($host);
        }

        mysqli_stmt_close($updateStmt);
    } else {
        echo "Error in preparing SQL statement for update: " . mysqli_error($host);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Profile</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nama_user" class="form-label">Nama:</label>
                <input type="text" name="nama_user" class="form-control" value="<?php echo $userInfo['nama_user']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email_user" class="form-label">Email:</label>
                <input type="email" name="email_user" class="form-control" value="<?php echo $userInfo['email_user']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="password_user" class="form-label">Password (biarkan kosong jika tidak diubah):</label>
                <input type="password" name="password_user" class="form-control">
            </div>
            <div class="mb-3">
                <label for="foto_profile" class="form-label">Foto Profile:</label>
                <input type="file" name="foto_profile" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    <footer></footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
