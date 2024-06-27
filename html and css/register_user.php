<?php
// Include the database connection file
include_once("dbconnect.php");

if (!isset($_POST)) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = sha1($_POST['password']);

// Get the current date and time in the "Y-m-d H:i:s" format
$registrationDate = date("Y-m-d H:i:s");

$sqlinsert = "INSERT INTO tbl_users (user_email, user_name, user_phone, user_password, user_datereg) VALUES ('$email','$name','$phone','$password','$registrationDate')";

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
