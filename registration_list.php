<?php

session_start();
ob_start();
require('cat.inc.php');
require('pdf/fpdf181/fpdf.php');
include('expire.inc.php');
if ( $_SESSION['employee'] == 0){
	header('Location: login.php');
}


$conn =new mysqli($host,$user,$pwd,$db) or die ("Cannot connect to server");
//get clients 
/*
$sql = "SELECT a.client_id,a.hospital_id, b.hospital_name as Location,b.address as Address, b.city as City, b.state as State, b.zip as Zip,a.email as Email, a.phone as Phone, a.fax as Fax, a.fname as 'First Name', a.lname as 'Last Name',a.date as 'Created Date' from client a right join hospital b on a.hospital_id = b.hospital_id WHERE a.isActive = '1' order by hospital_name";
*/

$sql = "SELECT hospital_name, contact_name, contact_number, contact_email, contact_email2, electronic_signature, registration_date, payment_type, insert_date FROM registration order by hospital_name";
$result =$conn->query($sql);
   
				
$message = "";


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
		.bottom-margin{margin-bottom: 15px;}
		.title-text{margin-top:15px; margin-bottom:30px;}
		.over {height: 750px; overflow: scroll;}
		th{background:#333;color:#eee;}
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
      	  	 <li><a href="employee_workspace.php">Workspace</a></li>
      	  	 <li><a href="clientfiles.php" >Client Documents</a></li>
      	  	   <li><a href="registration_list.php" class="active" >Client Registrations</a></li>
      	  	  <li><a href="client-list.php" >Client List</a></li>
        <li><a href="employee_admin.php" >Add News</a></li>
          <li><a href="employee_changepassword.php">Reset Password</a></li>
    	  <li><a href="downloadFile.php?file=ClientHelp.pdf">Help</a></li>
    	  <li><a href="logout.inc.php">Logout</a></li>
    	    
    	    
      </ul>

    
    </div>
	
  </div>
</nav>

  
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>



           <div class="container">   
  
           
<form action="" method="post"> 
	
         
                 <!--  <table class ="table table-bordered">
                   <tr><th class="success">Location</th><th  class="success">Address</th>
                   	<th  class="success">City</th><th  class="success">State</th><th  class="success">Zip</th>
                   	<th  class="success">Email</th><th  class="success">Phone</th><th  class="success">Archive</th></tr></table> -->
                   	
                   	<h3 class="text-center">List of Registrations for PetLabs</h3>
                   	
                 <div class="over">
                   	<table class ="table table-bordered">
           <tr><th>Location</th><th>Name</th><th>Phone</th><th>Email</th><th>2nd Email</th><th>Signature</th><th>Date</th><th>Payment Type</th></tr>
                 <?php
                 
                 
                  		
                 
                  
				   	while($row = $result->fetch_assoc())
				   	{
				   	
				   	
				   	echo '<tr><td>' . $row['hospital_name'] . '</td><td>' . $row['contact_name'] . '</td><td>' . $row['contact_number'] . '</td><td>' . $row['contact_email'] . '</td><td>' . $row['contact_email2'] . '</td><td>' . $row['electronic_signature'] . '</td><td>' . $row['registration_date'] . '</td><td> ' .  $row['payment_type'] . '</td> </tr>' ;
				   	
				   	
				   	
				   	
				   	
				   	
				   	
				   	
				   	}
                 
                 
                 
                 
                 
                                  ?>
                  
                   </table></div>   

 </form>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
					    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
					    <!-- Include all compiled plugins (below), or include individual files as needed -->
					    <script src="js/bootstrap.min.js"></script>



      

</div>
</body>
</html>