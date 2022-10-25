<?php
    function generateSongentry($song){
        $readable_duration = gmdate("i:s", $song['duration']);

        $html = <<<EOF
        <div class="song-listentry" onclick="window.location=`/song?id={$song['song_id']}`">
            <img class="song-listentry-thumbnail" alt="{$song['judul']}" src="{$song['image_path']}">
            <div class="song-listentry-titlepenyanyi">
                <div class="song-listentry-title">{$song['judul']}</div>
                <span class="song-listentry-penyanyi">{$song['penyanyi']}</span>
            </div>
            <div class="song-listentry-durationtahunterbit">
                <div class="song-listentry-duration">{$readable_duration}</div>
                <span class="song-listentry-tahunterbit">{$song['tahun_terbit']}</span>
            </div>
        </div>
        EOF;

        echo $html;
    }
?>