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

// Check if the chapter ID is provided in the URL
if (isset($_GET['chapter_id'])) {
    $chapterId = $_GET['chapter_id'];

    // Check if the chapter exists
    if (isset($content['chapters'][$chapterId])) {
        $chapterData = $content['chapters'][$chapterId];
    } else {
        die('Chapter not found');
    }
} else {
    die('Invalid request');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($chapterData['title']); ?></title>
    <link rel="icon" href="images/webicon.png" type="image/png">
    <style>
        body, ul {
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
            background: url('images/Portugal.jpeg') no-repeat center center fixed;
            background-size: cover;
            overflow: auto;
            position: relative;
            backdrop-filter: blur(3px);
        }

        nav {
            background-color: #333;
            overflow: hidden;
            position: relative;
            padding: 0; /* Added to remove default padding */
            margin: 0; /* Added to remove default margin */
        }

        nav button {
            background-color: #555;
            border: none;
            color: white;
            padding: 14px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 0; /* Remove default margin to prevent gaps */
            line-height: normal; /* Adjust line height if necessary */
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

        .body2 {
            text-align: center;
            font-family: 'Arial', sans-serif;
        }

        #story-container {
          max-width: 1000px;
          text-align: center;
          padding: 40px;
          border: 2px solid #333;
          background-color: #fff;
          margin: auto; /* Add this line to center the container */
        }

        #arrow-container {
            margin-top: 20px;
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
        }

        .arrow {
            font-size: 20px;
            cursor: pointer;
            margin: 10px 9px;
        }

        .arrow-fill {
            display: inline-block;
            width: 30px; /* Adjust the width as needed */
            height: 30px; /* Adjust the height as needed */
            background-color: #3498db; /* Add your desired arrow color */
            border-radius: 50%; /* Make it a circle */
            color: white; /* Text color inside the circle */
            text-align: center;
            line-height: 30px; /* Center the text vertically */
        }

        .arrow:hover .arrow-fill {
          background-color: #2980b9; /* Change the color on hover */
        }

        .scene-img {
          max-width: 100%;
          height: auto;
          margin-bottom: 20px;
        }

        .scene-text {
          text-align: justify;
        }

        .video-container {
          position: relative;
          width: 100%;
          padding-bottom: 56.25%; /* 16:9 aspect ratio */
          margin-bottom: 20px;
        }

        .video-container iframe {
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
        }

        .gradient-button:hover {
          background: linear-gradient(to right, #020202, #000000); /* Change the colors as needed */
        }

      .button-container {
              display: flex;
              justify-content: center;
              margin-top: 20px;
              margin-left: 20px;
          }

      .gradient-button {
          background: linear-gradient(to right, #0d0e0d, #0c0c0c); /* Adjust gradient colors */
          border: none;
          color: white;
          padding: 10px 20px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 20px;
          border-radius: 5px;
          cursor: pointer;
        }

        .button-container2 {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-right: 30px;
        }

        .gradient-button2 {
            background: linear-gradient(to right, #0d0e0d, #0c0c0c); /* Adjust gradient colors */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 30px;
            border-radius: 5px;
            cursor: pointer;
        }

        .button-container a {
            margin: 0 10px; /* Adjust the value to control the amount of space */
        }

        .f-l {
            float: left;
        }
        
        .f-r {
            float: right;
        }


        .transparent-box {
            background-color: rgba(255, 255, 255, 0.5); /* Set the background color with transparency */
            padding: 10px; /* Adjust padding as needed */
            border-radius: 5px; /* Optional: Add rounded corners to the box */
            display: inline-block;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <nav>
        <button><a href="index.php" style="text-decoration: none; color: white;">Home</a></button>
        <button><a href="Story.php" style="text-decoration: none; color: white;">Story</a></button>
        <button onclick="checkLoginAndRedirect()">Challenge</button>
        <button><a href="aboutUs.php" style="text-decoration: none; color: white;">About Us</a></button>
        <button id="signInButton"><a href="SignIn.html" style="text-decoration: none; color: white;">Sign In</a></button>
        <button><a href="Admin.php" style="text-decoration: none; color: white;">Contributors</a></button>
        <button id="logoutButton" style="display:none;">Log Out</button>
    </nav>

    <button type="button" onclick="window.location.href='Story.php'">Close</button>

    <div class="body2">
        <h1 span class="transparent-box"><?php echo htmlspecialchars($chapterData['title']); ?></span></h1>
    </div>

    <div id="story-container">        
        <?php
        // Loop through content of the chapter
        foreach ($chapterData['content'] as $section) {
            echo '<div class="section">';

            // Display images if available
            if (!empty($section['images'])) {
                echo '<img src="' . htmlspecialchars($section['images']) . '" alt="Content Image Preview" class="scene-img">';
            }
            
            // Display heading if available
            if (!empty($section['heading'])) {
                echo '<h1>' . htmlspecialchars($section['heading']) . '</h2>';
            }

            // Display text if available
            if (!empty($section['text'])) {
                echo '<p class="scene-text">' . htmlspecialchars($section['text']) . '</p>';
            }

            echo '<br><br></div>';
            
        }
        ?>

        <?php
            // Display video if available
            if (!empty($chapterData['video'])) {
                echo '<div class="video-container">';
                echo '<iframe width="480" height="270" src="' . $chapterData['video'] . '" frameborder="0" allowfullscreen></iframe>';
                echo '</div>';
                echo '<p class="scene-text"><strong>WATCH THIS VIDEO!!!</strong></p>';
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