<?php
// Database configuration
define('DB_HOST', 'localhost'); // Or your database host (e.g., 127.0.0.1)
define('DB_USERNAME', 'drought_user'); // Replace with your database username
define('DB_PASSWORD', 'secure_password'); // Replace with your database password
define('DB_NAME', 'drought_prediction_db');

// Attempt to connect to MySQL database
$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Set character set to utf8mb4 (optional, but good for unicode support)
if (!$mysqli->set_charset("utf8mb4")) {
    // printf("Error loading character set utf8mb4: %s\n", $mysqli->error);
    // For simplicity in this context, we might not die here, but log it in a real app.
}

// Function to close the connection (optional, as PHP usually closes it at script end)
function close_db_connection($mysqli_conn) {
    if ($mysqli_conn) {
        $mysqli_conn->close();
    }
}

// You can choose to return the $mysqli object directly if you prefer that pattern
// For example:
// return $mysqli;
// Or have a function like:
// function get_db_connection() {
//     global $mysqli; // Or re-establish connection inside function
//     return $mysqli;
// }
?>
