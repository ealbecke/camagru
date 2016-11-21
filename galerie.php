<?php
	session_start();
//	include ("user_only.php");
	include('connexion_bdd.php');
	$count = $bdd->query("SELECT COUNT(id) FROM pictures");
	$count = $count->fetch();
	if ($count['0'] == 0)
	{
		header('location: index.php');
		$_SESSION['flah']['empty_galerie'] = "<p class=\"flash_red\">Personne n'a fait de photos</p>";
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<title>Galerie</title>
</head>
<body>
<?php include ("headers/header.php");
if (!$_SESSION['login'])
{
	?>
	<header><a href="index.php">Accueil</a></header>
	<?php
	}?>
	<?php
		include('connexion_bdd.php');
		$cnt = $bdd->prepare("SELECT COUNT(id) AS nbrPic FROM pictures");
		$cnt->execute();
		$cnt = $cnt->fetch();
		$nbrPic = ($cnt[0]);
		$perPage = 8;
		$nbPage = ceil($nbrPic/$perPage);
		if (isset($_GET['p']) && $_GET['p'] > 0 && $_GET['p'] <= $nbPage)
			$cPage = intval($_GET['p']);
		else
			$cPage = 1;
		$result =  $bdd->prepare("SELECT * FROM pictures ORDER BY id DESC LIMIT " . (($cPage-1)*$perPage) . ", $perPage");
		$result->execute();
		$ret = $result->fetchAll();
		echo "<div class=\"galerie\">";
			foreach ($ret as $elem)
			{
				echo "<div class=\"galerie_img\">";
					echo "<img src='pictures/$elem[2]'/>";
					$id_picture = $elem[0];
					$result =  $bdd->prepare("SELECT commentaire, sender FROM comments WHERE id_picture = $id_picture");
					$result->execute();
					if ($result->rowCount() != 0)
					{
						$ret = $result->fetchAll();
						foreach ($ret as $element)
						{
							echo "<p class=\"comment\" >" . $element[0]. "</p>";
						}
					}
					if (isset($_SESSION['login']))
					{
						echo '<form action="add_comment.php" method="post">';
						echo '<input type="hidden" id="id_picture" name="id_picture" value="'.$elem[0].'" />';
						echo '<input type="hidden" id="recipient" name="recipient" value="'.$elem[1].'" />';
						echo '<input type="hidden" id="name_picture" name="name_picture" value="'.$elem[2].'" />';
						echo '<input type="hidden" id="sender" name="sender" value="'.$_SESSION['login'].'" />';
						echo '<input type="text" id="commentaire" name="commentaire" value="" />';
						echo '<input type="submit" value="Envoyer le commentaire" />';
						echo '</form>';

						$return =  $bdd->query("SELECT active FROM likes WHERE id_picture = '$elem[0]'");
						if ($return->rowCount() == 0)
						{
							echo '<form action="add_comment.php" method="post">';
							echo '<input type="hidden" id="id_picture" name="id_picture" value="'.$elem[0].'" />';
							echo '<input type="hidden" id="recipient" name="recipient" value="'.$elem[1].'" />';
							echo '<input type="hidden" id="name_picture" name="name_picture" value="'.$elem[2].'" />';
							echo '<input type="hidden" id="sender" name="sender" value="'.$_SESSION['login'].'" />';
							echo '<input type="hidden" id="like" name="like" value="1" />';
							echo '<input type="submit" value="Like" />';
							echo '</form>';	
						}
						else
						{
							echo '<form action="add_comment.php" method="post">';
							echo '<input type="hidden" id="id_picture" name="id_picture" value="'.$elem[0].'" />';
							echo '<input type="hidden" id="recipient" name="recipient" value="'.$elem[1].'" />';
							echo '<input type="hidden" id="name_picture" name="name_picture" value="'.$elem[2].'" />';
							echo '<input type="hidden" id="sender" name="sender" value="'.$_SESSION['login'].'" />';
							echo '<input type="hidden" id="unlike" name="unlike" value="0"/>';
							echo '<input type="submit" value="UnLike" />';
							echo '</form>';	
						}
					}
				echo "</div>";
			}
		echo "</div>";
		echo "<div id=\"pagination\">";
			for ($i=1; $i<=$nbPage;$i++) {
			if ($i == $cPage)
				echo $i . " / ";
			else
				echo "<a href=\"galerie.php?p=".$i."\">$i</a> /";
			}
		echo "</div>";
	?>
	<footer><p>ealbecke - 2016</p></footer>
</body>
</html>