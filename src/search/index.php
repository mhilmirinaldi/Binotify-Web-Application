<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <link href="./style.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
        
    <title>Search Result</title>
    <link rel="icon" href="/static/logo-only.svg" type="image/svg+xml">
</head>
<body>
    <?php
        include('../navbar/navbargenerate.php');
        echo_card();
    ?>
    <div class="main">
        <div class="main-view">
            <div>
                <form action="/search" method="GET">
                    <input type="text"
                        name="search"
                        placeholder="What do you want to listen?"
                        value=<?php if(isset($_GET['search'])) echo "{$_GET['search']}"; else echo ""; ?> >
                    <button type="submit">Search</button>
                    <div class="search-by">
                        <input type="radio" name="searchby" value="all"
                            <?php if(!isset($_GET['searchby']) || $_GET['searchby'] == 'all') echo 'checked'; ?>
                        >All</input>
                        <input type="radio" name="searchby" value="judul"
                            <?php if(isset($_GET['searchby']) && $_GET['searchby'] == 'judul') echo 'checked'; ?>
                        >Title</input>
                        <input type="radio" name="searchby" value="penyanyi"
                            <?php if(isset($_GET['searchby']) && $_GET['searchby'] == 'penyanyi') echo 'checked'; ?>
                        >Penyanyi</input>
                        <input type="radio" name="searchby" value="tahun"
                            <?php if(isset($_GET['searchby']) && $_GET['searchby'] == 'tahun') echo 'checked'; ?>
                        >Tahun</input>

                        <input id="is-genre-filter" type="checkbox" onclick="togglegenre()"
                            <?php if(isset($_GET['genre'])) echo 'checked' ?>
                        >Genre: </input>
                        <input id="genre-filter" type="text" name="genre" placeholder="genre filter"
                            <?php if(isset($_GET['genre'])) echo "value={$_GET['genre']}"; else echo "disabled" ?>
                        >
                    </div>
                    <div class="search-sortby-container">
                        <label>Sort by: </label>
                        <select name="sortby">
                            <option value="judul"
                                <?php if(!isset($_GET['sortby']) || $_GET['sortby'] == 'judul') echo 'selected'; ?>
                            >Title</option>
                            <option value="tahun"
                                <?php if(isset($_GET['sortby']) && $_GET['sortby'] == 'tahun') echo 'selected'; ?>
                            >Year</option>
                        </select>
                        <input name="desc" value=true type="checkbox"
                            <?php if(isset($_GET['desc']) && $_GET['desc'] == true) echo 'checked'; ?>
                        >Descending</input>
                    </div>
                </form>
            </div>

            <div>
                <div class="search-song-title-result">
                    <div class="search-song-title">
                        <h2>Songs</h2>
                    </div>

                    <div class="search-song-result">
                        <?php
                            include('./search-functions.php');
                            include('../components/songentry-template.php');
                            if(isset($_GET['search']) && $_GET['search'] != ''){
                                try {
                                    $songs = search();
                                    foreach($songs as $song){
                                        generateSongentry($song);
                                    }
                                } catch(Exception $e){
                                    echo $e;
                                }
                            } else {
                                echo "<i>Empty search key</i>";
                            }
                        ?>
                    </div>
                    
                </div>
            </div>

            <div class="search-pagination">
                <?php
                    include('./pagination-template.php');
                    if(isset($_GET['search']) && $_GET['search'] != ''){
                        try{
                            $count = searchCount();
                            if(!isset($_GET['page'])){
                                $currentPage = 1;
                            } else{
                                $currentPage = intval($_GET['page']);
                            }
                            generatePagination($currentPage, $count->totalpages, parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), $_SERVER["QUERY_STRING"]);
                        } catch(Exception $e){
                            echo "<i>", $e->getMessage(), "</i>";
                        }
                    }
                ?>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../utility.js"></script>
    <script>
        function togglegenre(){
            const isGenreFilter = document.getElementById('is-genre-filter');
            const genreFilter = document.getElementById('genre-filter');
            if(isGenreFilter.checked == true){
                genreFilter.disabled = false;
            } else{
                genreFilter.disabled = true;
            }
        }

    </script>
</body>
</html>
