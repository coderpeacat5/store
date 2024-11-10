<?php 
$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $exists = false;

    // Check if passwords match
    if ($password == $cpassword && $exists == false) {
        $sql = "INSERT INTO `users` (`Username`, `Password`, `Date`) VALUES ('$username', '$password', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            // Redirect to index.php after successful signup
            header("Location: index.php");
            exit(); // Prevent further execution of the script
        }
    } else {
        $showError = "Passwords do not match";
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <div class="container illustration">
        <div class="signup-form">
            <img src="images/logo.png" alt="drdo logo" class="logo">
            <h2>Sign Up to our Website</h2>

            <form action="signup.php" method="post" id="signup-form">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>

                <label for="password">Password</label>
                <input type="text" id="password" name="password" placeholder="Enter your password" required>

                <label for="cpassword">Confirm Password</label>
                <input type="password" id="cpassword" name="cpassword" placeholder="Confirm your password" required>

                <label for="login-type">Login Type </label>
                <select name="login-type" id="login-type">
                    <option value="user">User</option>
                </select>

                <div class="btn-container">
                    <!-- Signup button -->
                    <button type="submit" class="btn" id="signup-button">Sign Up</button>
                </div>
            </form>
        </div>

        <!-- Right section -->
        <div class="image-section illustration-img">
            <img src="image.png" alt="Logo Not Found" >
        </div>
    </div>
</body>
</html>
