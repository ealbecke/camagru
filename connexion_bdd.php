<?php
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=CAMAGRU', 'root', '');
		$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$bdd->exec("SET CHARACTER SET utf8");
		return $bdd;
	}
	catch (PDOException $e)
	{
		echo 'Erreur : ' . $e->getMessage();
		return false;
	}
?>
