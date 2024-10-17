
<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["fname"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];
    $date = $_POST["dob"];

    // Basic validation
    if (empty($name) || empty($username) || empty($email) || empty($phone) || empty($password) || empty($repassword) || empty($date)) {
        echo "All fields are required.";
    } elseif ($password !== $repassword) {
        echo "Passwords do not match.";
    } else {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO signup (name, username, email, date, phone, password, repassword) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $username, $email, $date, $phone, $hashedPassword, $repassword);

        // Execute SQL statement
        if ($stmt->execute()) {
            echo "Registration successful.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }
}

// Close connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style> 
    body {
    font-family: Arial, sans-serif;
    background-color: #f7f7f7;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

form {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    width: 300px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="date"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

input[type="submit"] {
    background-color: #ff6347;
    color: white;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #e5533c;
}

.error {
    color: red;
}

.success {
    color: green;
}
</style><!-- Assuming you have a CSS file -->
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h2>SIGNUP</h2>
        <label>Full name</label>
        <input type="text" name="fname"><br>
        <label>Username</label>
        <input type="text" name="username"><br>
        <label>Email</label>
        <input type="email" name="email"><br>
        <label>Create Password</label>
        <input type="password" name="password"><br>
        <label>Re-enter Password</label>
        <input type="password" name="repassword"><br>
        <label>Date of birth</label>
        <input type="date" name="dob"><br>
        <label>Phone number</label>
        <input type="text" name="phone"><br>
        <input type="submit" name="submit" value="Signup">
    </form>
</body>
</html>
