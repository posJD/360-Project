<?php
require 'config.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['username'])) {
        $username = $_GET['username'];
        $stmt = $pdo->prepare("SELECT * FROM User WHERE Username LIKE ? ");
        $stmt->execute(["%$username%"]);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            echo "<tr>
                    <td>{$user['Name']}</td>
                    <td>{$user['Email']}</td>
                    <td>{$user['Username']}</td>
                    <td class='user-actions'>
                        <button class='enable-btn action-btn'>Enable</button>
                        <button class='disable-btn action-btn'>Disable</button>
                    </td>
                </tr>";
        }
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
