<?php

$servername ='localhost';
$dbname = 'db_86043593';
$username = '86043593';
$password = '86043593';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$searchQuery = $_GET['searchQuery'];


$sql = "SELECT * FROM Threads WHERE Tags LIKE '%$searchQuery%'";
$result = $conn->query($sql);

$discussions = array();

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
        $discussion = array(
            'title' => $row['Title'],
            'content' => $row['Content']
            
        );
        array_push($discussions, $discussion);
    }
}


$conn->close();


header('Content-Type: application/json');
echo json_encode($discussions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Page / Tag Page</title>
    <style>
         body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #2c3e50;
        }
       
        nav a {
            color: white;
            text-decoration: none;
            padding: 10px;
            margin-right: 10px;
        }
        .help-button {
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .search-results {
            margin-top: 20px;
            padding: 0 20px;
        }
        .search-results h2 {
            margin-bottom: 10px;
        }
        .post {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 10px;
        }
        .post h3 {
            margin-top: 0;
        }
        .post p {
            margin-bottom: 0;
        }
        footer {
            background-color: #2c3e50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            position: fixed;
            bottom: 0%;
            width: 100%;
            height: 5%;


        }
        
        nav a {
            color: white;
            text-decoration: none;
            padding: 10px;
            margin-right: 10px;
        }
        #logo {
            max-height: 60px;
            padding: 10px 40px;
        }
        .search-bar {
            display: flex;
            align-items: center;
        }

        .search-bar input[type="text"] {
            width: 300px;
            padding: 8px;
            border: none;
            border-radius: 4px;
        }

        .search-bar button {
            background-color: #3498db;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

    </style>
</head>
<body>
    <header>

        <img src="Logo.png" alt="Logo" id="logo">
         <nav>

            <a href="#">Discussions</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
            <div class="search-bar">
                <input type="text" placeholder="Search...">
                <button>Search</button>
            </div>
            <a href="create_account.html" id="create_account" target="_blank">Create Account</a>
            <a href="login.html" id="login" target="_blank">Login</a>
            <button class="help-button">Help</button>
        </nav>
        </header>
    <div class="search-results">
        <h2>Search Results</h2>
        <?php foreach ($discussions as $discussion): ?>
            <div class="post">
                <h3><?php echo $discussion['title']; ?></h3>
                <p><?php echo $discussion['content']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <footer>
        <nav>
            
            &copy; 2024 DS CSS. All rights reserved.
        </nav>
    </footer>
</body>
</html>

