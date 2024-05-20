<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage All Reviews</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .delete-form,
        .edit-form {
            display: inline-block;
        }

        .delete-button,
        .edit-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-button:hover,
        .edit-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>

<body>
    <h1>Manage Reviews</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Rating</th>
            <th>Review</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
        <?php
        // Include database connection
        include '../connect.php';

        // Fetch reviews from the database
        $sql = "SELECT * FROM review";
        $result = $connect->query($sql);

        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["r_id"] . "</td>";
                echo "<td>" . $row["r_name"] . "</td>";
                echo "<td>" . $row["r_rating"] . "</td>";
                echo "<td>" . $row["r_review"] . "</td>";
                echo "<td><img src='../img/" . $row["r_image"] . "' alt='Review Image' style='max-width: 100px; max-height: 100px;'></td>";
                echo "<td>
                        <form class='delete-form' method='POST' action='manage_review.php'>
                            <input type='hidden' name='id' value='" . $row["r_id"] . "'>
                            <button type='submit' class='delete-button'>Delete</button>
                        </form>
                        <form class='edit-form' method='POST' action='edit_review.php'>
                            <input type='hidden' name='id' value='" . $row["r_id"] . "'>
                            <button type='submit' class='edit-button'>Edit</button>
                        </form>
                    </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No reviews found</td></tr>";
        }

        ?>
    </table>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
        // Prepare a delete statement
        $sql = "DELETE FROM review WHERE r_id = ?";

        if ($stmt = $connect->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $id);

            // Set parameters
            $id = $_POST['id'];

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                echo "Review deleted successfully.";
                header("Location: manage_review.php");
                exit();
            } else {
                echo "Error deleting review.";
            }
        }

        // Close statement
    
    }

    // Close connection
    ?>
</body>

</html>