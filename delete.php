<?php
session_start(); // Start the session

// Verify if the user is logged in and has the 'admin' role
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || strtolower($_SESSION['role']) != 'admin') {
    header("Location: index.php"); // Redirect to login if not logged in or not an admin
    exit();
}

include 'partials/_dbconnect.php'; // Database connection

// Check if an S.No. parameter is provided in the URL
if (isset($_GET['S_No'])) {
    $s_no = $_GET['S_No'];

    // Fetch the record to confirm it exists
    $sql = "SELECT * FROM data_table WHERE `S_No` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $s_no);
    $stmt->execute();
    $result = $stmt->get_result();
    $record = $result->fetch_assoc();

    // If the record is found, ask for confirmation to delete
    if ($record) {
        // If delete is confirmed
        if (isset($_POST['confirm_delete'])) {
            // Prepare and execute the delete statement
            $deleteSql = "DELETE FROM data_table WHERE `S_No` = ?";
            $deleteStmt = $conn->prepare($deleteSql);
            $deleteStmt->bind_param("i", $s_no);

            if ($deleteStmt->execute()) {
                // Redirect to the dashboard with a success message
                header("Location: login.php?message=Record+deleted+successfully");
                exit();
            } else {
                echo "Error deleting record: " . $conn->error;
            }
        }
    } else {
        echo "Record not found!";
        exit();
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
    <title>Delete Record</title>
    <link rel="stylesheet" href="styles/dstyle.css">
</head>
<body>
    <div class="container">
    <img src="images/logo.png" alt="drdo logo" class="logo">
    <h2>Delete Record</h2>

    <?php if ($record) { ?>
        <span>Are you sure you want to delete the following record?</span>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($record['Username']); ?></p>
        <!-- <p><strong>Role:</strong> <?php echo htmlspecialchars($record['Role']); ?></p> -->
        <p><strong>Date:</strong> <?php echo htmlspecialchars($record['Date']); ?></p>
        <p><strong>File No.:</strong> <?php echo htmlspecialchars($record['File No.']); ?></p>
        <p><strong>Item Name:</strong> <?php echo htmlspecialchars($record['Item Name']); ?></p>
        <p><strong>Status:</strong> <?php echo htmlspecialchars($record['Status']); ?></p>

        <!-- Confirmation form -->
        <form method="post" action="" class="del-form">
            <button type="submit" name="confirm_delete" class="del-btn">Yes, delete this record</button>
        </form>
        <a href="login.php" class="btn">Cancel</a>
        </div>
    <?php } ?>

    
</body>
</html>

<?php
$stmt->close(); 
$conn->close(); 
?>
