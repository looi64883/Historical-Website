<?php
// Include the database connection file
include_once("dbconnect.php");

// Check if 'email' is set in POST request
if (!isset($_POST['email'])) {
    $response = array('status' => 'failed', 'data' => 'No email provided');
    sendJsonResponse($response);
    die();
}

$email = $_POST['email'];

// Prepare an UPDATE SQL statement with placeholders
$sqlupdate = "UPDATE tbl_users SET game = 1 WHERE user_email = ?";

// Prepare the statement
$stmt = $conn->prepare($sqlupdate);
if ($stmt === false) {
    $response = array('status' => 'failed', 'data' => $conn->error);
    sendJsonResponse($response);
    die();
}

// Bind parameters (email in this case) and execute
$stmt->bind_param("s", $email);

if ($stmt->execute()) {
    $response = array('status' => 'success', 'data' => null);
} else {
    $response = array('status' => 'failed', 'data' => $stmt->error);
}

// Send response
sendJsonResponse($response);

function sendJsonResponse($sentArray) {
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}

// Close statement and database connection
$stmt->close();
$conn->close();
?>