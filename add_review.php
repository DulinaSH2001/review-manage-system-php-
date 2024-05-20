<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="review.css" />
    <title>Add Review</title>
</head>

<body>

    <?php include 'websiteHeader.php';
    include 'connect.php' ?>

    <div class="form-container">
        <div class="form-outliner">
            <form action="add_review.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="profileImage">Profile Image:</label>
                    <input type="file" id="profileImage" name="profileImage" required>
                    <img id="imagePreview" src="#" alt="Preview"
                        style="display: none; max-width: 200px; margin-top: 10px;">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="rating">Rating:</label>
                    <div class="star-rating">
                        <input type="radio" id="rating1" name="rating" value="1" required><label for="rating1"></label>
                        <input type="radio" id="rating2" name="rating" value="2"><label for="rating2"></label>
                        <input type="radio" id="rating3" name="rating" value="3"><label for="rating3"></label>
                        <input type="radio" id="rating4" name="rating" value="4"><label for="rating4"></label>
                        <input type="radio" id="rating5" name="rating" value="5"><label for="rating5"></label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <textarea id="comment" name="comment" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit Review">
                </div>
            </form>
        </div>
    </div>
    <?php
    // submitReview.php
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $name = $_POST['name'];
        $profileImage = $_FILES['profileImage'];
        $email = $_POST['email'];
        $rating = $_POST['rating'];
        $comment = $_POST['comment'];

        if ($_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {

            $profileImageName = uniqid() . '_' . $_FILES['profileImage']['name'];

            $targetDirectory = "img/";

            $targetFilePath = $targetDirectory . $profileImageName;


            if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $targetFilePath)) {


                include 'connect.php';

                if ($connect->connect_error) {
                    die("Connection failed: " . $connect->connect_error);
                }


                $sql = "INSERT INTO review (r_name, r_image, r_email, r_rating, r_review) VALUES ('$name', '$profileImageName', '$email', $rating, '$comment')";

                if ($connect->query($sql) === TRUE) {

                    header('Location: review.php');
                    exit;
                } else {
                    echo "Error: " . $sql . "<br>" . $connect->error;
                }


                $connect->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    ?>




    <?php include 'websiteFooter.php'; ?>




</body>
<script>
// Function to handle file input change
document.getElementById('profileImage').addEventListener('change', function(event) {
    var input = event.target;
    var reader = new FileReader();

    reader.onload = function() {
        var imagePreview = document.getElementById('imagePreview');
        imagePreview.src = reader.result;
        imagePreview.style.display = 'block'; // Show the image preview
    };

    // Read the selected image file
    reader.readAsDataURL(input.files[0]);
});
</script>

</html>