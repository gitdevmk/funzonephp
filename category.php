<?php
// Include header file
require_once("includes/header.php");

// Check if $con and $userLoggedIn variables are set
if (!isset($con) || !isset($userLoggedIn)) {
    // Handle the case when variables are not set
    echo "Error: Database connection or user session not available.";
    // You may choose to exit script execution or handle this error differently
    exit();
}

// Check if "id" parameter is provided in the URL
if(!isset($_GET["id"])) {
    ErrorMessage::show("No ID passed to page");
    exit(); // Ensure script stops execution after displaying error message
}

// Create a preview for the specified category
$preview = new PreviewProvider($con, $userLoggedIn);
echo $preview->createCategoryPreviewVideo($_GET["id"]);

// Display content for the specified category
$containers = new CategoryContainers($con, $userLoggedIn);
echo $containers->showCategory($_GET["id"]);
?>
