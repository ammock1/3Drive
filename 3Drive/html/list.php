
<?php
	include ('logincode.php');
	include ('upload.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>3Drive</title>
		<link rel="stylesheet" href="../css/list.css" />
		<style>
		</style>
	</head>
	<body>
		<header>
			<img id="logo" src="../images/Logo.png" width = "90px">
			<form>
				<label>Viewing models in:</label>
				<select>
					<option>All</option>
				</select>
			</form>
		</header>
		<div id = "sidebar">

			<form action="" method="post" enctype="multipart/form-data">
					<label>Username: <?php echo $_SESSION["username"]; ?> </label>

					<input type = 'file' id="userfile" name="userfile" accept=".obj"/>
					<input type = 'submit' value="Upload"/>
			</form>

		</div>
		<main>
			<div id="obj1" class="obj">
				<div class="objInfo">
					<label class="objname">Obj name here</label>
					<button>hamburger</button>
				</div>
				<img src="../images/Cube.png" width=128px/>
			</div>
			<div id="obj2" class="obj">
				<label class="objname">CUBE</label>
				<button>hamburger</button>
				<img src="../images/Cube.png" width=128px/>
			</div>
		</main>
		<footer>
			<hr>
			&copy; 2020 Anne Mock and Claire Meany
		</footer>
	</body>
</html>
