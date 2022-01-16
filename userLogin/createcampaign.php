<?php
session_start();

include("../phpclass.inc.php");
$obj = new PHPClass();
$obj->isLoginSessionExpired();// check if session is expired

if(isset($_SESSION["user_id"])) {
	if($obj ->isLoginSessionExpired()) {
		header("Location:../logout.php?session_expired=1");
	}
}

function validate($inputdata){
	$inputdata = trim($inputdata);
	$inputdata = stripslashes($inputdata);
	$inputdata = htmlspecialchars($inputdata);
	return $inputdata;
}


if(isset($_POST['preview'])){
	$cname  = mysqli_real_escape_string($obj->conndb(),$_POST['cname']);
	$date1  = mysqli_real_escape_string($obj->conndb(),$_POST['date1']);
	$date2  = mysqli_real_escape_string($obj->conndb(),$_POST['date2']);
	$tbudget= mysqli_real_escape_string($obj->conndb(),$_POST['tbudget']);
	$dbudget= mysqli_real_escape_string($obj->conndb(),$_POST['dbudget']);
	$user   = mysqli_real_escape_string($obj->conndb(),$_POST['username']);
	
	//match letters,numbers and space
	$obj->matchLetterNumberSpace($cname,"Campaign Name should Contain only Letters, Numbers  and White Space");
	
	//check if daily budget is less than total budget 
	$obj->budget($tbudget,$dbudget);
	
	
	/*check if month from is less than or equal to month to, and year 
	from is less than or equal to year to*/
	$obj->checkMonthYear($date1,$date2,$date1,$date2);
	
    $targetDir = "images/"; 
    $allowTypes = array('jpg','png','jpeg','gif'); 
     
    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = ''; 
    $fileNames = array_filter($_FILES['img']['name']); 
    if(!empty($fileNames)){ 
       foreach($_FILES['img']['name'] as $key=>$val){ 
            // File upload path 
            $fileName = basename($_FILES['img']['name'][$key]); 
            $targetFilePath = $targetDir . $fileName; 
             
            // Check whether file type is valid 
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
            if(in_array($fileType, $allowTypes)){ 
                // Upload file to server 
                if(move_uploaded_file($_FILES["img"]["tmp_name"][$key], $targetFilePath)){ 
                    // Image db insert sql 
                    $insertValuesSQL .= $fileName."/"; 
                }else{ 
                    $errorUpload .= $_FILES['img']['name'][$key].' | '; 
                } 
            }else{ 
                $errorUploadType .= $_FILES['img']['name'][$key].' | '; 
            } 
        } 
         
        // Error message 
        $errorUpload = !empty($errorUpload)?'Upload Error: '.trim($errorUpload, ' | '):''; 
        $errorUploadType = !empty($errorUploadType)?'File Type Error: '.trim($errorUploadType, ' | '):''; 
        $errorMsg = !empty($errorUpload)?'<br/>'.$errorUpload.'<br/>'.$errorUploadType:'<br/>'.$errorUploadType; 
         
        if(!empty($insertValuesSQL)){ 
            $insertValuesSQL = trim($insertValuesSQL, ','); 
            // Insert image file name into database 
			$campaignName = $obj->campaignDuplication($cname);
			if(mysqli_num_rows($campaignName)>=1){
				echo "Campaign Name Exist";
				exit;
			}
			
			$create = mysqli_query($obj->conndb(),"INSERT INTO 
								preview(cname,datefrom,dateto,tbudget,dbudget,image,username) 
								VALUES('".$cname."','".$date1."','".$date2."','".$tbudget."','".$dbudget."','".$insertValuesSQL."','".$user."')");

            if($create){ 
				include("modal.php");//popup modal	
            }else{ 
                $statusMsg = "Sorry, there was an error uploading your file."; 
	
            } 
        }else{ 
            $statusMsg = "Upload failed! ".$errorMsg; 
        } 
    }else{ 
        $statusMsg = 'Please select a file to upload.'; 
    } 
} 
 
mysqli_close($obj->conndb()); // close connection

?>