<?php
session_start();
ob_start();
require('cat.inc.php');
include('expire.inc.php');
if ( $_SESSION['employee'] == 0){
	header('Location: login.php');
}

$conn =new mysqli($host,$user,$pwd,$db) or die ("Cannot connect to server");
$sqlClient = "select distinct hospital_name,hospital_id from hospital order by hospital_name asc";
$resultClient =$conn->query($sqlClient);


$target_dir = "files/";
$valid_formats = array("docx","doc","txt","pdf","xlsx","xls","rtf");

$error_message = '';



if(isset($_POST["submit"])) {
	
	
	
	$uploadOk = 0;
	if(isset($_POST['hospital_dd']) && ($_POST['hospital_dd']) != '' ){
		
			$hospitalId = $_POST['hospital_dd'];
		
			$sql = "select email from client where hospital_id = $hospitalId ";
			$clientResult = $conn->query($sql);
			
				while($clientRow = $clientResult->fetch_assoc()){
					$client_email = $clientRow['email'];
					}
				
			$clientResult->free();
		
	
		

	foreach($_FILES["fileToUpload"]["name"] as $f => $filename){
		$filename = preg_replace("/[^a-zA-Z0-9.]/", "", $filename);
		$uploadOk = 1;
		$target_file = "files/".$filename;
		
		
		
		// Check if file already exists
		if (file_exists($target_file)) {
			$messages[]= "Sorry, " . $target_file." already exists.";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"][$f] > 500000) {
			$messages[]= "Sorry, your " . $target_file." is too large.";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if(! in_array(pathinfo($filename, PATHINFO_EXTENSION), $valid_formats) ) {
			$messages[]= "Sorry, only doc, docx, pdf, txt are allowed.";
			$uploadOk = 0;
		}
	
	
	
	 
			// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					$messages[]= "Sorry, your " . $target_file." was not uploaded.";
				// if everything is ok, try to upload file
				} else {
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$f], $target_file)) {
						$messages[]= "The file ". basename( $_FILES["fileToUpload"]["name"][$f] ). " has been uploaded.";
						
						
						$sql = "INSERT INTO documents (Document, HospitalId, FileName,FileDate) values ('$target_file', '$hospitalId', '$filename',NOW())";
						$result  =$conn->query($sql);
					
					
						
						
						
						
					} else {
						$messages[]= "Sorry, there was an error uploading your " . $target_file.".";
					}
				}
			}
			
			
	if($uploadOk ==1){
	$from = "info@petlabsdiagnostics.com";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From:" . $from . "\r\n";
			$headers .= "BCc: guit117_jj@yahoo.com" . "\r\n";
			mail($client_email,"Documents Ready","<html><head><title>Documents Ready for Review</title></head><body><p>PetLabs documents are ready for review.</p><p> Login into Petlabs to download your documents.</p><p><a href='http://dev.petlabsdiagnostics.com/petlabbackup/login.php'>Login</a> </p> </body> </html>   ",$headers);
			}
	
	
	}
else {
	$error_message ="Please Select Client";
}
	}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <title>Petlabs Diagnostic Laboratories Inc.</title>

    <link href="css/spacelab.min.css" rel="stylesheet">

	<style type="text/css">
		footer{ background:#333; color:#eee; font-size:11px; padding:20px;width:100%;}
		body{background-color:#F8F8F8; }
		.wrapper{min-height:100%; height:auto; !important; height:100%; margin:0 auto -155px;}
		.push { height:155px; }	
		.img-margin{margin-bottom:10px;}
		.active {font-weight:bold; color:#fff; border: 1px solid #FFFFFF;}
		a {color:#808080;}
		tr, td {padding:5px;}
	</style>


  </head>

  <body>
  	<div class="wrapper">
  <header>
  <div class = "container">
  		  <div class="row">
    		  <div class="col-lg-6 col-md-6">
    		  	   <h4><a href="index.php" style="text-decoration: none;color:black;">Petlabs Diagnostics Laboratories Inc.</a></h4>
    		  </div>	
  		  </div>
  </div>
  
  
  
  </header>

<nav class="navbar navbar-default navbar-inverse ">
  <div class="container">
   
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#petlabs-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    
    </div>


 
    <div class="collapse navbar-collapse" id="petlabs-navbar-collapse-1">
  
      <ul class="nav navbar-nav">
      	  	 <li><a href="employee_workspace.php"class="active">Workspace</a></li>
      	  	 <li><a href="clientfiles.php" >Client Documents</a></li>
        <li><a href="employee_admin.php" >Add News</a></li>
          <li><a href="employee_changepassword.php">Reset Password</a></li>
    	  <li><a href="downloadFile.php?file=ClientHelp.pdf">Help</a></li>
    	  <li><a href="logout.inc.php">Logout</a></li>
    	    
    	    
      </ul>

    
    </div>
	
  </div>
</nav>

  
  
   <div class="container">
   	
   	<div class="row">
   		<div class="col-lg-6 col-lg-offset-2">

  <?php
  
  if(isset($messages)){
  
	  echo '<ul style="color:red">';
	  foreach($messages as $message){
	  echo "<li>$message</li>";
	  }
	  echo '</ul>';
  }
  ?>
  
      <form action="employee_workspace.php" method="post" enctype="multipart/form-data"> 
          
          
         
          
          
         
              <table cellpadding="5" cellspacing="5" border="0"><tr><td> Choose Client:</td>
              
              
              <td>
                  <?php 
				  
				  
				  
					echo "<select name='hospital_dd'>";
                    echo "<option value=''>Select Client</option>";
					while ($rowHospital = $resultClient->fetch_assoc()){
					
					if($rowHospital['hospital_id'] == $_POST['hospital_dd']){
						$selected = ' selected="selected"';
					}else{
						$selected = '';
					}
					
					echo "<option value='".$rowHospital['hospital_id']."'". $selected.">";
					echo $rowHospital['hospital_name'];
					echo "</option>";
					}
					echo "</select>";
					
			
					?>
                   </td></tr>
                  


                  
                  <tr><td>&nbsp;</td><td>  <input type="file" name="fileToUpload[]" id="fileToUpload" multiple="multiple"></input></td></tr>
                  <tr><td>&nbsp;</td><td> <input type="submit" value="Upload File" name="submit"></input>
                  	
                  	
                  	<?php
                  	if(isset($error_message))
					  {
					  	echo '<span style="color:red">',$error_message . '</span>';
					  }
					  ?>
                  	
                  </td></tr></table>
          
          <br/>
          <br/><br/><br/>
          
          
      </form>
     
  </div>
  
  <div class="col-lg-3">
    <p>Download PDFs</p>
    
             <p><a href="downloadFile.php?file=TEST_MANUAL_INDEX.pdf">-Index</a><br />
              
              <a href="downloadFile.php?file=TEST_MANUAL_BLOOD.pdf">-Blood Tests</a><br />
            <a href="downloadFile.php?file=TEST_MANUAL_MICRO.pdf" >-Microbiology Tests</a></p>
            <p><br />
              
              
              
              <a href="downloadFile.php?file=PL-19.pdf" >-Bloodwork Form</a><br />
               <a href="downloadFile.php?file=PL-20.pdf">-Micro/Immunology Form</a><br />
              <a href="downloadFile.php?file=Histopathology.pdf">-Histopathology Form</a><br />
            </p>
         </div>
         

 
  

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
					    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
					    <!-- Include all compiled plugins (below), or include individual files as needed -->
					    <script src="js/bootstrap.min.js"></script>




</body>
</html>
