<?php

if(isset($_POST['logoff'])){

  session_destroy();
  header("Location: 3drive.html");
  //exit;
}

?>
