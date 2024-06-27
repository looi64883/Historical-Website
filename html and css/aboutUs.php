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
            background-image: url('images/19.jpg'); /* Set the background image */
            background-color: #d3cfcf; /* Set the background color as a fallback */
            background-size: cover; /* Cover the entire page with the image */
            background-repeat: no-repeat; /* Prevent the image from repeating */
            font-family: 'Arial', sans-serif;
            overflow: auto;
            backdrop-filter: blur(3px);
        }

        /* Create a navigation bar with solid buttons */
        nav {
            background-color: #333; /* Background color for the navbar */
            overflow: hidden;
            position: fixed; /* Change to fixed */
            top: 0; /* Align to the top of the viewport */
            left: 0; /* Align to the left of the viewport */
            width: 100%; /* Ensure it stretches across the full viewport width */
            z-index: 2000; /* Ensure it stays on top of other content */
            height: 55px;
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

        .center-pad {
            position: fixed; 
            top: calc(55px + 2%); 
            left: 50%; 
            transform: translate(-50%, -150%);
            opacity: 0;
            width: 1300px; 
            height: 1400px; 
            background-color: rgba(253, 255, 211, 0.9);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000; 
            padding: 20px; 
            box-sizing: border-box; 
            border-radius: 10px; 
            display: block;
            transition: transform 1s ease, opacity 2s ease;
        }

        .center-pad-active {
            transform: translate(-50%, -50%);
            opacity: 1;
        }

        .pad-image {
            margin-top: 670px; /* Adjust this value as needed */
            width: 100%;
            height: auto;
        }


    </style>
</head>
<body>
    <!-- Navigation bar with buttons -->
    <nav>
        <button><a href="index.php" style="text-decoration: none; color: white;">Home</a></button>
        <button><a href="Story.php" style="text-decoration: none; color: white;">Story</a></button>
        <button onclick="checkLoginAndRedirect()">Challenge</button>
        <button><a href="#" style="text-decoration: none; color: white;">About Us</a></button>
        <button id="signInButton"><a href="SignIn.html" style="text-decoration: none; color: white;">Sign In</a></button>
        <button><a href="Admin.php" style="text-decoration: none; color: white;">Contributors</a></button>
        <button id="logoutButton" style="display:none;">Log Out</button>
    </nav>

    <div id="popOutPad" class="center-pad">
        <?php
        // Read and decode the JSON content
        $content = json_decode(file_get_contents('content.json'), true);

        // Check if decoding was successful
        if ($content !== null) {
            $aboutusContent = $content['aboutus'][0];
            
            // Check if there are images in the about us content
            if (!empty($aboutusContent['images'])) {
                // Loop through each image and display it
                foreach ($aboutusContent['images'] as $image) {
                    echo '<div class="image-container">';
                    echo '<img src="' . $image . '" alt="About Us Image" class="pad-image">';
                    echo '</div>';
                }
            } else {
                echo '<p>No images available for About Us.</p>';
            }
        } else {
            echo '<p>Failed to load content. Please try again later.</p>';
        }
        ?>
    </div>

    <script>
        function showPad() {
            var pad = document.getElementById("popOutPad");
            pad.classList.add("center-pad-active");
        }



        window.onload = function() {
            showPad();
    
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