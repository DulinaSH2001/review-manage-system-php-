<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../review.css" />
    <title>Edit Review</title>
</head>

<body>

    <div class="form-container">
        <div class="form-outliner">
            <?php
            // Include database connection
            include '../connect.php';

            // Check if review ID is set and if the form is submitted
            if (isset($_POST['id'])) {
                // Fetch review details based on ID
                $id = isset($_POST['id']);
                $sql = "SELECT * FROM review WHERE r_id = $id";
                $result = $connect->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    ?>
                    <form action="update_review.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $row['r_id']; ?>">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" id="name" name="name"
                                value="<?php echo isset($row['r_name']) ? $row['r_name'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="profileImage">Profile Image:</label>
                            <input type="file" id="profileImage" name="profileImage">
                            <img id="imagePreview" src="../img/<?php echo isset($row['r_image']) ? $row['r_image'] : ''; ?>"
                                alt="Preview" style="max-width: 200px; max-height: 200px;">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email"
                                value="<?php echo isset($row['r_email']) ? $row['r_email'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="rating">Rating:</label>
                            <div class="star-rating">
                                <?php
                                // Display star rating based on the current rating value
                                for ($i = 5; $i >= 1; $i--) {
                                    $checked = isset($row['r_rating']) && $row['r_rating'] == $i ? 'checked' : '';
                                    echo "<input type='radio' id='rating$i' name='rating' value='$i' $checked>";
                                    echo "<label for='rating$i'></label>";
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label for="comment">Comment:</label>
                                <textarea id="comment" name="comment" rows="4"
                                    required><?php echo isset($row['r_review']) ? $row['r_review'] : ''; ?></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Update Review">
                            </div>
                    </form>
                    <?php
                } else {
                    echo "Review not found.";
                }
            } else {
                echo "Review ID not specified.";
            }
            ?>
        </div>
    </div>



    <script>
        // Function to handle file input change
        document.getElementById('profileImage').addEventListener('change', function (event) {
            var input = event.target;
            var reader = new FileReader();

            reader.onload = function () {
                var imagePreview = document.getElementById('imagePreview');
                imagePreview.src = reader.result;
                imagePreview.style.display = 'block'; // Show the image preview
            };

            // Read the selected image file
            reader.readAsDataURL(input.files[0]);
        });
    </script>

</body>

</html>