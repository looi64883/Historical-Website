<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/webicon.png" type="image/png">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Navigation bar styles */
        nav {
            background-color: #333;
            overflow: hidden;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1;
        }

        nav button {
            background-color: #555;
            border: none;
            color: white;
            padding: 16px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        nav button:hover {
            background-color: #777;
        }

        /* Dashboard header styles */
        header {
            background-color: #333;
            color: white;
            padding: 20px;
            text-align: center;
            margin-top: 70px; /* Adjusted margin to avoid overlapping with the nav menu */
        }

        /* Section styles */
        section {
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        /* Dashboard card styles */
        .dashboard-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        /* User list styles */
        .user-list {
            list-style-type: none;
            padding: 0;
        }

        .user-list-item {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-list-item button {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .user-list-item button:hover {
            background-color: #c82333;
        }

    </style>
</head>
<body>

    <!-- Navigation bar with buttons -->
    <nav>
        <button><a href="#" style="text-decoration: none; color: white;">Home</a></button>
        <button><a href="admin_content_management.php" style="text-decoration: none; color: white;">Content Management</a></button>
    </nav>

    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <section id="user-management">
        <div class="dashboard-card">
            <h2>User Management</h2>
            <ul class="user-list">
                <?php
                // Include the function to retrieve user info
                include_once("retrieve_users_info.php");

                // Get user information
                $usersInfo = getUsersInfo();

                if (!empty($usersInfo)) {
                    foreach ($usersInfo as $user) {
                        echo "<li class='user-list-item'>";
                        echo "User ID: " . $user["user_id"]. " - Name: " . $user["user_name"]. " - Email: " . $user["user_email"];
                        echo " <button onclick='deleteUser(" . $user["user_id"] . ")'>Delete</button>";
                        echo "</li>";
                    }
                } else {
                    echo "<li class='user-list-item'>No users found</li>";
                }
                ?>
            </ul>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

        function deleteUser(userId) {
            // Confirm deletion with an alert
            var confirmDelete = confirm("Are you sure you want to delete this user?");
            
            if (confirmDelete) {
                // Call the PHP function to delete the user
                $.ajax({
                    type: 'POST',
                    url: 'delete_user.php',
                    data: { userId: userId },
                    dataType: 'json', // Expect JSON response
                    success: function(response) {

                        // Check the response for success or error
                        if (response.status === 'success') {
                            // Display success message
                            alert(response.message);

                            // Refresh the user list after successful deletion
                            location.reload();
                        } else {
                            console.error("Error deleting user: ", response.message);
                        }
                    },
                    error: function(error) {
                        // Display error message
                        alert("Error deleting user. Please try again.");

                        console.error("AJAX error: ", error);
                    }
                });
            }
        }
    </script>

</body>
</html>
