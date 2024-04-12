<?php
$host = 'localhost';
$dbname = 'db_86043593';
$username = '86043593';
$password = '86043593';
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['admin_id'])) {
    echo "This page is for admins only.";
    exit;
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("SELECT * FROM User");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    
    $stmt = $pdo->query("SELECT 'thread' AS type, Title AS content, Username AS user, Time FROM Threads 
    UNION ALL 
    SELECT 'comment' AS type, Content AS Content, Username AS user, Time FROM Comments 
    ORDER BY Time DESC");
    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            margin: 0;
        }

        main {
            padding: 20px;
        }

        input[type="text"] {
            width: 300px;
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
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        .user-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .action-btn {
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .enable-btn {
            background-color: #4caf50;
            color: white;
        }

        .disable-btn {
            background-color: #e74c3c;
            color: white;
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

        .thread-table {
            margin-top: 20px;
        }

        .thread-table th, .thread-table td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        .thread-table th {
            background-color: #3498db;
            color: white;
        }

        .thread-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <h1>Admin Page</h1>
        <button onclick="window.location.href = 'login.php'">Login</button>
    </header>

    <main>
        <h2>All Users</h2>
        <input type="text" id="searchInput" placeholder="Search by username...">
        <button onclick="searchUsers()">Search</button>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['Name']; ?></td>
                    <td><?php echo $user['Email']; ?></td>
                    <td><?php echo $user['Username']; ?></td>
                    <td class="user-actions">
    <button class="enable-btn action-btn" onclick="enableUser(<?php echo $user['UserId']; ?>)">Enable</button>
    <button class="disable-btn action-btn" onclick="disableUser(<?php echo $user['UserId']; ?>)">Disable</button>
</td>

                </tr>
                <?php endforeach; ?>
            </tbody>
            <h2>Recent Activity</h2>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Content</th>
                    <th>User</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activities as $activity): ?>
                <tr>
                    <td><?php echo $activity['type']; ?></td>
                    <td><?php echo $activity['content']; ?></td>
                    <td><?php echo $activity['user']; ?></td>
                    <td><?php echo $activity['Time']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        &copy; 2024 DS CSS. All rights reserved.
    </footer>

    <script>
        function searchUsers() {
            var searchQuery = document.getElementById("searchInput").value.trim();
            if (searchQuery !== "") {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("userTableBody").innerHTML = this.responseText;
                    }
                };
                xhttp.open("GET", "search_users.php?username=" + searchQuery, true);
                xhttp.send();
            } else {
                alert("Please enter a username to search.");
            }
        }

        function enableUser(userId) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                  
                }
            };
            xhttp.open("GET", "enable_user.php?user_id=" + userId, true);
            xhttp.send();
        }

        function disableUser(userId) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    alert(this.responseText);
                    
                }
            };
            xhttp.open("GET", "disable_user.php?user_id=" + userId, true);
            xhttp.send();
        }
    </script>
</body>
</html>
