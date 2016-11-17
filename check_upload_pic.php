<?php
session_start();

if (!$_FILES['img']['tmp_name']) {
    $_SESSION['flash']['error'] = "<p class='flash_red'>Probleme avec le fichier</p>";
	header('location: index.php');
	exit();
}
else if ($_FILES['img']['error'] > 0) {
    $_SESSION['flash']['error'] = "<p class='flash_red'>Erreur lors du transfert</p>";
    header('location: index.php');
    exit();
}
else if ($_FILES['img']['size'] > 5242880) {
    $_SESSION['flash']['error'] = "<p class='flash_red'>Le fichier selectionner fait plus de 5 Mo</p>";
    header('location: index.php');
    exit();
}
else {
    $extensions_valides = array("jpg", "jpeg", "gif", "png");
    $extension_upload = strtolower(substr(strrchr($_FILES['img']['name'], '.'), 1));
    if (in_array($extension_upload, $extensions_valides) === FALSE) {
        $_SESSION['flash']['error'] = "<p class='flash_red'>Le fichier selectionner n'est pas une image</p>";
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
    if ($extension_upload == 'png') {
        if (mime_content_type($tmp_name) == 'image/png')
            $im = imagecreatefrompng($tmp_name);
        else
            $im = imagecreatefromstring(file_get_contents($tmp_name));
    }
    else
        $im = imagecreatefromjpeg($tmp_name);
    if (!$im) {
        $im  = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 0, 0, 0);
        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);
        imagestring($im, 1, 5, 5, 'Erreur de chargement ' . $imgname, $tc);
    }
    $marge_right = 10;
    $marge_bottom = 60;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);
    //MOdifier 320 & 280 pour changer la position du stamp sur la photo
    imagecopy($im, $stamp, 320 - $sx - $marge_right, 280 - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
    $fullPath = "pictures/" . $name;
    imagejpeg($im, $fullPath);
    //$resultat = move_uploaded_file($tmp_name,"$destination/$name");
    include('connexion_bdd.php');
    $login = $_SESSION['login']; 
    $result =  $bdd->query("INSERT INTO pictures (name_member, name_picture) VALUES ('$login', '$name')");
    header('location: index.php');
}











?>