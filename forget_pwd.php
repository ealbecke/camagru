<?php
session_start();

if(isset($_POST['pass']))
{
	if (isset($_POST['pwd1']) && !empty($_POST['pwd1']) && isset($_POST['pwd2']) && !empty($_POST['pwd2']))
	{
		$pwd1 = hash('whirlpool' , htmlspecialchars($_POST['pwd1']));
		$pwd2 = hash('whirlpool' , htmlspecialchars($_POST['pwd2']));
		if ($pwd1 == $pwd2)
		{
			$login_pw = $_POST['login_pwd'];
			include('connexion_bdd.php');
			$result = $bdd->prepare('SELECT login FROM members WHERE login = :login');
			$result->bindValue(':login', $login_pw);
			$result->execute();
			$num = $result->fetchAll();
			$count = count($num);
			if ($count == 1)
			{
				$req = $bdd->prepare("UPDATE members SET password = '$pwd1' WHERE login = '$login_pw'");
				$req->execute();
				$bdd = NULL;
				header('location: index.php');
				$_SESSION['flash']['new_pwd'] = "<p class=\"flash_green\">Votre mot de passe a ete changé avec succes !</p>";
			}
			$bdd = NULL;

		}
		else
			echo "Les mots de passe ne sont pas les memes";
	}
	else
		echo "Il faut remplir les deux champs pour le mot de passe";
}

if (isset($_GET['login']) && !empty($_GET['login']))
{
	$log = htmlspecialchars($_GET['login']);
	include('connexion_bdd.php');
	$result = $bdd->prepare('SELECT login FROM members WHERE login = :log');
	$result->bindValue(':log', $log);
	$result->execute();
	$bdd = NULL;
	$num = $result->fetchAll();
	$count = count($num);
	if ($count == 1)
	{
		echo "<form action=\"forget_pwd.php\" method=\"post\">";
		echo "<p>Nouveau: <input type=\"password\" name=\"pwd1\"></p>";
		echo "<p>Confirmer Nouveau: <input type=\"password\" name=\"pwd2\"></p>";
		echo "<input type='hidden' name='login_pwd' value='". $log ."'>";
		echo "<input type=\"submit\" name=\"pass\" value=\"Envoyer\">";
		echo "</form>";
	}
	else
	{
		echo "NON, NON, NON, de quel droit tu changes l'URL ?";
		echo "<br />";
		echo "Tu ne pourras pas me baisser, mais essaye encore ;)";
	}
}

if (isset($_POST['login']) && !empty($_POST['login']))
{
	$login = htmlspecialchars($_POST['login']);
	include('connexion_bdd.php');
	$result = $bdd->prepare('SELECT mail FROM members WHERE login = :login');
	$result->bindValue(':login', $login);
	$result->execute();
	$bdd = NULL;
	$num = $result->fetchAll();
	$count = count($num);
	$mail = $num[0][mail];
	if ($count == 1)
	{
		$sujet = "Reset mot de passe";
		$entete = "From: camagru.fr";
		$message = 'Pour reset ton mot de passe, click sur le lien suivant :

			http://e2r1p2.42.fr:8080/camagru/forget_pwd.php?login='.$login.'
			OU
			http://localhost/camagru/forget_pwd.php?login='.$login.'
			OU
			http://localhost/CAMAGRU/forget_pwd.php?login='.$login.'
			----------------
			Ceci est un mail automatique.';
		mail($mail, $sujet, $message, $entete);

		echo "On vous a envoye un mail !";
	}
	else
		echo "Ce login ne match pas !";
}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="CSS/style.css" type="text/css"/>
	<title>Inscription</title>
</head>
<body>

<?php

if ((!isset($_POST['login']))  || (isset($_POST['login']) && empty($_POST['login'])) ||(isset($count) && $count == 0))
{
	if (!isset($_GET['login']) && !isset($_POST['pass']))
	{
		echo "<form action=\"forget_pwd.php\" method=\"post\">";
		echo "<p>login: <input type=\"text\" name=\"login\"></p>";
		echo "<input type=\"submit\" name=\"ok\" value=\"Envoyer\">";
		echo "</form>";
	}
}
?>
</body>
</html>
