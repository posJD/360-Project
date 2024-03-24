<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Overview</title>
    <link rel="stylesheet" href="AccountOverview.css">
</head>
<body>
    <header>
        <a href="home_Page.php">
            <img src="Logo.png" alt="Logo">
        </a>
        <a href="login.php">
            <img src="UserImage.jpeg" alt="User Image" class="user-image-button">
        </a>
    </header>
    <main>
        <nav>
            <a href="#">Home</a>
            <a href="#">Profile</a>
            <a href="#">Settings</a>
        </nav>
        <div class="profile-container">
            <img src="UserImage.jpeg" alt="Profile Image" class="profile-image">
            <div class="user-info">
                <h2>Name: <?php echo htmlspecialchars($user['Name']); ?>
                    <button onclick="editName()">Edit</button>
                </h2>
                <p>Email: <?php echo htmlspecialchars($user['Email']); ?>
                    <button onclick="editEmail()">Edit</button>
                </p>
                <p>Username: <?php echo htmlspecialchars($user['Username']); ?>
                    <button onclick="editUsername()">Edit</button>
                </p>
                <p>Date of Birth: <?php echo htmlspecialchars($user['DOB']); ?>
                    <button onclick="editDob()">Edit</button>
                </p>
                <p>Bio: <?php echo htmlspecialchars($user['Bio']); ?>
                    <button onclick="editBio()">Edit</button>
                </p>
            </div>
        </div>
    </main>
    <footer>
        &copy; 2024 DS CSS. All rights reserved.
    </footer>
    <script>
        function editName() {
            var newName = prompt("Enter new name:");
            if (newName != null) {
                window.location.href = "update_info.php?type=name&value=" + newName;
            }
        }

        function editEmail() {
            var newEmail = prompt("Enter new email:");
            if (newEmail != null) {
                window.location.href = "update_info.php?type=email&value=" + newEmail;
            }
        }

        // Repeat similar edit functions for other fields (username, dob, bio)
    </script>
</body>
</html>
