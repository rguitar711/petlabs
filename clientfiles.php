<?php
session_start();
ob_start();
require('cat.inc.php');
include('expire.inc.php');
if ( $_SESSION['employee'] == 0){
	header('Location: workspace.php');
}

//hospital dropdown
$conn =new mysqli($host,$user,$pwd,$db) or die ("Cannot connect to server");
$sqlClient = "select distinct hospital_name,hospital_id  from hospital where IsActive = '1' order by hospital_name asc";
$resultClient =$conn->query($sqlClient);





if(isset($_POST["submit"])) {



	if(isset($_POST['hospital_dd'])){
	
		$hospitalId = $_POST['hospital_dd'];
	
		//get documents for hosptial id
		
		$sql  = "SELECT Id, FileName,FileDate, Document, isRead FROM documents WHERE HospitalId = '$hospitalId' ORDER BY CreateDate DESC";
		$result=$conn->query($sql);
		$rowcount=mysqli_num_rows($result);
		if($rowcount <=0){
			$noDocs = "No documents found";
		}
		}
		
		
}

if(isset($_POST["deleteButton"])) {
	
	$doc = $_POST["deleteClient"];
	
	
	
	if(empty($doc))
	{
		$message = "Nothing Selected";
	}	else {
		$number = count($doc);

		
		for($i=0; $i < $number; $i++){
			$sqlGet = "SELECT FileName FROM documents WHERE Id  ='$doc[$i]'";
			$getResult = $conn->query($sqlGet);
			while ($row = $getResult->fetch_assoc())
			{
				$filename = $row[FileName];
			}
		
			
			$sql = "DELETE FROM documents WHERE Id ='$doc[$i]'";
			
			
			if ($conn->query($sql) === TRUE) {
				
				 $filedeleted =    unlink( $_SERVER['DOCUMENT_ROOT'].'/files/'.$filename);
				 
				 if($filedeleted)
					 {
					 	$successMessage ="Document deleted successfully";
					 }else
					 	{
					 		$message = 'failes';
					 		
					 	}

    				
				} else {
    				$message = $message."Error deleting record: ".$doc. $conn->error;
				}
				
				
				

				
		}
	}
	
	if(isset($_POST['hospital_dd'])){
	
	$hospitalId = $_POST['hospital_dd'];
		
	//get documents for hosptial id
		
		$sql  = "SELECT Id, FileName,FileDate, Document, isRead FROM documents WHERE HospitalId = '$hospitalId' ORDER BY CreateDate DESC";
		$result=$conn->query($sql);
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
		.unread {font-weight: bold;}
		.title-text{margin-bottom:50px;}
	</style>

	
</script>

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
      	  	 <li><a href="employee_workspace.php">Workspace</a></li>
      	  	 <li><a href="clientfiles.php" class="active">Client Documents</a></li>
      	  	 <li><a href="client-list.php" >Client List</a></li>
      	  	  <li><a href="registration_list.php" >Client Registrations</a></li>
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
   				<p class="unread text-center title-text">*If the file name is bold, then the file has not been downloaded by client.</p>
  
  <?php
  if(isset($message)){
  
	  echo '<ul style="color:red">';
	  
	  echo "<li>$message</li>";
	
	  echo '</ul>';
  }
	  if(isset($successMessage))
	  {
	  	echo '<ul style="color:green">';
	  
	  echo "<li>$successMessage</li>";
	
	  echo '</ul>';
	  }
  
  ?>
  
      <form action="" method="post"> 

              <table cellpadding="5" cellspacing="5" border="0"><tr><td></td>
               
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
                   </td>

                 
                <td> <button type="submit" class="btn btn-success" id="submit" name ="submit">Get Files</button></td>
                <td><button type="submit" class="btn btn-danger pull-right" id="deleteFile" name="deleteButton">Delete</button></td></tr></table>
                 
                 </div>
                 </div>
                 
                  <br/>
                  
                  
 	<div class="row">
   		<div class="col-lg-6 col-lg-offset-2">
   			
   		
   			
   			<br/>
   			
   				
   				<br/>
 					<table class="table table-striped table-hover table-bordered ">
 						<thead>
 							<tr>
 								<th class="success">
 									File Name
 								</th>
 								<th  class="success">
 									Date
 								</th>
 								<th class="success">
 									Delete
 							</th> 
 							</tr>
 						</thead>
 						
 						
 						
 						
                  <tbody>
                   
                   <?php
				    $RowColor = '';
				    $numRows = $result->num_rows;
					for($i = 0; $i < $numRows ; $i++)
					{ 
					
						$row = $result->fetch_assoc();
					
						
						if($row['isRead'] == 0)
						{
							$rowRead = " class='unread' ";
						}else{
							$rowRead = " class='' ";
						}
						
						if($i % 2)
						{
						$RowColor=" class='warning' ";
						}
						else {
							$RowColor = '';
						}
						
						
                   $checkbox = '<input type="checkbox" name="deleteClient[]" class="delete" value="'.$row["Id"].'">';
                   
                  
				   
				   
				   echo "<tr ".$RowColor."><td><a ".$rowRead." href='downloadDoc.php?file=$row[FileName]&id=$row[Id]'>$row[FileName]</td><td>$row[FileDate]</td><td  ".$RowColor.">".$checkbox."</td></tr>";
				   }
                   
                   ?>
                   </tbody>
                   </table>
              <?php
                     if(isset($noDocs))
	 					 {
				  		echo '<ul style="color:red">';
				  
				  		echo "<li>$noDocs</li>";
				
				  		echo '</ul>';
				  		}
	  				?>
   		</div>
          
      </form>
     
  </div></div>
  
  <!-- row -->
		
					    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
					   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> 
					    <!-- Include all compiled plugins (below), or include individual files as needed -->
					    <script src="js/bootstrap.min.js"></script>
					    
					  


  </body>
  </html>