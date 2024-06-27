<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Read and decode the JSON content
    $content = json_decode(file_get_contents('content.json'), true);

    // Check if decoding was successful
    if ($content !== null) {
        // Get the aboutus content
        $aboutusContent = $content['aboutus'][0];

        // Check if there are images to delete
        if (isset($_POST["deleteImage"]) && is_array($_POST["deleteImage"])) {
            foreach ($_POST["deleteImage"] as $index) {
                // Remove the selected image
                if (isset($aboutusContent['images'][$index])) {
                    unlink($aboutusContent['images'][$index]); // Delete the file from the server
                    unset($aboutusContent['images'][$index]); // Remove the image from the array
                }
            }
        }

        // Check if a new image is uploaded
        if ($_FILES["imageUpload"]["error"] == 0) {
            // Handle the new image upload
            $targetDir = "images/"; // Change this to your desired upload directory
            $targetFile = $targetDir . basename($_FILES["imageUpload"]["name"]);
            move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $targetFile);

            // Replace the existing images in the array with the new one
            $aboutusContent['images'] = [$targetFile];
        }

        // Update the content in the main array
        $content['aboutus'][0] = $aboutusContent;

        // Save the updated content back to content.json
        if (file_put_contents('content.json', json_encode($content, JSON_PRETTY_PRINT))) {
            echo '<script>alert("Content updated successfully!"); window.location.href = "admin_content_management.php";</script>';
            exit(); // Ensure that the script stops execution after the redirect
        } else {
            echo '<script>alert("Error updating content. Please try again."); window.location.href = "admin_content_management.php";</script>';
        }
    } 
}else {
    echo 'Invalid request.';
}
?>