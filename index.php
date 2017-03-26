<?php
session_start();
ob_start();


require_once 'fido.inc.php';
//require_once 'lost_password.php';
//require_once 'inc/log.php';
require_once('cat.inc.php');


function LogInUser($email, $result){

$host = "localhost";
$user="northoft_labtech";
$pwd="lab7007";
$db="northoft_petlabs";

if(isset($email) && isset($result)){

$connLog = new mysqli($host,$user,$pwd,$db) or die("conn".mysql_error());

$sqlLog = "insert into logs (User,LoginResult) values ('$email','$result')";



$connLog->query($sqlLog);


$connLog->close();



}
}


$currentNews ='';	 
$conn = new mysqli($host, $user, $pwd, $db) or die();
$sql = "SELECT description FROM news WHERE id = '1'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
        $currentNews =  $row["description"];
		//$conn->close();
    }
} else {


    $currentNews =  "0 results";
	//$conn->close();
}


if (array_key_exists('login', $_POST))

	{

	$email = trim($_POST['client_username']);
	$pwd = trim($_POST['client_password']);

	if($_POST['forgot_password']=='forgot_password'){
	LogInUser($email,'forgot password'); 
	forgot($email);
	
	exit;
	}

      
        
	$theclass = new mysql();
	
	$authorized = $theclass->verifyUser($email,$pwd);
	
	if ($authorized){
	  	LogInUser($email,'success'); 
		header('Location: workspace.php');
		exit;
	}else{
	LogInUser($email,'failed'); 
	   $_SESSION = array();
		session_destroy();
		$error = "<p style='color:#FF0000'>Invalid username or password</p>";
		
	}
	
}
	
	
if (array_key_exists('sendEmail', $_POST))
	{
	
	if(isset($_POST['url']) && $_POST['url'] == ''){
		$to = 'stromberg.1@osu.edu';
		$subject = 'Request information from PetLabs Website';
		$message ="Dr. Stromberg "."<br>".  $_POST['comments'] . "<br>" . $_POST['contactName'] ;
		$headers = "From: " . $_POST['contactEmail']."\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	   
		if(mail($to, $subject, $message,$headers))
			{
  echo "<script> alert('Mail Sent Successfully')</script>";
}else{
  echo "<script> alert('Mail Not Sent')</script>";
}	
	
	}
	}
	
