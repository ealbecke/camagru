<?php
session_start();

$receivedData = json_decode(file_get_contents('php://input'), true);
$data["image"] = htmlspecialchars($receivedData["image"]);
$data["image"] = str_replace('data:image/png;base64,', '', $data["image"]);
$data["image"] = str_replace(' ', '+', $data["image"]);
$data["image"] = base64_decode($data["image"]);

if (!file_exists( 'pictures/')) {
	mkdir('pictures/');
}
if ($data["image"]) {
	$stamp = imagecreatefrompng("filter/" . $receivedData["over"] . ".png");

	$im = imagecreatefromstring($data["image"]);
	$marge_right = 10;
	$marge_bottom = 10;
	$sx = imagesx($stamp);
	$sy = imagesy($stamp);
	imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
	$name = $_SESSION['login'] . "_" . time(0) . ".jpg";
	imagejpeg($im, "pictures/".$name);

	include('connexion_bdd.php');
	$login = $_SESSION['login']; 
	$result =  $bdd->query("INSERT INTO pictures (name_member, name_picture) VALUES ('$login', '$name')");
	$namePhoto = 'pictures/' . $name;
	echo $namePhoto;
}
else
	echo "PROBLEME decode 64 decode";
?>