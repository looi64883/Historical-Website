<?php

if (!isset($_POST['email']) || !isset($_POST['otp'])) {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
    die();
}

$email = $_POST['email'];
$otp = $_POST['otp'];

include_once("dbconnect.php");

// Assuming your time column is named `time`
// This SQL will check if the OTP is within the last 2 minutes
$sqllogin = "SELECT * FROM `tbl_forgot` WHERE user_email = '$email' AND user_otp = '$otp' AND `time` > NOW() - INTERVAL 2 MINUTE";
$result = $conn->query($sqllogin);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    $response = array('status' => 'success');
    sendJsonResponse($response);
} else {
    $response = array('status' => 'failed', 'data' => null);
    sendJsonResponse($response);
}

function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}
?>