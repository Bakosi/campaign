<?php 
session_start();
include_once("phpclass.inc.php");
$obj = new PHPClass();
 ?>
<!DOCTYPE html>

<html>

	<head>
		<title>Campaign|Signup</title>
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
							<h3 class="panel-title">Campaign|Signup</h3> 
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
								 class = "btn btn-default" value = "Signup">
								<input type = "reset" name = "submit" 
								 class = "btn btn-default" value = "Cancel">
						
							</div>								
						</div> 
						</form>
				<?php


					
					if(isset($_POST['submit'])){
						
						$user = mysqli_real_escape_string($obj->conndb(),$_POST['user_name']);
						$psw  = mysqli_real_escape_string($obj->conndb(),$_POST['password']);
						if(empty($user) && empty($psw)){
							echo "<div class = 'alert alert-success'>username and password cannot be empty</div>";
							exit;
						}elseif(strlen($user)>26){
							echo "<div class = 'alert alert-success'>username must not be Greater 
							than 25 character</div>";
							exit;
						}elseif(strlen($user)<8){
							echo "<div class = 'alert alert-success'>username must not be Less
							than 8 character</div>";
							exit;							
						}	
						elseif(strlen($psw)>16){
							echo "<div class = 'alert alert-success'>password
							must not be greater than 15 character</div>";
							exit;							
						}
						elseif(strlen($psw)<8){
							echo "<div class = 'alert alert-success'>password 
							must not be Less than 8 character</div>";
							exit;							
						}						
						echo $obj->signup($user,$psw,"username exist","Signup Succesfully 
								   Click <a href = 'index.php'>login</a> if not redirect after 5s");
						//check database table if user exist display error message else register users
			
					}
					mysqli_close($obj->conndb()); //close database connection

				?>
					</div>
				</div>
			</div>
		</div>
	

		<script src = "js/jquery.js"></script>
		<script src = "js/bootstrap.min.js"></script>
	</body>

</html>
