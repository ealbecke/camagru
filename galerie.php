<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Galerie</title>
</head>
<body>
	<?php
//		session_start();
		include('connexion_bdd.php');
//		$login = $_SESSION['login'];
		$result =  $bdd->prepare("SELECT * FROM pictures ORDER BY name_picture DESC");
		$result->execute();
		$ret = $result->fetchAll();
		foreach ($ret as $elem)
		{
			echo "<div>";
			echo "<img src='pictures/$elem[2]'/>";

				$id_picture = $elem[0];
				$result =  $bdd->prepare("SELECT commentaire, sender FROM comments WHERE id_picture = $id_picture");
				$result->execute();
				if ($result->rowCount() != 0)
				{
					$ret = $result->fetchAll();
					foreach ($ret as $element)
					{
						echo "<br />";
						echo $element[0];
					}
				}
				echo '<form action="add_comment.php" method="post">';
				echo '<input type="hidden" id="id_picture" name="id_picture" value="'.$elem[0].'" />';
				echo '<input type="hidden" id="recipient" name="recipient" value="'.$elem[1].'" />';
				echo '<input type="hidden" id="name_picture" name="name_picture" value="'.$elem[2].'" />';
				echo '<input type="hidden" id="sender" name="sender" value="'.$_SESSION['login'].'" />';
				echo '<input type="text" id="commentaire" name="commentaire" value="" />';
				echo '<input type="submit" value="Envoyer le commentaire" />';
				echo '</form>';

			echo "</div>";
		}
	?>
</body>
</html>