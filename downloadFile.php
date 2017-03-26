<?php

// block any attempt to explore the filesystem
if (isset($_GET['file']) && basename($_GET['file']) == $_GET['file']) {
  $getfile = $_GET['file'];
  }
else {
  $getfile = NULL;
	return;
  }
// define error handling
$nogo = 'Sorry, download unavailable. <a href="prompt.php">Back</a>.';

if (!$getfile) {
  // go no further if filename not set
  echo $nogo;
  }
else {
  // define the pathname to the file
  $filepath = $_SERVER['DOCUMENT_ROOT'].'/forms/'.$getfile;
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
      fpassthru($file);
      exit;
      }
	else {
	  echo $nogo;
	  }
	}
  else {
    echo $nogo;
	}
  }
?>


