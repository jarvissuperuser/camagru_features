<?php

$projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
require $projectRoot.'Sources/BackEnd/controller/relativePathController.php';
session_start();
if (!isset($_SESSION['userid'])){
	header("location: ../../../../index.php");
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link href="../../css/indexLogin.css" rel="stylesheet">
		<link href="../../css/main.css" rel="stylesheet">
	</head>
	<body>
		<header>
			<a class="logoutButtonClass" href="main_layout.php"> Home </a>
			<a class="logoutButtonClass" href="../../../BackEnd/controller/logoutController.php">Log Out</a>
		</header>
			<?php
			// put your code here
			?>
		<div id="pagenation"></div>
		<div class="modal">
			<div class="modal-content animate">
				<div class="pullright top" onclick="close_(this)">X</div>
				<img class="modal-img blk">
				<div class="likes top il"></div>
				<div class="il cdate"></div>
				<div class="il top" onclick="ft_like(this)">( like )</div>
			</div>
		</div>
		<script>
			localStorage.setItem('start',0);
			var data = null;
			var actv = null;
					function gallIndex(){
					var ax = new XMLHttpRequest();
					var data_to_be_sent = new FormData();
					if (localStorage.start < 0) localStorage.start = 0;
					data_to_be_sent.append("start",localStorage.start);//filename sanitise
					data_to_be_sent.append("offset",'8');
					ax.addEventListener('load',function(){
						var gallery ={};
						if (this.status === 200 && (gallery = JSON.parse(this.response)))
						{//watch
							if (!gallery.hasOwnProperty("msg")){
								data = gallery;
								if (gallery.length > 0){
								var container = document.getElementById('pagenation');
								container.innerHTML = "";
								for (var a = 0;a < gallery.length;a++){
									container.innerHTML += "<img id='"+ gallery[a].imageID +"' src='../../../../Resources/"+
													gallery[a].imageTitle +
													".png' class='imWrap il' onclick='launch(this)'/>";
								}
								container.innerHTML += "<div style='width:100%'> "+
												"<button class='pullleft il' onclick='ft_prev_()'> <= </button>"+
												"<button class='pullright il' onclick='ft_next_()' > => </button></div>";
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
					ax.open("POST","../../../../Sources/BackEnd/engine/galleryLoader.php?Show=X231q");
					ax.send(data_to_be_sent);
				}
				function ft_next_()
				{
					localStorage.start =parseInt(localStorage.start)+8;
					gallIndex();
				}
				function ft_prev_()
				{
					localStorage.start =parseInt(localStorage.start)-8;
					gallIndex();
				}
				function launch(t)
				{
					actv =  t.id;
					document.querySelector('.modal').style.display = 'block';
					var element = document.querySelector('.modal-img');
					element.src = t.src;
					var ele = document.querySelector('.likes');
					ft_askLikes(actv,ele);
					console.log(t);
				}
				function close_(e){
					//e.preventDefault();
					document.querySelector('.modal').style.display = 'none';
				}
				function ft_like(e){
//				var prop = e.toElement.parentNode.parentNode.childNodes[3];
//				e.toElement.parentNode.parentNode.childNodes[3].innerText = "Like: " + "";
	//				var img  =  e.toElement.parentNode.parentNode.childNodes[1].id.split("_");
					var ltype = 1;

					if (actv>0){
						var ax = new XMLHttpRequest();
						var data_to_be_sent = new FormData();
						data_to_be_sent.append("likedPic",actv);//filename sanitise
						data_to_be_sent.append("ltype",ltype);// to be implemented
						ax.addEventListener('load',function(){
							console.log(this.responseText);
							ft_askLikes(actv,document.querySelector('.likes'));
							//localStorage.setItem('imgstatus', "");//ready for merge
						});

						ax.open("POST", "../../../BackEnd/engine/likePic.php");
						ax.send(data_to_be_sent);
					}
				}
			
		function ft_askLikes(img,text){;
				//if (true){
					var ajx = new XMLHttpRequest();
					var dtb = new FormData();
					dtb.append("askLikes",img);//filename sanitise
					//dtb.append("ltype","1");// to be implemented
					ajx.addEventListener('load',function(){
						console.log(this.responseText);
						var t = JSON.parse(this.responseText);
						text.innerText = "Likes: " + (t.likes===undefined?0:t.likes);
						//localStorage.setItem('imgstatus', "");//ready for merge
					});
				ajx.open("POST", "../../../BackEnd/engine/likePic.php");
				ajx.send(dtb);
			//};
		}
		
				gallIndex();
		</script>
	</body>
</html>
