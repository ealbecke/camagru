<?php
	if ((isset($_GET['token'])) && (isset($_GET['login'])) && (!empty($_GET['token'])) && (!empty($_GET['login'])))
	{
		session_start();
		$token = addslashes(htmlentities(htmlspecialchars($_GET['token'])));
		$login = addslashes(htmlentities(htmlspecialchars($_GET['login'])));
		include ('connexion_bdd.php');
		$q = array ('login'=>$login, 'token'=>$token);
		$sql = "SELECT login, token FROM members WHERE login = :login AND token = :token";
		$req = $bdd->prepare($sql);
		$req->execute($q);
		$count = $req->rowCount($sql);
		if ($count == 1)
		{
			$v = array ('login'=>$login, 'actif'=>'1');
			$sql = "SELECT login, actif FROM members WHERE login = :login AND actif = :actif";
			$req = $bdd->prepare($sql);
			$req->execute($v);
			$dejactif = $req->rowCount($sql);
			if ($dejactif == 1)
			{
				$_SESSION['flash']['token'] = "<p class=\"flash_green\">Utilisateur deja actif</p>";
				header('location: index.php');
				exit();
			}
			else
			{
				$u = array ('actif'=>'1', 'login'=>$login);
				$sql = 'UPDATE members SET actif = :actif WHERE login = :login';
				$req = $bdd->prepare($sql);
				$req->execute($u);
				header('location: index.php');
				$_SESSION['flash']['validate'] = "<p class=\"flash_green\">le compte est activer</p>";
				exit();
			}
		}
		else
		{
			header('location: index.php');
			exit();
		}
	}
	else
	{
		header('location: index.php');
		exit();
	}
?>