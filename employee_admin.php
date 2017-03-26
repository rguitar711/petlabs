<?php

//session_start();
//ob_start();

require_once('cat.inc.php');
//include('expire.inc.php');

$message = '';
$currentNews = '';
$conn = new mysqli($host, $user, $pwd, $db) or die();


if(isset($_POST["submit"])) {
	
	$news = $_POST["news"];
	$sql = "UPDATE news SET description = ?,createdate = NOW() where id = '1'";
	$stmt = $conn->stmt_init();

	if($stmt->prepare($sql)){

		$stmt->bind_param('s', $news);
		$stmt->execute();
		$message = 'News Item Saved';	
		
	}
	else {
		$message = 'Error saving news item.';
		
	}

}

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


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <title>Petlabs Diagnostic Laboratories Inc.</title>

    <link href="css/spacelab.min.css" rel="stylesheet">
	<script src="ckeditor/ckeditor.js"></script>
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
      	 <li><a href="employee_workspace.php">Workspace</a></li>
      	  	 <li><a href="clientfiles.php" >Client Documents</a></li>
      	  	 <li><a href="client-list.php" >Client List</a></li>
      	  	  <li><a href="registration_list.php" >Client Registrations</a></li>
        <li><a href="employee_admin.php" class="active">Add News</a></li>
          <li><a href="employee_changepassword.php">Reset Password</a></li>
    	  <li><a href="downloadFile.php?file=ClientHelp.pdf">Help</a></li>
    	  <li><a href="logout.inc.php">Logout</a></li>
    	    
    	    
      </ul>

    
    </div>
	
  </div>
</nav>

<div class="container">
	<div class="text-center">
	
	
 	</div>
 	<br/>
 	


<div class="row">
	<div class="col-lg-6 col-lg-offset-3">
		<form action="" method="post">
			<p>Add News Items:</p>
			
				
				<textarea class="form-control" rows="3" id="news" name="news">
				
				
				
				
				<?php if(isset( $currentNews) && !empty( $currentNews)){
					echo  $currentNews;}
					?></textarea>		
			<script>
                // Replace the <textarea id="editor1"> with a CKEditor
                // instance, using default configuration.
                CKEDITOR.replace( 'news' );
            </script>
				

	
			<br/>
			
			 <button type="submit" class="btn btn-primary pull-right" name="submit">Save</button>
			
		</form>
		  
		<p style="color:green;"> <?php echo $message; ?></p>
		
	</div>
</div>




</div><!-- container -->






</div><!-- wrapper -->
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
					    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
					    <!-- Include all compiled plugins (below), or include individual files as needed -->
					    <script src="js/bootstrap.min.js"></script>
  </body>
</html>