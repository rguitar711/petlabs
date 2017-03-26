<?php
session_start();
ob_start();
include('expire.inc.php');
include('cat.inc.php');

$numRows=0;
$conn = new mysqli($host,$user,$pwd,$db) or die("Can't connect");


$sqlState = "select * from state order by state asc";
$result =  $conn->query($sqlState);

$clientId = $_SESSION['clientID'];




if(isset($_POST['submit'])){

    // create and execute INSERT query
        $hospital = strip_tags($_POST['txt_hospital']);
	$address = strip_tags($_POST['txt_address']);
        $city = strip_tags($_POST['txt_city']);
	$state = strip_tags($_POST['state']);
	$zip = strip_tags($_POST['txt_zip']);
	$phone = strip_tags($_POST['txt_phone']);
	$fax = strip_tags($_POST['txt_fax']);
	
	
	
	//check for hospital in hospital table

	$checkDuplicateHospital ="select hospital_name,hospital_id from hospital where address like ? or hospital_name like ? AND isActive = '1'";
	$hosp = '%'.$hospital.'%';
	$addr = '%'.$address.'%';
	
	$stmt = $conn->stmt_init();
	if($stmt->prepare($checkDuplicateHospital)){
		$stmt->bind_param('ss',$addr,$hosp);
		$stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
	}else{
		echo $stmt->error;
	}


	//if no hospital is found insert one
	if (!$numRows)
	{
		$sql = "insert into hospital (hospital_name, address, city, state, zip, client_id) values (?,?,?,?,?,?)";
		if($stmt->prepare($sql)){
			$stmt->bind_param('ssssss',$hospital, $address,$city,$state,$zip,$clientId);
			$stmt->execute();
			$message = "Hospital added to System";	
		}else{
		echo $stmt->error;
		}

		
	
	}
	else
	{
		$message = "Hospital already in System";
			
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
    <link href="css/screen.css" rel="stylesheet">
	<style type="text/css">
	
		footer{ background:#333; color:#eee; font-size:11px; padding:20px;width:100%;}
		body{background-color:#F8F8F8; }
		.wrapper{min-height:100%; height:auto; !important; height:100%; margin:0 auto -155px;}
		.push { height:155px; }	
		.img-margin{margin-bottom:10px;}
		.active {font-weight:bold; color:#fff; border: 1px solid #FFFFFF;}
		.spacer{height:250px;}
		.registration{margin-left:600px;margin-top: 30px;}
		td, th{padding:5px;}
		.error{color:red; font-weight:bold; }
		.textbox-width{width:300px;}
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
        <li><a href="workspace.php">Workspace</a></li>
        <li><a href="client_admin.php">Admin</a></li>
         <li><a href="update_client.php">Update Info</a></li>
       	<li><a href ="register_hospital.php" class="active">Add Location</a></li>
    	  <li><a href="downloadFile.php?file=ClientHelp.pdf">Help</a></li>
    	  <li><a href="logout.inc.php">Logout</a></li>
      </ul>

    
    </div>
	
  </div><!-- container -->
</nav>


 
  
  
  <div class="container">
   	
    <div class="row">
              			<div class="col-lg-10 col-lg-offset-2">	
<form method="post" action="" id="plform" class="form-horizontal">


<fieldset>
 
 <p class="error"><?php echo $message ?> </p>
 
 <hr/>
	<div class="form-group">
	
		<label for="txt_hospital" class="col-lg-2 control-label">Hospital: </label>
  		<div class="col-lg-10">
		<input type="text" name="txt_hospital" id="txt_hospital" class="col-xs-4" value="<?php echo $_POST['txt_hospital']; ?>" />
		</div>
	</div>
	<div class="form-group">
		<label for="txt_address" class="col-lg-2 control-label">Address: </label>
  		<div class="col-lg-10">
		<input type="text" name="txt_address" id="txt_address" class="col-xs-4" value="<?php echo $_POST['txt_address']; ?>" />
		</div>
	</div>
	
<div class="form-group">
	
		<label for="txt_city" class="col-lg-2 control-label">City: </label>
  <div class="col-lg-10">
		<input type="text" name="txt_city" id="txt_city" class="col-xs-4" value="<?php echo $_POST['txt_city']; ?>" />
</div>
	</div>
	
	<div class="form-group">
	
		<label for="state" class="col-lg-2 control-label">State: </label>
  <div class="col-lg-10">
		 
		
		 
		 
		 <?php 
		 
		
		 
		 
					echo "<select name='state'>";
					
					if(isset($_POST['state'])){
					
					  echo "<option value='". $_POST['state'].  "'>". $_POST['state'] . "</option>";
					}else
					{
					
					  echo "<option value=''>Select</option>";
					}
                  
					while($row = $result->fetch_assoc())  
				        {  
				           
				      

					
					if($row['state'] == $_POST['state']){
						$selected = ' selected="selected"';
					}else{
						$selected = '';
					}
					
					echo "<option value='".$row['state_abbr']."'". $selected.">";
					echo $row['state_abbr'];
					echo "</option>";
					}
					echo "</select>";
					
			
					?>
</div>
	</div>
	
	
	<div class="form-group">
		<label for="txt_zip" class="col-lg-2 control-label">Zip: </label>
  <div class="col-lg-10">
		<input type="text" name="txt_zip" id="txt_zip" value="<?php echo $_POST['txt_zip']; ?>"/>
</div>
</div>
	<div class="form-group">
	
		<label for="txt_phone" class="col-lg-2 control-label">Phone: </label>
  <div class="col-lg-10">
		<input type="text" name="txt_phone" id="txt_phone" value="<?php echo $_POST['txt_phone']; ?>" />
</div>
	</div>
<div class="form-group">
	
		<label for="txt_fax" class="col-lg-2 control-label">Fax: </label>
  <div class="col-lg-10">
		<input type="text" name="txt_fax" id="txt_fax" minlength="10" value="<?php echo $_POST['txt_fax']; ?>" />
</div>
	</div> 

<div class="form-group">
	 <div class="col-lg-10 col-lg-offset-2">

		 <button type="reset" class="btn btn-default">Cancel</button>
        	 <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        	 </div>
</div>
</fieldset>
	</form>
</div>
</div>
</div>

</script>
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>



<script src="js/jquery.js"></script>
<script src="js/jquery.validate.js"></script>

 <script>


  $("#plform").validate({


            rules: {

	              txt_hospital:{
	                    required:true,
	                    minlength: 2
	                },
	                txt_address:{
	                    required:true,
	                    minlength: 2
	                },
	                txt_city:{
	                    required:true,
	                    minlength: 2
	                },
	                txt_zip:{
	                    required:true,
	                    minlength: 5
	                },
	                txt_phone: {
	                    required: true,
	                    minlength: 10
	                }
	                
                
               
                }
               




            },

            messages: {
                txt_hospital: {
                    required:"*",
                    minlength: "Minimum 2 characters"
                },
		txt_address:{
		    required: "*",
		    minlength:"Minimum 2 characters"
		},		
                txt_city: {
                    required: "*",
                    minlength: "Minimum 2 characters"
                },
		
                txt_zip: {
                    required: "*",
                    minlength: "Minimum 5 characters"
                },
                txt_phone: {
                    required: "*",
                    minlength: "Minimum 10 characters"
                }
                
               
              
            }
        });
    </script>

   	
   	
   	
   	
   	</div>	
      





 	</div>	
   	   
<div class="spacer">  </div>
				<div class="push">
				</div>





<footer>
<div class="container">
	 <div class="row">
       <div class="col-lg-12 col-md-12">
       <p class="text-center">Petlabs Diagnostics Laboratories Inc. Main Office | 2510 Sub Station Road | Medina, Ohio 44256 | 330-220-6435</p>
	   <p class="text-center">Petlabs Animal Clinic Northview | 36400 Center Ridge Road | North Ridgeville, Ohio 44039 | 440-327-2062
        </div>
     </div>
	 
	 <div class="row">
	 <div class="col-lg-12 col-md-12">
	 <p class="text-center">Copyright &copy;2016 - Petlabs Diagnostics Laboratories Inc.</p>
	 </div>
	 </div>
</div> <!-- container-->
</footer>



</div><!-- wrapper -->
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
					    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
					    <!-- Include all compiled plugins (below), or include individual files as needed -->
					    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
     