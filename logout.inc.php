<?php
// run this script only if the logout button has been clicked
session_start();
  // empty the $_SESSION array
  $_SESSION = array();
  // invalidate the session cookie
  if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-86400, '/');
  }
  // end session and redirect
  session_destroy();

  header('Location: index.php');
  exit;

?>
<!--<style type="text/css">

.logout
{
background-color:#FFFFFF;
color:#000000;
border:none;
cursor:pointer;


}



</style>
<form id="logoutForm" method="post" action="">
  <input name="logout" type="submit" id="logout" value="Sign Out" class="logout">
</form>
-->