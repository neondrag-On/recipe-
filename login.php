<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username exists and get the hashed password
    $sql = "SELECT username, password FROM signup WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Get user's IP address
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $login_time = date("Y-m-d H:i:s");
    $status = "";

    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct
            $status = "success";

            // Redirect to homepage or admin page
            header("Location: index.html");
        } else {
            // Password is incorrect
            $status = "failed";
            echo "Invalid username or password.";
        }
    } else {
        // Username not found
        $status = "failed";
        echo "Invalid username or password.";
    }

    // Log the attempt in login_activities
    $sql = "INSERT INTO login_activity(username, login_time, ip_address, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $login_time, $ip_address, $status);
    $stmt->execute();
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="login.php" method="post">
        <h2>Login</h2>
        <label>Username</label>
        <input type="text" name="username" required><br>
        <label>Password</label>
        <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>

