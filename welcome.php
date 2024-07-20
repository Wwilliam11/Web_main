<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="design/styles.css">
    <title>Welcome</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    <div>
        <button><a href="logout.php" class="logout_button">Logout</a></button>
        <button><a href="start_page.php" class="start_button">START</a></button>
    </div>
</body>
</html>