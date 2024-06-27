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

// Check if the "Exploring Malaysia Heritage" section exists in the content
if (empty($content['sections']) || empty($content['sections'][0])) {
    die('No data found for "Exploring Malaysia Heritage" section in content.json');
}

$heritageSection = $content['sections'][0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historical Webpage</title>
    <link rel="icon" href="images/webicon.png" type="image/png">

    <style>
        /* Reset some default browser styles */
        body, ul, nav {
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #d3cfcf; /* Set the background to grey */
            font-family: 'Arial', sans-serif;
            overflow: hidden; /* Prevent body from scrolling */
        }

        /* Create a navigation bar with solid buttons */
        nav {
            background-color: #333; /* Background color for the navbar */
            overflow: hidden;
            position: relative; /* Position relative for stacking */
        }

        /* Style for the buttons */
        nav button {
            background-color: #555; /* Button background color */
            border: none;
            color: white;
            padding: 16px 32px; /* Increased padding */
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px; /* Increased font size */
            cursor: pointer;
            transition: background-color 0.3s ease; /* Add a smooth transition */
        }

        /* Hover effect for buttons */
        nav button:hover {
            background-color: #777; /* Darker color on hover */
        }

        /* Add some space between buttons */
        nav button:not(:last-child) {
            margin-right: 10px;
        }

        /* Align the "Sign In" button to the right */
        nav button:last-child {
            margin-left: auto;
        }

        .main-container {
            display: flex;
            height: 100vh; /* Set a fixed viewport height */
        }

        /* Left side styles */
        .sidebar {
            flex: 1; /* 1/5 of the space */
            background-color: #f4f4f4; /* Background color for sidebar */
            padding: 10px;
            overflow-y: auto; /* Enable vertical scroll */
            height: 100vh; /* Full viewport height */
            padding-bottom: 50px;
        }

        /* Right side styles */
        .main-content {
            flex: 4; /* 4/5 of the space */
            padding: 20px;
            overflow-y: auto; /* Enable vertical scroll */
            height: 100vh; /* Full viewport height */
        }

        /* Image button styles */
        .img-btn {
            background-color: #ddd; /* Background color for buttons */
            border: none;
            margin-bottom: 3px; /* Reduced bottom margin */
            cursor: pointer;
            padding: 100px 140px; /* Increased padding */
            text-align: left;
        }

        /* Style for button labels */
        .sidebar p {
            margin: 0; /* Remove default margin */
            padding: 5px 0; /* Add some padding */
            text-align: center; /* Center text */
            font-size: 14px; /* Adjust font size */
        }

        .image-container {
            width: 400px; /* Adjust the width as needed */
            height: 200px; /* Adjust the height as needed */
            margin: 10px; /* Add margin for spacing */
            overflow: hidden; /* Hide content that exceeds the container dimensions */
            display: flex; /* Use flexbox for centering image vertically */
            align-items: center; /* Center vertically */
            justify-content: center; /* Center horizontally */
            cursor: pointer;
        }

        /* Style for images inside the containers */
        .image-container img {
            max-width: 100%;
            max-height: 100%;
        }

        /* Content styling */
        .content {
            position: relative; /* Needed for absolute positioning of child */
            text-align: center;
        }

        /* Rolling container styles */
        #rollingContainer {
            width: 60%; /* Set to 60% of the parent element's width */
            background-color: #f5f5dc; /* Background color */
            overflow: hidden; /* Hide content out of bounds */
            transition: transform 0.5s ease; /* Smooth transition for rolling effect */
            transform: translateX(100%); /* Start off the screen */
            margin-top: 20px; /* Space below the paragraph */
            position: absolute; /* Use absolute positioning */
            right: 0; /* Align to the right of the parent */
            text-align: justify; /* Justify text inside the container */
            padding: 10px; /* Padding inside the container */
        }
    </style>
</head>
<body>
    
    <!-- Navigation bar with buttons -->
    <nav>
        <button>Home</button>
        <button><a href="Story.php" style="text-decoration: none; color: white;">Story</a></button>
        <button onclick="checkLoginAndRedirect()">Challenge</button>
        <button><a href="aboutUs.php" style="text-decoration: none; color: white;">About Us</a></button>
        <button id="signInButton"><a href="SignIn.html" style="text-decoration: none; color: white;">Sign In</a></button>
        <button id="adminLoginButton"><a href="adminLogin.html" style="text-decoration: none; color: white;">Admin Login</a></button>
        <button><a href="Admin.php" style="text-decoration: none; color: white;">Contributors</a></button>
        <button id="logoutButton" style="display:none;">Log Out</button>
    </nav>

    <div class="main-container">
        <div class="sidebar">
            <?php
            // Loop through each chapter in the content
            foreach ($content['chapters'] as $chapterId => $chapterData) {
                $chapterLink = "{$chapterId}.php"; // Adjust the link format based on your filenames

                echo '<a href="' . $chapterLink . '">';
                echo '<button class="img-btn" style="background-image: url('. $chapterData['mainimage'] .'); background-size: cover; background-position: center;"></button>';
                echo '<p>' . $chapterData['title'] . '</p>';
                echo '</a>';
                echo '<br><br><br>';
            }
            ?>
        </div>

        <!-- Main content area -->
        <div class="main-content">
            <div class="content">
                <h1><?php echo $heritageSection['title']; ?></h1>
                <p><?php echo $heritageSection['subtext']; ?></p>
                
                <!-- Rolling container -->
                <div id="rollingContainer">
                    <!-- Content inside rolling container -->
                    <?php
                    foreach ($heritageSection['content'] as $paragraph) {
                        echo '<p>' . $paragraph['text'] . '</p>';
                    }
                    ?>
                </div>
            </div>

            <!-- Display images from the heritage section -->
            <?php
            foreach ($heritageSection['images'] as $image) {
                echo '<div class="image-container">';
                echo '<img src="' . $image . '" alt="Heritage Image">';
                echo '</div>';
            }
            ?>
        </div>

        

    <!-- JavaScript for Rolling Effect -->
    <script>
        window.onload = function() {
        // Initialize rolling container
        setTimeout(function() {
            var container = document.getElementById("rollingContainer");
            if (container.style.transform === "translateX(100%)" || container.style.transform === "") {
                container.style.transform = "translateX(3%)";
            }
        }, 100);

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



