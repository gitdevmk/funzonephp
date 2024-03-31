<?php
$hideNav = true;
require_once("includes/header.php");

// Check if the 'id' parameter is provided in the URL
if (!isset($_GET["id"])) {
    // Show error message and stop further execution
    ErrorMessage::show("No ID passed into page");
    exit();
}

// Check if required variables are set
if (!isset($con) || !isset($userLoggedIn)) {
    // Handle the case when variables are not set
    ErrorMessage::show("Database connection or user session not available.");
    exit();
}

// Create Video object with the provided ID
$video = new Video($con, $_GET["id"]);
$video->incrementViews();

// Get the next video to play
$upNextVideo = VideoProvider::getUpNext($con, $video);
?>

<div class="watchContainer">
    <div class="videoControls watchNav">
        <button onclick="goBack()"><i class="fas fa-arrow-left"></i></button>
        <h1><?php echo $video->getTitle(); ?></h1>
    </div>

    <div class="videoControls upNext" style="display:none;">
        <button onclick="restartVideo();"><i class="fas fa-redo"></i></button>
        <div class="upNextContainer">
            <h2>Up next:</h2>
            <h3><?php echo $upNextVideo->getTitle(); ?></h3>
            <h3><?php echo $upNextVideo->getSeasonAndEpisode(); ?></h3>
            <button class="playNext" onclick="watchVideo(<?php echo $upNextVideo->getId(); ?>)">
                <i class="fas fa-play"></i> Play
            </button>
        </div>
    </div>

    <video controls autoplay onended="showUpNext()">
        <source src='<?php echo $video->getFilePath(); ?>' type="video/mp4">
    </video>
</div>

<script>
    // Initialize video player
    initVideo("<?php echo $video->getId(); ?>", "<?php echo $userLoggedIn; ?>");
</script>
