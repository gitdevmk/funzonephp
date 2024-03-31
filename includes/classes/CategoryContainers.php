<?php
class CategoryContainers {

    private $con, $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    // Show all categories with both TV shows and movies
    public function showAllCategories() {
        $query = $this->con->query("SELECT * FROM categories");
        $html = "<div class='previewCategories'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, null, true, true);
        }

        return $html . "</div>";
    }

    // Show categories with only TV shows
    public function showTVShowCategories() {
        $query = $this->con->query("SELECT * FROM categories");
        $html = "<div class='previewCategories'>
                    <h1>TV Shows</h1>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, null, true, false);
        }

        return $html . "</div>";
    }

    // Show categories with only movies
    public function showMovieCategories() {
        $query = $this->con->query("SELECT * FROM categories");
        $html = "<div class='previewCategories'>
                    <h1>Movies</h1>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, null, false, true);
        }

        return $html . "</div>";
    }
    
    // Show a specific category
    public function showCategory($categoryId, $title = null) {
        $query = $this->con->prepare("SELECT * FROM categories WHERE id=:id");
        $query->bindValue(":id", $categoryId);
        $query->execute();

        $html = "<div class='previewCategories noScroll'>";

        while($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $html .= $this->getCategoryHtml($row, $title, true, true);
        }

        return $html . "</div>";
    }

    // Generate HTML for a category
    private function getCategoryHtml($sqlData, $title, $tvShows, $movies) {
        $categoryId = $sqlData["id"];
        $title = $title == null ? $sqlData["name"] : $title;

        // Get entities based on category type (TV shows, movies, or both)
        if($tvShows && $movies) {
            $entities = EntityProvider::getEntities($this->con, $categoryId, 30);
        }
        else if($tvShows) {
            $entities = EntityProvider::getTVShowEntities($this->con, $categoryId, 30);
        }
        else {
            $entities = EntityProvider::getMoviesEntities($this->con, $categoryId, 30);
        }

        // Return if no entities found
        if(sizeof($entities) == 0) {
            return;
        }

        // Generate HTML for entities in the category
        $entitiesHtml = "";
        $previewProvider = new PreviewProvider($this->con, $this->username);
        foreach($entities as $entity) {
            $entitiesHtml .= $previewProvider->createEntityPreviewSquare($entity);
        }

        // Return the category HTML
        return "<div class='category'>
                    <a href='category.php?id=$categoryId'>
                        <h3>$title</h3>
                    </a>
                    <div class='entities'>
                        $entitiesHtml
                    </div>
                </div>";
    }
}
?>
