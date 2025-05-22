<?php
// Initialize the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
if (session_destroy()) {
    // Redirect to login page
    header("location: login.php");
    exit;
} else {
    // If destroying session failed, you could output an error or log it.
    // For simplicity, we'll still try to redirect.
    header("location: login.php");
    exit;
}
?>
