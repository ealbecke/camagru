<header>
<?php
include 'print_error.php';
if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
	echo "Vous etes connecté<br />
	login: ".$_SESSION['login']."<br />
	mail: ".$_SESSION['mail']."<br />
	<a href=\"logout.php\">Se déconecter</a><br />
	<a href=\"galerie.php\">GALERIE</a>";
}
else {
	header('location: index.php');
	exit();
}
?>
</header>