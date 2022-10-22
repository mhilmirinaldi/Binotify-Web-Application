<?php
    function generateSongPage($song){
        $html = <<<"EOT"
        <!DOCTYPE html>
        <html lang="id">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>{$song['judul']}</title>
            </head>
            <body>
                <h1>{$song['judul']}</h1>
                <p>Penyanyi: {$song['penyanyi']}</p>
                <p>Tanggal Terbit: {$song['tanggal_terbit']}</p>
                <p>Genre: {$song['genre']}</p>
                <p>Durasi: {$song['duration']} detik</p>
                <audio controls>
                    <source src="..{$song['audio_path']}">
                    Audio not supported
                </audio>
            </body>
        </html>
        EOT;

        echo $html;
    }

    $DB_CONNECTION_STRING = 'mysql:host=localhost;dbname=binotify';
    $db = new PDO($DB_CONNECTION_STRING, 'root', 'bryankeren');
    
    $stmt = $db->prepare('SELECT judul, penyanyi, tanggal_terbit, genre, duration, audio_path FROM song WHERE song_id=?');
    $stmt->execute(array($_GET['id']));
    $song = $stmt->fetch();
    generateSongPage($song);
?>

