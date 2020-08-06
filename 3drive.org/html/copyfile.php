<?php
if(isset($_POST['copy'])){
  $file = urldecode($_REQUEST["filename"]);
  $user=urldecode($_REQUEST["user"]);
  $source="../file-upload/" . $user . "/" . $file;
  $dest="../file-upload/" . $user . "/". $_POST["foldname"] . "/" . $file;
  copy($source, $dest);
  header("Location: list.php");
}
?>
