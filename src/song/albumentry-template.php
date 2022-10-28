<?php
    function generateAlbumentry($album){
        $readable_duration = gmdate("H:i:s", $album['total_duration']);

        $html = <<<EOT
        <div class="album-listentry" onclick="window.location=`/album?id={$album['album_id']}`">
            <img class="album-listentry-thumbnail" alt="{$album['album_judul']}" src="{$album['album_image_path']}">
            <div class="album-listentry-titlepenyanyi">
                <div class="album-listentry-title">{$album['album_judul']}</div>
                <span class="album-listentry-penyanyi">{$album['penyanyi']}</span>
            </div>
            <div class="album-listentry-durationtahunterbit">
                <div class="album-listentry-duration">{$readable_duration}</div>
                <span class="album-listentry-tahunterbit">{$album['album_tanggal_terbit']}</span>
            </div>
        </div>
        EOT;

        echo $html;
    }
?>