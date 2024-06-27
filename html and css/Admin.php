<!-- PHP code to establish connection with the localserver -->
<?php
 
// Username is root
$user = 'root';
$password = '';
 
// Database name
$database = '23_web';
 
// Server is localhost
$servername='localhost';
$mysqli = new mysqli($servername, $user,
                $password, $database);
 
// Checking for connections
if ($mysqli->connect_error) {
    die('Connect Error (' .
    $mysqli->connect_errno . ') '.
    $mysqli->connect_error);
}
 
// SQL query to select data from database
$sql = "SELECT * FROM tbl_users WHERE game = 1 ORDER BY user_id";
$result = $mysqli->query($sql);
$mysqli->close();
?>
<!-- HTML code to display data in tabular format -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Winner List</title>
    <link rel="icon" href="images/webicon.png" type="image/png">
    <!-- CSS FOR STYLING THE PAGE -->
    <style>
        body,
        ul {
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            background: url('images/4.jpg') no-repeat center center fixed;
            background-size: cover;
            overflow: hidden;
            position: relative;
            backdrop-filter: blur(5px);
        }

        nav {
            background-color: #333; /* Background color for the navbar */
            overflow: hidden;
            position: relative; /* Position relative for stacking */
        }

        /* Style for the buttons */
        nav button {
            background-color: #555; /* Button background color */
            border: none;
            color: white;
            padding: 16px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease; /* Add a smooth transition */
        }

        /* Hover effect for buttons */
        nav button:hover {
            background-color: #777; /* Darker color on hover */
        }

        /* Add some space between buttons */
        nav button:not(:last-child) {
            margin-right: 10px;
        }

        /* Align the "Sign In" button to the right */
        nav button:last-child {
            margin-left: auto;
        }

        table {
            margin: 0 auto;
            font-size: large;
            border: 1px solid black;
        }

        h1 {
            text-align: center;
            color: #006600;
            font-size: xx-large;
            font-family: 'Gill Sans', 'Gill Sans MT',
                ' Calibri', 'Trebuchet MS', 'sans-serif';
        }

        td {
            background-color: #E4F5D4;
            border: 1px solid black;
        }

        th,
        td {
            font-weight: bold;
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        td {
            font-weight: lighter;
        }

        /* Pagination styles */
        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            text-decoration: none;
            padding: 5px 10px;
            border: 1px solid #ccc;
            margin: 2px;
        }

        .pagination a:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <nav>
        <button><a href="index.php" style="text-decoration: none; color: white;">Home</a></button>
        <button><a href="Story.php" style="text-decoration: none; color: white;">Story</a></button>
        <button onclick="checkLoginAndRedirect()">Challenge</button>
        <button><a href="aboutUs.php" style="text-decoration: none; color: white;">About Us</a></button>
        <button id="signInButton"><a href="SignIn.html" style="text-decoration: none; color: white;">Sign In</a></button>
        <button><a href="#" style="text-decoration: none; color: white;">Contributors</a></button>
        <button id="logoutButton" style="display:none;">Log Out</button>
    </nav>

<section>
    <h1>Winner</h1>
    <!-- TABLE CONSTRUCTION -->
    <table>
        <tr>
            <th>Num</th>
            <th>Email</th>
            <th>User Name</th>
        </tr>
        <!-- PHP CODE TO FETCH DATA FROM ROWS -->
        <?php
        // Initialize variables
        $displayedRows = 0; // Number of displayed rows
        $currentPage = 1; // Current page number
        $pageSize = 10; // Number of rows to display per page
        $totalRows = $result->num_rows; // Total number of rows

        // Calculate the total number of pages
        $totalPages = ceil($totalRows / $pageSize);

        // Check if the page parameter is set in the URL
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $currentPage = $_GET['page'];
        }

        // Calculate the starting row for the current page
        $startRow = ($currentPage - 1) * $pageSize;

        // Move the result pointer to the starting row
        $result->data_seek($startRow);

        // Initialize a row counter
        $rowNumber = $startRow + 1;

        // Loop through rows for the current page
        while ($displayedRows < $pageSize && $row = $result->fetch_assoc()) {
            ?>
            <tr>
                <!-- Display row number -->
                <td><?php echo $rowNumber; ?></td>
                <!-- FETCHING DATA FROM EACH ROW OF EVERY COLUMN -->
                <td><?php echo $row['user_email']; ?></td>
                <td><?php echo $row['user_name']; ?></td>
            </tr>
            <?php
            $displayedRows++;
            $rowNumber++;
        }
        ?>
    </table>

    <!-- Pagination controls -->
    <div class="pagination">
        <?php if ($currentPage > 1): ?>
            <a href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
        <?php endif; ?>

        Page <?php echo $currentPage; ?>/<?php echo $totalPages; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="?page=<?php echo $currentPage + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
</section>

    <script>
        window.onload = function() {
    
            updateLoginStatus();

            var logoutButton = document.getElementById("logoutButton");
            // Add event listener for logout button
            logoutButton.addEventListener('click', function() {
                var confirmLogout = confirm("Are you sure you want to log out?");
                if (confirmLogout) {
                    // Reset session storage for user details and login status
                    sessionStorage.setItem("userEmail", "guest@gmail.com");
                    sessionStorage.setItem("userName", "guest");
                    sessionStorage.setItem("userPassword", "0000");
                    sessionStorage.setItem("isLoggedIn", "false"); // Set as a string "false"
                    window.location.href = 'index.php';

                    updateLoginStatus();

                    alert("You have been successfully logged out.");
                }
            });
        };

        function updateLoginStatus() {
            var isLoggedIn = sessionStorage.getItem("isLoggedIn") === "true"; // Ensure the correct evaluation
            var signInButton = document.getElementById("signInButton");
            var logoutButton = document.getElementById("logoutButton");

            if (isLoggedIn) {
                signInButton.style.display = 'none';
                logoutButton.style.display = 'inline-block';
            } else {
                signInButton.style.display = 'inline-block';
                logoutButton.style.display = 'none';
            }
        }

        function checkLoginAndRedirect() {
            var isLoggedIn = sessionStorage.getItem("isLoggedIn") === "true"; // Ensure the correct evaluation
            if (isLoggedIn) {       
                window.location.href = 'historicalgame.html'; // Redirect to Challenge page
            } else {
                // Show pop-up message
                var confirmBox = confirm("You need to be logged in to access the Challenge. Do you want to log in?");
                if (confirmBox == true) {
                    window.location.href = 'SignIn.html'; // Redirect to Sign In page
                }
            }
        }
    </script>
</body>
</html>