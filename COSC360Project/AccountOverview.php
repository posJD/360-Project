<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include 'config.php';

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM User WHERE UserId = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Error: User data not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Overview</title>
    <link rel="stylesheet" href="AccountOverview.css">
</head>
<body>
    <header>
        <a href="home_Page.html">
            <img src="Logo.png" alt="Logo">
        </a>
        <a href="login.html">
            <img src="UserImage.jpeg" alt="User Image" class="user-image-button">
        </a>
    </header>
    <main>
        <nav>
            <a href="#">Home</a>
            <a href="#">Profile</a>
            <a href="#">Settings</a>
        </nav>
        <div class="profile-container">
            <img src="/Images/UserImage.jpeg" alt="Profile Image" class="profile-image">
            <div class="user-info">
                <h2>Username: <?php echo $user['Username']; ?></h2>
                <p>Bio: <?php echo $user['Bio']; ?></p>
            </div>
        </div>
    </main>
    <footer>
        &copy; 2024 DS CSS. All rights reserved.
    </footer>
</body>
</html>
