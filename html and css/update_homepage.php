<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Your form processing logic here

    // Assuming you have included validation and sanitization for the form data

    // Read and decode the JSON content
    $content = json_decode(file_get_contents('content.json'), true);

    // Update content properties with the submitted data
    $content['sections'][0]['title'] = $_POST['title'];
    $content['sections'][0]['subtext'] = $_POST['subtext'];

    // Update content paragraphs
    $content['sections'][0]['content'] = array_map(function ($text) {
        return ['text' => $text];
    }, $_POST['content']);

    // Handle image deletion
    if (isset($_POST['deleteImage'])) {
        $deleteIndices = array_map('intval', $_POST['deleteImage']);
        foreach ($deleteIndices as $index) {
            unset($content['sections'][0]['images'][$index]);
        }
        $content['sections'][0]['images'] = array_values($content['sections'][0]['images']);
    }

    // Handle image replacement
    if (!empty($_FILES['imageUpload1']['tmp_name'])) {
        // Replace existing Image 1
        $newImage1 = 'images/' . basename($_FILES['imageUpload1']['name']);
        move_uploaded_file($_FILES['imageUpload1']['tmp_name'], $newImage1);
        $content['sections'][0]['images'][0] = $newImage1;
    }

    if (!empty($_FILES['imageUpload2']['tmp_name'])) {
        // Replace existing Image 2
        $newImage2 = 'images/' . basename($_FILES['imageUpload2']['name']);
        move_uploaded_file($_FILES['imageUpload2']['tmp_name'], $newImage2);
        $content['sections'][0]['images'][1] = $newImage2;
    }

    // Save the updated content back to content.json
    if (file_put_contents('content.json', json_encode($content, JSON_PRETTY_PRINT))) {
        echo '<script>alert("Content updated successfully!"); window.location.href = "admin_content_management.php";</script>';
        exit(); // Ensure that the script stops execution after the redirect
    } else {
        echo '<script>alert("Error updating content. Please try again."); window.location.href = "admin_content_management.php";</script>';
    }
} else {
    echo 'Invalid request.';
}
?>


