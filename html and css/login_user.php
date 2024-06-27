<?php

$email = $_POST['email'];
$pass = sha1($_POST['password']);

include_once("dbconnect.php");

$sqllogin = "SELECT * FROM `tbl_users` WHERE user_email = '$email' AND user_password = '$pass'";
$result = $conn->query($sqllogin);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userarray = array(
        'id' => $row['user_id'],
        'email' => $row['user_email'],
        'name' => $row['user_name'],
        'phone' => $row['user_phone'],
        'password' => $_POST['password'],
        'datereg' => $row['user_datereg']
    );
    $response = array('status' => 'success', 'data' => $userarray);
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
