<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="style.css" type="text/css"/>
	<title>Camagru</title>
</head>
<body>
<?php
echo $_SESSION['flash']['mail_token'];
echo $_SESSION['flash']['validate'];
echo $_SESSION['flash']['inscription'];
echo $_SESSION['flash']['pb'];
echo $_SESSION['flash']['new_pwd'];

$_SESSION['flash']['validate'] = NULL;
$_SESSION['flash']['mail_token'] = NULL;
$_SESSION['flash']['inscription'] = NULL;
$_SESSION['flash']['pb'] = NULL;
$_SESSION['flash']['new_pwd'] = NULL;
if (isset($_SESSION['login']))
{
	echo "Vous etes connecté";
	echo "<br />";
	echo "login: ".$_SESSION['login'];
	echo "<br />";
	echo "mail: ".$_SESSION['mail'];
	echo "<br />";
	echo "<a href=\"logout.php\">Se déconecter</a>";
}
else
{
?>
<header>
	<form action="check_connect.php" method="post">
		<p>Login: <input type="text" name="login">
		 Mot de passe: <input type="text" name="password">
		<input type="submit" name="ok" value="connexion"></p>
	</form>
	<a href="forget_pwd.php">Mot de passe oublie ?</a>
	<br />
	<a href="inscription.php">Inscription</a>
</header>
<?php } ?>
<?php if (isset($_SESSION['login'])){?>


	<div id="container">
		<div id="main">
      <video id="video"></video>
			<button id="startbutton">Prendre une photo</button>
		</div>




		<div id="side">
      <canvas id="canvas"></canvas>
    
      <div id="hello"></div>
    </div>
	</div>


<script type="text/javascript">

(function() {

  var streaming = false,
  video = document.querySelector('#video'),
  canvas = document.querySelector('#canvas'),
  //photo = document.querySelector('#photo'),
  startbutton = document.querySelector('#startbutton'),
  width = 320,
  height = 0;

  //OBTENIR LA VIDEO
  navigator.getMedia = ( navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);

  navigator.getMedia(
  {
    video: true,
    audio: false
  },
    function(stream)
    {
      if (navigator.mozGetUserMedia) //Firefox
        video.mozSrcObject = stream;
      else //Chrome
      {
        var vendorURL = window.URL || window.webkitURL;
        video.src = vendorURL.createObjectURL(stream);
      }
      video.play();
    },
    function(err)
    {
      console.log("Error ! GetUserMedia" + err);
    }
  );

  //REDIMENSIONNEMENT DE LA VIDEO
  video.addEventListener('canplay', function(ev){
    if (!streaming) {
      height = video.videoHeight / (video.videoWidth/width);
      video.setAttribute('width', width);
      video.setAttribute('height', height);
      canvas.setAttribute('width', width);
      canvas.setAttribute('height', height);
      streaming = true;
    }
  }, false);


//PRENDRE LA PHOTO
function takepicture() {
    canvas.width = width;
    canvas.height = height;
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    //toDataURL renvoit une image encodé
    var data = canvas.toDataURL('image/png');
    console.log(video);
    console.log(video.src);
    console.log(canvas);
    console.log(data);
 //   photo.setAttribute('src', data);
  }

startbutton.addEventListener('click', function(ev){takepicture();}, false);
})();

request(pictureLoaded, null, 'GET', '/camagru');
</script>




<?php } ?>
<footer></footer>
</body>
</html>
