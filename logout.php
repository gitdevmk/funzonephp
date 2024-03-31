<?php
// Start session if not already started
session_start();

// Destroy session
if(session_destroy()) {
    // Redirect to login page
    header("Location: login.php");
    exit(); // Ensure script stops execution after redirection
} else {
    // Handle error if session destruction fails
    echo "Error: Failed to destroy session.";
    // You may choose to handle this error differently
}
?>
