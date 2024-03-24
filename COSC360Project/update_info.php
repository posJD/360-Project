<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include 'config.php';

$user_id = $_SESSION['user_id'];
$type = $_GET['type'];
$value = $_GET['value'];

if ($type == 'name' || $type == 'email' || $type == 'username' || $type == 'dob' || $type == 'bio') {
    $updateStmt = $pdo->prepare("UPDATE User SET $type = :value WHERE UserId = :user_id");
    $updateStmt->execute(['value' => $value, 'user_id' => $user_id]);
    header("Location: account_overview.php");
    exit();
} else {
    echo "Invalid update type.";
    exit();
}
?>
