<?php
// Read and decode the JSON content
$content = json_decode(file_get_contents('content.json'), true);

// Check if decoding was successful
if ($content !== null) {
    
    $aboutusContent = $content['aboutus'][0];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/webicon.png" type="image/png">
    <title>Edit About Us page Content</title>
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
    <h1>Edit About Us Content</h1>
    <div style="position: relative;">
        <button type="button" onclick="window.location.href='admin_content_management.php'" style="position: absolute; top: 10px; left: 10px;">Close</button>
            <form action="update_about_us.php" method="post" enctype="multipart/form-data">
                
                <br><br>
                <!-- Image URLs -->
                <label for="images">Existing Images:</label>
                <div class="image-preview">
                    <?php
                    foreach ($aboutusContent['images'] as $index => $image) {
                        echo '<div>';
                        echo '<img src="' . $image . '" alt="Image Preview">';
                        echo '<input type="checkbox" class="delete-checkbox" name="deleteImage[]" value="' . $index . '"> Delete';
                        echo '</div>';
                    }
                    ?>
                </div>

                <br><br>
                <label for="imageUpload">Replace About Us Image:</label>
                <input type="file" id="imageUpload" name="imageUpload" accept="image/*">
                <?php
                if (empty($aboutusContent['images'])) {
                    echo '<small>No existing image. Upload Image will add a new image.</small>';
                } else {
                    echo '<small>Upload new image to replace existing Image.</small>';
                }
                ?>
                <br><br><br>

                <!-- Save Changes Button -->
                <button type="submit" name="submit">Save Changes</button>
            </form>
        </div>
</body>

</html>