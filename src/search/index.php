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
</head>
<body>
    <div class="main-container">
        <div>
            <form action="/search" method="GET">
                <input type="text"
                    name="search"
                    placeholder="What do you want to listen?"
                    value=<?php if(isset($_GET['search'])) echo "{$_GET['search']}"; else echo ""; ?> >
                <button type="submit">Search</button>
                <div class="search-by">
                    <a <?php if(empty($_GET['searchby'])) echo 'class="active"'; ?> onclick="applyall()">All</a>
                    <a <?php if(isset($_GET['searchby']) && $_GET['searchby'] === 'judul') echo 'class="active"'; ?> onclick="applyjudul()" >Title</a>
                    <a <?php if(isset($_GET['searchby']) && $_GET['searchby'] === 'penyanyi') echo 'class="active"'; ?> onclick="applypenyanyi()" >Penyanyi</a>
                    <a <?php if(isset($_GET['searchby']) && $_GET['searchby'] === 'tahun') echo 'class="active"'; ?> onclick="applyyear()">Year</a>
                    <input id="is-genre-filter" type="checkbox" onclick="togglegenre()">Genre: </input>
                    <input id="genre-filter" type="text" placeholder="genre filter" disabled=true>
                </div>
                <div class="search-sortby-container">
                    <label>Sort by: </label>
                    <select name="sortby">
                        <option value="judul">Title</option>
                        <option value="tahun">Year</option>
                    </select>
                    <input type="checkbox">Descending</input>
                </div>

            </form>
        </div>

        <div>
            <div class="search-filter">
            </div>
            <div class="search-song-title-result">
                <div class="search-song-title">
                    <h2>Songs</h2>
                </div>
                <div class="search-song-result">
                    <template id="songentrytemplate">
                        <div class="song-listentry">
                            <img class="song-listentry-thumbnail">
                            <div class="song-listentry-titlepenyanyi">
                                <div class="song-listentry-title">Gajah</div>
                                <span class="song-listentry-penyanyi">Tulus</span>
                            </div>
                            <div class="song-listentry-durationtahunterbit">
                                <div class="song-listentry-duration">3:59</div>
                                <span class="song-listentry-tahunterbit">2019</span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="../utility.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);

            if(!urlParams.get('search')){
                return;
            }

            const response = await requestGet(`/api/search.php?${urlParams.toString()}`);
            const json = response.responseJSON;

            const songResultNode = document.getElementsByClassName("search-song-result")[0];
            const template = document.getElementById("songentrytemplate")

            for(let i = 0; i < json.length; i++){
                const song = json[i];

                const songNode = template.content.cloneNode(true);
                songNode.querySelector('.song-listentry').onclick = function(){
                    openpage(song['song_id']);
                }
                songNode.querySelector('.song-listentry-thumbnail').src = song['image_path'];
                songNode.querySelector('.song-listentry-title').innerHTML = song['judul'];
                songNode.querySelector('.song-listentry-penyanyi').innerHTML = song['penyanyi'];
                let durationDate = new Date(0);
                durationDate.setSeconds(song['duration']);
                songNode.querySelector('.song-listentry-duration').innerHTML = durationDate.toISOString().substring(14, 19);
                songNode.querySelector('.song-listentry-tahunterbit').innerHTML = song['tahun_terbit'];
                songResultNode.appendChild(songNode);
            }
        });

        function openpage(song_id){
            window.location = `/song?id=${song_id}`;
        }

        function applyall(){
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            urlParams.delete('searchby');
            window.location = `/search?${urlParams.toString()}`;
        }

        function applyjudul(){
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            urlParams.delete('searchby');
            urlParams.append('searchby', 'judul');
            window.location = `/search?${urlParams.toString()}`;
        }

        function applypenyanyi(){
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            urlParams.delete('searchby');
            urlParams.append('searchby', 'penyanyi');
            window.location = `/search?${urlParams.toString()}`;
        }

        function applyyear(){
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            urlParams.delete('searchby');
            urlParams.append('searchby', 'tahun');
            window.location = `/search?${urlParams.toString()}`;
        }        

        function applyfilter(){
        }

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
