<?php
  $file = urldecode($_REQUEST["file"]);
  $user=urldecode($_REQUEST["user"]);
  $filepath = urldecode($_REQUEST["dir"]) . "/" .$file;

  unlink($filepath);
  header("Location: list.php");
?>
