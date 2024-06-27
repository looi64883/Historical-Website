<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Read and decode the JSON content
    $content = json_decode(file_get_contents('content.json'), true);

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

    // Initialize variable to track update status
    $updateStatus = '';

    // Initialize $chapterData for cases where the form is not submitted
    if (!isset($chapterData)) {
        $chapterData = [
            'title' => '',
            'mainimage' => '',
            'storyimage' => '',
            'content' => [],
        ];
    }

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Initialize variable to track update status
        $updateStatus = '';

        // Update the chapter data with the submitted values
        $chapterData['title'] = $_POST['title'];

        // Handle image deletion for main image
        if (!empty($_POST['deletemainImage']) && file_exists($chapterData['mainimage'])) {
            unlink($chapterData['mainimage']);
            $chapterData['mainimage'] = '';
        }

        // Handle image deletion for story image
        if (!empty($_POST['deletestoryImage']) && file_exists($chapterData['storyimage'])) {
            unlink($chapterData['storyimage']);
            $chapterData['storyimage'] = '';
        }

        // Update main image
        if (!empty($_FILES['mainimageUpload']['tmp_name'])) {
            $newMainImage = 'images/' . basename($_FILES['mainimageUpload']['name']);
            move_uploaded_file($_FILES['mainimageUpload']['tmp_name'], $newMainImage);
            $chapterData['mainimage'] = $newMainImage;
        }

        // Update story image
        if (!empty($_FILES['storyimageUpload']['tmp_name'])) {
            $newStoryImage = 'images/' . basename($_FILES['storyimageUpload']['name']);
            move_uploaded_file($_FILES['storyimageUpload']['tmp_name'], $newStoryImage);
            $chapterData['storyimage'] = $newStoryImage;
        }


        // Update content paragraphs
        $updatedContent = [];

        if (isset($_POST['content'])) {
            foreach ($_POST['content'] as $index => $contentData) {
                $newContent = [
                    'heading' => htmlspecialchars($contentData['heading']),
                    'text' => htmlspecialchars($contentData['text']),
                    'images' => $contentData['images'] // Preserve the previous image URL by default
                ];

                // Handle image deletion for content image
                if (!empty($_POST['deleteImage'][$index]) && !empty($newContent['images'])) {
                    // If the delete checkbox is checked and there is an existing image, set the image URL to null
                    $newContent['images'] = '';
                }

                // Handle image upload for content paragraphs (new)
                if (!empty($_FILES['contentImageUpload']['tmp_name'][$index])) {
                    $newContentImage = 'images/' . basename($_FILES['contentImageUpload']['name'][$index]);
                    move_uploaded_file($_FILES['contentImageUpload']['tmp_name'][$index], $newContentImage);
                    $newContent['images'] = $newContentImage;
                }

                // // Update content image (old) which cannot function
                // if (!empty($_FILES['contentImageUpload'][$index]['tmp_name'])) {
                //     $newContentImage = 'images/' . basename($_FILES['contentImageUpload'][$index]['name']);
                //     move_uploaded_file($_FILES['contentImageUpload'][$index]['tmp_name'], $newContentImage);
                //     $newContent['images'] = $newContentImage;
                // }

                // // Handle content image upload and update the file path
                // if (!empty($_FILES['contentImageUpload'][$index]['tmp_name'])) {
                //     $contentImagePath = 'images/new_content_image_' . $index . '.jpg'; // Replace with your actual image handling logic
                //     $newContent[$index]['images'] = $contentImagePath;

                // }


                $updatedContent[] = $newContent;
            }
        }

        // Update the video URL
        if (isset($_POST['video_url'])) {
            $videoUrl = htmlspecialchars($_POST['video_url']);
            $chapterData['video'] = $videoUrl;
        }

        // // Update the content JSON file
        $chapterData['content'] = $updatedContent; // Set the updated content paragraphs
    
        // Update the content JSON file
        $content['chapters'][$chapterId] = $chapterData;
        $updateStatus = file_put_contents('content.json', json_encode($content, JSON_PRETTY_PRINT)) ? 'success' : 'failure';

        // // Redirect to admin_content_management.php after processing the form
        // header("Location: admin_content_management.php");
        // exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/webicon.png" type="image/png">
    <title>Edit Chapter</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        form {
            max-width: 600px;
            margin: auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #333;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
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

        .image-preview {
            margin-bottom: 15px;
            text-align: center;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 200px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .delete-checkbox {
            margin-right: 5px;
        }

        .hidden {
            display: none;
        }
    </style>

    <script>
        function confirmUpdate() {
            return confirm("Are you sure you want to update the content?");
        }
    </script>

    <script>
        function confirmUpdate() {
            return confirm("Are you sure you want to update the content?");
        }

    </script>
</head>

<body>
        <h1>Edit Chapter: <?php echo htmlspecialchars($chapterData['title']); ?></h1>

        <div style="position: relative;">
            <button type="button" onclick="window.location.href='admin_content_management.php'" style="position: absolute; top: 10px; left: 10px;">Close</button>
            <form action="" method="post" enctype="multipart/form-data">

            <!-- Title -->
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($chapterData['title']); ?>" required>
            <br><br>

            <!-- Main Image -->
            <?php if (!empty($chapterData['mainimage'])) : ?>
                <div class="image-preview">
                    <img src="<?php echo htmlspecialchars($chapterData['mainimage']); ?>" alt="Main Image Preview">
                    <input type="checkbox" id="deleteMainImage" name="deletemainImage" value="mainimage">Delete
                </div>
            <?php endif; ?>
            <label for="mainimageUpload">Replace Main Page Image:</label>
            <input type="file" id="mainimageUpload" name="mainimageUpload" accept="image/*">
            <?php
            if (empty($chapterData['mainimage'])) {
                echo '<small>No existing image. Upload Main Page Image will add a new image.</small>';
            } else {
                echo '<small>Upload new image to replace existing Main Page Image.</small>';
            }
            ?>
            <br><br><br><br>

            <!-- Story Image -->
            <?php if (!empty($chapterData['storyimage'])) : ?>
                <div class="image-preview">
                    <img src="<?php echo htmlspecialchars($chapterData['storyimage']); ?>" alt="Story Image Preview">
                    <input type="checkbox" id="deleteStoryImage" name="deletestoryImage" value="storyimage">Delete
                </div>
            <?php endif; ?>
            <label for="storyimageUpload">Replace Story Page Image:</label>
            <input type="file" id="storyimageUpload" name="storyimageUpload" accept="image/*">
            <?php
            if (empty($chapterData['storyimage'])) {
                echo '<small>No existing image. Upload Story Page Image will add a new image.</small>';
            } else {
                echo '<small>Upload new image to replace existing Story Page Image.</small>';
            }
            ?>
            <br><br><br><br>

            <!-- Content Paragraphs -->
            <h3>Content Paragraphs:</h3>
            <?php
            foreach ($chapterData['content'] as $index => $paragraph) {
                echo '<div>';
                echo '<div class="image-preview">';
                
                // Display existing content image if available
                if (!empty($paragraph['images'])) {
                    echo '<img src="' . htmlspecialchars($paragraph['images']) . '" alt="Content Image Preview">';
                    echo '<input type="checkbox" id="deleteContentImage[' . $index . ']" name="deleteImage[' . $index . ']" value="1">Delete';
                    
                } else {
                    echo '<small>No existing image for Content Paragraph ' . ($index + 1) . '. Upload an image to add.</small>';
                }
                echo '</div>';
                
                echo '<label for="contentImages[' . $index . ']">Replace Content Image ' . ($index + 1) . ':</label>';
                echo '<input type="file" id="contentImageUpload[' . $index . ']" name="contentImageUpload[' . $index . ']" accept="image/*">';
                
                // Display heading input
                echo '<label for="heading[' . $index . ']">Heading:</label>';
                echo '<input type="text" id="heading[' . $index . ']" name="content[' . $index . '][heading]" value="' . htmlspecialchars($paragraph['heading']) . '">';
                
                // Display text textarea
                echo '<label for="text[' . $index . ']">Text:</label>';
                echo '<textarea id="text[' . $index . ']" name="content[' . $index . '][text]" rows="4">' . htmlspecialchars($paragraph['text']) . '</textarea>';

                // Display Content Image URL input field (hidden)
                echo '<input class="hidden" type="text" id="contentImageURL[' . $index . ']" name="content[' . $index . '][images]" value="' . htmlspecialchars($paragraph['images']) . '" placeholder="Enter content image URL ' . ($index + 1) . '">';
                                
                echo '<br><br>';
                
                echo '</div>';
            }
            ?>

            <?php
            if (!empty($chapterData['video'])) {
                echo '<div>';
                echo '<iframe width="560" height="315" src="' . htmlspecialchars($chapterData['video']) . '" frameborder="0" allowfullscreen></iframe>';
                echo '</div>';
            } else {
                echo '<small>No video URL provided.</small>';
            }
            ?>
            <!-- Video URL -->
            <label for="video">Video URL:</label>
            <input type="url" id="video" name="video_url" value="<?php echo htmlspecialchars($chapterData['video']); ?>" placeholder="Enter video URL">
            <br><br>

            <!-- Save Changes Button -->
            <button type="submit" name="submit">Save Changes</button>

        </form>
    </div>
</body>
</html>