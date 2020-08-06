<?php
  if(isset($_FILES['userfile'])){
    $user=$_SESSION["username"];
    $target_dir = "../file-upload/" . $user . "/";
    $target_file = $target_dir . basename($_FILES['userfile']['name']);
    $upload_ok = 1;
    $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);

    if (file_exists($target_file)) {
      echo "Filename taken, rename file.";
      $upload_ok = 0;
    }

    if($image_file_type != "obj" &&$image_file_type != "png") {
      echo "Only OBJ and PNG files are allowed.";
      $upload_ok = 0;
    }

    if ($upload_ok == 0) {
      echo "\nYour file could not be uploaded.";
    }
    else{
      if($image_file_type == "png"){
        move_uploaded_file($_FILES['userfile']['tmp_name'],
            '../file-upload/'. $user.'/thumbnails' . '/' . $_FILES['userfile']['name']  );
      }
      else{
        move_uploaded_file($_FILES['userfile']['tmp_name'],
            '../file-upload/'. $user . '/' . $_FILES['userfile']['name'] );
      }

    }
  }

?>
