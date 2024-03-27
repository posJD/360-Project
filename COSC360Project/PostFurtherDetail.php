<?php
include 'config.php';

session_start();

if (isset($_GET['threadId'])) {
    $threadId = $_GET['threadId'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }

        $commentContent = $_POST['comment'];
        $username = $_SESSION['username'];

        try {
            $sql = "INSERT INTO Comments (ThreadId, Username, Content) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$threadId, $username, $commentContent]);
            echo "Comment posted successfully.";
            header("Location: PostFurtherDetail.php?threadId=$threadId");
            exit();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    try {
        $sql = "SELECT Threads.*, User.Username, Images.ImgFile FROM Threads 
                INNER JOIN User ON Threads.UserId = User.UserId 
                LEFT JOIN Images ON Threads.ImageId = Images.ImageId
                WHERE ThreadId = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$threadId]);

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $title = $row['Title'];
            $content = $row['Content'];
            $postDate = $row['Time'];
            $username = $row['Username'];
            $imgFile = $row['ImgFile'];
            $tags = $row['Tags'];

            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Post Detail</title>
                <link rel="stylesheet" href="PostFurtherDetail.css">
            </head>
            <body>
                <header>
                    <a href="home_Page.php">
                        <img src="Logo.png" alt="Logo">
                    </a>
                    <a href="login.php">
                        <img src="UserImage.jpeg" alt="User Image Logo Button" id="user-image-logo-button">
                    </a>
                </header>
                <main>
                    <div class="post-container">
                        <div class="post">
                            <h2 class="post-title"><?php echo $title; ?></h2>
                            <?php if ($imgFile) : ?>
                                <img class="post-image" src="data:image/jpeg;base64,<?php echo base64_encode($imgFile); ?>" alt="Post Image">
                            <?php endif; ?>
                            <p class="post-content"><?php echo $content; ?></p>
                            <p class="post-info">Posted by: <span id="postUsername"><?php echo $username; ?></span> on <span id="postDate"><?php echo $postDate; ?></span></p>
                            <?php if ($tags) : ?>
                                <p class="post-tags">Tags: <?php echo $tags; ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="comments-section">
                            <h3>Comments</h3>
                            <?php

                            $sql = "SELECT * FROM Comments WHERE ThreadId = ?";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute([$threadId]);
                            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if ($comments) {
                                foreach ($comments as $comment) {
                                    echo '<div class="comment">';
                                    echo '<p class="comment-info">Commented by: ' . $comment['Username'] . ' on ' . $comment['Time'] . '</p>';
                                    echo '<p class="comment-text">' . $comment['Content'] . '</p>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>No comments yet.</p>';
                            }
                            ?>
                        </div>

                        <div class="comment-form">
                            <h3>Post a Comment</h3>
                            <?php if (isset($_SESSION['username'])) : ?>
                                <form method="POST" action="PostFurtherDetail.php?threadId=<?php echo $threadId; ?>">
                                    <textarea name="comment" rows="4" required></textarea>
                                    <button type="submit">Post Comment</button>
                                </form>
                            <?php else : ?>
                                <p>Please <a href="login.php">login</a> to comment.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <footer>
                        &copy; 2024 DS CSS. All rights reserved.
                    </footer>
                </main>
                </body>
            </html>
            <?php
        } else {
            echo "Post not found.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
