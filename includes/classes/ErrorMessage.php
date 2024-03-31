<?php
class ErrorMessage {
    public static function show($text, $element = 'span') {
        return "<$element class='errorBanner'>$text</$element>";
    }
}
?>
