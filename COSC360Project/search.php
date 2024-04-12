<?php
include 'config.php';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : '';

$sql = "SELECT t.Title, t.Content
        FROM Threads t
        INNER JOIN ThreadTag tt ON t.ThreadId = tt.ThreadId
        INNER JOIN Tags tg ON tt.TagId = tg.TagId
        WHERE tg.TagName LIKE '%$searchQuery%'";
$result = $conn->query($sql);

$discussions = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $discussion = array(
            'title' => $row['Title'],
            'content' => $row['Content']
        );
        array_push($discussions, $discussion);
    }
} else {
    echo "No discussions found.";
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($discussions);
?>
