<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Listings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        #jobList {
            margin-top: 20px;
        }

        .job-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fff;
        }

        .job-card h2 {
            margin-top: 0;
            color: #333;
        }

        .job-card p {
            margin: 5px 0;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        select {
            padding: 8px;
            font-size: 16px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        include 'connect.php';

        // Check connection
        if ($connect->connect_error) {
            die("Connection failed: " . $connect->connect_error);
        }

        // Query to fetch categories
        $category_sql = "SELECT catid, cat_name FROM category";
        $category_result = $connect->query($category_sql);

        // Check if category query was successful
        if ($category_result === false) {
            die("Error executing category query: " . $connect->error);
        }
        ?>

        <div>
            <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="category">Select Category:</label>
                <select id="category" name="category" onchange="this.form.submit()">
                    <option value="all">All Categories</option>
                    <?php
                    while ($category_row = $category_result->fetch_assoc()) {
                        echo "<option value='" . $category_row["catid"] . "'";
                        if (isset($_GET['category']) && $_GET['category'] == $category_row["catid"]) {
                            echo " selected";
                        }
                        echo ">" . $category_row["cat_name"] . "</option>";
                    }
                    ?>
                </select>
            </form>
        </div>

        <div id="jobList">
            <?php
            // Build the WHERE clause based on selected category
            $where_clause = "";
            if (isset($_GET['category']) && $_GET['category'] != 'all') {
                $selected_category = $_GET['category'];
                $where_clause = " WHERE catid = '$selected_category'";
            }

            // Query to fetch job details
            $job_sql = "SELECT j_id,name AS job_name,catid,location,company,sex 
                        FROM job" . $where_clause;

            $job_result = $connect->query($job_sql);

            // Check if job query was successful
            if ($job_result === false) {
                die("Error executing job query: " . $connect->error);
            }

            if ($job_result->num_rows > 0) {
                // Output data of each job
                while ($job_row = $job_result->fetch_assoc()) {
                    echo "<div class='job-card'>";
                    echo "<h2>" . $job_row["job_name"] . "</h2>";
                    echo "<p>Category: " . getCategoryName($job_row["catid"], $connect) . "</p>";
                    echo "<p>Location: " . $job_row["location"] . "</p>";
                    echo "<p>Company: " . $job_row["company"] . "</p>";
                    echo "<p>Sex: " . $job_row["sex"] . "</p>";
                    echo "<a href='job_details.php?j_id=" . $job_row["j_id"] . "' class='view-button'><button>View</button></a>";
                    echo "</div>";
                }
            } else {
                echo "No jobs found";
            }
            ?>
        </div>

        <?php
        $connect->close();

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
        ?>
    </div>
</body>

</html>