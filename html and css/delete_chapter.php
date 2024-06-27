<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the chapter ID from the request
    $chapterId = isset($_POST['chapter_id']) ? $_POST['chapter_id'] : '';

    if (!empty($chapterId)) {
        // Read content.json
        $jsonContent = file_get_contents('content.json');
        $content = json_decode($jsonContent, true);

        // Check if the chapter exists
        if (isset($content['chapters'][$chapterId])) {
            // Remove the chapter
            unset($content['chapters'][$chapterId]);

            // Save the updated content back to content.json
            $jsonContent = json_encode($content, JSON_PRETTY_PRINT);
            file_put_contents('content.json', $jsonContent);

            // Send a success response
            http_response_code(200);
            echo 'Chapter deleted successfully';
        } else {
            // Send a not found response
            http_response_code(404);
            echo 'Chapter not found';
        }
    } else {
        // Send a bad request response
        http_response_code(400);
        echo 'Bad request';
    }
} else {
    // Send a method not allowed response
    http_response_code(405);
    echo 'Method not allowed';
}
?>
