<?php
session_start(); 

if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || strtolower($_SESSION['role']) != 'admin') {
    header("Location: index.php"); 
    exit();
}

include 'partials/_dbconnect.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $date = $_POST['date'];
    $file_no = $_POST['file_no'];
    $item_name = $_POST['item_name'];
    $status = $_POST['status'];

    
    $insertSql = "INSERT INTO data_table (Username, Date, `File No.`, `Item Name`, Status) 
                  VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($insertSql);

    if ($stmt) {
        
        $stmt->bind_param("sssss", $username, $date, $file_no, $item_name, $status);

        if ($stmt->execute()) {
            echo "Record added successfully!";
            header("Location: dashboard.php"); 
            exit();
        } else {
            echo "Error adding record: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Failed to prepare SQL statement.";
    }
}

$conn->close(); 
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
            <a href="dashboard.php" class="btn">Cancel</a>
        </div>

        </form>
    </div>
</body>

</html>