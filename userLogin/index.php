<?php
session_start();

include("../phpclass.inc.php");
$obj = new PHPClass();

$obj->isLoginSessionExpired();//check if session is expired

if(isset($_SESSION["user_id"])) {
	if($obj->isLoginSessionExpired()) {
		header("Location:../logout.php?session_expired=1");
	}
}
if(isset($_SESSION['user_name'])) {
	
?>
<html>

	<head>
		<title>Create Campaign</title>
		<meta name = "viewport" content = "width=device-width,initial-scale=1">
		<link rel  = "stylesheet" href = "../css/bootstrap.min.css">
		<style>
			.form-width{
				width:200px;
			}
			.container-width{
				width:300px;
			}
		</style>
	</head>

	<body>
	
		<div class = "container">
			<div class = "row">
				<div class = "col-md-6 col-md-offset-3">
					<div class="panel panel-default" style = "margin-top:30px;"> 
						<?php include("panel-heading.php");?>
						<form method = "POST" action = "createcampaign.php" enctype = "multipart/form-data">
						<div class="panel-body"> 
							<div class = "form-group"><label>Campaign name</label>
								<input type = "text" name = "cname" class = "form-control"
								 placeholder = "Campaign name" required >
							</div>
							<div class = "form-group"><label>Date from</label>
								<input type = "date" name = "date1"
								class = "form-width form-control" required>
							</div>		
							<div class = "form-group"><label>Date to</label>
								<input type = "date" name = "date2" 
								class = "form-width form-control" required>
							</div>		
							<div class = "form-group"><label>Total Budget</label>
								<input type = "text" name = "tbudget" 
								class = "form-width form-control" required>
							</div>		
							<div class = "form-group"><label>Daily Budget</label>
								<input type = "text" name = "dbudget" 
								class = "form-width form-control" required>
							</div>	
							<div class = "form-group"><label>Campaign Photo | Campaign Photos</label>
								<input type = "file" name = "img[]" 
								multiple class = "btn btn-info" required>
							</div>								
							<div class = "form-group">
								<input type = "submit" name = "preview" value = "preview"
								 class = "btn btn-default"  data-toggle="modal" data-target="#myModal">
								<input type = "reset" 
								 class = "btn btn-default" value = "Cancel">	
								<input type = "hidden" value = "<?php echo $_SESSION['user_name'];?>" name = "username">
							</div>								
						</div> 
						</form>
					</div>
				</div>
			</div>
		</div>
	

		<script src = "../js/jquery.js"></script>
		<script src = "../js/bootstrap.min.js"></script>
	</body>

</html>

<?php
}else{
	echo "Page Not found";
}
mysqli_close($obj->conndb()); //close connection
?>