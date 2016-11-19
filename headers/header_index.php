<?php
echo "<header>";
if (isset($_SESSION['login']))
{
	echo "<h3 id=\"logo_header\"><a href=\"index.php\">WEBCAM</a></h3>
	<p id=\"bt_header\" >Bonjour: ".$_SESSION['login']."<br />
	<a href=\"galerie.php\" class=\"bt\">GALERIE</a><br />
	<a href=\"logout.php\" class=\"bt\">Se déconecter</a>";
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