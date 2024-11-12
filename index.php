<?php
include 'partials/_dbconnect.php'; 

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$sql = "SELECT `S_No`, `Username`, `Date`, `File No.`, `Item Name`, `Status` FROM data_table";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        $counter = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $counter . "</td>";
                            echo "<td>" . htmlspecialchars($row['Date']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['File No.']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Item Name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Username']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                            echo "</tr>";
                            $counter++;
                        }
                    } else {
                        echo "<tr><td colspan='6'>No data available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div class="btn-container">
            <a href="login.php" class="btn">Edit Record</a>
        </div>
    </div>
</body>
</html>

<?php
mysqli_close($conn);
?>
