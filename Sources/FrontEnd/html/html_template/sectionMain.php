<?php

    //Create Session
    session_start();

    //Global Variables
    $target_dir = "../../../../Resources/";
    $target_file = $target_dir.basename($_FILES['fileToUpload']['name']);
    $uploadChecker = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

    //Upload PHP Funtionality
    //Doesn't work yet
    if (isset($_POST['submit'])) {
        $check = getimagesize($_FILES['fileToUpload']['tmp_name']);
        if ($check !== false) {
            echo "File is an image - ".$check['mime'].".";
            $uploadChecker = 1;
        } else {
            echo "File is not an image. ";
            $uploadChecker = 0;
        }
    }

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
						localStorage.setItem("start",0);
            videoObj.cam = document.getElementById('video');
            videoObj.canvas = document.getElementById('photoShot');
            videoObj.context = videoObj.canvas.getContext('2d');

            function ft_getStream(stream) {

                videoObj.cam.src = window.URL.createObjectURL(stream);
                videoObj.feed = true;
            }

            if (navigator.webkitGetUserMedia){
                dev = navigator.webkitGetUserMedia({video: true}, ft_getStream, function (e) {
										console.log(e);
                    alert(e.toString());
                });
            } else if (navigator.mediaDevices.getUserMedia) {

                dev = navigator.mediaDevices.getUserMedia({video: true}).then( function (strm) {

                    videoObj.cam.srcObject = strm;
                    videoObj.feed = true;
                }, function (e) {

                    alert(e.toString());
										console.log(e);
                });
            }

            document.getElementById('takePicId').addEventListener("click", function () {

                var height = videoObj.canvas.height = videoObj.cam.videoHeight;
                var width = videoObj.canvas.width = videoObj.cam.videoWidth;
                console.log(height);
                console.log(width);
                videoObj.context.drawImage(videoObj.cam, 0, 0, width, height, 0, 0, 640, 500);
								var reg = /data:.+(?!base64,)/gi;
								var raw = videoObj.canvas.toDataURL('image/png');
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
				merge:function (ints){
					if (localStorage.imgstatus ==="0"){
						localStorage.imgstatus = "";
						var ax = new XMLHttpRequest();
						var data_to_be_sent = new FormData();
						data_to_be_sent.append("filename",localStorage.filename.
										split(":")[0]);//filename sanitise
						data_to_be_sent.append("resource",ints+".png");// to be implemented
						ax.addEventListener('load',function(){
							img = new Image();
							img.src = "../../../../Resources/"+localStorage.filename.split(':')[0];
							img.onload = function (){
								videoObj.imgClear();
								videoObj.context.drawImage(img,0,0);
							};
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
					if (localStorage.filename.
										split(":")[0].
										split(".")[1] ==="png"){
						var ax = new XMLHttpRequest();
						var data_to_be_sent = new FormData();
						data_to_be_sent.append("filename",localStorage.filename.
										split(":")[0]);//filename sanitise
						ax.addEventListener('load',function(){
							videoObj.imgClear();
							console.log(this.responseText);
							videoObj.gallery();
						}); 
						ax.open("POST","../../../BackEnd/engine/Saveimage.php");
						ax.send(data_to_be_sent);
					}
				},
				gallery:function (){
					var ax = new XMLHttpRequest();
					var data_to_be_sent = new FormData();
					if (localStorage.start < 0) localStorage.start = 0;
					data_to_be_sent.append("start",localStorage.start);//filename sanitise
					ax.addEventListener('load',function(){
						var gallery ={};
						if ((gallery = JSON.parse(this.response))){
							if (!gallery.hasOwnProperty("msg")){
								if (gallery.length>0){
								for (var a = 0;a < gallery.length;a++){
									document.
										getElementsByClassName("thumbNails")[a].src = 
										"../../../../Resources/"+
										gallery[a].imageTitle + ".png";
									document.getElementsByClassName("thumbNails")[a].id = "id_" 
										+ gallery[a].imageID;
									ft_askLikes(["id",gallery[a].imageID],
									document.getElementsByClassName("thumbNails")[a]
													.nextElementSibling);
								}
							}
							else{
								localStorage.start = 0;
							}
							}
							else {
								
								alert(gallery.problem);
							}
							console.log("Gal",localStorage.start);
						}
					}); 
					ax.open("POST","../../../BackEnd/engine/galleryLoader.php");
					ax.send(data_to_be_sent);
				}
    };
		function ft_like(e){
				var prop = e.toElement.parentNode.parentNode.childNodes[3];
				e.toElement.parentNode.parentNode.childNodes[3].innerText = "Like: " + "";
				var img  =  e.toElement.parentNode.parentNode.childNodes[1].id.split("_");
				var ltype = e.toElement.parentNode.className==="downvoteButton"?-1:1 ;
				
				if (img[0]==="id"){
					var ax = new XMLHttpRequest();
					var data_to_be_sent = new FormData();
					data_to_be_sent.append("likedPic",img[1]);//filename sanitise
					data_to_be_sent.append("ltype",ltype);// to be implemented
					ax.addEventListener('load',function(){
								//console.log(this.responseText);
						videoObj.gallery();
						//ft_askLikes(img,prop);
						//localStorage.setItem('imgstatus', "");//ready for merge
					});
				ax.open("POST", "../../../BackEnd/engine/likePic.php");
				ax.send(data_to_be_sent);
			}
		}
		function fileLoad(th){
			try{
			var file_read =  new FileReader();
			file_read.readAsDataURL(th[0]);
			file_read.onload = function(e){
				videoObj.img =new Image();
				videoObj.img.src = e.target.result;
				videoObj.img.onload = function(e){
					videoObj.imgClear();
					videoObj.canvas.height = 480;
					videoObj.canvas.width = 640;
					videoObj.context.drawImage(videoObj.img,0,0);
					var ax = new XMLHttpRequest();
					var data_to_be_sent = new FormData();
					data_to_be_sent.append("filedata",videoObj.canvas.toDataURL("image/png")
									.split(',')[1]);
					data_to_be_sent.append("meta","png");
					ax.addEventListener('load',function(){
						localStorage.setItem("filename",this.responseText);
						localStorage.setItem('imgstatus',"0");//ready for merge
					}); 
					ax.open("POST","../../../BackEnd/engine/imageUploadEngine.php");
					ax.send(data_to_be_sent);
				};
			};
		}catch(exc){
			
		}
		}
		function ft_next(){
			localStorage.start = parseInt(localStorage.start)+5;
			videoObj.gallery();
		}
		function ft_prev(){
			localStorage.start =parseInt(localStorage.start)-5;
			videoObj.gallery();
		}
		function ft_askLikes(img,text){;
				if (img[0]==="id"){
					var ajx = new XMLHttpRequest();
					var dtb = new FormData();
					dtb.append("askLikes",img[1]);//filename sanitise
					//dtb.append("ltype","1");// to be implemented
					ajx.addEventListener('load',function(){
						console.log(this.responseText);
						var t = JSON.parse(this.responseText);
						text.innerText = "Likes: " + (t.likes===undefined?0:t.likes);
						//localStorage.setItem('imgstatus', "");//ready for merge
					});
				ajx.open("POST", "../../../BackEnd/engine/likePic.php");
				ajx.send(dtb);
			};
		}
		function dbg(){
			var ajx = new XMLHttpRequest();
					var dtb = new FormData();
					//dtb.append("askLikes",img[1]);//filename sanitise
					//dtb.append("ltype","1");// to be implemented
					ajx.addEventListener('load',function(){
						console.log(this.responseText);
						//var t = JSON.parse(this.responseText);
						//text.innerText = "Likes: " + (t.likes===undefined?0:t.likes);
						//localStorage.setItem('imgstatus', "");//ready for merge
					});
				ajx.open("POST", "../../../BackEnd/debug.php");
				ajx.send(dtb);
		}
</script>

<main class="mainClass">

    <div id="camContainer">

			<video id="video" class="sectionMainClass" autoplay></video>
        <canvas id="photoShot"></canvas>
    </div>
    <div class="buttonStore">
        <button id="takePicId" class="takePicButtonClass">Take Pic</button>
<!--        <button class="uploadButtonClass">Upload</button>-->
        <div action="" method="POST" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" onchange="fileLoad(this.files)" class="uploadButtonClass" id="fileToUpload"/>
            <input type="button" value="Upload Image" name="Submit" class="uploadButtonClass"/>
        </div>
<button class="saveButtonClass" onclick="videoObj.save()">Save</button>
    </div>
    <div class="imageStore">

			<img src="../../../../Resources/1.png" onclick="videoObj.merge(1)">
        <img src="../../../../Resources/2.png" onclick="videoObj.merge(2)">
        <img src="../../../../Resources/3.png" onclick="videoObj.merge(3)">
    </div>
</main>

<script>
    videoObj.onload();
		videoObj.gallery();
</script>
