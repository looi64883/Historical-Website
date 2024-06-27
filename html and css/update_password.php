<?php
include 'dbconnect.php'; // Include the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $oldPassword = sha1($_POST['old_password']);
    $newPassword = sha1($_POST['new_password']);

    $sql = "SELECT * FROM tbl_users WHERE user_email = '$email' AND user_password = '$oldPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $updateSql = "UPDATE tbl_users SET user_password ='$newPassword' WHERE user_email = '$email'";
        if ($conn->query($updateSql) === TRUE) {
            $response = array('status' => 'success', 'message' => 'Password updated successfully');
            sendJsonResponse($response);
        } else {
            $response = array('status' => 'failed', 'message' => 'Failed to update password');
            sendJsonResponse($response);
        }
    } else {
        $response = array('status' => 'failed', 'message' => 'Invalid old password');
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
