<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>View Reviews</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    header,
    footer {
        background-color: #333;
        color: #fff;
        padding: 10px;
        text-align: center;
    }

    .reviews-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        padding: 20px;
    }

    .review-card {
        width: 300px;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .profile-info {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .profile-pic {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
    }

    .name {
        font-size: 1.2rem;
        margin: 0;
    }

    .star-rating {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }

    .star-rating label {
        font-size: 24px;
        cursor: pointer;
        color: #ccc;
        /* Default color for unfilled stars */
    }

    .star-rating .filled {
        color: #fbd702;
        /* Yellow color for filled stars */
    }

    /* Style unfilled stars */
    .star-rating .unfilled {
        color: #ccc;
        /* Light gray color for unfilled stars */
    }

    .comment p {
        margin: 0;
    }
    </style>
</head>

<body>

    <header>
        <!-- Header content here -->
    </header>

    <div class="reviews-container">
        <?php
        include 'connect.php';

        // Fetch reviews from the database
        $sql = "SELECT * FROM review";
        $result = $connect->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<div class='review-card'>";
                echo "<div class='profile-info'>";
                echo "<img src='img/" . $row["r_image"] . "' alt='Profile Image' class='profile-pic'>";
                echo "<h2 class='name'>" . $row["r_name"] . "</h2>";
                echo "</div>";
                echo "<div class='rating'>";
                echo "<div class='star-rating'>";
                for ($i = 1; $i <= 5; $i++) { // Assuming 5 stars is the maximum
                    if ($i <= $row["r_rating"]) {
                        echo "<label for='rating{$i}' class='filled'>&#9733;</label>";
                    } else {
                        echo "<label for='rating{$i}'>&#9733;</label>";
                    }
                }
                echo "</div>";
                echo "</div>";
                echo "<div class='comment'>";
                echo "<p>" . $row["r_review"] . "</p>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "0 results";
        }
        $connect->close();
        ?>
    </div>

    <footer>
        <!-- Footer content here -->
    </footer>

</body>

</html>