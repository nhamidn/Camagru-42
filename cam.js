(function() {

  var streaming = false,
      video        = document.querySelector('#video'),
      cover        = document.querySelector('#cover'),
      canvas       = document.querySelector('#canvas'),
      // photo        = document.querySelector('#photo'),
      startbutton  = document.querySelector('#startbutton'),
      width = 520,
      height = 0;

  navigator.getMedia = ( navigator.getUserMedia ||
                         navigator.webkitGetUserMedia ||
                         navigator.mozGetUserMedia ||
                         navigator.msGetUserMedia);

  navigator.getMedia({video: true},function(stream) {
      if (navigator.mozGetUserMedia) {
        video.mozSrcObject = stream;
      } else {
        var vendorURL = window.URL || window.webkitURL;
        video.srcObject=stream;
      }
      video.play();
    },
    function(err) {
      document.getElementById("startbutton").disabled = true;
      return false;
    }

  );
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
    var margint = 20;
    var marginl = 10;
    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
    canvas.getContext('2d').drawImage(video, 0, 0, width, height);
    document.getElementById("camwithstick").style.display = "block";
    document.getElementById("upload").disabled = false;
    document.getElementById('monatge').value = canvas.toDataURL('image/png');
    clear();

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
