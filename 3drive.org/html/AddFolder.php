<?php
error_reporting(0);
	$folderarr = array();

  if(isset($_POST['create'])){
    if(empty($_POST['folder'])){
      echo "<label>Field Missing </label>";
    }
    else{
			$user= $_SESSION["username"];
			$foldname = $_POST['folder'];
			//create folder in file Directory if it doesnt exist
			if(!file_exists("../file-upload/". $user ."/".$foldname)){
				mkdir("../file-upload/". $user ."/".$foldname, 0700);
				//add folder to db
				$conn = mysqli_connect("localhost", "root", "");
				$db = mysqli_select_db($conn, "3drive");


				$getID =mysqli_query($conn, "SELECT * FROM folders WHERE 1");
				$folderID= mysqli_num_rows ($getID);
				$folderID++;

				mysqli_query($conn, "INSERT INTO folders VALUES ('$folderID', '$user', '$foldname')");

				mysqli_close($conn);
			}

    }
  }



?>
