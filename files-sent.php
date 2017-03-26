<?php
session_start();
ob_start();
require('cat.inc.php');
include('expire.inc.php');
if ( $_SESSION['employee'] == 0){
	header('Location: login.php');
}

$conn =new mysqli($host,$user,$pwd,$db) or die ("Cannot connect to server");
$sql = "SELECT a.FileName, a.FileDate, b.hospital_name, c.email, c.phone, c.fax FROM documents a INNER JOIN hospital b ON a.HospitalID = b.hospital_id INNER JOIN client c ON b.hospital_id = c.hospital_id ORDER BY a.FileDate DESC ";
$result =$conn->query($sql);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Employee Workspace</title>
<link href="workspaceStyle.css" type="text/css" rel="stylesheet" />

<style type="text/css">

 #container { 
	width: 780px;  
	background: #B5B67E;
	margin: 0 auto; 
	border: 1px solid #000000;
	text-align: left;
} 
#mainContent
{ margin-left:190px;
margin-top:30px;
font-size:14px;

}
a 
{text-decoration:none;
color:#414A1B;
font-weight:bold;

}


#tbl_test td 
{text-align:center;

}
.link
{
text-decoration:underline;
font-weight:normal;
}
.btn
{
background-color:#574922;
border:none;
cursor:pointer;
color:#E8DBB9;
}

</style>
<title>Pet Labs Diagnostic Laboratories Inc.</title>
</head>

<body>
<div id="container"><!-- #BeginLibraryItem "/Library/NavHeader.lbi" -->


<table cellpadding="5" width="1200" style="border-bottom:solid #000000 1px;background:#fff;">
<tr><td width="66"><a href="employee_workspace.php">Workspace</a></td>
<td width="5">|</td>
<td width="60"><a href="clientfiles.php">Get Files</a></td>
<td width="5">|</td>
<td width="40"><a href="client_admin.php">Admin</a></td>
<td width="5">|</td>
<td width="40"><a href="downloadFile.php?file=EmployeeHelp.pdf">Help</a></td>
<td width="5">|</td>

<td width="410"  style="font-size:12px; text-align:right">
  <a href="logout.inc.php">Logout</a></td>
</tr></table><!-- #EndLibraryItem -->

              

                  
                   <table cellpadding="3" cellspacing="2" border="0" width="1200">
                   <tr><th style="background-color:#414A1B; color:#FFFFFF">File Date</th><th style="background-color:#414A1B; color:#FFFFFF">File Name</th><th style="background-color:#414A1B; color:#FFFFFF">Location</th><th style="background-color:#414A1B; color:#FFFFFF">Email</th><th style="background-color:#414A1B; color:#FFFFFF">Phone</th><th style="background-color:#414A1B; color:#FFFFFF">Fax</th></tr>
                   
                   <?php
				   
				    $numRows = $result->num_rows;
					for($i = 0; $i < $numRows ; $i++)
					{ 
					
						$row = $result->fetch_assoc();
						if($i % 2)
						{
						$RowColor="style='background-color:#ede4c5'";
						}
						else
						{
						//$RowColor="style='background-color:#c2c290'";
						$RowColor="style='background-color:#ffffff'";
						
						}
					
				   
                 
				   
				   echo "<tr><td ".$RowColor.">$row[FileDate]</td><td ".$RowColor.">$row[FileName]</td><td ".$RowColor.">$row[hospital_name]</td><td ".$RowColor.">$row[email]</td><td ".$RowColor.">$row[phone]</td><td ".$RowColor.">$row[fax]</td></tr>";
				   }
                   
                   ?>
                   </table>
                  

</body>
</html>
