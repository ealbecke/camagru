<?php
if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
?>
<header>
	<h3 id="logo_header"><a href="index.php">WEBCAM</a></h3>
	<ul>
		<li>Bonjour: Patrick</li>
		<li><a href="galerie.php" class="">GALERIE</a></li>
		<li><a href="logout.php" class="">Se déconecter</a></li>
	</ul>
</header>
<?php
}
?>