<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Reset Password</title>
		<link rel="stylesheet"
              href="Sources/FrontEnd/css/indexLogin.css"
              type="text/css"
        />
	</head>
	<body>
		<a href="./index.php"><h2>Go To Home</h2></a>
		<form action="step.php" method="POST">
			<label>Enter email to reset Password</label>
			<input type="email" name="reset" placeholder="Enter Email" required="">
			<button type="submit">Send Link</button>
		</form>
	</body>
</html>
