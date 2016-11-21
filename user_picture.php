<?php
	session_start();
	include ("user_only.php");
	include('connexion_bdd.php');
	$login = $_SESSION['login'];
	$result =  $bdd->prepare("SELECT * FROM pictures WHERE name_member = '$login' ORDER BY name_picture DESC");
	$result->execute();
	if ($result->rowCount() == 0)
	{
		$_SESSION['flash']['info'] = "<p class=\"flash_red\">Vous n'avez pas pris de photo</p>";
		header('location: index.php');
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<title>Mes photos</title>
</head>
<body>
<?php
	include('headers/header.php');
	$ret = $result->fetchAll();
	echo "<div class=\"galerie\">";
	foreach ($ret as $elem)
	{
		echo "<div class=\"galerie_img\">";
		echo "<img src='pictures/$elem[2]'/>";
		echo '<form action="add_info_img.php" method="post">';
		echo '<input type="hidden" id="id_picture" name="id_picture" value="'.$elem[0].'" />';
		echo '<input type="hidden" id="name_member" name="name_member" value="'.$elem[1].'"/>';
		echo '<input type="hidden" id="name_picture" name="name_picture" value="'.$elem[2].'" />';
		echo '<input type="submit" value="Delete image" />';
		echo '</form>';
		echo "</div>";
	}
	echo "</div>";
?>
<footer><p>ealbecke - 2016</p></footer>
</body>
</html>