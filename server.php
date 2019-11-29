<?php
function validateName($name) {
	if(!preg_match("/^[a-zA-Z ]*$/",$name)){
		$ErrorFlag = true;
		echo "<script type='text/javascript'>alert('Invalid Visitor Name');</script>";
	}
}

?>

<?php
	//$db = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
	$db = mysqli_connect('localhost', 'phpmyadmin', 'root', 'phpmyadmin'); 

	$username = "username@someemail.com";
	$hash = "7c75579c553fccec2fe790ae1f8dc650fabce48c057b573bacec3e0c52c5a16c";

	// varaibles to store input data from the visitor.
	$name = "";
	$email = "";
	$contact = "";
	$hostname = "";
	$hostemail = "";
	$hostcontact = "";


	// if visitor tries to checkin isset($_POST['checkin'] returns 1.
	if (isset($_POST['checkin'])) {
		// ErrorFlag is boolean to check for incorrect data entered.
		$ErrorFlag = false;

		// storing the checkin details provied by the visitor.
		$name = $_POST['Name'];
		$email = $_POST['Email'];
		$contact = $_POST['Contact'];
		$hostname = $_POST['hostName'];
		$hostemail = $_POST['hostEmail'];
		$hostcontact = $_POST['hostContact'];

		// check for correctness of all details provided.

		if (empty($name)) {
			$ErrorFlag = true;
			$nameErr = "Required";
		}else{
				validateName($name);
			}
			 

		if (empty($email)) {
			$ErrorFlag = true;
			$EmailErr = "Required";
		}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$ErrorFlag = true;
			echo "<script type='text/javascript'>alert('Invalid Visitor Email');</script>";
		}
		
		if (empty($contact)) {
			$ErrorFlag = true;
			$contactErr = "Required";
		}else if(strlen($contact)!=10){
			$ErrorFlag = true;
			echo "<script type='text/javascript'>alert('Invalid Visitor Contact number');</script>";
		}
		
		if (empty($hostname)) {
			$ErrorFlag = true;
			$hostnameErr = "Required";
		}else{
			validateName($hostname);
		}
		

		if (empty($hostemail)) {
			$ErrorFlag = true;
			$hostEmailErr = "Required";
		}else if(!filter_var($hostemail, FILTER_VALIDATE_EMAIL)){
			$ErrorFlag = true;
			echo "<script type='text/javascript'>alert('Invalid Host Email');</script>";
		}
		

		if (empty($hostcontact)) {
			$ErrorFlag = true;
			$hostcontactErr = "Required";
		}
		else if(strlen($hostcontact)>10 || strlen($hostcontact)<10){
			$ErrorFlag = true;
			echo "<script type='text/javascript'>alert('Invalid host Contact number.');</script>";
		}

		if($email==$hostemail){
			$ErrorFlag = true;
			echo "<script type='text/javascript'>alert('Visitor and host email cannot be same.');</script>";
		}

		if($contact==$hostcontact){
			$ErrorFlag = true;
			echo "<script type='text/javascript'>alert('Visitor and host Contact Number cannot be same.');</script>";
		}

		// if no error were found ErrorFlag will be flase.
		// so if its false proceding futhur. 

		if(!$ErrorFlag){

			// SQL query to select Email from database. 
			$verifyEmail = "SELECT * FROM Visitors WHERE VisitorEmail LIKE '$email' AND Checkout IS NULL";
			$result = mysqli_query($db, $verifyEmail);

			// if same email as checkin found in database with a non Null value
			if($result->num_rows > 0){
				echo "<script type='text/javascript'>alert('Someone has already Checked-In with the same details provided.');</script>";
			}else {
				// if not , then insert new isiter to database.
				$timestamp = date('Y-m-d H:i:s');
				$sql = "INSERT into Visitors (VisitorName, VisitorEmail, VisitorContact, HostName, HostEmail, HostContact, Checkin, Checkout)
					values ('$name','$email', $contact, '$hostname', '$hostemail', $hostcontact, '$timestamp', NULL)";
				mysqli_query($db, $sql);

				// Mail to Host informing him about the guest.
				$message = "VisitorName : " . $name . "VisitorEmail : ".$email . "Visitor Contact number  " . $contact . "Check In time of the visitor : " 
				. $timestamp . "  " ;
				// echo $message;
				if(mail($hostemail, "Details of the visitors",  $message)){
					echo "<script type='text/javascript'>alert('Your Checkin Details were sent to your Host Email Successfully.');</script>";
				}else{
					echo "<script type='text/javascript'>alert('A error occured while sending mail.');</script>";
				}
				
				// SMs to Host informing him about the guest.
				// Config variables. Consult http://api.textlocal.in/docs for more info.
				$test = "0";

				// Data for text message. This is the text message data.
				$sender = "TXTLCL"; // This is who the message appears to be from.
				$numbers = $hostcontact; // A single number or a comma-seperated list of numbers

				// 612 chars or less

				// A single number or a comma-seperated list of numbers
				$message = urlencode($message);
				$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
				$ch = curl_init('http://api.textlocal.in/send/?');
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch); // This is the result from the API
				curl_close($ch);
				if(!$result){
					echo "<script type='text/javascript'>alert('Error while sending sms);</script>";
				}else{
					echo $result;
					echo "<script type='text/javascript'>alert('SMS with your details was sucessfully sent to your host.');</script>";
				}
			}
		}

	}

	// if visitor tries to checkout isset($_POST['checkout'] returns 1.
	if (isset($_POST['checkout'])){

		// storing the checkout details provied by the visitor.
		$name = $_POST['Name'];
		$email = $_POST['Email'];
		$contact = $_POST['Contact'];
		
		// check for correctness of all details provided.
		if (empty($email)) {
			$ErrorFlag = true;
			$coEmailErr = "Required";
		}
		if (empty($contact)) {
			$ErrorFlag = true;
			$coContactErr = "Required";
		}
		else{
			// SQL query to select Email from database. 
			$verifyQuery = "SELECT * FROM Visitors WHERE VisitorEmail LIKE '$email' AND Checkout IS NULL";
			$result = mysqli_query($db,$verifyQuery);

			if ($result->num_rows > 0) {
				// if visitor found in database with non null checkout timestamp.
				// update its checkout time to current time.
				$chkoutsql = "UPDATE Visitors SET Checkout = now() WHERE VisitorEmail LIKE '$email' AND Checkout IS NULL";
				mysqli_query($db, $chkoutsql);
				$chkoutupdated = "SELECT * FROM Visitors WHERE VisitorEmail LIKE '$email' order by Checkout desc";
				$result = mysqli_query($db,$chkoutupdated);
				$row = mysqli_fetch_row($result);
				$message = "VisitorName : " . $name . "\nVisitorEmail : ". $email . "\nCheck In time of the visitor : " . $row[6]. "\nCheck Out time of the visitor : " . $row[7] . "\nHost name : " . $row[3]  . "\nEmail of host "  . $row[4] . "  ";
				// echo $message;
				
				// mailing the visitor his visit details.  
				if(mail($email, "Details of the visit",  $message)){
						echo "<script type='text/javascript'>alert('Your Checkout Details were sent to your Email Successfully.');</script>";
				}else{
					echo "<script type='text/javascript'>alert('A error occured while sending mail.');</script>";
				}

				// sending sms to visitor of his visit details. 
				// Config variables. Consult http://api.textlocal.in/docs for more info.
				$test = "0";

				// Data for text message. This is the text message data.
				$sender = "TXTLCL"; // This is who the message appears to be from.
				$numbers = $contact; // A single number or a comma-seperated list of numbers
				// 612 chars or less
				// A single number or a comma-seperated list of numbers
				
				$message = urlencode($message);
				$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
				$ch = curl_init('http://api.textlocal.in/send/?');
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$result = curl_exec($ch); // This is the result from the API
				curl_close($ch);
				if(!$result){
					echo "<script type='text/javascript'>alert('Error while sending sms);</script>";
				}else{
					echo $result;
					echo "<script type='text/javascript'>alert('SMS with your details was sucessfully sent to your Phone.');</script>";
				}	
			}else{
				echo "<script type='text/javascript'>alert('No matching data found . Please verify your Email');</script>";
			}
		}
	}
?>