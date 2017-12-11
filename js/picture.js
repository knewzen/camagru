(function() {
	var width = 400;
	var height = 400;

	var streaming = false;
  
	var video = document.getElementById('video');
	var canvas = document.createElement("canvas");
	var photo = document.getElementById('photo');
	var startbutton = document.getElementById('startbutton');
	var context = canvas.getContext('2d');

	var img = new Image();
	var path = "";
	var hat = document.getElementById('hat');
	var fire = document.getElementById('fire');
	var hatborder = document.getElementById('trHat');
	var fireborder = document.getElementById('trFire');
	var noneborder = document.getElementById('trNone');

	var array = [];

	function startup() {
  
		navigator.getMedia = (
			navigator.getUserMedia ||
			navigator.webkitGetUserMedia ||
			navigator.mozGetUserMedia ||
			navigator.msGetUserMedia);
  
	  navigator.getMedia({
		  video: true,
		  audio: false
		},function(stream) {
				if (navigator.mediaDevices.getUserMedia) {
					video.mozSrcObject = stream;
				}
				else {
					var vendorURL = window.URL || window.webkitURL;
					video.src = vendorURL.createObjectURL(stream);
				}
				video.play();
		},function(err) {
		  console.log("An error occured! " + err);
		});
  
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

	  if (width && height) {
			canvas.width = width;
			canvas.height = height;
			context.drawImage(video, 0, 0, width, height);
			if (path != "") {
				img.onload = function() {
					context.drawImage(img, 50, 0);
					var data = canvas.toDataURL('image/png');
					array.push(data);
				}
				img.src = path;
			}
			else {
				var data = canvas.toDataURL('image/png');
				array.push(data);
			}
			show_array();
		}
		else {
				//clearphoto();
	  }
	}
	function show_array() {
		var tmp = document.getElementById("tmp");
		var len = array.length - 1;
		var i = 0;
		tmp.innerHTML = '';
		while (i < 5) {
			var tr = document.createElement("tr");
			tr.innerHTML += "<img src=\"" + array[len] + "\"/>";
			tmp.appendChild(tr);
			i++;
			len--;
		}

	}
		function sendpicture() {	
			alert("coucou");
		}
		startbutton.addEventListener('click', function(ev){
			takepicture();
			ev.preventDefault();
		}, false);

		savebutton.addEventListener('click', function(ev){
			sendpicture();
		ev.preventDefault();
		}, false);

		fire.addEventListener('click', function(ev){
			path = "images/fire.png";
			fireborder.style.border = "1px solid white";
			noneborder.style.border = "none";
			hatborder.style.border = "none";
			ev.preventDefault();
		}, false);

		hat.addEventListener('click', function(ev){
			path = "images/hat.png";
			hatborder.style.border = "1px solid white";
			noneborder.style.border = "none";
			fireborder.style.border = "none";
			ev.preventDefault();
		}, false);

		none.addEventListener('click', function(ev){
			path = "";
			hatborder.style.border = "none";
			noneborder.style.border = "1px solid white";
			fireborder.style.border = "none";
			ev.preventDefault();
		}, false);

	}
	window.addEventListener('load', startup, false);
	})();