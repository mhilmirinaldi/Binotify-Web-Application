<?php
    function generatePageButton($page, $currentPage, $baseLink, $urlParams){
        if(!empty($urlParams)){
            parse_str($urlParams, $parsedParams);
            $parsedParams['page'] = $page;
            $paramsStr = http_build_query($parsedParams);
            $href = "$baseLink?$paramsStr";
        } else{
            $href = "$baseLink?page=$page";
        }

        if($page == $currentPage){
            $class = "active page-button";
        } else{
            $class = "page-button";
        }

        if(!empty($urlParams)){
            $html = <<<EOT
            <a class="$class" href="$href">
                $page
            </a>
            EOT;

        } else{
            $html = <<<EOT
            <a class="$class" href="$href">
                $page
            </a>
            EOT;
        }

        echo $html;
    }

    // $urlParams mungkin null
    function generatePagination($currentPage, $pageCount, $baseLink, $urlParams){
        echo '<div class="pagination-container">';
        for($i = 0; $i < $pageCount; $i++){
            generatePageButton($i+1, $currentPage, $baseLink, $urlParams);
        }
        echo '</div>';
    }
?>
