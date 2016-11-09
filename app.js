(function () {
  navigator.getUserMedia = ( navigator.getUserMedia ||
                       navigator.webkitGetUserMedia ||
                       navigator.mozGetUserMedia ||
                       navigator.msGetUserMedia);

  var constraints = {
    video: true,
    audio: false
  };

  if (navigator.getUserMedia) {
    navigator.getUserMedia(constraints, successCallback, errorCallback);
  } 
  else {
    console.error("getUserMedia not supported");
  }
})();

function successCallback(localMediaStream) {
  var video = document.querySelector('video');
  video.src = window.URL.createObjectURL(localMediaStream);
  video.play();
};

function errorCallback(err) {
  console.log("The following error occured: " + err);
};

function toggle() {
  var video = document.querySelector('video');
  video.paused ? video.play() : video.pause();
}

function takeSnap() {
  var canvas = document.querySelector('canvas'),
  video = document.querySelector('video');

  canvas.width = 300;
  canvas.height = 200;
  canvas.getContext('2d').drawImage(video, 0, 0, 300, 200);
  var data = canvas.toDataURL('image/png');
  canvas.setAttribute('src', data);
}