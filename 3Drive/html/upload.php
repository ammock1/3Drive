<?php
  if(isset($_FILES['userfile'])){
    $user=$_SESSION["username"];
    $target_dir = "../file-upload/" . $user . "/";
    $target_file = $target_dir . basename($_FILES['userfile']['name']);
    $upload_ok = 1;
    $image_file_type = pathinfo($target_file,PATHINFO_EXTENSION);
      //code to add to database - doesnt seem relevant at the moment
    	// $user=$_SESSION["username"];
      //
      // $filename =  ($_FILES['userfile']['name']);
    	// $conn = mysqli_connect("localhost", "root", "");
    	// $db = mysqli_select_db($conn, "3drive");
      // $getID =mysqli_query($conn, "SELECT * FROM files");
      // $fileID= mysqli_num_rows ($getID);
      // $fileID++;
      // $manifold = "N";
      // $date = date("m/d/Y");
      // mysqli_query($conn, "INSERT INTO files VALUES ('$user', '$filename', '$fileID', '$manifold', '$date')");
      // mysqli_close($conn);

    if (file_exists($target_file)) {
      echo "Filename taken, rename file.";
      $upload_ok = 0;
    }

    if($image_file_type != "obj") {
      echo "Only OBJ files are allowed.";
      $upload_ok = 0;
    }

    if ($upload_ok == 0) {
      echo "\nYour file could not be uploaded.";
    }
    else{
      move_uploaded_file($_FILES['userfile']['tmp_name'],
          '../file-upload/'. $user . '/' . $_FILES['userfile']['name'] );
    }
  }

?>
