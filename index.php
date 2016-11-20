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
//include ("headers/header_index.php");
include ("headers/header.php");
include("flash_messages.php");
if (isset($_SESSION['login'])){
?>
	<div class="container">

		<div id="choose_filter">
			<form>
			<p>1_ Selectionne ton filtre</p>
				<ul>
					<INPUT type="radio" style='visibility:hidden;display:none' name="toc" value="NULL" checked>
					<li>
						<INPUT type="radio" onclick="disabledButton()" id="validate" name="toc" value="validate">
						<label for="validate">
							<img class="filter" src="filter/validate.png">
						</label>
					</li>

					<li>
						<INPUT type="radio" onclick="disabledButton()" id="beard" name="toc" value="beard">
						<label for="beard">
							<img class="filter" src="filter/beard.png">
						</label>
					</li>

					<li>
						<INPUT type= "radio" onclick="disabledButton()" id="glass" name="toc" value="glass">
						<label for="glass">
							<img class="filter" src="filter/glass.png">
						</label>
					</li>
				</ul>
			</form>
		</div>

		<div id="select_picture">
			<p>2_ Choisi ton image</p>
			
			<div id="webcam">
				<video id="video"></video><br/ >
				<button class="bt_turquoise" id="startbutton">Prendre une photo</button>
			</div>

			<div id="upload_form">
			  	<form action="check_upload_pic.php" method="post" id="form_upload" name="form_upload" enctype="multipart/form-data">
					<label for="img">Veuillez choisir l'image a uploader (Max 5 Mo):</label><br />
					<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
					<input type="file" id="img" name="img" id="img" /><br />
					<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
					<input type="hidden" id="filterUpload" name="filterUpload" value="NULL">
					<input type="submit" class="bt_turquoise" id="buttonUpload"  value="envoyer" disabled="disabled"/>
				</form>
			</div>
		</div>

		<div id="return_pic">
		<p>3_ le resultat</p>
	  		<canvas id="canvas"></canvas>
	  		<div id="pic_bdd">
			  	<?php include 'insert_img.php'; ?>
			</div>
		</div>



		<div id="delete"><a href="user_picture.php">Supprimer des photos</a>
		</div>
	</div>

<script type="text/javascript">
</script>

<script type="text/javascript" src="cam.js"></script>
<?php }else {
	?>
	<header>
		<form action="check_connect.php" method="post">
			<p>Login: <input type="text" name="login">
			 Mot de passe: <input type="text" name="password">
			<input type="submit" name="ok" value="connexion"></p>
		</form>
		<a href="forget_pwd.php">Mot de passe oublie ?</a>
		<br />
		<a href="inscription.php">Inscription</a>
	</header>
	<p class="infos_general">CAMAGRU<br />
	Merci de vous connectrer ou de vous inscrire sur le site</p>
	<?php
}
	?>
<footer></footer>
</body>
</html>