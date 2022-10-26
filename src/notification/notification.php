<link rel = "stylesheet" href="../notification/notification.css">

<?php
function echo_notification($desc = "Default Description", $img = "../notification/success.svg") {
   $html = <<<"EOT"
    <div class="notification"> 
        <img src=$img></img>
        <p>$desc</p>
    </div>
    EOT;
   echo $html;
}
?>
