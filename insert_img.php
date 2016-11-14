<?php
	session_start();
	include('connexion_bdd.php');
	$login = $_SESSION['login'];
	$result =  $bdd->prepare("SELECT * FROM pictures WHERE name_member = '$login' ORDER BY name_picture DESC");
	$result->execute();
	$ret = $result->fetchAll();

foreach ($ret as $elem)
	echo "<img src='pictures/$elem[2].jpg'/>";
?>