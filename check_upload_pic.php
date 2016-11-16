<?php
session_start();

if (!$_FILES['img']['tmp_name'])
{
	header('location: index.php');
	exit();
}
$filter = "filter/" . $_POST['filterUpload'] . ".png";
$destination = 'pictures/';
$tmp_name = $_FILES["img"]["tmp_name"];
$login = $_SESSION['login'];
$name = $login.'_'.time(0).'.jpg';
$maxDimW = 320;
$maxDimH = 240;
list($width, $height, $type, $attr) = getimagesize( $tmp_name );
if ( $width > $maxDimW || $height > $maxDimH ) {
    $target_filename = $tmp_name;
    $fn = $tmp_name;
    $size = getimagesize( $fn );
    $ratio = $size[0]/$size[1];
    if( $ratio > 1) {
        $width = $maxDimW;
        $height = $maxDimH/$ratio;
    } else {
        $width = $maxDimW*$ratio;
        $height = $maxDimH;
    }
    $src = imagecreatefromstring(file_get_contents($fn));
    $dst = imagecreatetruecolor( $width, $height );
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1] );
    imagejpeg($dst, $target_filename);
}
$stamp = imagecreatefrompng($filter);

$im = imagecreatefromjpeg($tmp_name);
$marge_right = 10;
$marge_bottom = 60;
$sx = imagesx($stamp);
$sy = imagesy($stamp);


//imagecopy($im, $stamp, 0, 0, 0, 0, imagesx($stamp), imagesy($stamp));
imagecopy($im, $stamp, 320 - $sx - $marge_right, 240 - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
$fullPath = "pictures/" . $name;
imagejpeg($im, $fullPath);


//$resultat = move_uploaded_file($tmp_name,"$destination/$name");
include('connexion_bdd.php');
$login = $_SESSION['login']; 
$result =  $bdd->query("INSERT INTO pictures (name_member, name_picture) VALUES ('$login', '$name')");
//header('location: index.php');












?>