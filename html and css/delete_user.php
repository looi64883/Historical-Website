<?php

include_once("dbconnect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Perform the user deletion in the database
    $sqlDelete = "DELETE FROM `tbl_users` WHERE `user_id` = ?";

    // Using prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sqlDelete);
    $stmt->bind_param('i', $userId);

    if ($stmt->execute()) {
        $response = array('status' => 'success', 'message' => 'User deleted successfully');
    } else {
        $response = array('status' => 'error', 'message' => 'Unable to delete user');
    }

    // Close the prepared statement
    $stmt->close();
    
    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request
    $response = array('status' => 'error', 'message' => 'Invalid request');
    header('Content-Type: application/json');
    echo json_encode($response);
}

?>


