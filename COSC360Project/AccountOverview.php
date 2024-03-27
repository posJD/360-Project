<?php

include 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
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

        header("Location: account_overview.php");
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
</head>
<body>
    <header>
        <nav>
            <a href="#">Home</a>
            <a href="#">Profile</a>
            <a href="#">Settings</a>
        </nav>
        <a href="home_Page.php">
            <img src="Logo.png" alt="Logo">
        </a>
        <a href="login.php">
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
                        <button type="button" onclick="toggleEditMode('name', 'editName')">Edit</button>
                    </h2>
                    <p>Email:
                        <input id="email" type="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" disabled>
                        <button type="button" onclick="toggleEditMode('email', 'editEmail')">Edit</button>
                    </p>
                    <p>Username:
                        <input id="username" type="text" name="username" value="<?php echo htmlspecialchars($user['Username']); ?>" disabled>
                        <button type="button" onclick="toggleEditMode('username', 'editUsername')">Edit</button>
                    </p>
                    <p>Date of Birth:
                        <input id="dob" type="date" name="dob" value="<?php echo htmlspecialchars($user['DOB']); ?>" disabled>
                        <button type="button" onclick="toggleEditMode('dob', 'editDob')">Edit</button>
                    </p>
                    <p>Bio:
                        <textarea id="bio" name="bio" disabled><?php echo htmlspecialchars($user['Bio']); ?></textarea>
                        <button type="button" onclick="toggleEditMode('bio', 'editBio')">Edit</button>
                    </p>
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