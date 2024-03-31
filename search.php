<?php
// Include necessary header file
include_once("includes/header.php");
?>

<div class="textboxContainer">
    <input type="text" class="searchInput" placeholder="Search for something">
</div>

<div class="results"></div>

<script>
$(function() {
    var username = '<?php echo isset($userLoggedIn) ? $userLoggedIn : ""; ?>';
    var timer;

    $(".searchInput").keyup(function() {
        clearTimeout(timer);

        timer = setTimeout(function() {
            var val = $(".searchInput").val();
            
            if(val != "") {
                $.post("ajax/getSearchResults.php", { term: val, username: username }, function(data) {
                    $(".results").html(data);
                }).fail(function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                    // Handle error gracefully
                    $(".results").html("An error occurred while fetching results.");
                });
            } else {
                $(".results").html("");
            }
        }, 500);
    });
});
</script>
