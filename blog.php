<?php

session_start();
ob_start();

require_once('cat.inc.php');
include('expire.inc.php');



$conn = new mysqli($host, $user, $pwd, $db) or die();

$sql = "SELECT blogtext,title, date FROM blog ORDER BY DATE DESC";
$result = $conn->query($sql);



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
		.push { height:155px; }	
		.img-margin{margin-bottom:10px;}
		.active {font-weight:bold; color:#fff; border: 1px solid #FFFFFF;}
		.spacer{height:250px;}
		.warning{color:red; font-size: 16px;}
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
     	<li><a href="blog.html" class="active">Blog</a></li>       
      </ul>

    
    </div>
	
  </div><!-- container -->
</nav>
<div class="container">
	  <div class="blog-area"><?php
		  	if ($result->num_rows > 0) {
    
		    while($row = $result->fetch_assoc()) {
		    	
		    	
		        $blogtext =  $row["blogtext"];
				$title = $row['title'];
				$blogdate = $row["date"];
				
				echo '<b>';
				echo $title. ' - ' . $blogdate;
				echo '</b>';
				echo '<br />';
				echo '<div class="well">';
				echo $blogtext;
				echo '</div>';
				

			    }
			} else {
			    $blogtext=  "0 results";
				//$conn->close();
			}
		 
					?>
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