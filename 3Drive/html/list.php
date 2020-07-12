
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
		<script src="../js/list.css"></script>
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
				<div class="display">
					<div class="objInfo">
						<label class="objname">Obj name here</label>
						<button class="ham"></button>
					</div>
					<img src="../images/Cube.png" width=128px/>
				</div>
				<div class="options">
					<p>View</p>
					<p>Download</p>
					<p>Add to list</p>
					<p>Remove from list</p>
				</div>
			</div>
		</main>
		<footer>
			<hr>
			&copy; 2020 Anne Mock and Claire Meany
		</footer>
	</body>
</html>
