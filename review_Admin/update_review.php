<?php
include '../connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Get the form data
    $id = $_POST['id'];
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $rating = isset($_POST['rating']) ? $_POST['rating'] : '';
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';

    // Check if a new profile image is uploaded
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] !== UPLOAD_ERR_NO_FILE) {
        $profileImageName = uniqid() . '_' . $_FILES['profileImage']['name'];
        $targetDirectory = "../img/";
        $targetFilePath = $targetDirectory . $profileImageName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetFilePath)) {
            // Update the review with the new profile image
            $sql = "UPDATE review SET r_name='$name', r_image='$profileImageName', r_email='$email', r_rating=$rating, r_review='$comment' WHERE r_id=$id";

            if ($connect->query($sql) === TRUE) {
                // Redirect back to the edit review page with a success message
                header("Location: manage_review.php");
                exit;
            } else {
                echo "Error updating review: " . $connect->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        // Update the review without changing the profile image
        $sql = "UPDATE review SET r_name='$name', r_email='$email', r_rating=$rating, r_review='$comment' WHERE r_id=$id";

        if ($connect->query($sql) === TRUE) {
            // Redirect back to the edit review page with a success message
            header("Location: manage_review.php");
            exit;
        } else {
            echo "Error updating review: " . $connect->error;
        }
    }
}
?>