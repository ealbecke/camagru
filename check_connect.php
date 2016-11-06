<?php
if ((isset($_POST['mail'])) && isset($_POST['password']) && !empty($_POST['mail']) && !empty($_POST['password']))
{
	$mail = htmlspecialchars($_POST['mail']);
	$passwd = hash('whirlpool' , htmlspecialchars($_POST['password']));
	include('connexion_bdd.php');
	$result = $bdd->prepare('SELECT mail FROM members WHERE mail = :mail');
	$result->bindValue(':mail', $mail);
	$result->execute();
	$num = $result->fetchAll();
	$count = count($num);
	if ($count == 1)
	{
		$res = $bdd->prepare('SELECT actif FROM members WHERE mail = :mail');
		$res->bindValue(':mail', $_POST['mail']);
		$res->execute();
		$rep = $res->fetch();
		if ($rep['actif'] ==1)
		{
			$req = $bdd->prepare('SELECT password FROM members WHERE mail = :mail');
			$req->bindValue(':mail', $mail);
			$req->execute();
			$ret = $req->fetch();
			if ($ret['password'] == $passwd)
			{
				session_start();
				$req = $bdd->prepare('SELECT * FROM members WHERE mail = :mail');
				$req->bindValue(':mail', $mail);
				$req->execute();
				$ret = $req->fetch();
				$_SESSION['mail'] = $mail;
				$_SESSION['login'] = $ret['login'];
				header('location: index.php');
				exit();	
			}
			else
			{
				header ('location: index.php');
				session_start();
				$_SESSION['flash']['ps_begin_page(psdoc, width, height)'] = "<p class=\"flash_red\">Mot de passe Incorrect</p>";
				exit();
			}
		}
		else
		{
			header ('location: index.php');
			session_start();
			$_SESSION['flash']['pb'] = '<p class="flash_red">Vous devez valider votre inscription via le Mail</p>';
			exit();
		}

	}
	else
	{
		header ('location: index.php');
		session_start();
		$_SESSION['flash']['pb'] = "<p class=\"flash_red\">Vous n'etes pas inscrit</p>";
		exit();
	}
}
else
{
	header ('location: index.php');
	session_start();
	$_SESSION['flash']['pb'] = '<p class="flash_red">Les champs du formulaire sont vides</p>';
	exit();
}