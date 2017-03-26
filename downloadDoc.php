<?php
session_start();
ob_start();
include('expire.inc.php');
include('cat.inc.php');

// block any attempt to explore the filesystem
if (isset($_GET['file']) && basename($_GET['file']) == $_GET['file']) {
  $getfile = $_GET['file'];
	$getId = $_GET['id'];
	
  }
else {
  $getfile = NULL;
	return;
  }
// define error handling
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
$nogo = 'Sorry, download unavailable. <a href="'.$previous.'">Back</a>.';

if (!$getfile) {
  // go no further if filename not set
  echo 'failed the get file part';
  }
else {
  // define the pathname to the file
  $filepath = $_SERVER['DOCUMENT_ROOT'].'/files/'.$getfile;
  // check that it exists and is readable
  if (file_exists($filepath) && is_readable($filepath)) {
    // get the file's size and send the appropriate headers
    $size = filesize($filepath);
    header('Content-Type: application/octet-stream');
    header('Content-Length: '.$size);
    header('Content-Disposition: attachment; filename='.$getfile);
    header('Content-Transfer-Encoding: binary');
	// open the file in binary read-only mode
	// suppress error messages if the file can't be opened
    $file = @ fopen($filepath, 'rb');
    if ($file) {
	  // stream the file and exit the script when complete
	 $conn = new mysqli($host,$user,$pwd,$db) or die ("Cannot connect to server");
	$hospital_id=$_SESSION['hospitalID'];
	$sql  = "UPDATE documents SET isRead = '1' WHERE HospitalId = '$hospital_id' and Id = '$getId'";
	$result=$conn->query($sql);
      fpassthru($file);
    
      }
	else {
	  header('Location:error-download-file.html');
	  }
	}
  else {
   header('Location:error-download-file.html');
	}
  }
?>



