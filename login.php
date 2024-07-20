<?php
    include 'includes/db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['username'] = $username;
                header("Location: welcome.php");
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found.";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="design/styles.css">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <label for="username" class="center-text">Username:</label>
        <input type="text" id="username" name="username" class="rainbow-input" required><br>
        <label for="password" class="center-text">Password:</label>
        <input type="password" id="password" name="password" class="rainbow-input" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
