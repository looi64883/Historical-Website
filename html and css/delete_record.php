<?php
include 'dbconnect.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    $sql = "SELECT * FROM tbl_users WHERE user_email = '$email' AND user_password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Password matches, proceed with deletion
        $deleteSql = "DELETE FROM tbl_users WHERE user_email = '$email'";
        if ($conn->query($deleteSql) === TRUE) {
            $response = array('status' => 'success', 'message' => 'User account deleted successfully');
            sendJsonResponse($response);
        } else {
            $response = array('status' => 'failed', 'message' => 'Failed to delete user account');
            sendJsonResponse($response);
        }
    } else {
        $response = array('status' => 'failed', 'message' => 'Invalid email or password');
        sendJsonResponse($response);
    }
} else {
    $response = array('status' => 'failed', 'message' => 'Invalid request method');
    sendJsonResponse($response);
}

function sendJsonResponse($sentArray)
{
    header('Content-Type: application/json');
    echo json_encode($sentArray);
}
?>
