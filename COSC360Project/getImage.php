<?php
include 'config.php';

if(isset($_GET['id']) && is_numeric($_GET['id'])) {
    $imageId = $_GET['id'];
    
    try {
        $stmt = $pdo->prepare("SELECT ImgFile FROM Images WHERE ImageId = ?");
        $stmt->execute([$imageId]);
        $imageData = $stmt->fetch(PDO::FETCH_ASSOC);

        if($imageData && isset($imageData['ImgFile'])) {
            header("Content-type: image/jpeg"); // Adjust the content type based on your image type
            echo $imageData['ImgFile'];
            exit();
        } else {
            header("Location: UserImage.jpeg");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    header("Location: UserImage.jpeg");
    exit();
}
?>
