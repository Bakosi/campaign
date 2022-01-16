<?php
session_start();
include_once("../phpclass.inc.php");
$obj = new PHPClass();


$obj->isLoginSessionExpired();// check if session is expired

if(isset($_SESSION["user_id"])) {
	if($obj->isLoginSessionExpired()) {
		header("Location:../logout.php?session_expired=1");
	}
}
if(isset($_SESSION['user_name'])) {
$user = $_SESSION['user_name'];
?>
<html>

	<head>
		<title>Campaign</title>
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
							<table class = "table">
								<thead>
									<tr>
										<th>Campaign Name</th>
										<th>Date Created</th>
									</tr>
								</thead>
								<?php
									$sql    = "SELECT * FROM createcampaign WHERE username = '".$user."'";
									$result = mysqli_query($obj->conndb(),$sql);
									while($row = mysqli_fetch_assoc($result)){
										?>
									<tr>
										<td><?php echo $row["cname"];?></td>
										<td><?php echo $row["datestamp"];?></td>
									</tr>
										<?php
									}
									
								
								?>
							</table>		
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
mysqli_close($obj->conndb());//close connection
?>