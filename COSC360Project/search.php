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
