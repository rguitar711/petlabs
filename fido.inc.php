<?php

class mysql{
	
	function verifyUser($email,$pwd){
		
		//$conn = new mysqli($host,$user,$pwd,$db) or die("conn".mysql_error());
		$conn = new mysqli('localhost','northoft_labtech','lab7007','northoft_petlabs') or die("This is an error connecting".mysql_error());
		
		$sql = "select salt,pwd,hospital_id, fname,lname,client_id,employee from client WHERE  email = ? AND isActive = '1'";
		
		if($stmt = $conn->prepare($sql)){
			
			$stmt->bind_param('s', $email);
			$stmt->bind_result($salt,$storedPwd,$hospital_id,$fname, $lname,$client_id,$employee);
			$stmt->execute();
			$stmt->fetch();
			
			if (sha1($pwd.$salt)==$storedPwd){
			
				$_SESSION['clientID'] = $client_id;
				$_SESSION['hospitalID'] =$hospital_id;
				$_SESSION['client_fn'] = $fname;
				$_SESSION['client_ln']=$lname;
				$_SESSION['employee']=$employee;	
				$_SESSION['email'] = $email;
				$_SESSION['start']=time();	
				return true;
			
				}else{
				return false;
			}
		
		}
	}
}
?>