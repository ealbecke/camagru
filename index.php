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
			<button id="startbutton">Prendre une photo</button>
		</div>

		<div id="side">
	  		<canvas id="canvas"></canvas>

	  		
	  		<div id="pic_bdd">
			  	<?php include 'insert_img.php'; ?>
			</div>

	  <div id="hello"></div>
	</div>
	</div>


<script src="cam.js"></script>

<?php } ?>
<footer></footer>
</body>
</html>
