<?php
$commentaire = addslashes(htmlentities(htmlspecialchars($_POST['commentaire'])));
if (isset($commentaire) && !empty($commentaire))
{
	$sender = addslashes(htmlentities(htmlspecialchars($_POST['sender'])));
	$recipient = addslashes(htmlentities(htmlspecialchars($_POST['recipient'])));
	$id_picture = addslashes(htmlentities(htmlspecialchars($_POST['id_picture'])));
	$name_picture = addslashes(htmlentities(htmlspecialchars($_POST['name_picture'])));
	include('connexion_bdd.php');
	$result =  $bdd->query("INSERT INTO comments (sender, recipient, id_picture, name_picture, commentaire) VALUES ('$sender', '$recipient', '$id_picture', '$name_picture', '$commentaire')");
}
header('location: galerie.php');
?>