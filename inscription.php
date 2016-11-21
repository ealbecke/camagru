<?php
	session_start();
	if (isset($_SESSION['login']))
	{
		$_SESSION['flash']['inscription'] = "<p class=\"flash_green\">Vous etes connecté, vous ne pouvez donc pas vous inscrire</p>";
		header('location: index.php');
		exit;
	}
	if (isset($_POST['ok']))
	{
		if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['mail']) && !empty($_POST['mail']) && isset($_POST['password']) && !empty($_POST['password']))
		{
			$pattern = '/^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])/';
			if (preg_match($pattern, $_POST['password']))
			{
				$login = addslashes(htmlentities(htmlspecialchars($_POST['login'])));
				$mail = addslashes(htmlentities(htmlspecialchars($_POST['mail'])));
				$passwd = hash('whirlpool' , addslashes(htmlentities(htmlspecialchars($_POST['password']))));
				$token = sha1(uniqid(rand()));
				include('connexion_bdd.php');
				$result =  $bdd->prepare("SELECT * FROM members WHERE login = '$login'");
				$result->execute();
				$ret = $result->rowCount();
				if ($ret == 0)
				{
					$req = $bdd->prepare("INSERT INTO members (login, mail, password, token, create_date) VALUES (:login, :mail, :pass, :token, NOW())");
					$req->bindValue(':login', $login);
					$req->bindValue(':mail', $mail);
					$req->bindValue(':pass', $passwd);
					$req->bindValue(':token', $token);
					$req->execute();
					$bdd = NULL;
					header ('location: index.php');
					$sujet = "Activation de votre compte";
					$entete = "From: inscription@camagru.fr";
					$message = 'Bienvenue sur le site CAMAGRU

						Pour activer votre compte, clique ou copie le lien suivant : 
						http://localhost:8080/camagru/token_activation.php?token='.$token.'&login='.$login.'
						
						----------------
						Ceci est un mail automatique.';
					mail($mail, $sujet, $message, $entete);
					session_start();
					$_SESSION['flash']['mail_token'] = "<p class=\"flash_green\">un mail de confirmation vous a été envoyé</p>";
				}
				else
					$_SESSION['flash']['registration'] = "<p class=\"flash_red\">Ce login est deja utilisé</p>";
			}
			else
				$_SESSION['flash']['registration'] = '<p class="flash_red">Veuillez vous assurer qu\'il y a au min une Maj, une Min ainsi qu\'un chiffre</p>';
		}
		else
			$_SESSION['flash']['registration'] = '<p class="flash_red">Veuillez remplir tout les champs du formulaire</p>';
		$bdd = NULL;
	}
	?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css"/>
	<title>Inscription</title>
</head>
<body>
<header>
	<a href="index.php">Accueil</a>
	<form action="inscription.php" method="post">
	<p>Login: <input type="text" name="login"></p>
	<p>mail: <input type="email" name="mail"></p>
	<p>Password: <input type="password" name="password"></p>
	<input type="submit" name="ok" value="Inscription">
	</form>
</header>
<?php 
	echo $_SESSION['flash']['registration'];
	$_SESSION['flash']['registration'] = NULL;
?>
<p class="infos_general">Merci de remplir les champs pour vous inscrire</p>
<footer><p>ealbecke - 2016</p></footer>
</body>
</html>