if (array_key_exists('sendCytologistEmail', $_POST))
	{
	$to = 'MVPC@Roadrunner.com';
	$subject = 'Request information from PetLabs Website';
	$message ="Dr. Skowrenak "."<br>".  $_POST['comments'] . "<br>" . $_POST['contactName'] ;
	$headers = "From: " . $_POST['contactEmail']."\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
   
   if(mail($to, $subject, $message,$headers))
			{
  echo "<script> alert('Mail Sent Successfully')</script>";
}else{
  echo "<script> alert('Mail Not Sent')</script>";
}	
	
	
	
	}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Petlabs Diagnostic Laboratories Inc.</title>

    <!-- Bootstrap -->
    <link href="css/spacelab.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via  -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	<style type="text/css">
	.announcement { color:red; font-size: 16px;}
	footer{ background:#333; color:#eee; font-size:11px; padding:20px;width:100%;}
	body{background-color:#F8F8F8; }
	.wrapper{min-height:100%; height:auto; !important; height:100%; margin:0 auto -155px;}
	.push { height:155px; }	
	.textboxwidth{width:200px;margin-bottom:3px;}
    .login-area-controls{margin-left:40px;}
    .warning{color:red; font-size:11px;}
   .login {border:1px solid green; padding: 5px; background-color:#eee;}
   .login-text{font-size:14px;}
   .news-text-title{font-size:18px; font-weight:bold;  }
   .panel-padding{padding:5px;}
   .image-margin{margin-bottom:10px; margin-top:3px;}
   .antispam { display:none;}
	</style>


  </head>

  <body>
  <div class="wrapper">
  <header>
  <div class = "container">
  		  <div class="row">
    		  <div class="col-lg-6 col-md-6">
    		  	   <h4>Petlabs Diagnostics Laboratories Inc.</h4>
    		  </div>	
  		  </div>
  </div>
  
  
  
  </header>

<nav class="navbar navbar-default navbar-inverse ">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#petlabs-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    
    </div>


 <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="petlabs-navbar-collapse-1">
  
      <ul class="nav navbar-nav">
        <li><a href="services.html">Services</a></li>
    	  <li><a href="mission.html">Mission</a></li>
    	  <li><a href="about.html">About</a></li>
    	  <li><a href="contact.html">Contact</a></li>
    	  <li><a href="http://www.petlabsdiagnostics.com/blog/" >Blog  </a></li>    
      </ul>

    <ul class="nav navbar-nav navbar-right">
        <li><a href="client_registration.php"><span class="glyphicon glyphicon-user"></span> Register</a></li>
        <!--<li><a href="#" id="login-button"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <li><a href="#" data-target=".login-modal" data-toggle="modal"><span class="glyphicon glyphicon-log-in"></span> Login</a></li> -->
      </ul>

	 
    </div>
	
  </div>
</nav>

<div class="container">

    
 <div class="row">
 	<div class="col-md-9"> 
      	   
      	   
    			<div class="panel panel-info"> 
         	  <div class="panel-heading"> 
        	  	   <h3 class="panel-title panel-text-title news-text-title">Latest News </h3>
        	  </div> 
          	   <div class="panel-body panel-text"> 
          	   		<p><?php echo $currentNews; ?></p>
        </div> 
    	</div>
    	 <img src="images/DSC_6985.jpg" alt="location" width="100%" height="100%" class="image-margin"> 
    </div>
      	   
      	 
   
	<div class="col-md-3">
	
	 <!--<p class="announcement" >All reports to be accessed through website. </p>
       <p class="announcement">Registration necessary for accessing reports</p>-->
	    
	  <div class="well">
	  	<form action="" method="post">
	   
	  	 
	  	  	    	<!--<div class="row">

	  	  	    		<div class="col-md-3 col-md-offset-2 col-sm-3 col-sm-offset-2 col-xs-3 col-xs-offset-2">  -->
	  	  	    			 <div class="form-group"> 
	  	  	    			 	<label for="client_username" class="login-text">Email:</label><br/>
	           					<input type="text" id="client_username" name="client_username"  placeholder="Your Email" class="form-control input-sm textboxwidth"> 
	           					</div>
	           					
	           				
	  	  	    		
	  	  	    		
	  	  	    		
	  	  	    			<div class="form-group"> 
	  	  	    					<label for="client_password" class="login-text">Password:</label><br/>
	           						<input type="password"  id="client_password" name="client_password"  placeholder="Your Password"  class="form-control input-sm textboxwidth">
	           						 <a href="password-recovery.php" class="login-text">Forgot Password?</a>
	           					</div>
	           						
	  	  	    		
	  	  	    		<div class="form-group">
	  	  	    			<button type="submit" name="login" id="login" class="btn btn-success">Login</button>
	  	  	    		</div>
	  	  	    		
	  	  	    		<div class="form-group">	  	  	    			
	  	  	    			
						<?php

						if (isset($error)) {
		  					echo "<span class='warning'>$error</span>";
		  					}elseif (isset($_GET['expired'])){
		  					echo '<span class="warning">Your session has expired. Please log in again.</span>';
							} 
							
						?>
						</div>
	  	  	    		
	  
			</form>
    	</div> <!--login-well -->
    	
    	<div class="panel panel-default"> 
         	  <div class="panel-heading"> 
        	  	   <h3 class="panel-title panel-text-title">Download PDF's:</h3>
        	  </div> 
          	   <div class="panel-body panel-text"> 
          	   		<h4>Forms and Tests</h4>    
		              <p><a href="downloadFile.php?file=PL-19.pdf" >-Bloodwork Form</a><br />
		               <a href="downloadFile.php?file=PL-20.pdf">-Micro/Immunology Form</a><br />
		              <a href="downloadFile.php?file=Histopathology.pdf">-Histopathology Form</a><br /></p>
    		
	 					<p><a href="downloadFile.php?file=TEST_MANUAL_INDEX.pdf">-Index</a><br />	              
	              		<a href="downloadFile.php?file=TEST_MANUAL_BLOOD.pdf">-Blood Tests</a><br />
	            		<a href="downloadFile.php?file=TEST_MANUAL_MICRO.pdf" >-Microbiology Tests</a></p>	            
        </div> 
    	</div>

	</div><!-- col -->	
  </div> <!-- row -->



		<div class="row">
		  <div class="col-sm-6 col-md-4">
		 
<div class="panel panel-success"> 
         	  <div class="panel-heading"> 
        	  	   <h3 class="panel-title panel-text-title">Biopsies, Histopathology and Cytologies:</h3>
        	  </div> 
          	   <div class="panel-body panel-text">
          	 
          	   		<address>
		          <strong>PetLabs</strong><br>
		          PO Box 1960<br>
		           Powell, OH 43065<br>
		          <abbr title="Phone">&nbsp;</abbr><br>
		           
		          </address>
		    
 <p> <a class="btn btn-primary btn-xs" href="downloadFile.php?file=Powell.pdf" >Mailing Labels</a></p>
  <!-- Button trigger modal -->
<p><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
  Contact Dr. Paul Stromberg
</button></p>
<p><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal2">
  Contact Dr. Tony Skowrenak
</button></p>
		         
        </div> 
    	</div>
		  </div>
		
		
		  <div class="col-sm-6 col-md-4">
		  

<div class="panel panel-success"> 
         	  <div class="panel-heading"> 
        	  	   <h3 class="panel-title panel-text-title">Microbiology:</h3>
        	  </div> 
          	   <div class="panel-body panel-text"> 
          	
          	   		<address>
		    		<strong>PetLabs</strong><br>
		           2510 Substation Rd<br>
		           Medina, OH 44256<br>
		           <abbr title="Phone">P:</abbr>440-465-3392
				 </address> <a class="btn btn-primary btn-xs" href="downloadFile.php?file=Medina.pdf" >Mailing Labels</a><br />
				 <br>
        </div> 
    	</div>



		  </div>
		
		
		  <div class="col-sm-6 col-md-4">
		  

<div class="panel panel-success"> 
         	  <div class="panel-heading"> 
        	  	   <h3 class="panel-title panel-text-title">Blood Work, Endocrinology and Coggins:</h3>
        	  </div> 
          	   <div class="panel-body panel-text"> 
          	 
          	   		<address>
				<strong>PetLabs (USDA certified)</strong><br>
		         36400 Center Ridge Rd<br>
		         North Ridgeville, OH 44039<br>
		         <abbr title="Phone">P:</abbr>440-327-2062 
		       
		        </address>  <a class="btn btn-primary btn-xs" href="downloadFile.php?file=NorthRidgeville.pdf" >Mailing Labels</a><br />
		        <br>
        </div> 
    	</div>

		  </div>
		
		
		   <div class="row">
		   <div class="col-md-12">
		     <div class="well">
		       <p class="text-center"><a class="btn btn-info btn-sm" href="http://www.troybio.com/">Purchase Lab Supplies</a> </p>
		       
		       </div>
		       </div>
		       </div>
		   <div class="row">
		   <div class="col-md-12">
		     <div class="well">
		       <p class="text-center">Free Medical Consultations Available for Emergency Services, 24 hours, 6 Days a Week. </p>
		       <p  class="text-center">Hours of operation: Monday thru Saturday 9am-9pm</p>
		     </div>
		   </div>
		 
		 
		 </div>
		</div> <!-- row -->
		
					    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
					    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
					    <!-- Include all compiled plugins (below), or include individual files as needed -->
					    <script src="js/bootstrap.min.js"></script>
</div> <!-- row -->

	<div class="push">
	</div>

</div> <!-- container -->

<?php include 'inc/footer.php' ?>


</div> <!-- wrapper-->


 <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    


    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Contact Dr. Stromberg</h4>
      </div>
      <div class="modal-body">
      
        <form class="form-horizontal" method="POST" action="">
        
        
  <fieldset>
    <legend></legend>
    <div class="form-group">
      <label for="contactEmail" class="col-lg-2 control-label">Email</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="contactEmail" name="contactEmail" placeholder="Email">
      </div>
    </div>
    <div class="form-group">
      <label for="contactName" class="col-lg-2 control-label">Name</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="contactName" name="contactName" placeholder="Name">
       
      </div>
    </div>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label">Comments</label>
      <div class="col-lg-10">
        <textarea class="form-control" rows="3" id="comments" name="comments"  placeholder="Comments"></textarea>
        
      </div>
    </div>
   
     <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label antispam">Url</label>
      <div class="col-lg-10">
        <textarea class="form-control antispam" rows="3" id="url" name="url"  placeholder="Url"></textarea>
        
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" class="btn btn-default" data-dismiss="modal" >Cancel</button>
        <button type="submit" class="btn btn-primary" id="sendEmail" name = "sendEmail">Submit</button>
      </div>
    </div>
  </fieldset>
</form>
      </div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
			
	  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>		






 <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
    


    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Contact Dr. Tony Skowrenak</h4>
      </div>
      <div class="modal-body">
      
        <form class="form-horizontal" method="POST" action="">
        
        
  <fieldset>
    <legend></legend>
    <div class="form-group">
      <label for="contactEmail" class="col-lg-2 control-label">Email</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="contactEmail" name="contactEmail" placeholder="Email">
      </div>
    </div>
    <div class="form-group">
      <label for="contactName" class="col-lg-2 control-label">Name</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" id="contactName" name="contactName" placeholder="Name">
       
      </div>
    </div>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label">Comments</label>
      <div class="col-lg-10">
        <textarea class="form-control" rows="3" id="comments" name="comments"  placeholder="Comments"></textarea>
        
      </div>
    </div>
   
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" class="btn btn-default" data-dismiss="modal" >Cancel</button>
        <button type="submit" class="btn btn-primary" id="sendCytologistEmail" name = "sendCytologistEmail">Submit</button>
      </div>
    </div>
  </fieldset>
</form>
      </div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
			
			
 
  </body>
</html>