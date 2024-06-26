
<?php
session_start();

include 'config.php';

$user = null; 

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT * FROM User WHERE UserId = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
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

        .user-image-button {
            width: 40px; 
            height: 40px; 
            border-radius: 50%
            margin-left: 10px;
        }

        main {
            padding: 20px;
        }

        .discussion {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .discussion h2 {
            margin-top: 0;
        }

        .help-button {
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        #logo {
            max-height: 60px;
            padding: 10px 40px;
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
    </style>
</head>

<body>
<header>
    <img src="Logo.png" alt="Logo" id="logo">
    <nav>
        <a href="CreatePost.php">New Post</a>
        <a href="Admin.php">Admin</a>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search by tag...">
            <button onclick="searchByTag()">Search</button>
        </div>
        <?php if(isset($_SESSION['user_id'])) : ?>
            <a href="logout.php">Logout</a>
        <?php else : ?>
            <a href="create_account.php" id="create_account">Create Account</a>
            <a href="login.php" id="login">Login</a>
        <?php endif; ?>
        <a href="AccountOverview.php">
            <img src="<?php echo $user['ImageId'] ? 'getImage.php?id='.$user['ImageId'] : 'UserImage.jpeg'; ?>" alt="User Image" class="user-image-button">
        </a>
    </nav>
</header>



    <main id="discussionContainer">
    <?php
       $sql = "SELECT t.ThreadId, t.Title, t.Content, GROUP_CONCAT(DISTINCT tg.TagName SEPARATOR ', ') AS Tags 
       FROM Threads t
       LEFT JOIN ThreadTag tt ON t.ThreadId = tt.ThreadId
       LEFT JOIN Tags tg ON tt.TagId = tg.TagId
       GROUP BY t.ThreadId
       ORDER BY t.Time DESC";

        $stmt = $pdo->query($sql);

        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="discussion" data-tags="' . $row["Tags"] . '" data-thread-id="' . $row["ThreadId"] . '">';
                echo '<h2>' . $row["Title"] . '</h2>';
                echo '<p>' . $row["Content"] . '</p>';
                echo '</div>';
            }
        } else {
            echo "No discussions found.";
        }
        ?>
    </main>
    </main>

    <footer>
        <nav>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Cookie Policy</a>
            &copy; 2024 DS CSS. All rights reserved.
        </nav>
    </footer>
    <script>
        function searchByTag() {
            var searchQuery = document.getElementById("searchInput").value.toLowerCase();

            
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        
                        var discussions = JSON.parse(xhr.responseText);
                        
                        displayDiscussions(discussions);
                    } else {
                        console.error('Error:', xhr.statusText);
                    }
                }
            };
            xhr.open('GET', 'search.php?searchQuery=' + searchQuery, true);
            xhr.send();
        }

       
        function displayDiscussions(discussions) {
            var discussionContainer = document.getElementById("discussionContainer");
            discussionContainer.innerHTML = ""; 
            discussions.forEach(function (discussion) {
                var discussionHTML = '<div class="discussion">';
                discussionHTML += '<h2>' + discussion.title + '</h2>';
                discussionHTML += '<p>' + discussion.content + '</p>';
                discussionHTML += '</div>';
                discussionContainer.innerHTML += discussionHTML;
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
        var discussions = document.querySelectorAll('.discussion');
        discussions.forEach(function (discussion) {
            discussion.addEventListener('click', function () {
                var threadId = discussion.getAttribute('data-thread-id');
                window.location.href = 'PostFurtherDetail.php?threadId=' + threadId;
            });
        });
    });
    </script>
</body>
</html>

