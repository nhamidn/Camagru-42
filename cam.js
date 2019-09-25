(function() {

  var streaming = false,
      video        = document.querySelector('#video'),
      cover        = document.querySelector('#cover'),
      canvas       = document.querySelector('#canvas'),
      startbutton  = document.querySelector('#startbutton'),
      width = 1024,
      height = 0;

  navigator.getMedia = (navigator.getUserMedia ||
                        navigator.webkitGetUserMedia ||
                        navigator.mediaDevices.getUserMedia||
                        navigator.msGetUserMedia);


if (navigator.mediaDevices.getUserMedia) {
  navigator.mediaDevices.getUserMedia({  audio: false, video: true })
.then(function (stream) {
  try {
    video.src = window.URL.createObjectURL(stream);
  } catch (error) {
    video.srcObject = stream;
  }
  // video.srcObject=stream;
  var show = document.getElementById("startbutton");
  document.getElementById("startbutton").setAttribute("name", "true");
  video.play();
})
.catch(function (e) { return false; });
} else {
  navigator.getMedia({video: true},function(stream) {
      video.srcObject = stream;
      var show = document.getElementById("startbutton");
      document.getElementById("startbutton").setAttribute("name", "true");
      video.play();
    },

    function(err) {
      document.getElementById("startbutton").disabled = true;
      return false;
    }
  );
}

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

  function takepicture() {
    canvas.width = width;
    canvas.height = height;

    if (document.getElementById('filter').value == "1"
        || document.getElementById('filter').value == "2"
        || document.getElementById('filter').value == "3"
        || document.getElementById('filter').value == "4") {
    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    document.getElementById("camwithstick").style.display = "block";
    document.getElementById("upload").disabled = false;
    document.getElementById('monatge').value = canvas.toDataURL('image/png');
    clear();

  }
  else {
    return false;
  }


    // var data = canvas.toDataURL('image/png');
    // photo.setAttribute('src', data);
  }
  function clear(){
    // console.log(document.getElementById("imginput").value);
    document.getElementById("imginput").value = "";
  }

  startbutton.addEventListener('click', function(ev){
      takepicture();
    ev.preventDefault();
  }, false);

})();


// video.srcObject=stream;
