<?php
// Ensure necessary files are included
require_once("includes/header.php");

// Check if $con and $userLoggedIn variables are set
if (!isset($con) || !isset($userLoggedIn)) {
    // Handle the case when variables are not set
    echo "Error: Database connection or user session not available.";
    // You may choose to exit script execution or handle this error differently
    exit();
}

// Create a preview for the logged-in user
$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createPreviewVideo(null);

// Display all categories
$containers = new CategoryContainers($con, $userLoggedIn);
echo $containers->showAllCategories();
?>
