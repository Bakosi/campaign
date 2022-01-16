<?php

	#PHP Class Name
	class PHPClass{
		
		 private $host = "localhost"; //hostname
		 private $user = "root";     //username
		 private $psw  = "";  		// password
		 private $db   = "dbcampaign"; //Database Name
		
		//function conndb() returns the database connection
		public function conndb(){
			$condb = mysqli_connect($this->host,$this->user,$this->psw,$this->db);
			return $condb;
		}
		
		/**function signup($a,$b,$c,$d) check the database if user exist
		or not,add record to the table if user those not exist.**/
		public function signup($user,$pasw,$msg1,$msg2){
			$obj = new PHPClass();
			$result = mysqli_query($obj->conndb(),"SELECT username FROM signup WHERE username = '".$user."'");
			if(mysqli_num_rows($result)>=1){
				echo "<div class = 'alert alert-success'>".$msg1."</div>";
			}else{
				mysqli_query($obj->conndb(),"INSERT INTO signup(username,password) VALUES('$user','$pasw')");
				echo "<div class = 'alert alert-success'>".$msg2."</div>";
				echo"<script>
							setTimeout(myURL,5000);
							function myURL(){
								window.open('index.php');
							}
				     </script>";
			}
			
		}
		
		
		/*the function checkMonthYear($a,$b,$c,$d) validate Date (from and to)
		Checking year from will not be greater than year to and
		Month from will not be greater than month to.*/
		public function checkMonthYear($yr1,$yr2,$m1,$m2){
			
			$yearfrm = substr(date($yr1),0,4);
			$yearto  = substr(date($yr2),0,4);			
			
			$mnthfrm = substr(date($m1),5,2);
			$mnthto  = substr(date($m2),5,2);
			
			if($yearfrm > $yearto){
				echo "Year from Cannot Be greater than Year to";
				exit;
			}elseif($mnthfrm > $mnthto){
				echo "Month from Cannot Be greater than date to";
				exit;
			}			
		}
		
		//function isLoginSessionExpired() check if the session is expired
		public function isLoginSessionExpired(){
			$login_session_duration = 3000; 
			$current_time = time(); 
			if(isset($_SESSION['loggedin_time']) and isset($_SESSION["user_id"])){  
				if(((time() - $_SESSION['loggedin_time']) > $login_session_duration)){ 
					return true; 
				} 
			}
				return false;
		}
		
		/*function validate($a,$b) checks if username and password is valid
		login, else display error message, also check for login expiration*/
		public function validate($user,$pass){
			$obj = new PHPClass();
			$message="";
			if(count($_POST)>0){
				$username = $user;
				$password = $pass;
	
				$sql = "SELECT * FROM signup WHERE username = '$username' 
				and password = '$password'";
				$res = mysqli_query($obj->conndb(),$sql);
				if(mysqli_num_rows($res)>=1){
					$_SESSION["user_id"] =101;
					$_SESSION["user_name"] = $_POST["user_name"];
					$_SESSION['loggedin_time'] = time(); 
				}else{
					echo "Invalid Username or Password!";		
				}
			}

			if(isset($_SESSION["user_id"])) {
				if(!($obj->isLoginSessionExpired())) {
					header("Location:userLogin/index.php");
				} else {
					header("Location:logout.php?session_expired=1");
				}
			}

			if(isset($_GET["session_expired"])) {
				$message = "Login Session is Expired. Please Login Again";
			}
		}
		
		/*function createCampaign($a,$b,$c,$d,$e,$f,$g) add new campaign to
		the table and return the value*/
		public function createCampaign($cname,$fdate,$tdate,$tbudget,$dbudget,$img,$user){
			$obj = new PHPClass();
			$result = mysqli_query($obj->conndb(),"INSERT INTO 
								createcampaign(cname,datefrom,dateto,tbudget,dbudget,image,username) 
								VALUES('".$cname."','".$fdate."','".$tdate."','".$tbudget."','".$dbudget."','".$img."','".$user."')");
			return $result;				
		}
		
		//campaignDuplication($a) check if campaign name is Duplicated
		public function campaignDuplication($cname){
			$obj = new PHPClass();
			$sql = "SELECT * FROM preview WHERE cname = '".$cname."'";
			$result = mysqli_query($obj->conndb(),$sql);
			return $result;
		}
		
		//editCampaign($a,$b,$c,$d,$e,$f,$g) edit campaign  created
		public function editCampaign($cname,$fdate,$tdate,$tbudget,$dbudget,$img,$id){
			$obj = new PHPClass();
			$result = mysqli_query($obj->conndb(),"UPDATE createcampaign SET cname='$cname',datefrom='$fdate',
												   dateto='$tdate',tbudget='$tbudget',
												   dbudget='$dbudget',image='$img' WHERE id ='$id'");
			return $result;
		}
		
		//retrieveEditCampaign($a)
		public function retrieveEditCampaign($id){
			$obj = new PHPClass();
			$result = mysqli_query($obj->conndb(),"SELECT * FROM createcampaign WHERE id = '$id'");
			return $result;
		}
		
		//matchLetterNumberSpace($a,$b) match only letters,numbers and white space
		public function matchLetterNumberSpace($data,$msg1){
			$result = preg_match("/^[0-9a-zA-Z ]+$/",$data);
			if(!$result){
				echo $msg1;
				exit;
			}	
		}
		
		//budget($a,$b) validate daily budget but must be less than total budget
		public function budget($totalBudget,$dailyBudget){
			if($dailyBudget>=$totalBudget){
				echo "<p>Daily Budget Must not be equal to or greater than Your total Budget</p>";
				exit;
			}
		}
		
		//retrieveBudget($a,$b,$c) retrieve budget from table and convert to float
		public function retrieveBudget($totalBudget,$dailyBudget,$id){
			$obj = new PHPClass();
			$sql = "SELECT tbudget,dbudget FROM createCampaign WHERE id = '".$id."'";
			$res = mysqli_query($obj->conndb(),$sql);
			$row = mysqli_fetch_assoc($res);
			$totalBudget = floatval($row['tbudget']);
			$dailyBudget = floatval($row['dbudget']);
			if($dailyBudget>=$totalBudget){
				echo "<p>Daily Budget Must not be equal to or greater than Your total Budget</p>";
				exit;
			}			
			
		}
		
		/*checkBudget($a,$b) validate  daily budget 
		must be less than total budget */
		public function checkBudget($totalBudget,$dailyBudget){	
			if(floatval($dailyBudget)>=floatval($totalBudget)){
				echo "<p>Daily Budget Must not be equal to or greater than Your total Budget</p>";
				exit;
			}
		}
		
		//campaignRemove($a) remove campaign record from table
		public function campaignRemove($user){
			$obj = new PHPClass();
			$sql = "DELETE FROM preview WHERE username = '".$user."'";
			$res = mysqli_query($obj->conndb(),$sql);
			return $res;
		}
		
	}



?>