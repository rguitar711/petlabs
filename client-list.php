<?php
session_start();
ob_start();
require('cat.inc.php');
require('pdf/fpdf181/fpdf.php');
include('expire.inc.php');
if ( $_SESSION['employee'] == 0){
	header('Location: index.php');
}

$conn =new mysqli($host,$user,$pwd,$db) or die ("Cannot connect to server");
//get clients 
/*
$sql = "SELECT a.client_id,a.hospital_id, b.hospital_name as Location,b.address as Address, b.city as City, b.state as State, b.zip as Zip,a.email as Email, a.phone as Phone, a.fax as Fax, a.fname as 'First Name', a.lname as 'Last Name',a.date as 'Created Date' from client a right join hospital b on a.hospital_id = b.hospital_id WHERE a.isActive = '1' order by hospital_name";
*/

$sql = "SELECT a.client_id,b.hospital_id, b.hospital_name as Location,b.address as Address, b.city as City, b.state as State, b.zip as Zip,a.email as Email, a.phone as Phone, a.fax as Fax, a.fname as 'First Name', a.lname as 'Last Name',a.date as 'Created Date' from client a right join hospital b on a.client_id = b.client_id WHERE a.isActive = '1' and b.isActive = '1' order by hospital_name";
$result =$conn->query($sql);

$message = "";
if(isset($_POST["deleteButton"])) {
	
	$hospitalId = $_POST["deleteClient"];
	
	
	
	if(empty($hospitalId))
	{
		$message = "Nothing Selected";
	}
	else {
		$number = count($hospitalId);
		
		for($i=0; $i < $number; $i++)
		{
		
				
				$sql = "UPDATE client SET isActive = '0' WHERE hospital_id = '$hospitalId[$i]'";
						
				if ($conn->query($sql) === TRUE) {
				
					$sqlHospital = "UPDATE hospital SET isActive = '0' WHERE hospital_id = '$hospitalId[$i]'";
						if ($conn->query($sqlHospital) === TRUE) {
						 header('Location: client-list.php');
						}
						else
						{
							$message = $message."Error archiving Hospital record: ".$hospitalId[$i] . $conn->error;
						}
					
    				
				} else {
    				$message = $message."Error archiving Client record: ".$hospitalId[$i] . $conn->error;
				}

				$conn->close();
		}
	}

}

if(isset($_POST["printClients"])) {



$conn =new mysqli($host,$user,$pwd,$db) or die ("Cannot connect to server");
//get clients 
$sql = "SELECT a.client_id,a.hospital_id, b.hospital_name as Location,b.address as Address, b.city as City, b.state as State, b.zip as Zip,a.email as Email, a.phone as Phone, a.fax as Fax, a.fname as 'First Name', a.lname as 'Last Name',a.date as 'Created Date' from client a right join hospital b on a.hospital_id = b.hospital_id WHERE a.isActive = '1' order by hospital_name";
$result =$conn->query($sql);



$pdf=new FPDF('Landscape','mm','A4'); 
//$pdf=new FPDF(); 

$pdf->AddPage();



    $pdf->SetFont('Arial','B',15);
    // Move to the right
    $pdf->Cell(80);
    // Title
    $pdf->Cell(5,10,'Current Clients',0,0,'L');
    // Line break
    $pdf->Ln(20);


$pdf->SetAutoPageBreak(true,10);







 $numRows = $result->num_rows;
for($i = 0; $i < $numRows ; $i++)
{ 
					

	$row = $result->fetch_assoc();
	
	//$pdf->Cell(40,10,$row[Location] .' | ' .$row[Address].' |  '.$row[City].',  '.$row[State].'   '.$row[Zip].' |  '.$row[Email].'  | '.$row[Phone],0,1,'L');
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(80,2,$row[Location],0,1,'L');	
	$pdf->SetFont('Arial','',10);			
	$pdf->Cell(60,10,$row[Address],0,0,'L');
	$pdf->Cell(30,10,$row[City],0,0,'L');
	$pdf->Cell(10,10,$row[State],0,0,'L');
	$pdf->Cell(20,10,$row[Zip],0,0,'L');
	$pdf->Cell(60,10,$row[Email],0,0,'L');
	$pdf->Cell(10,10,$row[Phone],0,1,'L');
	
	$pdf->Ln(10);
	
}

$pdf->Output();



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
		.bottom-margin{margin-bottom: 15px;}
		.title-text{margin-top:15px; margin-bottom:30px;}
		.over {height: 750px; overflow: scroll;}
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
      	  	  <li><a href="client-list.php" class="active" >Client List</a></li>
      	  	   <li><a href="registration_list.php" >Client Registrations</a></li>
        <li><a href="employee_admin.php" >Add News</a></li>
          <li><a href="employee_changepassword.php">Reset Password</a></li>
    	  <li><a href="downloadFile.php?file=ClientHelp.pdf">Help</a></li>
    	  <li><a href="logout.inc.php">Logout</a></li>
    	    
    	    
      </ul>

    
    </div>
	
  </div>
</nav>

  
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){


	$('.delete').on('click', function() {
    var choice = confirm('Do you really want to archive this record? Test results will not be available to client after archiving. Must upload results again for client after they register.');
    if(choice === true) {
        return true;
    }
    return false;
});
});
	
</script>

           <div class="container">   
           
<form action="" method="post">
 <button type="submit" class="btn btn-success pull-right" name="printClients">Print</button>
</fom>
           
<form action="client-list.php" method="post"> 
	
         
                 <!--  <table class ="table table-bordered">
                   <tr><th class="success">Location</th><th  class="success">Address</th>
                   	<th  class="success">City</th><th  class="success">State</th><th  class="success">Zip</th>
                   	<th  class="success">Email</th><th  class="success">Phone</th><th  class="success">Archive</th></tr></table> -->
                   	
                   	<h3 class="text-center">List of Active Clients for PetLabs</h3>
                   	
                 <div class="over">
                   	<table class ="table table-bordered">
           
                   <?php
				   
				    $numRows = $result->num_rows;
					for($i = 0; $i < $numRows ; $i++)
					{ 
					
						$row = $result->fetch_assoc();
						if($i % 2)
						{
						$RowColor='class="info"';
						}
						else
						{
						//$RowColor="style='background-color:#c2c290'";
						$RowColor="style='background-color:#ffffff'";
						
						}
					
				   
                 
				   $checkbox = '<input type="checkbox" name="deleteClient[]" value="'.$row["hospital_id"].'">';
				   
				   echo "<tr><td ".$RowColor.">$row[Location]</td><td ".$RowColor.">$row[Address]</td><td ".$RowColor.">$row[City]</td><td ".$RowColor.">$row[State]</td><td ".$RowColor.">$row[Zip]</td><td ".$RowColor.">$row[Email]</td><td ".$RowColor.">$row[Phone]</td><td  ".$RowColor.">$checkbox</td></tr>";
				   }
                   
                   ?>
                  
                   </table></div>   <button type="submit" class="delete btn btn-danger pull-right" name="deleteButton">Archive</button><?php echo $message ?>

 </form>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
					    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
					    <!-- Include all compiled plugins (below), or include individual files as needed -->
					    <script src="js/bootstrap.min.js"></script>



      

</div>
</body>
</html>