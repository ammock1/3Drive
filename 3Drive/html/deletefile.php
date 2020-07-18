<?php
  $file = urldecode($_REQUEST["file"]);
  $user=urldecode($_REQUEST["user"]);
  $filepath = '../file-upload/'. $user . '/' . $file;

  unlink($filepath);
  header("Location: list.php");
?>
