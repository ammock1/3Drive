<?php
error_reporting(0);
$mydir = '../file-upload/' . $_SESSION["username"];
$selectOpt = $_POST['folder'];

$cnt=1;
$user=$_SESSION["username"];
$conn = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($conn, "3drive");
$getfold=mysqli_query($conn, "SELECT * FROM folders WHERE Username = '$user'");
while($row = mysqli_fetch_array($getfold)){
  if($selectOpt==$cnt){
    $mydir=$mydir . '/'.$row['FolderNm'];
  }
  $cnt++;
}


//scanning files in a given diretory in ascending order
$myfiles = preg_grep('~\.(obj)$~', scandir($mydir));
$length = count($myfiles);
?>
