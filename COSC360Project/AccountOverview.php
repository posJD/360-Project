<?php

include 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM User WHERE UserId = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Error: User data not found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $dob = $_POST['dob'];
        $bio = $_POST['bio'];
    
        $updateStmt = $pdo->prepare("UPDATE User SET Name = :name, Email = :email, Username = :username, DOB = :dob, Bio = :bio WHERE UserId = :user_id");
        $updateStmt->execute(['name' => $name, 'email' => $email, 'username' => $username, 'dob' => $dob, 'bio' => $bio, 'user_id' => $user_id]);
    
        header("Location: AccountOverview.php");
        exit();
    } elseif (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['profile_image'];
        $fileName = $file['name'];
        $tmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
    
        if ($fileError == UPLOAD_ERR_OK) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($fileName);
    
            if (move_uploaded_file($tmpName, $targetFile)) {
                $updateImageStmt = $pdo->prepare("UPDATE User SET ImageId = :image_id WHERE UserId = :user_id");
                $updateImageStmt->execute(['image_id' => $targetFile, 'user_id' => $user_id]);
    
                header("Location: AccountOverview.php");
                exit();
            } else {
                echo "Error uploading image.";
            }
        } else {
            echo "Error uploading image.";
        }
    }
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Overview</title>
    <link rel="stylesheet" href="AccountOverview.css">
       <script>
            function toggleEditMode(inputId, editButtonId) {
                var input = document.getElementById(inputId);
                var editButton = document.getElementById(editButtonId);

                if (input.disabled) {
                    input.disabled = false;
                    editButton.textContent = "Done";
                } else {
                    input.disabled = true;
                    editButton.textContent = "Edit";
                }
            }
        </script>

    </script>
</head>
<body>
    <header>
        <a href="home_Page.php">
            <img src="Logo.png" alt="Logo">
        </a>
        <a href="AccountOverview.php">
            <img src="<?php echo $user['ImageId'] ?? 'UserImage.jpeg'; ?>" alt="User Image" class="user-image-button">
        </a>
    </header>
    <main>
        <div class="profile-container">
            <img src="<?php echo $user['ImageId'] ?? 'UserImage.jpeg'; ?>" alt="Profile Image" class="profile-image">
            <div class="user-info">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <h2>Name:
                        <input id="name" type="text" name="name" value="<?php echo htmlspecialchars($user['Name']); ?>" disabled>
                        <button type="button" onclick="toggleEditMode('name', 'editNameText')">Edit</button>
                    </h2>
                    <input type="hidden" name="original_name" value="<?php echo htmlspecialchars($user['Name']); ?>">
                    <p>Email:
                        <input id="email" type="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" disabled>
                        <button type="button" onclick="toggleEditMode('email', 'editEmailText')">Edit</button>
                    </p>
                    <input type="hidden" name="original_email" value="<?php echo htmlspecialchars($user['Email']); ?>">
                    <p>Username:
                        <input id="username" type="text" name="username" value="<?php echo htmlspecialchars($user['Username']); ?>" disabled>
                        <button type="button" onclick="toggleEditMode('username', 'editUsernameText')">Edit</button>
                    </p>
                    <input type="hidden" name="original_username" value="<?php echo htmlspecialchars($user['Username']); ?>">
                    <p>Date of Birth:
                        <input id="dob" type="date" name="dob" value="<?php echo htmlspecialchars($user['DOB']); ?>" disabled>
                        <button type="button" onclick="toggleEditMode('dob', 'editDobdate')">Edit</button>
                    </p>
                    <input type="hidden" name="original_dob" value="<?php echo htmlspecialchars($user['DOB']); ?>">
                    <p>Bio:
                        <textarea id="bio" name="bio" disabled><?php echo htmlspecialchars($user['Bio']); ?></textarea>
                        <button type="button" onclick="toggleEditMode('bio', 'editBio')">Edit</button>
                    </p>                
                    <input type="hidden" name="original_bio" value="<?php echo htmlspecialchars($user['Bio']); ?>">
                    <p>
                        <input type="file" name="profile_image">
                        <button type="submit" name="submit">Update Profile</button>
                    </p>
                </form>
            </div>
        </div>
    </main>
    <footer>
        &copy; 2024 DS CSS. All rights reserved.
    </footer>
</body>
</html>
