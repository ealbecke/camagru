<header>
<?php
include 'print_error.php';
if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
	echo "<h3 id=\"logo_header\"><a href=\"index.php\">WEBCAM</a></h3>
	<p id=\"bt_header\" >Bonjour: ".$_SESSION['login']."<br />
	<a href=\"galerie.php\" class=\"bt\">GALERIE</a><br />
	<a href=\"logout.php\" class=\"bt\">Se déconecter</a>";
}
else {
	header('location: index.php');
	exit();
}
?>
</header>