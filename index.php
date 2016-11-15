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
include 'print_error.php';
if (isset($_SESSION['login']))
{
	echo "Vous etes connecté";
	echo "<br />";
	echo "login: ".$_SESSION['login'];
	echo "<br />";
	echo "mail: ".$_SESSION['mail'];
	echo "<br />";
	echo "<a href=\"logout.php\">Se déconecter</a>";
}
else
{
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
<?php } ?>
<?php if (isset($_SESSION['login'])){?>
	


	<div id="container">
		


		<div id="main">
	  		<video id="video"></video>


	  	<form action="check_upload.php" method="post" enctype="multipart/form-data">
		<label for="img">Veuillez choisir l'image a uploader (Max 5 Mo):</label><br />
		<input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
		<input type="file" name="img" id="img" /><br />
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
					<INPUT type="radio" id="validate" name="toc" value="validate" onclick="buttonRadio()">
					<label for="validate">
						<img class="filter" src="filter/validate.png">
					</label>


					<INPUT type="radio" id="beard" name="toc" value="beard" onclick="buttonRadio()">
					<label for="beard">
							<img class="filter" src="filter/beard.png">
					</label>

					<INPUT type= "radio" id="glass" name="toc" value="glass" onclick="buttonRadio()">
					<label for="glass">
							<img class="filter" src="filter/lunette.png">
					</label>
			</form>
		</div>
	</div>




<script type="text/javascript">
	function buttonRadio()
	{
		var validate = document.getElementById('validate').checked;
		var beard = document.getElementById('beard').checked;
		var glass = document.getElementById('glass').checked;
		var startbut = document.getElementById('startbutton');
		
		var filter = {
			validate: 0,
			beard: 0,
			glass: 0
		};

		if (validate == true) {
			filter.validate = '1';
			filter.beard = '0';
			filter.glass = '0';
		}
		else if (beard == true) {
			filter.validate = '0';
			filter.beard = '1';
			filter.glass = '0';
		}
		else if (glass == true) {
			filter.validate = '0';
			filter.beard = '0';
			filter.glass = '1';
		}
		console.log(filter.validate);
		console.log(filter.beard);
		console.log(filter.glass);
	}

</script>
<script type="text/javascript" src="cam.js"></script>
<?php } ?>
<footer></footer>
</body>
</html>