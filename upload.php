<?php 

if (isset($_POST['upload'])){
$destination = 'upload/';
require_once('classes/Ps2/upload.php');
try
{
$upload = new Ps2_Upload($destination);
$upload->addPermittedTypes(array('application/pdf','text/plain'));
$upload->move();
$result = $upload->getMessages();
}catch (Exception $e){
echo $e->getMessage();
}

}

?>

<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #404B1B;
}
body {
	background-color: #B5B67E;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
.style2 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 14px;
	color: #000000;
}

#statement
{
	width:350px;
	line-height:120%;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #404B1B;
	font-weight:bold;
}

-->
</style>
<script type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<title>Pet Labs Diagnostic Laboratories Inc.</title><body onload="MM_preloadImages('images/roll_over/Layout-2_18.jpg','images/roll_over/Layout-2_19.jpg','images/roll_over/Layout-2_20.jpg','images/roll_over/Layout-2_21.jpg','images/roll_over/Layout-2_22.jpg')">


<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="98%" height="506" align="center" valign="top"><table width="60%" height="533" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="1%" height="533" valign="top" background="images/Layout-2_03.jpg"><img src="images/Layout-2_03.jpg" width="17" height="10"></td>
        <td width="1%" valign="top" bgcolor="#404B1B">&nbsp;</td>
        <td width="87%" align="center" valign="top" bgcolor="#404B1B"><table width="70%" height="610" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="100%" height="44" align="center" valign="top"><table width="927" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="66"><img src="images/Layout-2_04.jpg" width="66" height="104"></td>
                <td width="121"><img src="images/Layout-2_05.jpg" width="121" height="104"></td>
                <td width="144"><img src="images/Layout-2_06.jpg" width="144" height="104"></td>
                <td width="179"><img src="images/Layout-2_07.jpg" width="179" height="104"></td>
                <td width="185"><img src="images/Layout-2_08.jpg" width="185" height="104"></td>
                <td width="166"><img src="images/Layout-2-cuts_09.jpg" width="166" height="104"></td>
                <td width="58"><img src="images/Layout-2-cuts_10.jpg" width="66" height="104"></td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td height="506" valign="top"><table width="61%" height="534" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="4%" height="51" align="right" valign="top"><img src="images/Layout-2_256.jpg" width="41" height="28"></td>
                <td width="2%" align="left" valign="top" background="images/Layout-2_17.jpg"><img src="images/Layout-2_16.jpg" width="21" height="51"></td>
                <td width="64%" align="center" valign="top" background="images/Layout-2_17.jpg"><table width="795" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="121" height="51"><a href="index.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image18','','images/roll_over/Layout-2_18.jpg',1)"><img src="images/Layout-2_18.jpg" name="Image18" width="121" height="51" border="0"></a></td>
                    <td width="144"><a href="about.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image19','','images/roll_over/Layout-2_19.jpg',1)"><img src="images/Layout-2_19.jpg" name="Image19" width="144" height="51" border="0"></a></td>
                    <td width="179"><a href="mission.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image20','','images/roll_over/Layout-2_20.jpg',1)"><img src="images/Layout-2_20.jpg" name="Image20" width="179" height="51" border="0"></a></td>
                    <td width="185"><a href="services.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image21','','images/roll_over/Layout-2_21.jpg',1)"><img src="images/Layout-2_21.jpg" name="Image21" width="185" height="51" border="0"></a></td>
                    <td width="175"><a href="contact.html" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image22','','images/roll_over/Layout-2_22.jpg',1)"><img src="images/Layout-2_22.jpg" name="Image22" width="166" height="51" border="0"></a></td>
                  </tr>
                </table></td>
                <td width="26%" align="right" valign="top" background="images/Layout-2_17.jpg"><img src="images/Layout-2_24.jpg" width="20" height="51"></td>
                <td width="4%" align="left" valign="top"><img src="images/Layout-2_256.jpg" width="41" height="28"></td>
              </tr>
              <tr>
                <td height="18" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top" background="images/Layout-2_27.jpg"><img src="images/Layout-2_27.jpg" width="21" height="12"></td>
                <td align="center" valign="top" bgcolor="#F4EED6">&nbsp;</td>
                <td align="right" valign="top" background="images/Layout-2_29.jpg"><img src="images/Layout-2_29.jpg" width="20" height="12"></td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td height="464" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top" background="images/Layout-2_27.jpg">&nbsp;</td>
                <td align="center" valign="top" bgcolor="#F4EED6" class="style2"><H3>&nbsp;</H3>
                  <div id="statement">
                    <p>Save files to PetLabs Diagnostics!</p>
                    <p>&nbsp;</p>
                    <p><?php
if(isset($result)) {
echo '<ul>';
foreach ($result as $message){
echo "<li>$message</li>";
}
echo '</ul>';
}

?></p>
                    <p><form action="" method="post" enctype="multipart/form-data" id="uploadImage">
<p>
Upload file:
  <input type="file" name="image" id="image" />
</p>
<input type="submit" name="upload" id="upload" value="upload" />
</form></p>
                  </div></td>
                <td align="right" valign="top" background="images/Layout-2_29.jpg">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
            </table></td>
            </tr>

        </table></td>
        <td width="10%" valign="top" bgcolor="#404B1B">&nbsp;</td>
        <td width="1%" valign="top" background="images/Layout-2_11.jpg"><img src="images/Layout-2_11.jpg" width="16" height="10"></td>
      </tr>
    </table></td>
  </tr>
</table>
<style type="text/css"><!--
body,td,th {
	font-family: Courier New, Courier, monospace;
	font-size: 12px;
	color: #313B15;
}
body {
	background-color: #B5B67E;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
-->
</style>
<style type="text/css">
<!--
body,td,th {
	font-family: Courier New, Courier, monospace;
	font-size: 12px;
	color: #313B15;
}
body {
	background-color: #B5B67E;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
a {
	font-size: 12px;
	color: #483B1B;
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #483B1B;
}
a:hover {
	text-decoration: underline;
	color: #483B1B;
}
a:active {
	text-decoration: none;
	color: #483B1B;
}
h1,h2,h3,h4,h5,h6 {
	font-weight: bold;
}
h1 {
	font-size: 24px;
	color: #313B15;
}
h2 {
	font-size: 18px;
	color: #313B15;
}
-->
</style><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
</body>
</html>
