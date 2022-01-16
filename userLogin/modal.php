<html>

	<head>
		<title>campaign</title>
		<meta name = "viewport" content = "width=device-width,initial-scale=1">
		<link rel  = "stylesheet" href = "../css/bootstrap.min.css">
	</head>

	<body>
	
	
<!-- Button trigger modal --> 
	<?php
			
			#retrieve data from table.
			$sql = "SELECT * FROM preview  WHERE username = '".$user."'
			ORDER BY id DESC LIMIT 1";
			$res = mysqli_query($obj->conndb(),$sql);
		    $row = mysqli_fetch_assoc($res);
			
			
	?>
	<!-- Modal --> 
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
			<div class="modal-dialog"> 
			<form method = "POST" action = "create.php">
			<div class="modal-content"> 
				<div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button> 
					<h4 class="modal-title" id="myModalLabel">Preview Campaign</h4> 
				</div> 
				<div class="modal-body"> 
					<h5>Campaign Name: <?php echo $row["cname"];?></h5>
					<input type = "hidden" value = "<?php echo $row['cname'];?>" name = "cname">
					<h5>Date from: <?php echo $row["datefrom"];?></h5>
					<input type = "hidden" value = "<?php echo $row['datefrom'];?>" name = "date1">
					<h5>Date to: <?php echo $row["dateto"];?></h5>
					<input type = "hidden" value = "<?php echo $row['dateto'];?>" name = "date2">
					<h5>Total Budget $<?php echo number_format($row["tbudget"],2);?></h5>
					<input type = "hidden" value = "<?php echo $row["tbudget"];?>" name = "tbudget">
					<h5>Daily Budget $<?php echo number_format($row["dbudget"],2);?></h5>
					<input type = "hidden" value = "<?php echo $row["dbudget"];?>" name = "dbudget">

					<?php
							foreach($row as $k=>$v){
								if($k == "image"){
									$del = "/";
									$img = "";
									$token = strtok($v,$del);
									while($token!==false){
										?><img class = "thumbnail" src = "images/<?php echo $token;?>" 
										style = "width:100px;height:100px;display:inline;"><?php
										#echo $token."<br>";
										$img .=$token."/";
										$token = strtok($del);
									}
									?><input type = "hidden" name = "img" value = "<?php echo $img;?>"><?php
									?><input type = "hidden" name = "user" value = "<?php echo $user;?>"><?php
									
								}
							}				
					
					?>
				</div> 
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-default" data-dismiss="modal">Close </button>
					<button type="submit" name = "submit" class="btn btn-primary"> Create  </button> 
				</div> 
			</div><!-- /.modal-content --> 
			</form>
			</div><!-- /.modal -->
			</body>
		<script src = "../js/jquery.js"></script>
		<script src = "../js/bootstrap.min.js"></script>
		<script>
			$(document).ready(function(){
				$("#myModal").modal('show');
			});
		
		</script>
	</body>

</html>			