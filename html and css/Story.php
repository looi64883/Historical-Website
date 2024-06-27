<?php
$jsonContent = file_get_contents('content.json');

if ($jsonContent === false) {
    die('Error reading content.json file');
}

$content = json_decode($jsonContent, true);

// Check if there are any chapters and sections in the content
if (empty($content['chapters']) && empty($content['sections'])) {
    die('No chapters or sections found in content.json');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Story Page</title>
    <link rel="icon" href="images/webicon.png" type="image/png">
    <style>
        /* Reset some default browser styles */
        body, ul {
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            background: url('images/2.jpg') no-repeat center center fixed;
            background-size: cover;
            overflow: auto;
            position: relative;
            backdrop-filter: blur(3px);
        }

        nav {
            background-color: #333;
            overflow: hidden;
            position: relative;
        }

        nav button {
            background-color: #555;
            border: none;
            color: white;
            padding: 16px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        nav button:hover {
            background-color: #777;
        }

        nav button:not(:last-child) {
            margin-right: 10px;
        }

        nav button:last-child {
            margin-left: auto;
        }

        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            height: auto;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes zoom {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .chapter-button {
            display: block;
            margin: 8px 8px 70px;
            flex-basis: calc(33.333% - 20px);
            text-align: center;
            animation: float 3s ease-in-out infinite, zoom 6s ease-in-out infinite;
        }

        .chapter-button img {
            width: 75%;
            height: auto;
        }

        .chapter-button span {
            display: block; /* Ensures the text appears below the image */
            text-align: center; /* Centers the text */
            margin-top: 5px; /* Space between image and text */
            color: #000; /* Text color */
            font-size: 16px; /* Adjust font size as needed */
        }
    </style>

</head>
<body>

    <nav>
        <button><a href="index.php" style="text-decoration: none; color: white;">Home</a></button>
        <button>Story</button>
        <button onclick="checkLoginAndRedirect()">Challenge</button>
        <button><a href="aboutUs.php" style="text-decoration: none; color: white;">About Us</a></button>
        <button id="signInButton"><a href="SignIn.html" style="text-decoration: none; color: white;">Sign In</a></button>
        <button><a href="Admin.php" style="text-decoration: none; color: white;">Contributors</a></button>
        <button id="logoutButton" style="display:none;">Log Out</button>
    </nav>

    <div class="button-container">
        <?php
        // Loop through each chapter in the content
        foreach ($content['chapters'] as $chapterId => $chapterData) {
            $chapterLink = "chapter.php?chapter_id={$chapterId}"; // Include the chapter ID in the link

            echo '<a href="' . $chapterLink . '" class="chapter-button">';
            echo '<img src="' . $chapterData['storyimage'] . '" alt="' . $chapterId . '">';
            echo '<span>' . $chapterData['title'] . '</span>';
            echo '</a>';
            echo '<br>';
        }
        ?>
    </div>

    <script>
        window.onload = function() {
    
        updateLoginStatus();

        var logoutButton = document.getElementById("logoutButton");
        // Add event listener for logout button
        logoutButton.addEventListener('click', function() {
            var confirmLogout = confirm("Are you sure you want to log out?");
            if (confirmLogout) {
                // Reset session storage for user details and login status
                sessionStorage.setItem("userEmail", "guest@gmail.com");
                sessionStorage.setItem("userName", "guest");
                sessionStorage.setItem("userPassword", "0000");
                sessionStorage.setItem("isLoggedIn", "false"); // Set as a string "false"
                window.location.href = 'index.php';

                updateLoginStatus();

                alert("You have been successfully logged out.");
            }
        });
    };

    function updateLoginStatus() {
        var isLoggedIn = sessionStorage.getItem("isLoggedIn") === "true"; // Ensure the correct evaluation
        var signInButton = document.getElementById("signInButton");
        var logoutButton = document.getElementById("logoutButton");

        if (isLoggedIn) {
            signInButton.style.display = 'none';
            logoutButton.style.display = 'inline-block';
        } else {
            signInButton.style.display = 'inline-block';
            logoutButton.style.display = 'none';
        }
    }

    function checkLoginAndRedirect() {
        var isLoggedIn = sessionStorage.getItem("isLoggedIn") === "true"; // Ensure the correct evaluation
        if (isLoggedIn) {       
            window.location.href = 'historicalgame.html'; // Redirect to Challenge page
        } else {
            // Show pop-up message
            var confirmBox = confirm("You need to be logged in to access the Challenge. Do you want to log in?");
            if (confirmBox == true) {
                window.location.href = 'SignIn.html'; // Redirect to Sign In page
            }
        }
    }
    </script>
</body>
</html>