<?php
class Season {

    private $seasonNumber;
    private $videos;

    public function __construct($seasonNumber, $videos) {
        $this->seasonNumber = $seasonNumber;
        $this->videos = $videos;
    }

    public function getSeasonNumber() {
        return $this->seasonNumber;
    }

    public function getVideos() {
        return $this->videos;
    }

    public function addVideo($video) {
        $this->videos[] = $video;
    }

    public function hasVideos() {
        return !empty($this->videos);
    }
}
?>
