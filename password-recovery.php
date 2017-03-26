<?php 


	session_start();
	


	if (array_key_exists('submit',$_POST))
	{	
	
		require 'cat.inc.php';
		$conn = new mysqli($host,$user,$pwd,$db) or die("conn".mysql_error());
		
		$email = $_POST['email'];
		
	
		$sql = "select client_id from client where email = ?";
		
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("s",$email);
		$stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;
		$stmt->bind_result($client_id);
		$stmt->fetch();
		
		$stmt->close();
		
		if($rows>0) {
	
			
			$random_password=uniqid(rand());
			$random_password=substr($random_password, 0, 8);
			
			
			$salt = time();
			$new_password=sha1($random_password.$salt);
	
			$sqlUpdate = "update client set pwd = '$new_password', salt = $salt where email = '$email'";
			$conn->query($sqlUpdate);
			
			
			$from = "info@petlabsdiagnostics.com";
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From:" . $from . "\r\n";
			$headers .= "BCc: guit117_jj@yahoo.com" . "\r\n";
			mail($email,"Forgot Password","<html><head><title>PetLabs Password</title></head><body><p>Your temporary password is $random_password .</p><p> Login into Petlabs with this password then change it to a preferred password in your 	Admin page.</p><p><a href='http://www.petlabsdiagnostics.com/index.php'>Login</a> </p> </body> </html>   ",$headers);
			$forgotPassword = "Password has been emailed to you";
					

		}
		else
		{
			$forgotPassword = "Email Not In System";
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
		.spacer{height:250px;}
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
    	  <li><a href="contact.html" class="active">Contact</a></li>      
      </ul>

    
    </div>
	
  </div><!-- container -->
</nav>
<div class="container">
	<div class="row">
	<div class="col-lg-6 col-lg-offset-2">
		
		
		
<form action="" method="post" >
	
	
	
        <p class="img-margin">Enter in your PetLabs login email address to get temporary password.</p>
        
<div class="img-margin">
        <input type="text" class="form-control" id="email" name="email" placeholder="Email" >  
         </div>
         
           <div class="img-margin">
        <button type="submit" class="btn btn-primary pull-right" name="submit">Send</button>
           </div>
 
		<p><?php echo $forgotPassword; ?></p>

	
	
</form>









</div>
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