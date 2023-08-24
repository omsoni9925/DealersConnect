<?php
// Start the session to access the session data
session_start();

// Check if the user is logged in (i.e., if the username is set in the session data)
if (isset($_SESSION['email'])) {
    // User is logged in, get the username from the session data
    $email = $_SESSION['email'];
} else {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Check if the user has uploaded a profile picture
if (isset($_FILES['profile_picture'])) {
    // Specify the directory where uploaded files will be stored
    $targetDir = "uploads/"; // Replace with the desired directory path
    $targetFile = $targetDir . basename($_FILES['profile_picture']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the uploaded file is an image
    $check = getimagesize($_FILES['profile_picture']['tmp_name']);
    if ($check !== false) {
        // Allow only certain image file formats (you can add more if needed)
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
            $uploadOk = 0;
        }

        // Check if the file was successfully uploaded
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
                // Save the uploaded file path in the session data
                $_SESSION['profile_picture'] = $targetFile;
                echo "Profile picture uploaded successfully.";
                $_SESSION['profile_photo_uploaded'] = true;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }

        }
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
?>

<!-- Redirect back to the profile page after the upload process -->
<script>
    window.location.href = "profile.php";
</script>

