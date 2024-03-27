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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['admin_login'])) {
        $admin_username = $_POST['admin_username'];
        $admin_password = $_POST['admin_password'];
        
        $stmt = $pdo->prepare("SELECT * FROM Admin WHERE Username = :username");
        $stmt->execute(['username' => $admin_username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($admin && $admin['Password'] === $admin_password) {
            session_start();
            $_SESSION['admin_id'] = $admin['AdminId'];
            $_SESSION['admin_username'] = $admin['Username'];
            header("Location: admin.php");
            exit();
        } else {
            $admin_error_message = "Invalid admin username or password.";
        }
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM User WHERE Username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['Password'])) {
            session_start();
            $_SESSION['user_id'] = $user['UserId'];
            $_SESSION['username'] = $user['Username'];
            
            header("Location: home_Page.php");
            exit();
        } else {
            $error_message = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
 body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
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

        form {
            width: 300px;
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
        #createAccountBtn {
            background-color: #3498db;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        #forgotPasswordLink {
            display: block;
            text-align: right;
            margin-top: 10px;
            color: #3498db; 
            text-decoration: none;
        }
        #logo {
            max-height: 60px;
            padding: 10px 40px;
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 999;
        }

    </style>
</head>
<body>
    <header>
        <a href="home_Page.php"><img src="Logo.png" alt="Logo" id="logo"></a>
    </header>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Login</h2>
        <?php if(isset($error_message)) { ?>
            <div><?php echo $error_message; ?></div>
        <?php } ?>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>

        <button id="createAccountBtn" onclick="window.open('create_account.html', '_blank')">Create Account</button>
        <a href="forgot_password.html" id="forgot_PasswordLink" target="_blank">Forgot Password?</a>
    </form>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Admin Login</h2>
        <?php if(isset($admin_error_message)) { ?>
            <div><?php echo $admin_error_message; ?></div>
        <?php } ?>
        <label for="admin_username">Username:</label>
        <input type="text" id="admin_username" name="admin_username" required>

        <label for="admin_password">Password:</label>
        <input type="text" id="admin_password" name="admin_password" required>

        <button type="submit" name="admin_login">Admin Login</button>
    </form>
</body>
</html>
