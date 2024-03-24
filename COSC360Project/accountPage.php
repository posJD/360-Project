<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 50%;
        }

        h3 {
            margin-top: 10px;
        }

        #userBio {
            margin-top: 10px;
            font-style: italic;
        }

        #userActivity {
            margin-top: 20px;
        }

        .post {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 10px;
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
    
    <?php
    
    $servername = 'localhost';
    $username = '86043593';
    $password = '86043593';
    $dbname = 'db_86043593';

    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    session_start(); 
    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $sql = "SELECT User.*, Images.ImgFile FROM User LEFT JOIN Images ON User.ImageId = Images.ImageId WHERE Username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                echo "<div class='container'>";
                echo "<h2>Account Page</h2>";
                echo "<img src='data:image/jpeg;base64," . base64_encode($row['ImgFile']) . "' alt='Profile Image'>";
                echo "<h3>Username: " . $row["Username"] . "</h3>";
                echo "<p id='userBio'>Bio: " . $row["Bio"] . "</p>";
                echo "<div id='userActivity'>";
                echo "<h4>User Activity</h4>";
                echo "<p>Recent comments and posts...</p>";

                
                $userId = $row["UserId"];
                $sql_posts = "SELECT * FROM Threads WHERE UserId = $userId ORDER BY Time DESC LIMIT 5";
                $result_posts = $conn->query($sql_posts);
                if ($result_posts->num_rows > 0) {
                    
                    while($row_posts = $result_posts->fetch_assoc()) {
                        echo "<div class='post'>";
                        echo "<h3>" . $row_posts["Title"] . "</h3>";
                        echo "<p>" . $row_posts["Content"] . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "No recent posts.";
                }
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "User not found.";
        }
    } else {
        echo "You are not logged in.";
    }


    $conn->close();
    ?>
    
    <footer>
        &copy; 2024 DS CSS. All rights reserved.
    </footer>   
</body>
</html>
