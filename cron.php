<?php


$txt = "cron  run at ".date("Y-m-d h:i:sa");;
 $myfile = file_put_contents('logs.txt', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
?>