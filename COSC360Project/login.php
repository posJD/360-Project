<?php
// Place your PHP code here for handling login authentication
// Define database connection parameters
$host = 'localhost';
$dbname = 'your_database';
$username = 'your_username';
$password = 'your_password';

// Attempt to establish a connection to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Check if the login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the login form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL query to retrieve user information
    $stmt = $pdo->prepare("SELECT * FROM User WHERE Username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify if the user exists and the password matches
    if ($user && password_verify($password, $user['Password'])) {
        // User authentication successful
        // You can set session variables or redirect the user to a dashboard page
        session_start();
        $_SESSION['user_id'] = $user['UserId'];
        $_SESSION['username'] = $user['Username'];
        // Redirect the user to the dashboard or any other page
        header("Location: dashboard.php");
        exit();
    } else {
        // Invalid username or password
        $error_message = "Invalid username or password.";
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
        }
    </style>
</head>
<body>
    <header>
        <img src="Logo.png" alt="Logo" id="logo">
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
    <footer>
        &copy; 2024 DS CSS. All rights reserved.
    </footer>
</body>
</html>
