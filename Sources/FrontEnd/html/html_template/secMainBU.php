<?php


?>

<script>

    var videoObj = {

        cam: null,
        dev: null,
        cnv: null,
        ecn: null,
        feed: null,
        img: null,
        hpnl: null,
        ic: null,

        onload: function () {

            videoObj.cam = document.getElementById('video');
            videoObj.canvas = document.getElementById('photoShot');
            videoObj.context = videoObj.canvas.getContext('2d');

            function ft_getStream(stream) {

                videoObj.cam.src = window.URL.createObjectURL(stream);
                videoObj.feed = true;
            }

            if (navigator.webkitGetUserMedia){
                dev = navigator.webkitGetUserMedia({video: true}, ft_getStream, function (e) {

                    alert(e.toString());
                });
            } else if (navigator.mediaDevices.getUserMedia) {

                dev = navigator.mediaDevices.getUserMedia({video: true}).then( function (strm) {

                    videoObj.cam.srcObject = strm;
                    videoObj.feed = true;
                }, function (e) {

                    alert(e.toString());
                });
            }

            document.getElementById('takePicId').addEventListener("click", function () {

                var height = videoObj.canvas.height = videoObj.cam.videoHeight;
                var width = videoObj.canvas.width = videoObj.cam.videoWidth;
                console.log(height);
                console.log(width);
                videoObj.context.drawImage(videoObj.cam, 0, 0, width, height, 0, 0, 640, 500);
								var reg = /data:.+(?!base64,)/gi;
								var raw = videoObj.canvas.toDataURL();
								var rs = raw.match(reg);
								var meta = rs[0].split("/")[1].split(";")[0];
								var idata = raw.split(",")[1];
								var ax = new XMLHttpRequest();
								var data_to_be_sent = new FormData();
								data_to_be_sent.append("filedata",idata);
								data_to_be_sent.append("meta",meta);
								ax.addEventListener('load',function(){
									localStorage.setItem("filename",this.responseText);
									localStorage.setItem('imgstatus',"0");//ready for merge
								}); 
								ax.open("POST","../../../BackEnd/engine/imageUploadEngine.php");
								ax.send(data_to_be_sent);
								
            });
        },
				merge:function (){
					if (localStorage.imgstatus ==="0"){
						localStorage.imgstatus = "";
						var ax = new XMLHttpRequest();
						var data_to_be_sent = new FormData();
						data_to_be_sent.append("filename",localStorage.filename.
										split(":")[0]);//filename sanitise
						data_to_be_sent.append("resource","2.png");// to be implemented
						ax.addEventListener('load',function(){
							img = new Image();
							img.onload = function (){
								videoObj.imgClear();
								videoObj.context.drawImage(img,0,0);
							};
							
							img.src = "../../../../Resources/"+localStorage.filename.split(':')[0];
							
							//videoObj.canvas.toDataURL("image/png");
							///localStorage.setItem("filename",this.responseText);
							localStorage.setItem('imgstatus',"");//ready for merge
						}); 
						ax.open("POST","../../../BackEnd/engine/imageMerge.php");
						ax.send(data_to_be_sent);
					}
				},
				imgClear:function (){
					videoObj.context.clearRect(0,0,
					videoObj.canvas.width,videoObj.canvas.height);
				},
				save:function(){
					var ax = new XMLHttpRequest();
						var data_to_be_sent = new FormData();
						data_to_be_sent.append("filename",localStorage.filename.
										split(":")[0]);//filename sanitise
						//data_to_be_sent.append("resource","2.png");// to be implemented
						ax.addEventListener('load',function(){
							img = new Image();
							img.onload = function (){
								videoObj.imgClear();
								videoObj.context.drawImage(img,0,0);
							};
							
							img.src = "../../../../Resources/"+localStorage.filename.split(':')[0];
							
							//videoObj.canvas.toDataURL("image/png");
							///localStorage.setItem("filename",this.responseText);
							localStorage.setItem('imgstatus',"");//ready for merge
						}); 
						ax.open("POST","../../../BackEnd/engine/imageMerge.php");
						ax.send(data_to_be_sent);
				}
    };
		function ft_like(e){
			console.log(e.toElement.parentNode.parentNode.childNodes[3].innerText);
			e.toElement.parentNode.parentNode.childNodes[3].innerText = "Like: " + "";
			var ax = new XMLHttpRequest();
						var data_to_be_sent = new FormData();
						data_to_be_sent.append("filename",localStorage.filename.
										split(":")[0]);//filename sanitise
						data_to_be_sent.append("resource","2.png");// to be implemented
						ax.addEventListener('load',function(){
							img = new Image();
							img.onload = function (){
								videoObj.imgClear();
								videoObj.context.drawImage(img,0,0);
							};
							
							img.src = "../../../../Resources/"+localStorage.filename.split(':')[0];
							
							//videoObj.canvas.toDataURL("image/png");
							///localStorage.setItem("filename",this.responseText);
							localStorage.setItem('imgstatus',"");//ready for merge
						}); 
						ax.open("POST","../../../BackEnd/engine/likePic.php");
						ax.send(data_to_be_sent);
		}
</script>

<main class="mainClass">

    <div id="camContainer">

        <video id="video" class="sectionMainClass" autoplay></video>
        <canvas id="photoShot"></canvas>
    </div>
    <div class="buttonStore">
        <button id="takePicId" class="takePicButtonClass">Take Pic</button>
        <button class="uploadButtonClass">Upload</button>
        <button class="saveButtonClass" onclick="videoObj.save()">Save</button>
    </div>
    <div class="imageStore">

        <img src="../../../../Resources/smily.png">
        <img src="../../../../Resources/smily.png">
        <img src="../../../../Resources/smily.png">
        <img src="../../../../Resources/smily.png">
        <img src="../../../../Resources/smily.png">
    </div>
</main>

<script>
    videoObj.onload();
</script>
