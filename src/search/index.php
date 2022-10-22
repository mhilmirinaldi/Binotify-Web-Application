<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Result</title>
</head>
<body>
    <?php
        function generateSongEntry($song){
            $html = <<<"EOT"
            <div onclick="openpage({$song['song_id']})"
                style="cursor: pointer; border: solid; border-radius: 20px; margin: 10px 50px; padding: 5px 10px">
                <h4>{$song['judul']}</h4>
                <p>{$song['penyanyi']}</p>
                <p>{$song['tahun_terbit']}</p>
                <p>{$song['genre']}</p>
            </div>
            EOT;

            echo $html;
        }
    
        try{
            $DB_CONNECTION_STRING = 'mysql:host=localhost;dbname=binotify';
            $db = new PDO($DB_CONNECTION_STRING, 'root', 'bryankeren');
            
            $stmt = $db->prepare("SELECT song_id, judul, penyanyi, YEAR(tanggal_terbit) AS tahun_terbit, genre FROM song WHERE judul = ?");
            $stmt->execute(array($_GET['search']));
            $songs = $stmt->fetchAll();
            foreach ($songs as $song) {
                //echo $song['judul'];
                generateSongEntry($song);
            }
        } catch (PDOException $e){
            echo $e;
        }
    ?>

    <script>
        function openpage(song_id){
            window.location = `/song?id=${song_id}`;
        }
    </script>
</body>
</html>
