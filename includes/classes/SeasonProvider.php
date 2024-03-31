<?php
class SeasonProvider {
    private $con, $username;

    public function __construct($con, $username) {
        $this->con = $con;
        $this->username = $username;
    }

    public function create($entity) {
        $seasons = $entity->getSeasons();

        if(empty($seasons)) {
            return "";
        }

        $seasonsHtml = "";
        foreach($seasons as $season) {
            $seasonNumber = $season->getSeasonNumber();
            $videosHtml = $this->createVideosHtml($season->getVideos());

            $seasonsHtml .= "<div class='season'>
                                    <h3>Season $seasonNumber</h3>
                                    <div class='videos'>
                                        $videosHtml
                                    </div>
                                </div>";
        }

        return $seasonsHtml;
    }

    private function createVideosHtml($videos) {
        $videosHtml = "";
        foreach($videos as $video) {
            $videosHtml .= $this->createVideoSquare($video);
        }
        return $videosHtml;
    }

    private function createVideoSquare($video) {
        $id = $video->getId();
        $thumbnail = $video->getThumbnail();
        $name = $video->getTitle();
        $description = $video->getDescription();
        $episodeNumber = $video->getEpisodeNumber();
        $hasSeen = $video->hasSeen($this->username) ? "<i class='fas fa-check-circle seen'></i>" : "";

        return "<a href='watch.php?id=$id'>
                    <div class='episodeContainer'>
                        <div class='contents'>
                            <img src='$thumbnail'>
                            <div class='videoInfo'>
                                <h4>$episodeNumber. $name</h4>
                                <span>$description</span>
                            </div>
                            $hasSeen
                        </div>
                    </div>
                </a>";
    }
}
?>
