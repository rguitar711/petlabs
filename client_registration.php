<?php

ob_start();
require('cat.inc.php');

$numRows=0;
$conn = new mysqli($host,$user,$pwd,$db) or die("Can't connect");

$sqlState = "select * from state order by state asc";
$result =  $conn->query($sqlState);

 $policy_message = '';
 $error_message = '';
 $message = '';
 
 

if(isset($_POST['submit'])){




    if(isset($_POST['ck_policy'])){

        $hospital = trim(strip_tags($_POST['txt_hospital']));
        $address = trim(strip_tags($_POST['txt_address']));
        $city = trim(strip_tags($_POST['txt_city']));
        $state = trim(strip_tags($_POST['state']));
        $zip = trim(strip_tags($_POST['txt_zip']));
        $phone = trim(strip_tags($_POST['txt_phone']));
        $fax = strip_tags($_POST['txt_fax']);
        $fname = trim(strip_tags($_POST['txt_fname']));
        $lname = trim(strip_tags($_POST['txt_lname']));
        $email =trim(strip_tags($_POST['txt_email']));
        $retype_email = trim(strip_tags($_POST['txt_retype_email']));
        $pwd = trim(strip_tags($_POST['txt_pwd']));
        $hospital_name =trim(strip_tags($_POST['txt_hospital_name']));
        $billingContact = trim(strip_tags($_POST['txt_billing_contact_name']));
        $billingPhone = trim(strip_tags($_POST['txt_billing_contact_phone']));
        $invoiceEmail =  trim(strip_tags($_POST['txt_invoice_email_address']));
        $invoiceEmail2 = trim(strip_tags($_POST['txt_invoice_email_address2']));
        $paymentType = trim(strip_tags($_POST['r_payment']));
        $signature = trim(strip_tags($_POST['txt_signature']));
        $reg_date = trim(strip_tags($_POST['txt_signature_date']));

        
        $error = false;
        


    
      if(empty($hospital_name) || empty($billingContact) || empty($billingPhone) || empty($invoiceEmail) || empty($paymentType) || empty($signature) || empty($reg_date))
        {
            $error = true;
            $error_message = '** PLEASE FILL OUT FORM COMPLETELY **';
        }

       
        if(empty($hospital) || empty($address) || empty($city) || empty($state) || empty($phone) || empty($fname) || empty($lname) || empty($email) || empty($pwd)){
        
                $error = true;
                $error_message = ' ** PLEASE FILL OUT FORM COMPLETELY **';
        }
	
	
	if ($email != $retype_email){
		
		$error_message = "** EMAIL ADDRESS DOESN'T MATCH *";
		$error = true;
	
	}
	
	
        if(!$error){
        
        //check for hospital in hospital table

        $checkDuplicateHospital ="select hospital_name,hospital_id from hospital where address like ? or hospital_name like ? AND isActive = '1'";
        $hosp = '%'.$hospital.'%';
        $addr = '%'.$address.'%';
        
        $stmt = $conn->stmt_init();
        if($stmt->prepare($checkDuplicateHospital)){
            $stmt->bind_param('ss',$addr,$hosp);
            $stmt->execute();
            $stmt->store_result();
            $numRows = $stmt->num_rows;
        }else{
            echo $stmt->error;
        }


        //if no hospital is found insert one
        if (!$numRows)
        {
            $sql = "insert into hospital (hospital_name, address, city, state, zip) values (?,?,?,?,?)";
            if($stmt->prepare($sql)){
                $stmt->bind_param('sssss',$hospital, $address,$city,$state,$zip);
                $stmt->execute();	
            }else{
            echo $stmt->error;
            }

            //get hospital_id
            $sql="select hospital_id from hospital where hospital_name = ?";
            if($stmt->prepare($sql)){
            
                $stmt->bind_param('s',$hospital);
                $stmt->bind_result($hosp_id);
                $stmt->execute();
                $stmt->store_result();
                $numRows =$stmt->num_rows;
                while ($stmt->fetch()) {
                
                    $hospital_id = $hosp_id;
                }
                
                /* free results */
                $stmt->free_result();
                
                
                }else{
                
                    echo $stmt->error;
                    
                }
        
        }
        else
        {
            $message = "Hospital already in System";
                
        }



	//check client in client table

	$checkDuplicate = "select email from client where email = ? AND isActive ='1'";
	if($stmt->prepare($checkDuplicate)){
		$stmt->bind_param('s',$email);
		$stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		
		}else{
				echo $stmt->error;	
		}

	//if no rows, insert client from this form into client table
	if (!$numRows)
		{

		//create salt
			$salt = time();
			$pwd = sha1($pwd.$salt);

			$sql = "insert into client (email, pwd, salt, hospital_id, phone, fax, fname, lname,date) values(?,?,?,?,?,?,?,?,CURDATE())"; 			
			if($stmt->prepare($sql)){
					$stmt->bind_param('ssssssss',$email,$pwd,$salt,$hospital_id,$phone,$fax,$fname,$lname);
					$stmt->execute();	
				}else{
				echo $stmt->error;
				}
				
				//get client_id
				$sql="select client_id from client where email = ?";
				if($stmt->prepare($sql)){
				
					$stmt->bind_param('s',$email);
					$stmt->bind_result($client_id);
					$stmt->execute();
					$stmt->store_result();
					$numRows =$stmt->num_rows;
					while ($stmt->fetch()) {
					
				       	$my_client_id = $client_id;
					   }
					
					   /* free results */
					   $stmt->free_result();
					
					  
					}else{
					
						echo $stmt->error;
						
					}
	
				$sqlUpdate = "UPDATE hospital SET client_id = $my_client_id WHERE hospital_id = $hospital_id";
				
					if (!$conn->query($sqlUpdate) === TRUE) {
					  
					    echo "Error updating record: " . $conn->error;
					}
					
				
				

          $sqlRegistration = "INSERT INTO registration (hospital_name, contact_name, contact_number, contact_email, contact_email2, electronic_signature, registration_date, payment_type,insert_date) values (?,?,?,?,?,?,?,?,CURDATE())";
                    if($stmt->prepare($sqlRegistration)){
                        $stmt->bind_param('ssssssss',$hospital_name,$billingContact,$billingPhone,$invoiceEmail,$invoiceEmail2,$signature,$reg_date,$paymentType);
                        $stmt->execute();	
                        }else{
                        echo $stmt->error;
                        }

   	$conn->close();



	    		$header = "From: Pet Labs Diagnostics<info@petlabsdiagnostics.com>";
			
			$mail = mail($email,"Pet Labs Confirmation","Welcome ".$fname.". Your able to access your records from Pet Labs Diagnostics Inc.",$header);
		
	
	   		     header("Location:success.html");
	   		     exit;		
    		
            }
            else
            {
            $message = "User already in System";	
            }
		
		}
        	else
		{		
		$message = $error_message;
		
		}

    }
    else
    {
        $policy_message = 'POLICY NOT ACCEPTED, PLEASE CHECK BOX TO AGREE';
    }

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
    <link href="css/screen.css" rel="stylesheet">
	<style type="text/css">
	
		footer{ background:#333; color:#eee; font-size:11px; padding:20px;width:100%;}
		body{background-color:#F8F8F8; }
		.wrapper{min-height:100%; height:auto; !important; height:100%; margin:0 auto -155px;}
		.push { height:155px; }	
		.img-margin{margin-bottom:10px;}
		.active {font-weight:bold; color:#fff; border: 1px solid #FFFFFF;}
		.spacer{height:250px;}
		.registration{margin-left:600px;margin-top: 30px;}
		td, th{padding:5px;}
		.error{color:red; font-weight:bold; }
		.textbox-width{width:300px;}
		
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
    	  <li><a href="mission.html">Mission</a></li>
    	  <li><a href="about.html">About</a></li>
    	  <li><a href="blog.php">Blog</a></li>  
    	  <li><a href="contact.html">Contact</a></li> 
    	      
      </ul>
	    
	    </div>
	
  </div><!-- container -->
</nav>


 
  
  
  <div class="container">
   	
    <div class="row">
    <div class="col-lg-10 col-lg-offset-2">	
    
	<form method="post" action="" id="plform" class="form-horizontal">
   		<fieldset>
     		<h3 style="font-weight:bold;">REGISTRATION FOR ACCOUNT </h3>
     		  <p class="error"><?php echo $message ?> </p>
        	 <hr />
			<div class="col-lg-10">
                            <h4 style="font-weight:bold;">CREDIT POLICY </h4>
                          



                            
                                <p>Invoices are prepared on the first of each month for the previous month’s requisitions.  Requisitions submitted at the end of the month may appear on the next 				month’s invoice.  Invoices are delivered via email to up to two email addresses.  A valid form of payment must be on file before any requisitions will be processed.  Payment may be made by either credit card or direct bank withdrawal.  All payments are automatically processed on the first of each month.</p>



                                <p class="error"><?php echo $policy_message ?> </p> <input type="checkbox" name="ck_policy" id="ck_policy" value="agreed" <?php if(isset($_POST['ck_policy'])) { echo 'checked';} ?>> &nbsp;I have read and understand the <strong>PETLABS DIAGNOSTIC LABORATORIES INC.</strong> Credit Policy.
                            </div>


                </div>
                </div>


                <div class="row">
                    <div class="col-lg-10 col-lg-offset-2">
                        <div class="col-lg-10">
                        <br/>
                        
                            <h4 style="font-weight:bold;">RECURRING PAYMENT AUTHORIZATION </h4>




                            <p>I authorize <strong>PETLABS DIAGNOSTIC LABORATORIES INC.</strong> to initiate either an electronic debit against my bank account or to charge my credit card according to the terms of the Credit Policy.</p>
                            <p>I acknowledge that any originating ACH transactions to this account must comply with the provisioning of United States law.</p>
</div>
</div>
</div>



        <div class="container">
            <div class="row">

                <div class="col-lg-10 col-lg-offset-2">
                
                <table>
                
                <tr>
                
                <td>
                Hospital Name:
                
                </td>
                <td>
                <input type="text" size="50" name="txt_hospital_name" id="txt_hospital_name" value="<?php echo $_POST['txt_hospital_name']; ?>"/>
                
                </td>
                
                
                </tr>
                
<tr>

<td>

Billing Contact Name:
</td>
<td>
	<input type="text" size="25" maxlength="25" name="txt_billing_contact_name" id="txt_billing_contact_name" value="<?php echo $_POST['txt_billing_contact_name']; ?>"/>

</td>


</tr>

<tr>
<td>
Billing Contact Phone: 
</td>

<td>
<input type="text" name="txt_billing_contact_phone" id="txt_billing_contact_phone" value="<?php echo $_POST['txt_billing_contact_phone']; ?>"/>
</td>
</tr>


<tr>
<td>
Invoice Email Address:
</td>
<td>
	<input type="text" size="50" name="txt_invoice_email_address" id="txt_invoice_email_address" value="<?php echo $_POST['txt_invoice_email_address']; ?>"/>
</td>
</tr>

<tr>
<td>
Second Invoice Email Address (optional):
</td>
<td>
<input type="text" size="50" name="txt_invoice_email_address2" id="txt_invoice_email_address2" value="<?php echo $_POST['txt_invoice_email_address2']; ?>"/>
</td>

</tr>

<tr>
<td>I prefer to pay via:
</td>

<td>	<input type="radio" name="r_payment" id="r_payment" value="checking" <?php if(isset($_POST['r_payment'])  && $_POST['r_payment'] == 'checking') { echo 'checked = "checked"';} ?> />&nbsp;Bank Draft from my checking account	&nbsp;&nbsp;&nbsp;
        <input type="radio" name="r_payment" id="r_payment" value="credit_card" <?php if(isset($_POST['r_payment'])  && $_POST['r_payment'] == 'credit_card') { echo 'checked = "checked"';} ?> /> &nbsp;Credit Card
</td>

</tr>
<tr><td colspan="2">A billing representative from <strong>PETLABS DIAGNOSTIC LABORATORIES INC.</strong> will contact you to obtain valid payment information. </td></tr>

</table>

<br/>

<br/>

<p>
This payment authorization will remain in full force and effect until I notify <strong>PETLABS DIAGNOSTIC LABORATORIES INC.</strong> of its cancellation by sending written notice in such time and such manner that allow both <strong>PETLABS DIAGNOSTIC LABORATORIES INC. </strong>and the receiving financial institution a reasonable opportunity to act upon it.</p>



<table>
<tr>
<td>
Electronic Signature:

</td>
<td>
<input type="text" name="txt_signature" id="txt_signature" value ="<?php echo $_POST['txt_signature']; ?>" />
</td>

</tr>

<tr>
<td>
Date:
</td>
<td>
<input type="text" name="txt_signature_date" id="txt_signature_date" value ="<?php echo $_POST['txt_signature_date']; ?>" />
</td>

</tr>


</table>

</div>

</div>

</div>


  <br/>
  <br/>
  
  
  <div class="container">
   	
    <div class="row">
              			<div class="col-lg-10 col-lg-offset-2">	
<fieldset>
 <p  style="font-weight:bold;">Registration to access records. Password to be between 6-20 characters </p>

 
 <hr/>
	<table border = "0" cellpadding="3" cellspacing="3">
	<tr>
	<td>Hospital Name: </td>
	<td><input type="text"  size="50" name="txt_hospital" id="txt_hospital" value="<?php echo $_POST['txt_hospital']; ?>" /></td>
	</tr>
	
	<tr>
	<td>Address: </label></td>
	<td><input type="text" size="50" name="txt_address" id="txt_address"  value="<?php echo $_POST['txt_address']; ?>" /></td>
	</tr>
	
	<tr>
	<td>City:</td>
	<td><input type="text" size="50" name="txt_city" id="txt_city"  value="<?php echo $_POST['txt_city']; ?>" /></td>
	</tr>
	
	<tr>
	<td>State: </td>
	<td>
		
  		
		
		 
		 <?php 
		 
		
		 
		 
					echo "<select name='state'>";
					
					if(isset($_POST['state'])){
					
					  echo "<option value='". $_POST['state'].  "'>". $_POST['state'] . "</option>";
					}else
					{
					
					  echo "<option value=''>Select</option>";
					}
                  
					while($row = $result->fetch_assoc())  
				        {  
				           
				      

					
					if($row['state'] == $_POST['state']){
						$selected = ' selected="selected"';
					}else{
						$selected = '';
					}
					
					echo "<option value='".$row['state_abbr']."'". $selected.">";
					echo $row['state_abbr'];
					echo "</option>";
					}
					echo "</select>";
					
			
					?>
</td>
</tr>
	
	
	<tr><td>Zip: </td>
	<td><input type="text" name="txt_zip" id="txt_zip" value="<?php echo $_POST['txt_zip']; ?>"/></td>
	</tr>
	
	<tr>
	<td>Phone: </td>
	<td><input type="text" name="txt_phone" id="txt_phone" value="<?php echo $_POST['txt_phone']; ?>" /></td>
	</tr>
	
	
	<tr>
	<td>Fax: </td>
	<td><input type="text" name="txt_fax" id="txt_fax" minlength="10" value="<?php echo $_POST['txt_fax']; ?>" /></td>
	</tr>
	
	<tr>
	<td>First Name: </td>
	<td><input size="25" maxlength="25" type="text" name="txt_fname"  id="txt_fname"  value="<?php echo $_POST['txt_fname']; ?>"  /></td>
	</tr>
	
	<tr>
	<td>Last Name:</td>
	<td><input size="25" maxlength="25" type="text" name="txt_lname" id="txt_lname" value="<?php echo $_POST['txt_lname']; ?>"  /></td>
	</tr>
	
	<tr>
	<td>Email:</td>
	<td><input type="text" size="50" name="txt_email"  id="txt_email" value="<?php echo $_POST['txt_email']; ?>" /></td>
	</tr>
	
	<tr>
	<td>Confirm Email:</td>
	<td><input type="text" size="50" name="txt_retype_email" id="txt_retype_email" value="<?php echo $_POST['txt_retype_email']; ?>"/></td>
	</tr>
	
	<tr>
	<td>Password: </td>
	<td><input type="password" name="txt_pwd" id="txt_pwd" id="txt_pwd"  /></td>
	</tr>
	
	
	
	<tr>
	<td>&nbsp;</td>
	<td> <button type="reset" class="btn btn-default">Cancel</button>&nbsp;&nbsp;<button type="submit" class="btn btn-primary" name="submit">Submit</button></td>
	
	</tr>
	
	</table>
	
		

	
		
  
	
	

</fieldset>
	</form>
</div>
</div>
</div>















 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>	
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>



   	
   	
   	
   	
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
					    
					    <!-- Include all compiled plugins (below), or include individual files as needed -->
					    <script src="js/bootstrap.min.js"></script>
					    
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>	
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">			    
	 <script>
  $( function() {
    $( "#txt_signature_date" ).datepicker();
  } );
  </script>				    
  </body>
</html>
     