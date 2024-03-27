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
    $tags = $_POST['tags'];

    if ($_FILES['image']['size'] > 0) {
        $img_content = file_get_contents($_FILES['image']['tmp_name']);
        $img_username = $_SESSION['username'];

        $stmt_img = $pdo->prepare("INSERT INTO Images (Username, ImgFile, UserId) VALUES (:username, :img_content, :user_id)");
        $stmt_img->execute(['username' => $img_username, 'img_content' => $img_content, 'user_id' => $user_id]);
        $img_id = $pdo->lastInsertId();
    } else {
        $img_id = null;
    }

    $stmt_thread = $pdo->prepare("INSERT INTO Threads (Title, Tags, Content, UserId, ImageId) VALUES (:title, :tags, :content, :user_id, :image_id)");
    $stmt_thread->execute(['title' => $_POST['postTitle'], 'tags' => $tags, 'content' => $post_content, 'user_id' => $user_id, 'image_id' => $img_id]);

    header("Location: home_Page.php");
    exit();
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
        <!-- Your header content here -->
    </header>
    <main>
        <form method="post" enctype="multipart/form-data"> <!-- Updated enctype for file upload -->
            <label for="postTitle">Title:</label>
            <input type="text" id="postTitle" name="postTitle" required>
            <br>
            <label for="postContent">Post Content:</label>
            <textarea id="postContent" name="postContent" rows="6" required></textarea>
            <br>
            <div id="imageContainer">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*"> <!-- Input for image upload -->
            </div>
            <br>
            <label for="tags">Tags:</label>
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

        function addTag() {
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
    </script>
</body>
</html>
