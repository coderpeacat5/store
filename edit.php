<?php
session_start(); // Start session

// Verify if the user is logged in and has the 'admin' role
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || strtolower($_SESSION['role']) != 'admin') {
    header("Location: index.php"); // Redirect to login if not logged in or not an admin
    exit();
}

include 'partials/_dbconnect.php'; // Database connection

// Check if an S.No. parameter is provided in the URL
if (isset($_GET['S_No'])) {
    $s_no = $_GET['S_No'];

    // Fetch the record from the database
    $sql = "SELECT * FROM data_table WHERE `S_No` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $s_no); // Bind as an integer to prevent SQL injection
    $stmt->execute();
    $result = $stmt->get_result();
    $record = $result->fetch_assoc();

    // If no record found, display an error message
    if (!$record) {
        echo "Record not found!";
        exit();
    }

    // Check if the form is submitted to update the record
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $date = $_POST['date'];
        $file_no = $_POST['file_no'];
        $item_name = $_POST['item_name'];
        $status = isset($_POST['status']) ? $_POST['status'] : ''; // Default to empty if not set

        // Prepare the update SQL query
        $updateSql = "UPDATE data_table SET 
                        Username = ?, 
                        Date = ?, 
                        `File No.` = ?, 
                        `Item Name` = ?, 
                        Status = ? 
                      WHERE `S_No` = ?";
        $stmt = $conn->prepare($updateSql);

        // Bind the parameters (all should be strings except for S_No which is integer)
        $stmt->bind_param("sssssi", $username, $date, $file_no, $item_name, $status, $s_no);

        // Execute the update query and check if successful
        if ($stmt->execute()) {
            echo "Record updated successfully!";
            header("Location: login.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
} else {
    echo "No S.No. provided!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <link rel="stylesheet" href="styles/estyle.css">
</head>

<body>
    <div class="container">
        <img src="images/logo.png" alt="drdo logo" class="logo">
        <h2>Update Record</h2>

        <?php if (isset($record)) { ?>
            <form method="post" action="" class="update-form">
                <label for="username">Username</label>
                <input type="text" id="username" name="username"
                    value="<?php echo htmlspecialchars($record['Username']); ?>" required><br>

                <label for="date">Date</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($record['Date']); ?>"
                    required><br>

                <label for="file_no">File No.</label>
                <input type="text" id="file_no" name="file_no" value="<?php echo htmlspecialchars($record['File No.']); ?>"
                    required><br>

                <label for="item_name">Item Name</label>
                <input type="text" id="item_name" name="item_name"
                    value="<?php echo htmlspecialchars($record['Item Name']); ?>" required><br>

                <label for="status">Status</label>
                <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($record['Status']); ?>"><br>

                <div class="btn-container">
                <button type="submit" class="btn">Update</button>
                <a href="login.php" class="btn">Cancel</a>
                </div>
                
            </form>
        </div>
    <?php } ?>

     <!-- Link back to the dashboard -->
</body>

</html>

<?php
$stmt->close(); // Close the statement
$conn->close(); // Close the database connection
?>