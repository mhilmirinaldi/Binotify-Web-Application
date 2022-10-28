<?php
    $config = include('../config.php');

    // Search must not be empty
    if(empty($_GET['search'])){
        http_response_code(400);
        echo "search must not be empty";
        exit;
    }
    $search = $_GET['search'];

    // searchby, optional, default search all aspects
    if(!empty($_GET['searchby'])){
        $searchby = $_GET['searchby'];
        if($searchby !== 'judul' && $searchby !== 'penyanyi' && $searchby !== 'tahun'){
            http_response_code(400);
            echo "searchby must be judul, penyanyi, tahun, or leave empty";
            exit;
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

        if($sortby !== 'judul' && $sortby !== 'penyanyi' && $sortby != 'tahun'){
            http_response_code(400);
            echo "invalid sort by";
            exit;
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

    try{
        $db = new PDO($config['db_pdo_connect'], $config['db_user'], $config['db_password']);
        
        if(!isset($searchby)){
            if(isset($genre)){
                $stmt = $db->prepare("SELECT COUNT(song_id) AS count FROM song
                                      WHERE (judul LIKE ? OR penyanyi LIKE ? OR YEAR(tanggal_terbit) = ?) AND genre = ?");
                $stmt->execute(array("%$search%", "%$search%", intval($search), $genre));
            } else{$searchby = $_GET['searchby'];
                if($searchby == 'all'){
                    unset($searchby);
                } else if($searchby !== 'judul' && $searchby !== 'penyanyi' && $searchby !== 'tahun'){
                    $stmt = $db->prepare("SELECT COUNT(song_id) AS count FROM song
                                      WHERE (judul LIKE ? OR penyanyi LIKE ? OR YEAR(tanggal_terbit) = ?)");
                    $stmt->execute(array("%$search%", "%$search%", intval($search)));
                }
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
        $count->totalpages = ceil($count->count / $pagesize);
        
        header('Content-type: application/json');
        echo json_encode($count);
        
    } catch(Exception $e){
       http_response_code(500);
       echo "server database error";
    }
?>
