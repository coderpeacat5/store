<?php
session_start();
$login = false;
$showError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'partials/_dbconnect.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT username, role FROM users WHERE username = ? AND password = ? AND role = ?");
    $stmt->bind_param("sss", $username, $password, $role); // Bind the role as well
    $stmt->execute();
    $stmt->bind_result($dbUsername, $dbRole);
    $stmt->fetch();

    // Check if the username, password, and role match
    if ($dbUsername) {
        $_SESSION['username'] = $dbUsername;
        $_SESSION['role'] = $dbRole;
        header("Location: login.php"); // Redirect to the dashboard
        exit();
    } else {
        echo "<script>
        alert('Invalid Username, Password, or Role');
        </script>";
    }

    $stmt->close();
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container illustration">
        <!-- Left section -->
        <div class="login-form">
            <img src="images/logo.png" alt="drdo logo" class="logo">
            <h2>Welcome to the Store</h2>
            <p>Sign into your Account</p>

            <form action="index.php" method="post" id="login-form">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>

                <label for="password">Password</label>
                <input type="text" id="password" name="password" placeholder="Enter your password" required>

                <label for="role">Login Type</label>
                <select name="role" id="role">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>

                <div class="btn-container">
                    <button type="submit" class="btn">Log In</button>
                    <a href="signup.php" class="btn">Sign Up</a>
                </div>
            </form>
        </div>
        <!-- Right section -->
        <div class="image-section illustration-img">
        </div>
    </div>
</body>

</html>