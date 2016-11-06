<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="CSS/style.css" type="text/css"/>
	<title>Inscription</title>
</head>
<body>
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
			$login = htmlspecialchars($_POST['login']);
			$mail = htmlspecialchars($_POST['mail']);
			$passwd = hash('whirlpool' , htmlspecialchars($_POST['password']));
			$token = sha1(uniqid(rand()));
			include('connexion_bdd.php');
			$result =  $bdd->prepare("SELECT * FROM members WHERE mail = '$mail'");
			$result->execute();
			$ret = $result->rowCount();
			if ($ret == 0)
			{
				$req = $bdd->prepare("INSERT INTO members (login, mail, password, token, date_create) VALUES (:login, :mail, :pass, :token, NOW())");
				$req->bindValue(':login', $login);
				$req->bindValue(':mail', $mail);
				$req->bindValue(':pass', $passwd);
				$req->bindValue(':token', $token);
				$req->execute();
				$bdd = NULL;

				$sujet = "Activation de votre compte";
				$entete = "From: inscription@camagru.fr";
				$message = 'Bienvenue sur le site CAMAGRU

				Pour activer votre compte, clique ou copie le lien suivant : 
				
				http://localhost/CAMAGRU/token_activation.php?token='.$token.'&mail='.$mail.'
				----------------
				Ceci est un mail automatique.';
				mail($mail, $sujet, $message, $entete);
				session_start();
				$_SESSION['flash']['mail_token'] = '<p class="flash_green">un mail de confirmation vous a été envoyé</p>';
				header ('location: index.php');
			}
			else
				echo "Un user utilise deja ce mail";
		}
		else
			echo '<p class="flash_red">Veuillez remplir tout les champs du formulaire</p>';
		$bdd = NULL;
	}
?>
	<form action="inscription.php" method="post">
	<p>Login: <input type="text" name="login"></p>
	<p>mail: <input type="text" name="mail"></p>
	<p>Password: <input type="text" name="password"></p>
	<input type="submit" name="ok" value="Inscription">
	</form>
</body>
</html>