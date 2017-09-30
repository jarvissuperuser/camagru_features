<?php

    $projectRoot = substr(getcwd(), 0, strpos(getcwd(), "Sources"));
    require $projectRoot.'Sources/BackEnd/controller/relativePathController.php';

    session_start();
    //Global Variables
    $pageTitle = "$db_name";
    $emailLabelText = "Email";
    $passwordLabelText = "Password";
    $loginButtonText = "Login";
    $registrationButtonText = "Register";
    $formSubmitLoginButtonText = "Login";
    $formSubmitRegistrationButtonText = "Submit";
    $formSubmitCancelButtonText = "Cancel";
    $confirmLogin = $_SESSION['confirmLogin'];
    $errorMessage = "Error Login Unsuccessful! Please Try Again.";
    $_SESSION['pageTypeCheck'] = 'indexPage';
		$path = filter_input(INPUT_GET, "path");
		$msg = filter_input(INPUT_GET,"msg");
		if (strlen($path)>5){
			$_SESSION['auth_data'] = $path;
			header("Location: ./new_auth.php");
		}else if (strlen($msg)>1){
			$msg = "Reset Email Sent";
		}
?>

<!--HTML Content-->
<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="UTF-8">
        <title><?php echo $pageTitle?></title>
        <link rel="stylesheet"
              href="Sources/FrontEnd/css/indexLogin.css"
              type="text/css"
        />
        <script src="Sources/BackEnd/controller/jsMethodController.js"
                type="text/javascript">
        </script>
				<script>
					localStorage.setItem('start',0);
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
								if (gallery.length > 0){
								var container = document.getElementById('pagenation');
								container.innerHTML = "";
								for (var a = 0;a < gallery.length;a++){
									container.innerHTML += "<img src='Resources/"+
													gallery[a].imageTitle +
													".png' class='imWrap il'/>";
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
					ax.open("POST","Sources/BackEnd/engine/galleryLoader.php");
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
				</script>
    </head>
    <body>
			

        <?php include $headerTemplate?>
				<?php echo "<h3>$msg</h3>";?>
        <button onclick="document.getElementById('loginButton').style.display='block'"
                style="width: auto;">

            <?php echo $loginButtonText?>
        </button>

        <button onclick="document.getElementById('registrationButton').style.display='block'"
                style="width: auto;">

            <?php echo $registrationButtonText?>
        </button>

        <?php

            if($confirmLogin == 0) {

                //JS Alert disabled
                //echo '<script type="text/javascript">alert("'.$errorMessage.'");</script>';
            }
        ?>

        <div id = 'loginButton'
            class = 'modal'>

            <form class="modal-context animate"
                  action="Sources/BackEnd/engine/htmlRequestHandler.php"
                  method="post"
            >
                <div class="container">
                    <label>
                        <b><?php echo $emailLabelText?></b>
                    </label>
                    <input type="text"
                            placeholder="Enter Email"
                            name="email"
                    required/>
                    <label>
                        <b><?php echo $passwordLabelText?></b>
                    </label>
                    <input type="password"
                            placeholder="Enter Password"
                            name="passwordName"
                    required/>
                    <button type="submit"
                            name="submitFormButton"
                            value="loginButtonParse"
                    >
                        <?php echo $formSubmitLoginButtonText?>
                    </button>
										<a class="cancelbtn" href="./ResetPassword.php">Forgot Password?</a>
                    <button type="button"
                            name="submitFormbutton"
                            value="cancelButtonParse"
                            onclick="document.getElementById('loginButton').style.display='none'"
                            class="cancelbtn"
                    >
                        <?php echo $formSubmitCancelButtonText?>
                    </button>
                </div>
            </form>
        </div>
        <div id = 'registrationButton'
             class = 'modal'>
            <div><h1>Camagru Registration Form</h1></div>
            <form class="modal-context animate"
                  action="Sources/BackEnd/engine/htmlRequestHandler.php"
                  method="post"
            >
                <div class="container">
                    <input type="text"
                           placeholder="Enter Username"
                           name="userName"
                           required/>
                    <input type="text"
                           placeholder="Enter Email"
                           name="email"
                           required/>
                    <input type="password"
                           placeholder="Enter Password"
                           name="passwordName"
                           required/>
                    <input type="password"
                           placeholder="Repeat Password"
                           name="repeatPasswordName"
                           required/>
                    <button type="submit"
                            name="submitFormButton"
                            value="registrationButtonParse"
                    >
                        <?php echo $formSubmitRegistrationButtonText?>
                    </button>
                    <button type="button"
                            name="submitFormbutton"
                            value="cancelButtonParse"
                            onclick="document.getElementById('registrationButton').style.display='none'"
                            class="cancelbtn"
                    >
                        <?php echo $formSubmitCancelButtonText?>
                    </button>
                </div>
            </form>
        </div>
			<div id="pagenation" class="il  imContainer">
			</div>
			<script>
			gallIndex();
			</script>
    </body>
</html>
