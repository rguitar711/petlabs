<?php

session_start();
ob_start();

require_once('cat.inc.php');

//include('expire.inc.php');

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
		.push { height:250px; }	
		.img-margin{margin-bottom:10px;}
		.active {font-weight:bold; color:#fff; border: 1px solid #FFFFFF;}
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
      	 <li><a href="workspace.php">Workspace</a></li>
        <li><a href="client_admin.php" class="active">Admin</a></li>
         <li><a href="update_client.php">Update Info</a></li>
  <li><a href="register_hospital.php">Add Location</a></li>
       
    	  <li><a href="downloadFile.php?file=ClientHelp.pdf">Help</a></li>
    	  <li><a href="logout.inc.php">Logout</a></li>
    	    
      </ul>

    
    </div>
	
  </div>
</nav>

<div class="container">
	<div class="text-center">
	<p>Change and update password</p>
	<p>Password shall be 6-20 characters</p>
	
 	</div>
 	<br/>
 	
<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
<?php

$email = $_SESSION['email'];	


// initialize HTML_QuickForm object
$path = '/home1/northoft/php';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
require('/home1/northoft/php/HTML/QuickForm.php');
$form = new HTML_QuickForm('client_registration');


// add input boxes

$form->addElement('password', 'txt_pwd', 'Password:', array('size' => 30, 'maxlength'=>40));
$form->addElement('password', 'txt_retype_pwd', 'Retype Password:', array('size' => 30, 'maxlength'=>40));
$form->addRule('txt_pwd', 'ERROR: Missing value', 'required');
$form->addRule('txt_pwd','ERROR: Password must be between 6-20 characters','rangelength',array(6,20));
$form->addRule(array('txt_pwd','txt_retype_pwd') ,'Passwords don\'t match','compare');
$form->addRule('txt_retype_pwd', 'ERROR: Missing value', 'required');

// add submit button
$form->addElement('submit', null, 'Submit');
//add reset button
$form->addElement('reset',null,'Reset');

// validate input 
if ($form->validate()) {
    // if valid, freeze the form
    $form->freeze();
    
    // retrieve submitted data as array
    $data = $form->exportValues();
    
 


	$conn = new mysqli($host,$user,$pwd,$db);
   	$pwd = trim($_POST['txt_pwd']);
    $email = $_SESSION['email'];	
	
	if(isset($email)){
		//create salt
		$salt = time();
		$pwd = sha1($pwd.$salt);
		$sql = "update client set  pwd = ?, salt = ? where email = ?"; 			
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('sis', $pwd, $salt,$email);
		$stmt->execute();
		$stmt->close();

   		 // display success message and exit
			echo '<h3>';
   		 	echo 'Password has been changed'; 
			echo '</h3>';
			
    		exit;
		}
		else
		{

                        echo '<h3>';
   		 	echo 'Failed'; 
			echo '</h3>';

		exit;
		}
}


		// render and display the form
		$form->display();
?>

</div>
</div>

<div class="push">
				</div>

</div><!-- container -->






</div><!-- wrapper -->
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
					    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
					    <!-- Include all compiled plugins (below), or include individual files as needed -->
					    <script src="js/bootstrap.min.js"></script>
  </body>
</html>