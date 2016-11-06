<?php
	if ((isset($_GET['token'])) && (isset($_GET['mail'])) && (!empty($_GET['token'])) && (!empty($_GET['mail'])))
	{
		$token = htmlspecialchars($_GET['token']);
		$mail = htmlspecialchars($_GET['mail']);
		include ('connexion_bdd.php');
		$q = array ('mail'=>$mail, 'token'=>$token);
		$sql = "SELECT mail, token FROM members WHERE mail = :mail AND token = :token";
		$req = $bdd->prepare($sql);
		$req->execute($q);
		$count = $req->rowCount($sql);
		if ($count == 1)
		{
			$v = array ('mail'=>$mail, 'actif'=>'1');
			$sql = "SELECT mail, actif FROM members WHERE mail = :mail AND actif = :actif";
			$req = $bdd->prepare($sql);
			$req->execute($v);
			$dejactif = $req->rowCount($sql);
			if ($dejactif == 1)
			{
				echo "utilisateur deja actif";
			}
			else
			{
				session_start();
				$u = array ('actif'=>'1', 'mail'=>$mail);
				$sql = 'UPDATE members SET actif = :actif WHERE mail = :mail';
				$req = $bdd->prepare($sql);
				$req->execute($u);
				header('location: index.php');
				$_SESSION['flash']['validate'] = "<p class=\"flash_green\">le compte est activer</p>";
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