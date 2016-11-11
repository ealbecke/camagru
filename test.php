<?php
session_start();
$data = htmlspecialchars($_POST['param1']);

$data = str_replace('data:image/png;base64,', '', $data);
$data = str_replace(' ', '+', $data);
$decode = base64_decode($data);

if (!file_exists( 'pictures/'))
{
	mkdir('pictures/');
}
if ($decode)
{
	$name = $_SESSION['login'] . "_" . time(0);
	$namePhoto = 'pictures/' . $name . '.png';
	file_put_contents($namePhoto, $decode);

	include('connexion_bdd.php');
	$login = $_SESSION['login']; 
	$result =  $bdd->query("INSERT INTO pictures (name_member, name_picture) VALUES ('$login', '$name')");
	echo $namePhoto;
}
else
	echo "PROBLEME";
?>
