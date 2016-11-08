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
echo $_SESSION['flash']['mail_token'];
echo $_SESSION['flash']['validate'];
echo $_SESSION['flash']['inscription'];
echo $_SESSION['flash']['pb'];
echo $_SESSION['flash']['new_pwd'];

$_SESSION['flash']['validate'] = NULL;
$_SESSION['flash']['mail_token'] = NULL;
$_SESSION['flash']['inscription'] = NULL;
$_SESSION['flash']['pb'] = NULL;
$_SESSION['flash']['new_pwd'] = NULL;
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
		<div id="main"></div>
		<div id="side"></div>
	</div>










<?php } ?>
<footer></footer>
</body>
</html>
