<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Add Album or Song</h1>
    <h2>Add Song</h2>
    <form action="insertSong.php" method="post" enctype="multipart/form-data">
        <p>judul lagu</p>
        <input type="text" name ="judul">
        <p>penyanyi</p>
        <input type="text" name ="penyanyi">
        <p>tanggal terbit</p>
        <input type="text" name ="tanggal_terbit">
        <p>Genre</p>
        <input type="text" name ="genre">
        <p>Input file Audio</p>
        <!-- <input type="file"  accept="audio/*" name ="songInput">
        <p>Input file image</p> -->
        <input type="file" name ="fileImage" accept="image/*" >
        <p>input name album</p>
        <input type="text" id="" name="album" >
        <input type="submit" value="Upload">
    </form>
    
</body>

    <script>
        document.querySelector("#songImageInput").addEventListener("change", function(){
            console.log(this.files)
        });
    </script>

</html>