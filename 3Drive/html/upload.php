<?php
  if(isset($_FILES['userfile'])){

    	$user=$_SESSION["username"];

      $filename =  ($_FILES['userfile']['name']);
    	$conn = mysqli_connect("localhost", "root", "");
    	$db = mysqli_select_db($conn, "3drive");
      $getID =mysqli_query($conn, "SELECT * FROM files");
      $fileID= mysqli_num_rows ($getID);
      $fileID++;
      $manifold = "N";
      $date = date("m/d/Y");
      mysqli_query($conn, "INSERT INTO files VALUES ('$user', '$filename', '$fileID', '$manifold', '$date')");
      mysqli_close($conn);

    move_uploaded_file($_FILES['userfile']['tmp_name'],
          '../file-upload/' . $_FILES['userfile']['name'] );
  }

?>
