<?php

$email = $_POST['email'];
$pass = sha1($_POST['password']);

include_once("dbconnect.php");

$sqllogin = "SELECT * FROM `tbl_admin` WHERE admin_email = '$email' AND admin_password = '$pass'";
$result = $conn->query($sqllogin);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userarray = array(
        'email' => $row['admin_email'],
        'name' => $row['admin_username'],
        'password' => $_POST['password']
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