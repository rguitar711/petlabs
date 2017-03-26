<?php
session_start();
ob_start();
include('expire.inc.php');
include('cat.inc.php');


if ( $_SESSION['employee'] == 1)
{
header('Location: employee_workspace.php');
}


$conn = new mysqli($host,$user,$pwd,$db) or die ("Cannot connect to server");

//from the login, reading client table
$clientId = $_SESSION['clientID'];

$message = "";

	
	
//check for all hospitals for client

$sql = "SELECT * FROM hospital WHERE client_id =$clientId AND isActive = 1";
$locationResult = $conn->query($sql);
$rowcount=$locationResult->num_rows;



//if the client has only one location	
if ($rowcount == 1 )  {
	
	
	while($row = $locationResult->fetch_assoc()){
	$hospital_id = $row['hospital_id'];
	}
	//for hospital title box 		
	$sqlHospital = "SELECT hospital_name, address,city,state, zip FROM hospital WHERE hospital_id = '$hospital_id' limit 1";
	$hospitalResult = $conn->query($sqlHospital);
	
	//get files for hospital	
	$sql  = "SELECT Id,FileName,FileDate, Document, isRead FROM documents WHERE HospitalId = '$hospital_id' ORDER BY CreateDate DESC";
	$result=$conn->query($sql);
		
}

//if client has multiple locations
//get info from the dropbox selection

if(isset($_POST['ddl_hospital'])){

	$hospitalId = $_POST['ddl_hospital'];
	
		
	//for hospital title box 		
	$sqlHospital = "SELECT hospital_name, address,city,state, zip FROM hospital WHERE hospital_id = '$hospitalId' limit 1";
	$hospitalResult = $conn->query($sqlHospital);
	
	$sql  = "SELECT Id,FileName,FileDate, Document, isRead FROM documents WHERE HospitalId = '$hospitalId' ORDER BY CreateDate DESC";
	$result=$conn->query($sql);
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<style type="text/css">
		footer{ background:#333; color:#eee; font-size:11px; padding:20px;width:100%;}
		body{background-color:#F8F8F8; }
		.wrapper{min-height:100%; height:auto; !important; height:100%; margin:0 auto -155px;}
		.push { height:155px; }	
		.img-margin{margin-bottom:10px;}
		.active {font-weight:bold; color:#fff; border: 1px solid #FFFFFF;}
		a {color:#808080;}
		.unread {font-weight: bold;}
		
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
      	 <li><a href="workspace.php" class="active">Workspace</a></li>
        <li><a href="client_admin.php">Admin</a></li>
         <li><a href="update_client.php">Update Info</a></li>
       	<li><a href ="register_hospital.php">Add Location</a></li>
    	  <li><a href="downloadFile.php?file=ClientHelp.pdf">Help</a></li>
    	  <li><a href="logout.inc.php">Logout</a></li>
    	    
      </ul>

    
    </div>
	
  </div>
</nav>

  
  
 
   	
   		   

   	
     <div class="container">
     <form action="" method ="post">	
   	<div class="row">
   	
   	
   	
   	
   	
   	
   	<div class = "row">
   		
  
   		<div class="col-lg-6 col-lg-offset-2">
   		
   		
   		
   		 <?php 
   		 	if($rowcount > 1){
		   		echo 'Select Location:';	
				echo '&nbsp;&nbsp;&nbsp;';   	
		   		echo '<select name="ddl_hospital">';
		   		echo '<option value = "">Select</option>';
		   		while($row = $locationResult->fetch_assoc()){
   		
			   		echo '<option value = "'.$row[hospital_id]. '">'.$row[hospital_name].'</option>';
   				}
				echo '</select>';
				echo '&nbsp;&nbsp;&nbsp;';
				echo '<button type="submit" name="btn_location" class="btn btn-primary">Go</button>';
			}
	   		?>
   		<p>
   			
   			   	<?php
   	
   	
				while($hrow =$hospitalResult ->fetch_assoc()){
					echo '<div class="panel panel-primary">';
					echo '<div class="panel-heading">';      
					echo "<strong>$hrow[hospital_name]</strong>";
					echo '</div>';
					echo '<div class="panel-body">';
					echo "$hrow[address] <br/>$hrow[city], &nbsp; $hrow[state] &nbsp; $hrow[zip]";
					echo '</div>';
					echo '</div>';

				}?>
			   	
			   	
			   	
   			
   		</p>
  			

			<table class="table table-striped table-hover table-bordered " id="myTable">
 						<thead>
 							<tr>
 								<th class="success">
 									File Name
 								</th>
 								<th class="success">
 									Date
 								</th>
 								
 							</tr>
 						</thead>
 						
 						
 						
 						
                  <tbody>
                   
                  	 <?php
				    	$RowColor = '';
					$rowRead = '';
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
						
						
						echo "<tr ".$RowColor."><td><a ".$rowRead." href='downloadDoc.php?file=$row[FileName]&id=$row[Id]'>$row[FileName]</td>				<td>$row[FileDate]</td></tr>";
				   }
                                    ?>
                   </tbody>
                   </table>
                   </form>
   		</div>
   		
   	</div>
   	
   </div>
   
   
  
  

					  
					  
					  


</body>
</html>