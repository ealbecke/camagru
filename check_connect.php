<?php
if ((isset($_POST['login'])) && isset($_POST['password']) && !empty($_POST['login']) && !empty($_POST['password']))
{
	$login = htmlspecialchars($_POST['login']);
	$passwd = hash('whirlpool' , htmlspecialchars($_POST['password']));
	include('connexion_bdd.php');
	$result = $bdd->prepare('SELECT login FROM members WHERE login = :login');
	$result->bindValue(':login', $login);
	$result->execute();
	$num = $result->fetchAll();
	$count = count($num);
	if ($count == 1)
	{
		$res = $bdd->prepare('SELECT actif FROM members WHERE login = :login');
		$res->bindValue(':login', $login);
		$res->execute();
		$rep = $res->fetch();
		if ($rep['actif'] ==1)
		{
			$req = $bdd->prepare('SELECT password FROM members WHERE login = :login');
			$req->bindValue(':login', $login);
			$req->execute();
			$ret = $req->fetch();
			if ($ret['password'] == $passwd)
			{
				session_start();
				$req = $bdd->prepare('SELECT * FROM members WHERE login = :login');
				$req->bindValue(':login', $login);
				$req->execute();
				$ret = $req->fetch();
				$_SESSION['login'] = $login;
				$_SESSION['mail'] = $ret['mail'];
				$_SESSION['id'] = $ret['id'];
				$bdd = NULL;
				header('location: index.php');
				exit();	
			}
			else
			{
				header ('location: index.php');
				session_start();
				$_SESSION['flash']['ps_begin_page(psdoc, width, height)'] = "<p class=\"flash_red\">Mot de passe Incorrect</p>";
				$bdd = NULL;
				exit();
			}
		}
		else
		{
			header ('location: index.php');
			session_start();
			$_SESSION['flash']['pb'] = '<p class="flash_red">Vous devez valider votre inscription via le Mail</p>';
			$bdd = NULL;
			exit();
		}

	}
	else
	{
		header ('location: index.php');
		session_start();
		$_SESSION['flash']['pb'] = "<p class=\"flash_red\">Vous n'etes pas inscrit</p>";
		$bdd = NULL;
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