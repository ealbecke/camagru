<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<title>Camagru</title>
</head>
<body>
<?php
include ("header_index.php");
include("flash_messages.php");
if (isset($_SESSION['login'])){
?>
	<div id="container">

		<div id="main">
	  		<video id="video"></video>


		  	<form action="check_upload_pic.php" method="post" id="form_upload" name="form_upload" enctype="multipart/form-data">
				<label for="img">Veuillez choisir l'image a uploader (Max 5 Mo):</label><br />
				<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
				<input type="file" id="img" name="img" id="img" /><br />
				<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
				<input type="hidden" id="filterUpload" name="filterUpload" value="NULL">
				<input type="submit" id="buttonUpload"  value="envoyer" disabled="disabled"/>
			</form>

			<button id="startbutton">Prendre une photo</button>
		</div>




		<div id="side">
	  		<canvas id="canvas"></canvas>
	  		<div id="pic_bdd">
			  	<?php include 'insert_img.php'; ?>
			</div>
		</div>

		<div id="choise_pic">
			<form>
					<INPUT type="radio" style='visibility:hidden;display:none' name="toc" value="NULL" checked>
					<INPUT type="radio" onclick="disabledButton()" id="validate" name="toc" value="validate">
					<label for="validate">
						<img class="filter" src="filter/validate.png">
					</label>

					<INPUT type="radio" onclick="disabledButton()" id="beard" name="toc" value="beard">
					<label for="beard">
							<img class="filter" src="filter/beard.png">
					</label>

					<INPUT type= "radio" onclick="disabledButton()" id="glass" name="toc" value="glass">
					<label for="glass">
							<img class="filter" src="filter/glass.png">
					</label>
			</form>
		</div>
		<div id="delete"><a href="user_picture.php">Supprimer des photos</a></div>
	</div>

<script type="text/javascript">



</script>





<script type="text/javascript" src="cam.js"></script>
<?php } ?>
<footer></footer>
</body>
</html>