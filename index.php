<?php include ('server.php'); ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Innovaccer Booking</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body style="background-color:#FFFFC2;">
		<div class="img"> <img src="logo" alt="Error Logo Missing" height="150" width="1000"></div>
		<div class="Checkout_form">
			<form method="post" action="index.php">
				<div class="ckout_input">
					<input type="text" name="Name" placeholder="Your Name" class="input_text">
				</div>
				<div class="ckout_input">
					<input type="text" name="Email" placeholder="Your Email Address" class="input_text">
					<span>* <?php echo $coEmailErr;?></span>
				</div>
				<div class="ckout_input">
					<input type="text" name="Contact" placeholder="Your Contact Number" class="input_text">
					<span>* <?php echo $coContactErr;?></span>
				</div>
				<div class="ckout_input">
					<button type="submit" name="checkout" class="btn">Checkout</button>
				</div>
			</form>

		</div>

		<div class="about_class">
			<div class="about_img">
				<div class="about">
					<pre style="font-family:cursive; font-style:italic; font-size:40px">WHAT IS OUR STORY?</pre>
					<p style="font-size:25px;">			
						Fueled by innovation, people at Innovaccer are driven by a hunger for learning and a desire to make a difference. We’re a San Francisco-based organization focused on helping healthcare organizations accelerate innovation by making powerful decisions based on key insights and data-driven predictions.
						<div class="about_img">
							<div class="img"> <img src="summergeeks.png" alt="Error Logo Missing" height="200" width="460"></div>
						</div>
					</p>
				</div>
			</div>
	 	</div>


	 	<div class="Main_checkin">
	 		<div class="book_app">Book An Appoinment</div>
	 		<form method="post" action="index.php" onsubmit="return validateForm()" class="reg_form">
	 			<div class="your_detail">
	 				Your Details
	 			</div>
		 		<div class="checkin">
		 			<div class="input">
						<input type="text" name="Name" placeholder="Your Name">
						<span>* <?php echo $nameErr;?></span>
					</div>
				
	                <div class="input">
						<input type="text" name="Email" placeholder="Your Email Address">
						<span>* <?php echo $EmailErr;?></span>
				    </div>
				
					<div class="input">
						<input type="text" name="Contact" placeholder="Your Contact number">
						<span>* <?php echo $contactErr;?></span>
					</div>
				</div>

				<div class="host_detail">
					Host Details
				</div>
		 		<div class="checkin">
		 			<div class="input">
						<input type="text" name="hostName" placeholder="Host Name">
						<span>* <?php echo $hostnameErr;?></span>
					</div>
					
					<div class="input">
						<input type="text" name="hostEmail" placeholder="Your Email Address">
						<span>* <?php echo $hostEmailErr;?></span>
					</div>
					
					<div class="input">
						<input type="text" name="hostContact" placeholder="Host Contact number">
						<span>* <?php echo $hostcontactErr;?></span>
					</div>
				</div>
				<div class="input">
					<button type="submit" name="checkin" class="btn">CheckIn</button>
				</div>
			</form>
	 	</div>
	</body>
</html>