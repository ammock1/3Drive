
<?php
	include ('logincode.php');
	include ('upload.php');
	include ('accessfiles.php');
	include ('download.php');
	include ('AddFolder.php');
	include ('logoff.php');
	include ('copyfile.php');

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
			<label>Folder Selection:</label>
			<form action="" method ="post">
				<select name="folder">

					<option value = "All">All</option>
					<?php
					$user=$_SESSION["username"];
					$count=1;
					$conn = mysqli_connect("localhost", "root", "");
		      $db = mysqli_select_db($conn, "3drive");
					$getfold=mysqli_query($conn, "SELECT * FROM folders WHERE Username = '$user'");
					while($row = mysqli_fetch_array($getfold)){
						$print=$row['FolderNm'];
		        echo "<option value=$count>$print</option>";
						$count++;
		      }
					mysqli_close($conn);
					?>
				</select>
				<input type="submit" value="Submit">
			</form>
			<form method="post">
				<input type = 'submit' class = 'button' value="Log Off" name="logoff" id="logoff">
			</form>
		</header>
		<div id = "sidebar">

			<form action="" method="post" enctype="multipart/form-data">

					<label>Username: <?php echo $_SESSION["username"];
					$user=$_SESSION["username"];?> </label> <br>
					<br><label> Upload Files </label> <br>
					<label> ~ .obj files will be available for viewing </label><br>
					<label> ~ .png files will be saved as thumbnails if the name corresponds with an uploaded .obj file </label><br>
					<input type = 'file' name="userfile"/>
					<input type = 'submit' value="Upload"/>
			</form>

			<form action ="" method="post">
				<label> Create Folder </label> <br> <br>
				<label>Folder Name: </label>
				<input type='text' id="folder" name="folder"/>
				<input type = 'submit' value="Create" name="create">
			</form>

		</div>

		<main>
			<!-- <div id="obj1" class="obj"> -->
				<?php for($i=2; $i<$length+2 ; $i++){
					echo "<div id='obj' class='obj'>";
					echo "<div class='objInfo'>";
					echo "<label class='objname'>$myfiles[$i]</label>";
					echo "</div>";
					//if file exists in user folder
					if(file_exists("../file-upload/" . $user . "/" ."thumbnails/" . substr($myfiles[$i],0,-4) . ".png")){
						$pathThumb="../file-upload/" . $user . "/" ."thumbnails/" . substr($myfiles[$i],0,-4). ".png";
						echo "<img class='image' src=$pathThumb width=128px/>";
					}
					//else use default image
					else{
						echo "<img class='image' src='../images/Cube.png' width=128px/>";
					}
					echo "<div class='options'>";
					echo	"<p><a href = 'viewer.php?filename=$myfiles[$i]&user=$user'>View</a></p>";
					echo 	"<p><a href='download.php?file=$myfiles[$i]&user=$user'> Download</a></p>";
					echo 	"<p><a href='deletefile.php?file=$myfiles[$i]&user=$user&dir=$mydir'> Delete</a></p>";
					echo 	"<p><a href='../php_manifold/ManifoldChecker.php?file=$myfiles[$i]&user=$user'> Check Manifold</a></p>";
					$openform="openForm(".$i.")";
					echo "<button class='open-button' onclick=$openform>Copy to Folder</button>";
					$myform="myForm".$i;
					echo "<div class='form-popup' id=$myform>";
					echo "<form action='copyfile.php?filename=$myfiles[$i]&user=$user' method='post'>";
					echo "<label>Choose Folders</label><br>";
					$count=1;
					$conn = mysqli_connect("localhost", "root", "");
					$db = mysqli_select_db($conn, "3drive");
					$getfold=mysqli_query($conn, "SELECT * FROM folders WHERE Username = '$user'");
					while($row = mysqli_fetch_array($getfold)){
						$print=$row['FolderNm'];
						echo "<input type='radio' name='foldname' value=$print><label for=$count>$print</label><br>";
						$count++;
					}

					echo "<button type='submit' class='btn' name='copy'>Copy</button>";
					$closeform="closeForm(".$i.")";
					echo "<button type='button' class='btn cancel' onclick=$closeform>Cancel</button>";
					echo "</form>";
					mysqli_close($conn);
					echo "</div>";
					echo "</div>";
					echo "</div>";
				} ?>

				<script>
				function openForm(num) {
  				document.getElementById("myForm"+num).style.display = "block";
				}

				function closeForm(num) {
  				document.getElementById("myForm"+num).style.display = "none";
				}
			</script>
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
