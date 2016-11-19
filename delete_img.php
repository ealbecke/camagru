<?php
session_start();
$member_pic = htmlspecialchars($_POST['name_member']);
$id_pic = htmlspecialchars($_POST['id_picture']);
$name_pic = htmlspecialchars($_POST['name_picture']);
if ($_SESSION['login'] == $member_pic)
{
	include('connexion_bdd.php');
	$result =  $bdd->query("DELETE FROM pictures WHERE id = $id_pic");
	if (file_exists("pictures/" . $name_pic))
	{
		unlink("pictures/" . $name_pic);
		$ret =  $bdd->prepare("SELECT * FROM comments WHERE name_picture = '$name_pic'");
		$ret->execute();
		if ($ret->rowCount() != 0)
		{
			foreach ($ret as $key)
				$ret = $bdd->query("DELETE FROM comments WHERE name_picture = '$name_pic'");
		}
		$bdd = NULL;
		header('location: user_picture.php');
		exit();
	}
	$bdd = NULL;
	header('location: user_picture.php');
	exit();
}
else
{
	header('location: index.php');
	exit();
}
?>