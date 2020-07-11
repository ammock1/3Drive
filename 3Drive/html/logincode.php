<?php

$invalid ='';

if(isset($_POST['submit'])){
	if(empty($_POST['user']) || empty($_POST['pass'])){
		$invalid =  "Field Missing";
	}
	else{
		$user=$_POST['user'];
		$pass1=$_POST['pass'];

		$conn = mysqli_connect("localhost", "root", "");
		$db = mysqli_select_db($conn, "3drive");
		$query = mysqli_query($conn, "SELECT * FROM users WHERE Password='$pass1' AND Username='$user'");

		$rows = mysqli_num_rows ($query);

		if($rows == 1){
			header("Location: list.html");
		}

		else{
			$invalid = "Incorrect Login";
		}

		mysqli_close($conn);
	}
}
?>
