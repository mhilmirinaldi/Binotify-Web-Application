<?php
    function search(){
        $config = include('../config.php');

        // Search must not be empty
        if(empty($_GET['search'])){
        } else{
            $search = $_GET['search'];
        }

        // searchby, optional, default search all aspects
        if(!empty($_GET['searchby'])){
            $searchby = $_GET['searchby'];
            if($searchby == 'all'){
                unset($searchby);
            } else if($searchby !== 'judul' && $searchby !== 'penyanyi' && $searchby !== 'tahun'){
                throw new Exception("400: searchby must be judul, penyanyi, tahun, or leave empty");
            }
        }

        // Pagination parameter, optional, default page 1 and pagesize 10
        if(!empty($_GET['page'])){
            $page = intval($_GET['page']);
        } else{
            $page = 1;
        }

        if(!empty($_GET['pagesize'])){
            $pagesize = intval($_GET['pagesize']);
        } else{
            $pagesize = $config['search_defaultpagesize'];
        }
        $offset = ($page-1) * $pagesize;

        // sortby, default by judul ascending
        if(!empty($_GET['sortby'])){
            $sortby = $_GET['sortby'];

            if($sortby !== 'judul' && $sortby != 'tahun'){
                throw new Exception("400: invalid sort by");
            }

            if($sortby === 'tahun'){
                $sortby = 'tahun_terbit';
            }
        } else{
            $sortby = 'judul';
        }

        if(!empty($_GET['desc']) && $_GET['desc'] == true){
            $sortorder = 'DESC';
        } else{
            $sortorder = 'ASC';
        }

        // genre, optional, default all genres will be returned
        if(!empty($_GET['genre'])){
            $genre = $_GET['genre'];
        }

        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);

        if(!isset($_GET['search']) || empty($_GET['search'])){
            if(isset($genre)){
                $stmt = $db->prepare("SELECT song_id, judul, penyanyi, YEAR(tanggal_terbit) AS tahun_terbit, genre, duration, image_path FROM song
                                    WHERE genre = ?
                                    ORDER BY $sortby $sortorder LIMIT $offset,$pagesize");
                $stmt->execute(array($genre));
            } else{
                $stmt = $db->prepare("SELECT song_id, judul, penyanyi, YEAR(tanggal_terbit) AS tahun_terbit, genre, duration, image_path FROM song
                                    ORDER BY $sortby $sortorder LIMIT $offset,$pagesize");
                $stmt->execute(array());
            }
        }
        else if(!isset($searchby)){
            if(isset($genre)){
                $stmt = $db->prepare("SELECT song_id, judul, penyanyi, YEAR(tanggal_terbit) AS tahun_terbit, genre, duration, image_path FROM song
                                    WHERE (judul LIKE ? OR penyanyi LIKE ? OR YEAR(tanggal_terbit) = ?) AND genre = ?
                                    ORDER BY $sortby $sortorder LIMIT $offset,$pagesize");
                $stmt->execute(array("%$search%", "%$search%", intval($search), $genre));
            } else{
                $stmt = $db->prepare("SELECT song_id, judul, penyanyi, YEAR(tanggal_terbit) AS tahun_terbit, genre, duration, image_path FROM song
                                    WHERE (judul LIKE ? OR penyanyi LIKE ? OR YEAR(tanggal_terbit) = ?)
                                    ORDER BY $sortby $sortorder LIMIT $offset,$pagesize");
                $stmt->execute(array("%$search%", "%$search%", intval($search)));
            }
        } else if($searchby === 'judul'){
            if(isset($genre)){
                $stmt = $db->prepare("SELECT song_id, judul, penyanyi, YEAR(tanggal_terbit) AS tahun_terbit, genre, duration, image_path FROM song
                                    WHERE (judul LIKE ?) AND genre = ?
                                    ORDER BY $sortby $sortorder LIMIT $offset,$pagesize");
                $stmt->execute(array("%$search%", $genre));
            } else{
                $stmt = $db->prepare("SELECT song_id, judul, penyanyi, YEAR(tanggal_terbit) AS tahun_terbit, genre, duration, image_path FROM song
                                    WHERE (judul LIKE ?)
                                    ORDER BY $sortby $sortorder LIMIT $offset,$pagesize");
                $stmt->execute(array("%$search%"));
            }
        } else if($searchby === 'penyanyi'){
            if(isset($genre)){
                $stmt = $db->prepare("SELECT song_id, judul, penyanyi, YEAR(tanggal_terbit) AS tahun_terbit, genre, duration, image_path FROM song
                                    WHERE (penyanyi LIKE ?) AND genre = ?
                                    ORDER BY $sortby $sortorder LIMIT $offset,$pagesize");
                $stmt->execute(array("%$search%", $genre));
            } else{
                $stmt = $db->prepare("SELECT song_id, judul, penyanyi, YEAR(tanggal_terbit) AS tahun_terbit, genre, duration, image_path FROM song
                                    WHERE (penyanyi LIKE ?)
                                    ORDER BY $sortby $sortorder LIMIT $offset,$pagesize");
                $stmt->execute(array("%$search%"));
            }
        } else if($searchby === 'tahun'){
            if(isset($genre)){
                $stmt = $db->prepare("SELECT song_id, judul, penyanyi, YEAR(tanggal_terbit) AS tahun_terbit, genre, duration, image_path FROM song
                                    WHERE (YEAR(tanggal_terbit) = ?) AND genre = ?
                                    ORDER BY $sortby $sortorder LIMIT $offset,$pagesize");
                $stmt->execute(array(intval($search), $genre));
            } else{
                $stmt = $db->prepare("SELECT song_id, judul, penyanyi, YEAR(tanggal_terbit) AS tahun_terbit, genre, duration, image_path FROM song
                                    WHERE (YEAR(tanggal_terbit) = ?)
                                    ORDER BY $sortby $sortorder LIMIT $offset,$pagesize");
                $stmt->execute(array(intval($search)));
            }
        }

        $songs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $songs;
    }

    function searchCount(){
        $config = include('../config.php');

        // Search must not be empty
        if(empty($_GET['search'])){
            
        } else{
            $search = $_GET['search'];
        }

        // searchby, optional, default search all aspects
        if(!empty($_GET['searchby'])){
            $searchby = $_GET['searchby'];
            if($searchby == 'all'){
                unset($searchby);
            } else if($searchby !== 'judul' && $searchby !== 'penyanyi' && $searchby !== 'tahun'){
                throw new Exception("400: searchby must be judul, penyanyi, tahun, or leave empty");
            }
        }

        // Pagination parameter, optional, default page 1 and pagesize 10
        if(!empty($_GET['page'])){
            $page = intval($_GET['page']);
        } else{
            $page = 1;
        }

        if(!empty($_GET['pagesize'])){
            $pagesize = intval($_GET['pagesize']);
        } else{
            $pagesize = $config['search_defaultpagesize'];
        }
        $offset = ($page-1) * $pagesize;

        // sortby, default by judul ascending
        if(!empty($_GET['sortby'])){
            $sortby = $_GET['sortby'];

            if($sortby !== 'judul' && $sortby != 'tahun'){
                throw new Exception("400: invalid sort by");
            }

            if($sortby === 'tahun'){
                $sortby = 'tahun_terbit';
            }
        } else{
            $sortby = 'judul';
        }

        if(!empty($_GET['desc']) && $_GET['desc'] == true){
            $sortorder = 'DESC';
        } else{
            $sortorder = 'ASC';
        }

        // genre, optional, default all genres will be returned
        if(!empty($_GET['genre'])){
            $genre = $_GET['genre'];
        }

        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
        
        if(!isset($_GET['search']) || empty($_GET['search'])){
            if(isset($genre)){
                $stmt = $db->prepare("SELECT COUNT(song_id) AS count FROM song
                                    WHERE genre = ?");
                $stmt->execute(array($genre));
            } else{
                $stmt = $db->prepare("SELECT COUNT(song_id) AS count FROM song");
                $stmt->execute(array());
            }
        } else if(!isset($searchby)){
            if(isset($genre)){
                $stmt = $db->prepare("SELECT COUNT(song_id) AS count FROM song
                                      WHERE (judul LIKE ? OR penyanyi LIKE ? OR YEAR(tanggal_terbit) = ?) AND genre = ?");
                $stmt->execute(array("%$search%", "%$search%", intval($search), $genre));
            } else{
                $stmt = $db->prepare("SELECT COUNT(song_id) AS count FROM song
                                      WHERE (judul LIKE ? OR penyanyi LIKE ? OR YEAR(tanggal_terbit) = ?)");
                $stmt->execute(array("%$search%", "%$search%", intval($search)));
            }
        } else if($searchby === 'judul'){
            if(isset($genre)){
                $stmt = $db->prepare("SELECT COUNT(song_id) AS count FROM song
                                      WHERE (judul LIKE ?) AND genre = ?");
                $stmt->execute(array("%$search%", $genre));
            } else{
                $stmt = $db->prepare("SELECT COUNT(song_id) AS count FROM song
                                      WHERE (judul LIKE ?)");
                $stmt->execute(array("%$search%"));
            }
        } else if($searchby === 'penyanyi'){
            if(isset($genre)){
                $stmt = $db->prepare("SELECT COUNT(song_id) AS count FROM song
                                      WHERE (penyanyi LIKE ?) AND genre = ?");
                $stmt->execute(array("%$search%", $genre));
            } else{
                $stmt = $db->prepare("SELECT COUNT(song_id) AS count FROM song
                                      WHERE (penyanyi LIKE ?)");
                $stmt->execute(array("%$search%"));
            }
        } else if($searchby === 'tahun'){
            if(isset($genre)){
                $stmt = $db->prepare("SELECT COUNT(song_id) AS count FROM song
                                      WHERE (YEAR(tanggal_terbit) = ?) AND genre = ?");
                $stmt->execute(array(intval($search), $genre));
            } else{
                $stmt = $db->prepare("SELECT COUNT(song_id) AS count FROM song
                                      WHERE (YEAR(tanggal_terbit) = ?)");
                $stmt->execute(array(intval($search)));
            }
        }

        $count = $stmt->fetch(PDO::FETCH_OBJ);
        $count->pagesize = $pagesize;
        $count->totalpages = ceil($count->count / $pagesize);
        return $count;
    }
?>
