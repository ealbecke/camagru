<?php
session_start();
include 'isset_admin_access.php';

$erreur = 0;
if ($_FILES['img']['error'] > 0)
{
	$erreur = 1;
	echo "Erreur lors du transfert";
	exit();
}
if ($_FILES['img']['size'] > 5242880)
{
	$erreur = 1;
	echo "Le fichier selectionner fait plus de 5 Mo";
	exit();
}
$extensions_valides = array("jpg", "jpeg", "gif", "png");
$extension_upload = strtolower(substr(strrchr($_FILES['img']['name'], '.'), 1));
if (in_array($extension_upload, $extensions_valides) === FALSE)
{
	$erreur = 1;
	echo "Le fichier selectionner n'est pas une image";
	exit();
}
		$destination = './img';
		$tmp_name = $_FILES["img"]["tmp_name"];
		$name = 'COUCOU.jpg';
		$resultat = move_uploaded_file($tmp_name,"$destination/$name");

?>