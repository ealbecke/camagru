function makeRequest(url, data) {

        var httpRequest = false;

        if (window.XMLHttpRequest)// Mozilla, Safari,...
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
        httpRequest.onreadystatechange = function()
        {
          alertContents(httpRequest);
        };
        httpRequest.open('POST', url, true);
        httpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        httpRequest.send('param1=' + data);

    }

    function alertContents(httpRequest)
    {

      // 4 => terminé
        if (httpRequest.readyState == 4)
        {
            if (httpRequest.status == 200 || httpRequest.status == 0)
            {
                console.log(httpRequest.responseText);
            }
            else
            {
                alert('Un problème est survenu avec la requête.');
            }
        }
    }

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
    console.log("DATA de l'image");
   // alert(data);
    console.log("ICI");
 //   console.log(data);


 makeRequest('/camagru/test.php?param1=', data);
  }
console.log("Et la !");
startbutton.addEventListener('click', function(ev){takepicture();}, false);
})();