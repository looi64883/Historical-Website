<?php
// Include the database connection file
include_once("dbconnect.php");

if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}

$email = $_POST['email'];
$otp = $_POST['otp'];


$sqlinsert = "INSERT INTO tbl_forgot (user_email, user_otp) VALUES ('$email','$otp')";

// Perform the SQL query to insert data into the database
if ($conn->query($sqlinsert) === TRUE) {
    $response = array('status' => 'success', 'data' => null);
} else {
    $response = array('status' => 'failed', 'data' => $conn->error);
}

sendJsonResponse($response);

function sendJsonResponse($sentArray){
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}

// Close the database connection
$conn->close();
?>
