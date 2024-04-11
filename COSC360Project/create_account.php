<?php
$host = 'localhost';
$dbname = 'db_86043593';
$username = '86043593';
$password = '86043593';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$error_message1 = $error_message2 = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $dob = $_POST['dob'];

    if ($_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['profile_image'];
        $fileName = $file['name'];
        $tmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];

        if ($fileError == UPLOAD_ERR_OK) {
            $img_content = file_get_contents($tmpName);
        } else {
            echo "Error uploading image.";
            exit();
        }
    }

    $stmt = $pdo->prepare("SELECT * FROM User WHERE Email = :email");
    $stmt->execute(['email' => $email]);
    $existingEmail = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($existingEmail) {
        $error_message1 = "Email is already registered.";
    }

    $stmt = $pdo->prepare("SELECT * FROM User WHERE Username = :username");
    $stmt->execute(['username' => $username]);
    $existingUsername = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($existingUsername) {
        $error_message2 = "Username is already taken.";
    }

    if (!$existingEmail && !$existingUsername) {
        if (strlen($password) < 8) {
            $error_message1 = "Password must be at least 8 characters long.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            try {
                $pdo->beginTransaction();

                $stmt_img = $pdo->prepare("INSERT INTO Images (ImgFile) VALUES (?)");
                $stmt_img->bindParam(1, $img_content, PDO::PARAM_LOB);
                $stmt_img->execute();
                $image_id = $pdo->lastInsertId();

                $stmt_user = $pdo->prepare("INSERT INTO User (Name, Email, Username, Password, DOB, ImageId) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt_user->execute(["$firstName $lastName", $email, $username, $hashedPassword, $dob, $image_id]);

                $pdo->commit();

                header("Location: login.php");
                exit();
            } catch (PDOException $e) {
                $pdo->rollBack();
                echo "Error creating user: " . $e->getMessage();
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account Page</title>
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        form {
            width: 300px;
            height:550px;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4caf50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        header {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            position: fixed;
            top:0%;
            width: 100%;
            text-align:left;
            height: 70px;
            
            
            
           
        }

        footer {
            background-color: #2c3e50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            position: fixed;
            bottom: 0%;
            width: 100%;
            
            
        }
        #logo {
            max-height: 60px;
            padding: 10px 40px;
        }
    </style>
</head>
<body>
    <header>
        <a href="home_Page.php"><img src="Logo.png" alt="Logo" id="logo"></a>
    </header>
    <form id="createAccountForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Create Account</h2>
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>

        <label for="profile_image">Profile Image:</label>
        <input type="file" id="profile_image" name="profile_image">

        <button type="submit" name="create_account">Create Account</button>
    </form>
    <footer>
        &copy; 2024 DS CSS. All rights reserved.
    </footer>
</body>
</html>


