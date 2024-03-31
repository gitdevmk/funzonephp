<?php
class Video {
    private $con, $sqlData, $entity;

    public function __construct($con, $input) {
        $this->con = $con;

        try {
            if(is_array($input)) {
                $this->sqlData = $input;
            }
            else {
                $query = $this->con->prepare("SELECT * FROM videos WHERE id=:id");
                $query->bindValue(":id", $input);
                $query->execute();

                $this->sqlData = $query->fetch(PDO::FETCH_ASSOC);
            }

            $this->entity = new Entity($con, $this->sqlData["entityId"]);
        } catch (PDOException $e) {
            // Handle database errors
            error_log("Error in Video::__construct(): " . $e->getMessage());
            // You might want to throw an exception or handle it according to your application's logic
            // For now, we'll just return null
            return null;
        }
    }

    public function getId() {
        return $this->sqlData["id"];
    }

    public function getTitle() {
        return $this->sqlData["title"];
    }

    public function getDescription() {
        return $this->sqlData["description"];
    }

    public function getFilePath() {
        return $this->sqlData["filePath"];
    }

    public function getThumbnail() {
        return $this->entity->getThumbnail();
    }

    public function getEpisodeNumber() {
        return $this->sqlData["episode"];
    }

    public function getSeasonNumber() {
        return $this->sqlData["season"];
    }

    public function getEntityId() {
        return $this->sqlData["entityId"];
    }

    public function incrementViews() {
        try {
            $query = $this->con->prepare("UPDATE videos SET views=views+1 WHERE id=:id");
            $query->bindValue(":id", $this->getId());
            $query->execute();
        } catch (PDOException $e) {
            // Handle database errors
            error_log("Error in Video::incrementViews(): " . $e->getMessage());
        }
    }

    public function getSeasonAndEpisode() {
        if($this->isMovie()) {
            return;
        }

        $season = $this->getSeasonNumber();
        $episode = $this->getEpisodeNumber();

        return "Season $season, Episode $episode";
    }

    public function isMovie() {
        return $this->sqlData["isMovie"] == 1;
    }

    public function isInProgress($username) {
        try {
            $query = $this->con->prepare("SELECT * FROM videoProgress
                                        WHERE videoId=:videoId AND username=:username");

            $query->bindValue(":videoId", $this->getId());
            $query->bindValue(":username", $username);
            $query->execute();

            return $query->rowCount() != 0;
        } catch (PDOException $e) {
            // Handle database errors
            error_log("Error in Video::isInProgress(): " . $e->getMessage());
            return false;
        }
    }

    public function hasSeen($username) {
        try {
            $query = $this->con->prepare("SELECT * FROM videoProgress
                                        WHERE videoId=:videoId AND username=:username
                                        AND finished=1");

            $query->bindValue(":videoId", $this->getId());
            $query->bindValue(":username", $username);
            $query->execute();

            return $query->rowCount() != 0;
        } catch (PDOException $e) {
            // Handle database errors
            error_log("Error in Video::hasSeen(): " . $e->getMessage());
            return false;
        }
    }
}
?>
