<?php
session_start();
include ("user_only.php");
$id_picture = addslashes(htmlentities(htmlspecialchars($_POST['id_picture'])));
$name_picture = addslashes(htmlentities(htmlspecialchars($_POST['name_picture'])));
$sender = addslashes(htmlentities(htmlspecialchars($_POST['sender'])));
$recipient = addslashes(htmlentities(htmlspecialchars($_POST['recipient'])));
if (isset($_POST['commentaire']) && !empty($_POST['commentaire']))
{
	$commentaire = addslashes(htmlentities(htmlspecialchars($_POST['commentaire'])));
	include('connexion_bdd.php');
	$result =  $bdd->query("INSERT INTO comments (sender, recipient, id_picture, name_picture, commentaire) VALUES ('$sender', '$recipient', '$id_picture', '$name_picture', '$commentaire')");
	$ret = $bdd->prepare("SELECT mail FROM members WHERE login = '$recipient'");
	$ret->execute();
	$recipient = $ret->fetch();
	$bdd = NULL;
	$mail = $recipient['mail'];

	$sujet = "Commentaire";
	$entete = "CAMAGRU";
	$message = 'Votre photo a ete commenté par ' . $sender;
	mail($mail, $sujet, $message, $entete);
}
else if ($_POST['like'])
{
	include('connexion_bdd.php');
	$result =  $bdd->query("INSERT INTO likes (sender, recipient, id_picture, name_picture, active) VALUES ('$sender', '$recipient', '$id_picture', '$name_picture', 1)");
	$bdd = NULL;
}
else if ($_POST['unlike'] == 0)
{
	include('connexion_bdd.php');
	$result =  $bdd->query("DELETE FROM likes WHERE id_picture = '$id_picture'");

}
header('location: galerie.php');
exit();
?>