
function makeRequest(url, Data) {
	
	var httpRequest = false;

	if (window.XMLHttpRequest)
		httpRequest = new XMLHttpRequest();
	if (httpRequest.overrideMimeType)
	{
		httpRequest.overrideMimeType('text/xml');
	}  
	if (!httpRequest)
	{
		alert('Abandon :( Impossible de créer une instance XMLHTTP');
		return false;
	}

	httpRequest.onreadystatechange = function() {
		alertContents(httpRequest);
	};
		
	httpRequest.open("POST", url, true);
	httpRequest.setRequestHeader("Content-Type", "application/json; charset=utf-8");
	httpRequest.send(JSON.stringify(Data));
}

function alertContents(httpRequest)
{	
	// 4 => terminé
	if (httpRequest.readyState == 4)
	{
		if (httpRequest.status == 200 || httpRequest.status == 0)
		{
			//console.log(httpRequest)
  			e = document.getElementById("pic_bdd");
			e.innerHTML = "<img src='" + httpRequest.responseText + "'/>" + e.innerHTML 
		}
		else
			alert('Un problème est survenu avec la requête.');
	}
}

function disabledButton() {
	var validate = document.getElementById('validate').checked;
	var beard = document.getElementById('beard').checked;
	var glass = document.getElementById('glass').checked;
	if (validate == true || beard == true || glass == true)
	{
		var button = document.getElementById('buttonUpload');
		button.removeAttribute('disabled');
		button.classList.remove('disabled');

		var filt = document.getElementById('filterUpload');
		if (validate == true)
			filt.value = "validate";
		else if (beard == true)
			filt.value = "beard";
		else if (glass == true)
			filt.value = "glass";
	}
}

(function() {

	var streaming = false,
	video = document.querySelector('#video'),
	canvas = document.querySelector('#canvas'),
	startbutton = document.querySelector('#startbutton'),
	width = 320,
	height = 0;

	//OBTENIR LA VIDEO
	navigator.getMedia = ( navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);

	navigator.getMedia({
		video: true,
		audio: false
	},
	function(stream) {
		if (navigator.mozGetUserMedia) //Firefox
			video.mozSrcObject = stream;
		else //Chrome
		{
			var vendorURL = window.URL || window.webkitURL;
			video.src = vendorURL.createObjectURL(stream);
		}
		video.play();
	},
	function(err) {
		console.log("Error ! GetUserMedia" + err);
	});

	//REDIMENSIONNEMENT DE LA VIDEO
	video.addEventListener('canplay', function(ev) {
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
		pic_over = document.querySelector('input[name="toc"]:checked').value
		if ((pic_over == "validate") || (pic_over == "beard") || (pic_over == "glass")) {
			
					canvas.width = width;
					canvas.height = height;
					canvas.getContext('2d').drawImage(video, 0, 0, width, height);

					var Data = {
						image: canvas.toDataURL("image/png"),
						over: pic_over
					}
		
			makeRequest("/camagru/test.php", Data);
		}
	}

	startbutton.addEventListener('click', function(){
		takepicture();
	}, false);

})();
