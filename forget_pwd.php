<?php
session_start();
if(isset($_POST['pass'])) {
	if (isset($_POST['pwd1']) && !empty($_POST['pwd1']) && isset($_POST['pwd2']) && !empty($_POST['pwd2'])) {
		$pwd1 = hash('whirlpool' , addslashes(htmlentities(htmlspecialchars($_POST['pwd1']))));
		$pwd2 = hash('whirlpool' , addslashes(htmlentities(htmlspecialchars($_POST['pwd2']))));
		$_POST['pwd1'] = NULL;
		$_POST['pwd2'] = NULL;
		if ($pwd1 == $pwd2) {
			$login_pw = addslashes(htmlentities(htmlspecialchars($_POST['login_pw'])));
			include('connexion_bdd.php');
			$result = $bdd->prepare('SELECT login FROM members WHERE login = :login');
			$result->bindValue(':login', $login_pw);
			$result->execute();
			$num = $result->fetchAll();
			$count = count($num);
			if ($count == 1) {
				$req = $bdd->prepare("UPDATE members SET password = '$pwd1' WHERE login = '$login_pw'");
				$req->execute();
				$bdd = NULL;
				$pwd1 = NULL;
				$pwd2 = NULL;
				header('location: index.php');
				$_SESSION['flash']['info'] = "<p class=\"flash_green\">Votre mot de passe a ete changé avec succes !</p>";
			}
			$bdd = NULL;
		}
		else
			$_SESSION['flash']['forget_pwd'] = "<p class=\"flash_red\">Les mots de passe ne sont pas les memes</p>";
	}
	else
		$_SESSION['flash']['forget_pwd'] = "<p class=\"flash_red\">Il faut remplir les deux champs pour le mot de passe</p>";
}
if (isset($_GET['login']) && !empty($_GET['login'])) {
	$log = addslashes(htmlentities(htmlspecialchars($_GET['login'])));
	include('connexion_bdd.php');
	$result = $bdd->prepare('SELECT login FROM members WHERE login = :log');
	$result->bindValue(':log', $log);
	$result->execute();
	$bdd = NULL;
	$num = $result->fetchAll();
	$count = count($num);
	if ($count == 1) {
		echo "<form action=\"forget_pwd.php\" method=\"post\">
		<p>Nouveau: <input type=\"password\" name=\"pwd1\"></p>
		<p>Confirmer Nouveau: <input type=\"password\" name=\"pwd2\"></p>
		<input type='hidden' name='login_pwd' value='". $log ."'>
		<input type=\"submit\" name=\"pass\" value=\"Envoyer\">
		</form>";
	}
	else
		$_SESSION['flash']['forget_pwd'] = "<p class=\"flash_red\">NON, NON, NON, de quel droit tu changes l'URL ?
		<br />
		Tu ne pourras pas me baisser, mais essaye encore ;)</p>";
}
if (isset($_POST['login']) && !empty($_POST['login'])) {
	$login = addslashes(htmlentities(htmlspecialchars($_POST['login'])));
	include('connexion_bdd.php');
	$result = $bdd->prepare('SELECT mail FROM members WHERE login = :login');
	$result->bindValue(':login', $login);
	$result->execute();
	$bdd = NULL;
	$num = $result->fetchAll();
	$count = count($num);
	$mail = $num[0][mail];
	if ($count == 1) {
		$sujet = "Reset mot de passe";
		$entete = "From: camagru.fr";
		$message = 'Pour reset ton mot de passe, click sur le lien suivant :

			http://localhost:8080/camagru/forget_pwd.php?login='.$login.'
			OU
			http://localhost/camagru/forget_pwd.php?login='.$login.'
			OU
			http://localhost/CAMAGRU/forget_pwd.php?login='.$login.'
			----------------
			Ceci est un mail automatique.';
		mail($mail, $sujet, $message, $entete);
		$_SESSION['flash']['info'] = "<p class=\"flash_green\"> On vous a envoye un mail !</p>";
		header('location: index.php');
		exit();
	}
	else
		$_SESSION['flash']['forget_pwd'] = "<p class=\"flash_red\">Ce login ne match pas !</p>";
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css"/>
	<title>Inscription</title>
</head>
<body>
<?php
echo $_SESSION['flash']['forget_pwd'];
$_SESSION['flash']['forget_pwd'] = NULL;
if ((!isset($_POST['login']))  || (isset($_POST['login']) && empty($_POST['login'])) ||(isset($count) && $count == 0)) {
	if (!isset($_GET['login']) && !isset($_POST['pass'])) {
		echo "<p>Merce d'inscire votre login pour que l'on vous envoie un mail</p>";
		echo "<form action=\"forget_pwd.php\" method=\"post\">";
		echo "<p>login: <input type=\"text\" name=\"login\"></p>";
		echo "<input type=\"submit\" name=\"ok\" value=\"Envoyer\">";
		echo "</form>";
	}
}
?>

<!-- LIGNE 30 && 33 il faut faire une verifications de champs en Javascript -->
</body>
</html>

