<?php

$invalid ='';

if(isset($_POST['submit'])){
	if(empty($_POST['user']) || empty($_POST['pass1']) ||empty($_POST['pass2']) ){
		$invalid =  "Field Missing";
	}
	else{
		$user=$_POST['user'];
		$pass1=$_POST['pass1'];
    $pass2=$_POST['pass2'];

		$conn = mysqli_connect("localhost", "root", "");
		$db = mysqli_select_db($conn, "3drive");

    // check if passwords are equal
    if($pass1==$pass2){

		    $query = mysqli_query($conn, "SELECT * FROM users WHERE Username='$user'");
		    $rows = mysqli_num_rows ($query);

		    if($rows == 1){
			       $invalid = "Username taken";
		    }

		    else{
						$pass1=md5($pass1);
						mkdir("../file-upload/". $user, 0700);
            mysqli_query($conn, "INSERT INTO USERS VALUES ('$user', '$pass1')");
						header("Location: login.php");
			      $invalid = "Registration successful";
		    }
    }
    else{
       $invalid = "Passwords do not match";
    }
		mysqli_close($conn);
	}
}
?>
