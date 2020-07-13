
<?php
	include ('logincode.php');
	include ('upload.php');
	include ('accessfiles.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>3Drive</title>
		<link rel="stylesheet" href="../css/list.css" />
		<script src="../js/list.js"></script>
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
					<label>Username: <?php echo $_SESSION["username"];
					$user=$_SESSION["username"];?> </label>

					<input type = 'file' name="userfile"/>
					<input type = 'submit' value="Upload"/>
			</form>

		</div>

		<main>
			<!-- <div id="obj1" class="obj"> -->
				<?php for($i=0; $i<$length-2 ; $i++){
					echo "<div id='obj' class='obj'>";
					echo "<div class='objInfo'>";
					echo "<label class='objname'>$myfiles[$i]</label>";
					//echo	"<button class='ham'></button>";
					echo "</div>";
					echo "<img class='image' src='../images/Cube.png' width=128px/>";
					echo "<div class='options'>";
					echo	"<p><a href = 'viewer.php?filename=$myfiles[$i]&user=$user'>View</a></p>";
					echo 	"<p>Download</p>";
					echo 	"<p>Move</p>";
					echo "</div>";
					//echo "<a href = 'viewer.php?filename=$myfiles[$i]&user=$user'>$myfiles[$i]</a>";
					//echo "<br>";
					echo "</div>";
				} ?>
			<!-- </div> -->
			<div id="fileDisplay">


			</div>
		</main>
		<footer>
			<hr>
			&copy; 2020 Anne Mock and Claire Meany
		</footer>
	</body>
</html>
