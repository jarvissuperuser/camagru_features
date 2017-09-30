<?php
$projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
require $projectRoot.'Sources/BackEnd/controller/relativePathController.php';
session_start();
$data =$_SESSION['auth_data'];
$p = filter_input(INPUT_POST,"pwd") ;
$cp = filter_input(INPUT_POST,"cpwd") ;
if(strlen($data)>0){
	
$unlocked = base64_decode(str_rot13($data));
$obj = json_decode($unlocked);

$qry = "SELECT verificationStatus as vs FROM Camagru.users where userID = {$obj->userID}";
$mres = new DB_Control();

$ps = $mres->prep($qry,$mres->dbCon);
$ps->execute();

$res = $ps->fetchObject();
if ($res->vs == 3 &&$p ==$cp && strlen($p)>5 ){
	$password = hash("sha256",ft_validator(filter_input(INPUT_POST,"pwd")));
	$query = "UPDATE Camagru.users set verificationStatus = 1, password='$password' where userID = {$obj->userID}";	
	$ps = $mres->prep($query,$mres->dbCon);
	$ps->execute();
}
}

?>
<html lang="en">

	<head>
		 <link rel="stylesheet"
              href="Sources/FrontEnd/css/indexLogin.css"
              type="text/css"
        />
	</head>
	<body>
		<?php
		if ($res->vs == 3){
			echo "<h2>Changing Password For {$obj->userName}</h2>";
			echo '<form method="POST" onsubmit="sub(event)">';
		}
		else
			echo "<form hidden>";
		?>
		<input id="pwd" type="password" name='pwd' required="" 
					 placeholder="Password"><br>
		<input id="cpwd" type="password" name='cpwd' required="" 
					 placeholder="Confirm Password" oninput="onin()"><br>
		<input id='btn' class='cancelbtn' type="submit" disabled="" onsubmit="sub(event)">
		</form>
		<?php if ($res->vs != 3) {echo "<h1>Link Expired</h1><script>"
			. "setTimeout(function (){"
						. "	location = './index.php';"
						. "},4000);"
						. "</script>";}?>
		<script>
			
			function onin(){
				var cp =document.querySelector('#cpwd').value;
				if (cp.length > 5){
					var pwd = document.querySelector('#pwd').value;

					if (pwd.length > 6 && pwd===cp){
						document.querySelector("#btn").disabled = false;
					}else
					{
						document.querySelector("#btn").disabled = true;
					}
				}
			}
			function sub(e){
				e.preventDefault();
				document.querySelector('form').setAttribute('hidden',true);
				var data = document.querySelectorAll('input:valid');
				var form = new FormData();
				for (var inr in data )
					form.append(data[inr].name, data[inr].value);
				var x = new XMLHttpRequest();
				x.onload=function (){
					if (this.status === 200)
						document.querySelector('h2').innerHTML = "Password Successfully Changed";
						setTimeout(function (){
							location = "./index.php";
						},10000);
				};
				x.open("POST","./new_auth.php");
				x.send(form);
			}
			
			
		</script>
	</body>
</html>