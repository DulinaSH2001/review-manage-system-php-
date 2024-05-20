<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: #f4f4f4;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    h1 {
        margin-top: 0;
        color: #333;
    }

    p {
        margin: 10px 0;
    }

    strong {
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="container">
        <?php
        include 'connect.php';

        // Check if job ID is provided in the URL
        if (isset($_GET['j_id'])) {
            // Sanitize input to prevent XSS attacks
            $job_id = htmlspecialchars($_GET['j_id']);

            // Query to fetch job details
            $job_sql = "SELECT * FROM job WHERE j_id = '$job_id'";
            $job_result = $connect->query($job_sql);

            // Check if job query was successful
            if ($job_result === false) {
                die("Error executing job query: " . $connect->error);
            }

            // Check if job exists
            if ($job_result->num_rows > 0) {
                $job_row = $job_result->fetch_assoc();
                // Output job details
                echo "<h1>Job Details</h1>";
                echo "<p><strong>Job ID:</strong> " . $job_row['j_id'] . "</p>";
                echo "<p><strong>Name:</strong> " . $job_row['name'] . "</p>";
                echo "<p><strong>Category:</strong> " . getCategoryName($job_row['catid'], $connect) . "</p>";
                echo "<p><strong>Location:</strong> " . $job_row['location'] . "</p>";
                echo "<p><strong>Company:</strong> " . $job_row['company'] . "</p>";
                echo "<p><strong>Sex:</strong> " . $job_row['sex'] . "</p>";
                echo "<p><strong>Description:</strong> " . $job_row['description'] . "</p>";
                echo "<p><strong>Requirement:</strong> " . $job_row['requirement'] . "</p>";
            } else {
                echo "Job not found.";
            }
        } else {
            echo "No job ID provided.";
        }

        // Function to get category name by category ID
        function getCategoryName($catid, $conn)
        {
            $category_name = "Unknown";
            $category_sql = "SELECT cat_name FROM category WHERE catid = '$catid'";
            $category_result = $conn->query($category_sql);
            if ($category_result->num_rows > 0) {
                $category_row = $category_result->fetch_assoc();
                $category_name = $category_row["cat_name"];
            }
            return $category_name;
        }

        $connect->close();
        ?>
    </div>
</body>

</html>