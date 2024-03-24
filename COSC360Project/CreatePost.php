<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $stmt = $conn->prepare("INSERT INTO Threads (Title, Tags, Content, UserId) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $title, $tags, $content, $userId);

    $title = $_POST["postTitle"];
    $tags = $_POST["tags"];
    $content = $_POST["postContent"];
    $userId = 1; 

    $stmt->execute();

    $stmt->close();

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
        <a href="home_Page.html">
            <img src="Logo.png" alt="Logo" id="logo">
        </a>
        <a href="login.html">
            <img src="UserImage.jpeg" alt="User Image" class="user-image-button">
        </a>
        <h1>Create a Post</h1>
    </header>
    <main>
        <form method="post">
            <label for="postTitle">Title:</label>
            <input type="text" id="postTitle" name="postTitle" required>
            <br>
            <label for="postContent">Post Content:</label>
            <textarea id="postContent" name="postContent" rows="6" required></textarea>
            <br>
            <div id="imageContainer">
                <label for="image">Image:</label>
                <input type="file" id="image" name="image" accept="image/*" onchange="previewImage()">
                <button type="button" class="deleteImageButton" onclick="deleteImage()">X</button>
                <div id="imagePreview"></div>
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
