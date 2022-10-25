<?php

setcookie('user_id', '', time()-3600, '/');
setcookie('key', '', time()-3600, '/');

header("Location: ../login/login.php");

?>