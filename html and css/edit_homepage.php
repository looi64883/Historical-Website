<?php
// Read and decode the JSON content
$content = json_decode(file_get_contents('content.json'), true);

// Check if decoding was successful
if ($content !== null) {
    // Extract the relevant information for homepage content
    $homepageContent = $content['sections'][0];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/webicon.png" type="image/png">

    <title>Edit Homepage Content</title>
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
    </style>

    <script>
        function confirmUpdate() {
            return confirm("Are you sure you want to update the content?");
        }
    </script>
</head>

<body>
    <h1>Edit Homepage Content</h1>
    <div style="position: relative;">
        <button type="button" onclick="window.location.href='admin_content_management.php'" style="position: absolute; top: 10px; left: 10px;">Close</button>
            <form action="update_homepage.php" method="post" enctype="multipart/form-data">
                <!-- Title -->
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($homepageContent['title']); ?>">
                <br><br>

                <!-- Subtext -->
                <label for="subtext">Subtext:</label>
                <input type="text" id="subtext" name="subtext" value="<?php echo htmlspecialchars($homepageContent['subtext']); ?>">
                <br><br>

                <!-- Content paragraphs -->
                <label for="content">Content:</label>
                <?php
                foreach ($homepageContent['content'] as $index => $paragraph) {
                    echo '<textarea id="content' . $index . '" name="content[]" rows="4" placeholder="Enter content...">' . htmlspecialchars($paragraph['text']) . '</textarea>';
                }
                ?>

                <br><br>
                <!-- Image URLs -->
                <label for="images">Existing Images:</label>
                <div class="image-preview">
                    <?php
                    foreach ($homepageContent['images'] as $index => $image) {
                        echo '<div>';
                        echo '<img src="' . $image . '" alt="Image Preview">';
                        echo '<input type="checkbox" class="delete-checkbox" name="deleteImage[]" value="' . $index . '"> Delete';
                        echo '</div>';
                    }
                    ?>
                </div>

                <br><br>
                <label for="imageUpload1">Replace Image 1:</label>
                <input type="file" id="imageUpload1" name="imageUpload1" accept="image/*">
                <?php
                if (empty($homepageContent['images'][0])) {
                    echo '<small>No existing image. Upload Image 1 will add a new image.</small>';
                } else {
                    echo '<small>Upload new image to replace existing Image 1.</small>';
                }
                ?>
                <br><br><br>

                <label for="imageUpload2">Replace Image 2:</label>
                <input type="file" id="imageUpload2" name="imageUpload2" accept="image/*">
                <?php
                if (empty($homepageContent['images'][1])) {
                    echo '<small>No existing image. Upload Image 2 will add a new image.</small>';
                } else {
                    echo '<small>Upload new image to replace existing Image 2.</small>';
                }
                ?>
                <br><br>
                <!-- Save Changes Button -->
                <button type="submit" name="submit">Save Changes</button>
            </form>
        </div>
</body>

</html>




<?php
} else {
    echo "<p>Error decoding JSON content.</p>";
}
?>

