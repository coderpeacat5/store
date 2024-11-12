<?php
session_start(); // Start the session

// Check if the user is logged in and has a role
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: index.php"); // Redirect to login if not logged in
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

include 'partials/_dbconnect.php'; // Database connection

// Fetch data from the data_table for admin users
$sql = "SELECT `S_No`, `Username`, `Date`, `File No.`, `Item Name`, `Status` FROM data_table";
$result = mysqli_query($conn, $sql);

// Check for query error
if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles/tstyle.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the Dashboard</h1>

        <?php if (strtolower($role) == 'admin') { ?>
            
            <div class="table-container">
            <table border="1">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Date</th>
                        <th>File No.</th>
                        <th>Item Name</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        $counter = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $counter . "</td>";
                            echo "<td>" . $row['Date'] . "</td>";
                            echo "<td>" . $row['File No.'] . "</td>";
                            echo "<td>" . $row['Item Name'] . "</td>";
                            echo "<td>" . $row['Username'] . "</td>";
                            echo "<td>" . $row['Status'] . "</td>";
                            echo "<td><a class=\"edit-btn\" href='edit.php?S_No=" . urlencode($row['S_No']) . "'>🖉</a> | <a class=\"delete-btn\"href='delete.php?S_No=" . urlencode($row['S_No']) . "'>🗑️</a></td>";
                            echo "</tr>";
                            $counter++;
                        }
                        
                    } else {
                        echo "<tr><td colspan='8'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            </div>
            <div class="btn-container">
            <a href="update.php" class="btn">Add Record</a>
            <a href="index.php" class="btn">Logout</a>
            </div>
            
        <?php }?>
    </div>

</body>
</html>

<?php
mysqli_close($conn); 
?>
