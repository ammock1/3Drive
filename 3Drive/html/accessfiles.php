<?php

$mydir = '../file-upload/' . $_SESSION["username"];

//scanning files in a given diretory in ascending order
$myfiles = scandir($mydir, 1);
$length = count($myfiles);
?>
