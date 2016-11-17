<?php
	session_start();
	if (!$_SESSION['login'])
	{
		header('location: index.php');
		exit();
	}
	include('connexion_bdd.php');
	$login = $_SESSION['login'];
	$result =  $bdd->prepare("SELECT * FROM pictures WHERE name_member = '$login' ORDER BY name_picture DESC");
	$result->execute();
	if ($result->rowCount() == 0)
	{
		header('location: index.php');
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Mes photos</title>
</head>
<body>
<?php
	$ret = $result->fetchAll();

	foreach ($ret as $elem)
	{
		echo "<img src='pictures/$elem[2]'/>";
		echo '<form action="delete_img.php" method="post">';
		echo '<input type="hidden" id="id_picture" name="id_picture" value="'.$elem[0].'" />';
		echo '<input type="hidden" id="name_member" name="name_member" value="'.$elem[1].'"/>';
		echo '<input type="hidden" id="name_picture" name="name_picture" value="'.$elem[2].'" />';
		echo '<input type="submit" value="Delete image" />';
		echo '</form>';
	}
?>
</body>
</html>