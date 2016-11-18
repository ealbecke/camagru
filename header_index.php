<?php
echo "<header>";
if (isset($_SESSION['login']))
{
	echo "Vous etes connecté";
	echo "<br />";
	echo "login: ".$_SESSION['login'];
	echo "<br />";
	echo "mail: ".$_SESSION['mail'];
	echo "<br />";
	echo "<a href=\"logout.php\">Se déconecter</a>";
	echo "<br />";
	echo "<a href=\"galerie.php\">GALERIE</a>";
}
else
{
?>
		<form action="check_connect.php" method="post">
			<p>Login: <input type="text" name="login">
			 Mot de passe: <input type="text" name="password">
			<input type="submit" name="ok" value="connexion"></p>
		</form>
		<a href="forget_pwd.php">Mot de passe oublie ?</a>
		<br />
		<a href="inscription.php">Inscription</a>
<?php } ?>
</header>