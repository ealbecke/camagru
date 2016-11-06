<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="CSS/style.css" type="text/css"/>
	<title>Camagru</title>
</head>
<body>
<?php session_start(); 
echo $_SESSION['flash']['mail_token'];
echo $_SESSION['flash']['validate'];
echo $_SESSION['flash']['inscription'];
echo $_SESSION['flash']['pb'];
$_SESSION['flash']['validate'] = NULL;
$_SESSION['flash']['mail_token'] = NULL;
$_SESSION['flash']['inscription'] = NULL;
$_SESSION['flash']['pb'] = NULL;

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
		<p>Mail: <input type="text" name="mail">
		 Mot de passe: <input type="text" name="password">
		<input type="submit" name="ok" value="connexion"></p>
	</form>
	<a href="inscription.php">Inscription</a>
</header>
<?php } ?>

<video id="video"></video>
<img style="display: none; max-width: 600px; max-height: 480px;" id="img-filter" src="">


	<div class="video">
		<video id="video" class="center-block"></video>
		<img style="display: none; max-width: 600px; max-height: 480px;" id="img-filter" src="">
	</div>
	<button id="startbutton" class="center-block disabled" disabled="disabled"onclick="takepicture();">Prendre une photo</button>

	<div class="video">
		<canvas id="canvas" class="center-block" style="display: none;"></canvas>
		<img style="display: none; max-width: 600px; max-height: 480px;" id="img-filter2" class="center-block" src="">
	</div>

		<input type="hidden" name="data" id="myInput"></input>
</section>
<aside class="secondary clearfix">
	<h2 class="center">Dernières photos prises</h2>
	<div class="last clearfix" id="last">
		
	</div>
</aside>


<script type="text/javascript">

function activeButton() {

	var cadre = document.getElementById('cadre_item').checked;
	var chapeau = document.getElementById('chapeau_item').checked;
	var moustache = document.getElementById('moustache_item').checked;

	// input hidden
	var myFilter = document.getElementById('myFilter');

	if (cadre == true) {
	  myFilter.setAttribute('value', 'cadre');
	}
	else if (chapeau == true) {
	    myFilter.setAttribute('value', 'chapeau');
	}
	else if (moustache == true) {
		myFilter.setAttribute('value', 'moustache');
	}

	if (cadre == true || chapeau == true || moustache == true)
	{
		// bouton disabled
		var button = document.getElementById('startbutton');
		button.removeAttribute('disabled');
		button.classList.remove('disabled');

		var usend = document.getElementById('u_send');
		usend.removeAttribute('disabled');
		usend.classList.remove('disabled');
		
		var img_filter = document.getElementById('img-filter');
		img_filter.style.removeProperty('display');

		if (cadre == true) {
			img_filter.setAttribute('src', '/camagru/assets/img/cadre.png');
		}
		else if (chapeau == true) {
			img_filter.setAttribute('src', '/camagru/assets/img/chapeau.png');
		}
		else if (moustache == true) {
			img_filter.setAttribute('src', '/camagru/assets/img/moustache.png');
		}
		img_filter.className = 'center-block';
	}
}


</script>

</body>
</html>