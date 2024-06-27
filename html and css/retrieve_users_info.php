<?php
function getUsersInfo() {
    include_once("dbconnect.php");

    // SQL query to select all users from tbl_users
    $sql = "SELECT * FROM tbl_users";
    $result = $conn->query($sql);

    $usersInfo = array();

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // Add user data to the array
            $usersInfo[] = array(
                'user_id' => $row["user_id"],
                'user_name' => $row["user_name"],
                'user_email' => $row["user_email"]
                // Add more fields as needed
            );
        }
    }

    // Close the database connection
    $conn->close();

    return $usersInfo;
}
