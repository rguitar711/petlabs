




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data" id="uploadImage">
<p>
<label for="image">Upload Image:</label>
<input type="file" name="image" id="image" />
</p>
<p>
<input type="submit" name="upload" id="upload" value="Upload" />
</p>
</form>
<pre>
<?php
if (isset($_POST['upload'])) {
print_r($_FILES);
}

if(isset($_POST['upload'])){
$destination ='/public_html/petlabsdiagnostics/uploads/';
move_uploaded_file($_FILES['image']['tmp_name'], $destination . $_FILES['image']['name']);
}
?>
</pre>
</body>
</html>

