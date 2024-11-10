<?php
session_start(); // Start session

// Verify if the user is logged in and has the 'admin' role
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || strtolower($_SESSION['role']) != 'admin') {
    header("Location: index.php"); // Redirect to login if not logged in or not an admin
    exit();
}

include 'partials/_dbconnect.php'; // Database connection

// Check if the form is submitted to add a new record
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $date = $_POST['date'];
    $file_no = $_POST['file_no'];
    $item_name = $_POST['item_name'];
    $status = $_POST['status'];

    // Prepare the insert SQL query
    $insertSql = "INSERT INTO data_table (Username, Date, `File No.`, `Item Name`, Status) 
                  VALUES (?, ?, ?, ?, ?)";

    // Initialize statement variable to null
    $stmt = $conn->prepare($insertSql);

    if ($stmt) {
        // Bind parameters and execute the query if the statement is prepared correctly
        $stmt->bind_param("sssss", $username, $date, $file_no, $item_name, $status);

        // Execute the query and check if successful
        if ($stmt->execute()) {
            echo "Record added successfully!";
            header("Location: login.php"); // Redirect back to dashboard after successful insert
            exit();
        } else {
            echo "Error adding record: " . $conn->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Failed to prepare SQL statement.";
    }
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Record</title>
    <link rel="stylesheet" href="styles/ustyle.css">
</head>

<body>


    <div class="container">
        <img src="images/logo.png" alt="drdo logo" class="logo">
        <h2>Add New Record</h2>

        <form method="post" action="" class="update-form">

            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>

            <label for="date">Date</label>
            <input type="date" id="date" name="date" required>

            <label for="file_no">File No.:</label>
            <input type="text" id="file_no" name="file_no" placeholder="Enter file number" required><br>

            <label for="item_name">Item Name:</label>
            <input type="text" id="item_name" name="item_name" placeholder="Enter item name"  required><br>

            <label for="status">Status:</label>
            <input type="text" id="status" name="status" placeholder="Enter status" ><br>

            <div class="btn-container">
            <button type="submit" class="btn">Add</button>
            <a href="login.php" class="btn">Cancel</a>
        </div>



        </form>
        

        <!-- Link back to the dashboard -->

    </div>
</body>

</html>