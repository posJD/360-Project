<?php
require 'config.php';


if (isset($_GET['user_id'])) {
   
    $userId = $_GET['user_id'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       
        $stmt = $pdo->prepare("UPDATE User SET enabled = 0 WHERE UserId = ?");
        $stmt->execute([$userId]);

        
        echo "User disabled successfully.";
    } catch (PDOException $e) {
        
        echo "Error: " . $e->getMessage();
    }
} else {
   
    echo "User ID not provided.";
}
?>
