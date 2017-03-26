<?php

include('cat.inc.php');

$numRows=0;
$conn = new mysqli($host,$user,$pwd,$db) or die("Can't connect");

$sqlState = "select * from state order by state asc";
$result =  $conn->query($sqlState);




if(isset($_POST['submit'])){

    // create and execute INSERT query
       // create and execute INSERT query
        $hospital = trim(strip_tags($_POST['txt_hospital']));
	$address = trim(strip_tags($_POST['txt_address']));
        $city = trim(strip_tags($_POST['txt_city']));
	$state = trim(strip_tags($_POST['state']));
	$zip = trim(strip_tags($_POST['txt_zip']));
	$phone = trim(strip_tags($_POST['txt_phone']));
	$fax = strip_tags($_POST['txt_fax']);
	$fname = trim(strip_tags($_POST['txt_fname']));
	$lname = trim(strip_tags($_POST['txt_lname']));
	$email =trim(strip_tags($_POST['txt_email']));
	$pwd = trim(strip_tags($_POST['txt_pwd']));
	
	$error = false;
	
	
	if(empty($hospital) || empty($address) || empty($city) || empty($state) || empty($phone) || empty($fname) || empty($lname) || empty($email) || empty($pwd)){
	
	$error = true;
	
	}
	
	if(!$error){
	
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
		$sql = "insert into hospital (hospital_name, address, city, state, zip) values (?,?,?,?,?)";
		if($stmt->prepare($sql)){
			$stmt->bind_param('sssss',$hospital, $address,$city,$state,$zip);
			$stmt->execute();	
		}else{
		echo $stmt->error;
		}

		//get hospital_id
		$sql="select hospital_id from hospital where hospital_name = ?";
		if($stmt->prepare($sql)){
		
			$stmt->bind_param('s',$hospital);
			$stmt->bind_result($hosp_id);
			$stmt->execute();
			$stmt->store_result();
			$numRows =$stmt->num_rows;
			while ($stmt->fetch()) {
			
		       	$hospital_id = $hosp_id;
			   }
			
			   /* free results */
			   $stmt->free_result();
			
			  
			}else{
			
				echo $stmt->error;
				
			}
	
	}
	else
	{
		$message = "Hospital already in System";
			
	}



	//check client in client table

	$checkDuplicate = "select email from client where email = ? AND isActive ='1'";
	if($stmt->prepare($checkDuplicate)){
		$stmt->bind_param('s',$email);
		$stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		
		}else{
				echo $stmt->error;	
		}

	//if no rows, insert client from this form into client table
	if (!$numRows)
		{

		//create salt
			$salt = time();
			$pwd = sha1($pwd.$salt);

			$sql = "insert into client (email, pwd, salt, hospital_id, phone, fax, fname, lname,date) values(?,?,?,?,?,?,?,?,CURDATE())"; 			
			if($stmt->prepare($sql)){
					$stmt->bind_param('ssssssss',$email,$pwd,$salt,$hospital_id,$phone,$fax,$fname,$lname);
					$stmt->execute();	
				}else{
				echo $stmt->error;
				}
				
	
	
	
				//get client_id
				$sql="select client_id from client where email = ?";
				if($stmt->prepare($sql)){
				
					$stmt->bind_param('s',$email);
					$stmt->bind_result($client_id);
					$stmt->execute();
					$stmt->store_result();
					$numRows =$stmt->num_rows;
					while ($stmt->fetch()) {
					
				       	$my_client_id = $client_id;
					   }
					
					   /* free results */
					   $stmt->free_result();
					
					  
					}else{
					
						echo $stmt->error;
						
					}
	
				$sqlUpdate = "UPDATE hospital SET client_id = $my_client_id WHERE hospital_id = $hospital_id";
				
					if (!$conn->query($sqlUpdate) === TRUE) {
					  
					    echo "Error updating record: " . $conn->error;
					}
					
					$conn->close();
				

	    		$header = "From: Pet Labs Diagnostics<info@petlabsdiagnostics.com>";
			
			$mail = mail($email,"Pet Labs Confirmation","Welcome ".$fname.". Your able to access your records from Pet Labs Diagnostics Inc.",$header);
		
	
	   		     header("Location:success.html");
	   		     exit;
				
    		
		}
		else
		{
		$message = "User already in System";
		
		}
		
		}else
		{
		
		$message = 'Please fill out form completely';
		
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
        <li><a href="services.html">Services</a></li>
    	  <li><a href="mission.html" >Mission</a></li>
    	  <li><a href="about.html">About</a></li>
    	  <li><a href="contact.html">Contact</a></li>      
      </ul>

    
    </div>
	
  </div><!-- container -->
</nav>


 
  
  
  <div class="container">
   	
    <div class="row">
              			<div class="col-lg-10 col-lg-offset-2">	
<form method="post" action="" id="plform" class="form-horizontal">


<fieldset>
 <p  style="font-weight:bold;">Registration to access records. Password to be between 6-20 characters </p>
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
	
		<label for="txt_fname" class="col-lg-2 control-label">First Name: </label>
  <div class="col-lg-10">
		<input type="text" name="txt_fname"  id="txt_fname" class="col-xs-4" value="<?php echo $_POST['txt_fname']; ?>"  />
</div>
	</div>
<div class="form-group">
	
		<label for="txt_lname" class="col-lg-2 control-label">Last Name: </label>

  <div class="col-lg-10">
		<input type="text" name="txt_lname" id="txt_lname" class="col-xs-4" value="<?php echo $_POST['txt_lname']; ?>"  />
</div>
	</div>
<div class="form-group">
	
		<label for="txt_email" class="col-lg-2 control-label">Email: </label>
  <div class="col-lg-10">
		<input type="text" name="txt_email"  id="txt_email" class="col-xs-4" value="<?php echo $_POST['txt_email']; ?>" />
</div>
	</div>
<div class="form-group">
	
		<label for="txt_retype_email" class="col-lg-2 control-label">Confirm Email: </label>
  <div class="col-lg-10">
		<input type="text" name="txt_retype_email" id="txt_retype_email" class="col-xs-4"  value="<?php echo $_POST['txt_retype_email']; ?>"/>
</div>
	</div>
<div class="form-group">
	
		<label for="txt_pwd" class="col-lg-2 control-label">Password: </label>
  <div class="col-lg-10">
		<input type="password" name="txt_pwd" id="txt_pwd" class="col-xs-4" id="txt_pwd"  />
</div>
	</div>
<div class="form-group">
	
		<label for="txt_retype_pwd" class="col-lg-2 control-label">Confirm Password: </label>
  <div class="col-lg-10">
		<input type="password" name="txt_retype_pwd" class="col-xs-4" id="txt_retype_pwd"  />
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
                },
                txt_fname: {
                    required: true,
                    minlength: 2
                },
                txt_lname: {
                    required: true,
                    minlength: 2
                },

                txt_email: {
                    required: true,                 
                    email:true
                },
                txt_retype_email:{
                    required:true,
                    email:true,
                    equalTo: "#txt_email"
                },
                txt_pwd: {
                    required: true,
                    minlength: 6
                },
                txt_retype_pwd: {
                    required: true,
                    equalTo: "#txt_pwd"

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
                },
                txt_fname: {
                    required: "*",
                    minlength: "Minimum 2 characters"
                },
                txt_lname: {
                    required: "*",
                    minlength: "Minimum 2 characters"
                },
                txt_email: {
                    required: "*"
                   
                },
                txt_retype_email: {
                    required: "*",
                    equalTo: "Confirm email doesn't match email"
                },
                txt_pwd:
                {
                    required: "*",
                    minlength: "Minimum 6 characters"
                },
                txt_retype_pwd:
                {
		    required: "*",
                    equalTo: "Confirm password doesn't match the password"
                },
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
     