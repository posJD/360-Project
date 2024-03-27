<?php
include 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_profile'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $dob = $_POST['dob'];
        $bio = $_POST['bio'];

        $updateStmt = $pdo->prepare("UPDATE User SET Name = :name, Email = :email, Username = :username, DOB = :dob, Bio = :bio WHERE UserId = :user_id");
        $updateStmt->execute(['name' => $name, 'email' => $email, 'username' => $username, 'dob' => $dob, 'bio' => $bio, 'user_id' => $user_id]);

        header("Location: AccountOverview.php");
        exit();
    } elseif (isset($_POST['update_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['profile_image'];
        $fileName = $file['name'];
        $tmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];

        if ($fileError == UPLOAD_ERR_OK) {
            $img_content = file_get_contents($tmpName);

            try {
                $stmt_img = $pdo->prepare("INSERT INTO Images (ImgFile) VALUES (?)");
                $stmt_img->bindParam(1, $img_content, PDO::PARAM_LOB);
                $stmt_img->execute();

                $image_id = $pdo->lastInsertId();

                $updateImageStmt = $pdo->prepare("UPDATE User SET ImageId = ? WHERE UserId = ?");
                $updateImageStmt->execute([$image_id, $user_id]);

                header("Location: AccountOverview.php");
                exit();
            } catch (PDOException $e) {
                echo "Error uploading image: " . $e->getMessage();
                exit();
            }
        } else {
            echo "Error uploading image.";
        }
    }
}

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
        <a href="home_Page.php">
            <img src="Logo.png" alt="Logo">
        </a>
        <a href="AccountOverview.php">
            <img src="<?php echo $user['ImageId'] ? 'getImage.php?id='.$user['ImageId'] : 'UserImage.jpeg'; ?>" alt="User Image" class="user-image-button">
        </a>
    </header>
    <main>
        <div class="profile-container">
            <img src="<?php echo $user['ImageId'] ? 'getImage.php?id='.$user['ImageId'] : 'UserImage.jpeg'; ?>" alt="Profile Image" class="profile-image">
            <div class="user-info">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <h2>Name:
                        <input type="text" name="name" value="<?php echo htmlspecialchars($user['Name']); ?>">
                    </h2>
                    <p>Email:
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>">
                    </p>
                    <p>Username:
                        <input type="text" name="username" value="<?php echo htmlspecialchars($user['Username']); ?>">
                    </p>
                    <p>Date of Birth:
                        <input type="date" name="dob" value="<?php echo htmlspecialchars($user['DOB']); ?>">
                    </p>
                    <p>Bio:
                        <textarea name="bio"><?php echo htmlspecialchars($user['Bio']); ?></textarea>
                    </p>
                    <p>
                        <input type
