<?php
    include 'includes/db.php';
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Kiểm tra xem tên người dùng đã tồn tại chưa
        $check_sql = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($check_sql);

        if ($result->num_rows > 0) {
            echo "Account already used";
        } else {
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

            if ($conn->query($sql) === TRUE) {
                // Tạo session cho người dùng
                $_SESSION['username'] = $username;
                header("Location: welcome.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }
?>




<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="design/styles.css">
    <title>register</title>
</head>
<body>
    <h2>register</h2>
    <form method="post" action="register.php">
    <label for="username" class="center-text">Username:</label>
        <input type="text" id="username" name="username" class="rainbow-input" required><br>
        <label for="password" class="center-text">Password:</label>
        <input type="password" id="password" name="password" class="rainbow-input" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>