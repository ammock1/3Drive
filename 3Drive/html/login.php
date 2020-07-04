<?php
	include ('logincode.php')
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>3Drive</title>
		<link rel="stylesheet" href="../css/register.css" />
		<style>
			body { margin: 0; }
			canvas { display: block; }
		</style>
	</head>
	<body>
		<header>
			<img id="logo" src="../images/Logo.png" width = "128px">
			<h1> 3Drive </h1>
		</header>
		<main>
			<h2>Log in </h2>
			<form action="" method="post">
				<p>
					<label>Username: </label>
					<input type='text' id="user" name="user"/>
				</p>
				<p>
					<label>Password: </label>
					<input type='password' id="pass" name="pass"/>
				</p>
					<a href = '3drive.html'>Cancel</a>
					<input type = 'submit' name="submit">
					<span><?php echo $invalid; ?></span>
			</form>
		</main>
		<footer>
			&copy; 2020 Anne Mock and Claire Meany
		</footer>
	</body>
</html>
