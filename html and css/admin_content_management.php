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

// Check if the "About Us" section exists in the content
if (empty($content['aboutus']) || empty($content['aboutus'][0])) {
    die('No data found for About Us section in content.json');
}


$homepageContent = $content['sections'][0];
$aboutusContent = $content['aboutus'][0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/webicon.png" type="image/png">
    <title>Content Management</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Navigation bar styles */
        nav {
            background-color: #333;
            overflow: hidden;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1;
        }

        nav button {
            background-color: #555;
            border: none;
            color: white;
            padding: 16px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        nav button:hover {
            background-color: #777;
        }

        /* Section styles */
        section {
            padding: 20px;
            margin-top: 70px; /* Adjusted margin to avoid overlapping with the nav menu */
        }

        h2 {
            color: #333;
        }

        /* Chapter styles */
        .chapter {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .chapter h3 {
            margin-bottom: 10px;
        }

        .chapter button {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 8px 12px;
            margin-left: 10px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .chapter button:hover {
            background-color: #c82333;
        }

        /* Dashboard card styles */
        .dashboard-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        /* Dashboard header styles */
        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            margin-top: 70px; /* Adjusted margin to avoid overlapping with the nav menu */
        }

        .main-container {
            display: flex;
            height: 100vh; /* Set a fixed viewport height */
        }

        /* Right side styles */
        .main-content {
            flex: 4; /* 4/5 of the space */
            padding: 20px;
            overflow-y: auto; /* Enable vertical scroll */
            height: 50vh; /* Full viewport height */
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

        .image-container {
            width: 400px; /* Adjust the width as needed */
            height: 150px; /* Adjust the height as needed */
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
            margin-top: 20px; /* Space below the paragraph */
            position: absolute; /* Use absolute positioning */
            right: 0; /* Align to the right of the parent */
            text-align: justify; /* Justify text inside the container */
            padding: 10px; /* Padding inside the container */
        }

        /* Additional styles for consistent button look */
        .chapter-btn {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 8px 12px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .chapter-btn:hover {
            background-color: #c82333;
        }

    </style>
</head>

<body>

    <!-- Navigation bar with buttons -->
    <nav>
        <button><a href="admin_dashboard.php" style="text-decoration: none; color: white;">Home</a></button>
        <button><a href="#" style="text-decoration: none; color: white;">Content Management</a></button>
    </nav>

    <header>
        <h1>Content Management</h1>
    </header>

    <!-- AboutUs Content Management Section -->
    <section>
        <div class="dashboard-card">
            <h2>About Us Content Management</h2>
            <div class="main-content">

                <?php
                foreach ($aboutusContent['images'] as $image) {
                    echo '<div class="image-container">';
                    echo '<img src="' . $image . '" alt="About Us Image">';
                    echo '</div>';
                }
                ?>
            </div>
            <button class="chapter-btn" onclick="editaboutuspage()">Edit About Us page</button>
        </div>
    </section>

    <!-- Homepage Content Management Section -->
    <section>
        <div class="dashboard-card">
            <h2>Homepage Content Management</h2>
            <!-- Main content area -->
            <div class="main-content">
                <div class="content">
                    <h1><?php echo $homepageContent['title']; ?></h1>
                    <p><?php echo $homepageContent['subtext']; ?></p>
                    
                    <!-- Rolling container -->
                    <div id="rollingContainer">
                        <!-- Content inside rolling container -->
                        <?php
                        foreach ($homepageContent['content'] as $paragraph) {
                            echo '<p>' . $paragraph['text'] . '</p>';
                        }
                        ?>
                    </div>
                </div>

                <!-- Display images from the heritage section -->
                <?php
                foreach ($homepageContent['images'] as $image) {
                    echo '<div class="image-container">';
                    echo '<img src="' . $image . '" alt="Heritage Image">';
                    echo '</div>';
                }
                ?>

            </div>
            <button class="chapter-btn" onclick="editHomepage()">Edit Homepage</button>
        </div>
    </section>

    <!-- Chapter Content Management Section -->
    <section>
        <div class="dashboard-card">
            <h2>Chapter Content Management</h2>
            <?php
            $content = json_decode(file_get_contents('content.json'), true);

            foreach ($content['chapters'] as $chapterId => $chapterData) {
                echo "<div class='chapter'>";
                echo "<h3>{$chapterData['title']}</h3>";
                echo "<button onclick='editChapter(\"$chapterId\")'>Edit</button>";
                echo "<button onclick='deleteChapter(\"$chapterId\")'>Delete</button>";
                echo "</div>";
            }
            ?>

            <div class='chapter'>
                <h3>Add New Chapter</h3>
                <button onclick='addChapter()'>Add</button>
            </div>
        </div>
    </section>

    <script>
        function editaboutuspage() {
            // Redirect to the edit homepage page
            window.location.href = 'edit_about_us.php';
        }

        function editHomepage() {
            // Redirect to the edit homepage page
            window.location.href = 'edit_homepage.php';
        }
        
        function editChapter(chapterId) {
            // Redirect to the edit chapter page with the chapter ID
            window.location.href = 'edit_chapter.php?chapter_id=' + chapterId;
        }

        function deleteChapter(chapterId) {

            // Confirm if the admin really wants to delete the chapter
            var confirmDelete = confirm("Are you sure you want to delete this chapter? This action cannot be undone.");
            
            if (confirmDelete) {
                // Send an AJAX request to delete the chapter from content.json
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_chapter.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                
                // Define the data to be sent in the request
                var data = 'chapter_id=' + encodeURIComponent(chapterId);
                
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            // Success
                            alert('Chapter deleted successfully');
                            // Optionally, you can reload the page to reflect the changes
                            location.reload();
                        } else {
                            // Error
                            alert('Failed to delete chapter. Please try again.');
                        }
                    }
                };
            }
            
            // Send the request
            xhr.send(data);
        }

        function addChapter() {
            // Implement the logic to add a new chapter
            window.location.href = 'add_chapter.php';
        }
    </script>

</body>

</html>