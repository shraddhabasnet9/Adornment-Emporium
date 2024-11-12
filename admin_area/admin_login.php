<?php
@include('../include/connect.php');
@session_start();

if (isset($_POST['signup'])) {
    // Sanitize input
    $admin_username = htmlspecialchars(trim($_POST['admin_username']));
    $admin_password = htmlspecialchars(trim($_POST['admin_password']));

    // Ensure fields are not empty
    if (empty($admin_username) || empty($admin_password)) {
        echo "<script>alert('Please fill in all fields');</script>";
    } else {
        // Retrieve hashed password from DB
        $query = "SELECT * FROM `admin_table` WHERE `admin_username` = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $admin_username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['admin_password']; // Retrieved hashed password

            // Verify password
            if (password_verify($admin_password, $hashed_password)) {
                $_SESSION['admin_username'] = $admin_username;
                echo "<script>alert('Successfully loged in');</script>";
                echo "<script>window.open('index.php','_self')</script>";
            } else {
                echo "<script>alert('Incorrect password');</script>";
            }
        } else {
            echo "<script>alert('This admin does not exist');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel</title>
    <link rel="stylesheet" href="admin_login.css">
</head>
<body>
    <div class="login-form">
        <h2>Admin Login Panel</h2>
        <form method="POST">
            <div class="input">
                <label>Admin Name:</label>
                <input type="text" name="admin_username"  autocomplete="off" required>
            </div>
            <div class="input">
                <label>Admin Password:</label>
                <input type="password" name="admin_password"  autocomplete="off" required>
            </div>
            <button type="submit" class="btn" name="signup">Log In</button>
            <p>Don't have account? <a href="admin_register.php">Register</a></p>
        </form>
    </div>
</body>
</html>
