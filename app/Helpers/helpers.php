<?php

function getYoutubeId($url) {
    preg_match('/(?:youtube\.com\/.*v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $url, $matches);
    return $matches[1] ?? null;
}

function getVimeoId($url) {
    preg_match('/vimeo\.com\/(\d+)/', $url, $matches);
    return $matches[1] ?? null;
}
