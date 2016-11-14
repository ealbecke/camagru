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
	$stamp = imagecreatefrompng("filter/beard.png");



	$im = imagecreatefromstring($decode);
	$marge_right = 10;
	$marge_bottom = 10;
	$sx = imagesx($stamp);
	$sy = imagesy($stamp);
	imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
	$name = $_SESSION['login'] . "_" . time(0);
	imagejpeg($im, "pictures/".$name.".jpg");

	include('connexion_bdd.php');
	$login = $_SESSION['login']; 
	$result =  $bdd->query("INSERT INTO pictures (name_member, name_picture) VALUES ('$login', '$name')");
	$namePhoto = 'pictures/' . $name . '.jpg';
	echo $namePhoto;
}
else
	echo "PROBLEME decode 64 decode";
?>
