<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $post_content = $_POST['postContent'];
    $tags = isset($_POST['tags']) ? $_POST['tags'] : "";

    if ($_FILES['image']['size'] > 0) {
        $img_content = file_get_contents($_FILES['image']['tmp_name']);
        $img_username = $_SESSION['username'];

        try {
            $stmt_img = $pdo->prepare("INSERT INTO Images (ImgFile, UserId) VALUES (?, ?)");
            $stmt_img->execute([$img_content, $user_id]);
            $img_id = $pdo->lastInsertId();
        } catch (PDOException $e) {
            echo "Error inserting image: " . $e->getMessage();
            exit();
        }
    } else {
        $img_id = null;
    }

    try {
        $stmt_thread = $pdo->prepare("INSERT INTO Threads (Title, Content, UserId, ImageId) VALUES (?, ?, ?, ?)");
        $stmt_thread->execute([$_POST['postTitle'], $post_content, $user_id, $img_id]);
        $thread_id = $pdo->lastInsertId();

        $tag_array = explode(",", $tags);
        foreach ($tag_array as $tag) {
            $tag = trim($tag);
            if (!empty($tag)) {
                $stmt_tag_check = $pdo->prepare("SELECT TagId FROM Tags WHERE TagName = ?");
                $stmt_tag_check->execute([$tag]);
                $existing_tag = $stmt_tag_check->fetchColumn();

                if (!$existing_tag) {
                    $stmt_insert_tag = $pdo->prepare("INSERT INTO Tags (TagName) VALUES (?)");
                    $stmt_insert_tag->execute([$tag]);
                    $tag_id = $pdo->lastInsertId();
                } else {
                    $tag_id = $existing_tag;
                }
                $stmt_thread_tag = $pdo->prepare("INSERT INTO ThreadTag (ThreadId, TagId) VALUES (?, ?)");
                $stmt_thread_tag->execute([$thread_id, $tag_id]);
            }
        }

        header("Location: home_Page.php");
        exit();
    } catch (PDOException $e) {
        echo "Error inserting thread: " . $e->getMessage();
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a Post</title>
    <link rel="stylesheet" href="CreatePost.css">
</head>
<body>
    <header>
        <a href="home_Page.php">
            <img src="Logo.png" alt="Logo" id="logo">
        </a>
        <a href="AccountOverview.php">
            <img src="UserImage.jpeg" alt="User Image" class="user-image-button">
        </a>
        <h1>Create a Post</h1>
    </header>
    <main>
        <form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="postTitle">Title:</label>
            <input type="text" id="postTitle" name="postTitle" required>
            <br>
            <label for="postContent">Post Content:</label>
            <textarea id="postContent" name="postContent" rows="6" required></textarea>
            <br>
            <div id="imageContainer">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*"> 
            </div>
            <br>
            <label for="tags">Tags (Separate by commas):</label>
            <div id="tagList"></div>
            <input type="text" id="tags" name="tags">
            <br>
            <button type="button" onclick="addTag()">Add Tag</button>
            <button type="submit">Submit Post</button>
        </form>
    </main>
    <footer>
        &copy; 2024 DS CSS. All rights reserved.
    </footer>

    <script>
        function previewImage() {
            var input = document.getElementById('image');
            var preview = document.getElementById('imagePreview');
            
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="Image Preview">';
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.innerHTML = '';
            }
        }

        function deleteImage() {
            var input = document.getElementById('image');
            var preview = document.getElementById('imagePreview');
            input.value = '';
            preview.innerHTML = '';
        }

     /*   function addTag() {
            var tagInput = document.getElementById('tags');
            var tagList = document.getElementById('tagList');

            if (tagInput.value.trim() !== "") {
                var tagDiv = document.createElement('div');
                tagDiv.className = 'tag';
                var tagText = document.createElement('span');
                tagText.className = 'tag-text';
                tagText.textContent = tagInput.value.trim();
                var removeButton = document.createElement('button');
                removeButton.textContent = 'Remove';
                removeButton.addEventListener('click', function () {
                    tagList.removeChild(tagDiv);
                });

                tagDiv.appendChild(tagText);
                tagDiv.appendChild(removeButton);
                tagList.appendChild(tagDiv);

                tagInput.value = "";
            }
        }
        /*
    </script>
</body>
</html>

