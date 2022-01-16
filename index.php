<?php 
session_start(); 
include_once("phpclass.inc.php");
$obj = new PHPClass();
?>
<!DOCTYPE html>

<html>

	<head>
		<title>Campaign</title>
		<meta name = "viewport" content = "width=device-width,initial-scale=1">
		<link rel  = "stylesheet" href = "css/bootstrap.min.css">
		<style>
			#wrapper-center{
				margin-top:150px;
			}
		</style>
	</head>

	<body>
	
		<div class = "container" id = "wrapper-center">
			<div class = "row">
				<div class = "col-md-4 col-md-offset-4">
					<div class="panel panel-default"> 
						<div class="panel-heading"> 
							<h3 class="panel-title">Campaign|Login</h3> 
						</div> 
						<form method = "POST" action = "">
						<div class="panel-body"> 
							<div class = "form-group">
								<input type = "text" name = "user_name" class = "form-control"
								 placeholder = "username">
							</div>
							<div class = "form-group">
								<input type = "password" name = "password" class = "form-control"
								 placeholder = "password">
							</div>		
							<div class = "form-group">
								<input type = "submit" name = "submit" 
								 class = "btn btn-default" value = "login">
								<input type = "reset" name = "submit" 
								 class = "btn btn-default" value = "Cancel">
								<a href = "signup.php">Sign Up</a>
							</div>								
						</div> 
						</form>
					</div>
				</div>
			</div>
		</div>
	

		<script src = "js/jquery.js"></script>
		<script src = "js/bootstrap.min.js"></script>
	</body>

</html>

<?php

	if(isset($_POST['submit'])){
		$user = mysqli_real_escape_string($obj->conndb(),$_POST['user_name']);
		$psw  = mysqli_real_escape_string($obj->conndb(),$_POST['password']);
		$obj->validate($user,$psw);
		
	}
	mysqli_close($obj->conndb());

?>
