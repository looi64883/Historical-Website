<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read and decode the existing content
    $content = json_decode(file_get_contents('content.json'), true);

    // Get the data from the form
    $newChapterData = [
        'title' => $_POST['title'],
        'mainimage' => uploadImage('mainimageUpload', 'images'),
        'storyimage' => uploadImage('storyimageUpload', 'images'),
        'content' => [], // Initialize with empty values, modify as needed
        'video' => $_POST['video'] // Get video URL from the form
    ];

    // Add the new chapter data to the content
    $content['chapters']['chapter' . (count($content['chapters']) + 1)] = $newChapterData;

    // Save content paragraphs
    $contentParagraphs = $_POST['content'];
    $headings = $_POST['heading'];

    // Handle multiple file uploads for content images
    $contentImages = [];
    foreach ($_FILES['contentimageUpload']['name'] as $key => $value) {
        $tempFile = $_FILES['contentimageUpload']['tmp_name'][$key];
        $contentImage = 'images/' . basename($_FILES['contentimageUpload']['name'][$key]);
        if (move_uploaded_file($tempFile, $contentImage)) {
            $contentImages[] = $contentImage;
        }
    }

    foreach ($contentParagraphs as $key => $contentParagraph) {
        $newContentParagraph = [
            'heading' => $headings[$key],
            'text' => $contentParagraph,
            'images' => isset($contentImages[$key]) ? $contentImages[$key] : null
        ];
        $content['chapters']['chapter' . (count($content['chapters']))]['content'][] = $newContentParagraph;
    }

    // Save the updated content back to the file
    if (file_put_contents('content.json', json_encode($content, JSON_PRETTY_PRINT))) {
        $successMessage = "Successful add the chapter.";

    } else {
        $errorMessage = "Failed to add the chapter. Please try again.";

    }
}

function uploadImage($inputName, $targetDirectory)
{
    // Check if the file upload field is empty
    if (empty($_FILES[$inputName]['name'])) {
        return ''; // Return an empty string if no file is selected
    }

    $targetFile = $targetDirectory . '/' . basename($_FILES[$inputName]['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES[$inputName]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES[$inputName]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else { // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFile)) {
            return $targetFile;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    return '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/webicon.png" type="image/png">
    <title>Add New Chapter</title>
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
    </style>
</head>

<body>

    <!-- Your HTML form for adding a new chapter -->
    <h1>Add New Chapter</h1>
    <div style="position: relative;">
            <button type="button" onclick="window.location.href='admin_content_management.php'" style="position: absolute; top: 10px; left: 10px;">Close</button>
                <form action="" method="post" enctype="multipart/form-data">
                    <label for="title">Chapter Title:</label>
                    <input type="text" id="title" name="title" required>
                    <!-- Add more fields as needed for the new chapter -->
                    <!-- Main Image -->
                    <label for="mainimageUpload">Main Page Image:</label>
                    <input type="file" id="mainimageUpload" name="mainimageUpload" accept="image/*">
                    <br><br>

                    <!-- Story Image -->
                    <label for="storyimageUpload">Story Page Image:</label>
                    <input type="file" id="storyimageUpload" name="storyimageUpload" accept="image/*">
                    <br><br>

                    <!-- Content Paragraphs -->
                    <h3>Content Paragraphs:</h3>
                    <button type="button" onclick="addContentParagraph()">Add Content</button><br><br>

                        <div id="contentFieldsContainer">
                            <div class="contentField">
                                <label for="contentimageUpload">Content Image:</label>
                                <input type="file" name="contentimageUpload[]" accept="image/*">

                                <label for="heading">Heading:</label>
                                <input type="text" name="heading[]">

                                <label for="text">Text:</label>
                                <textarea name="content[]"></textarea>
                                <button type="button" onclick="removeContentParagraph(this)">Remove Content</button>
                                <br><br><br>
                            </div>
                        </div>

                        <!-- Video URL -->
                        <label for="video">Video URL:</label>
                        <input type="text" id="video" name="video">

                        <!-- Add this block to display alert messages -->
                        <?php if (isset($successMessage)): ?>
                            <script>alert("<?php echo $successMessage; ?>");
                            window.location.href = 'admin_content_management.php';</script>
                        <?php elseif (isset($errorMessage)): ?>
                            <script>alert("<?php echo $errorMessage; ?>");
                            window.location.href = 'admin_content_management.php';</script>
                        <?php endif; ?>

                    <button type="submit">Add Chapter</button>
            </form>
    </div>

    <script>
        function addContentParagraph() {
            var contentField = document.querySelector('.contentField');
            var clone = contentField.cloneNode(true);

            // Clear the values in the cloned fields
            clone.querySelector('input[name="contentimageUpload[]"]').value = '';
            clone.querySelector('input[name="heading[]"]').value = '';
            clone.querySelector('textarea[name="content[]"]').value = '';

            // Append the cloned content field to the container
            document.getElementById('contentFieldsContainer').appendChild(clone);
        }

        function removeContentParagraph(button) {
            var contentField = button.parentNode;
            var container = document.getElementById('contentFieldsContainer');

            // Ensure that at least one content paragraph remains
            if (container.children.length > 1) {
                container.removeChild(contentField);
            } else {
                alert("You cannot remove all content paragraphs.");
            }
        }
    </script>

</body>

</html>