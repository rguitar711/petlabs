<?php

$timeLimit=24 * 60;
//current time
$now = time();

$redirect = 'index.php';

if(!isset($_SESSION['clientID'])){
header("Location: $redirect");
exit;
}
elseif ($now > $_SESSION['start'] + $timeLimit){
$_SESSION= array();
if(isset($_COOKIE[session_name()])){
setcookie(session_name(),'',time()-86400,'/');
}
session_destroy();
header("Location: {$redirect}?expired=yes");
exit;
}
else
{
$_SESSION['start'] = time();
}

?>
