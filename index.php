<?php include ('server.php'); ?>
<!DOCTYPE html>
<html>

	<head>
		<title>Welcome To Innovaccer</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<div> <h1 class="MainHeading"><strong>Innovaccer</strong></h1> </div>

		<div>
			<div class=About>
				<p>Innovaccer Inc. is a Silicon Valley-based healthcare company, founded by Abhinav Shashank, Kanav Hasija, and Sandeep Gupta that provides physician practices, hospitals, health systems, and other healthcare providers with population health management and Pay-for-performance solutions.[buzzword] Innovaccer also provides solutions[buzzword] for care management, referral management, and patient engagement.</p>
			</div>
			<div class="logo" style="float: right; width: 50%">
				<img src="Innovaccer.jpg" alt="Error Logo Missing" height="400" width="400">
			</div>
		</div>

		<div class="checkOut" style="float: right; width: 50%">
			<h2 class="SideHeading"> <strong>Check Out</strong></h2>

			<form method="post" action="index.php">
				<div class="InputBlocks">
					<input type="text" name="Name" placeholder="Your Name">
				</div>
				<div InputBlocks>
					<input type="text" name="Email" placeholder="Your Email Address">
					<span class="error">* <?php echo $coEmailErr;?></span>
				</div>
				<div InputBlocks>
					<input type="text" name="Contact" placeholder="Your Contact Number">
					<span class="error">* <?php echo $coContactErr;?></span>
				</div>
				<div class="Enter">
					<button type="submit" name="checkout" class="btn">Checkout</button>
				</div>
			</form>
		</div>	

		<div class="checkin" style="float: right; width: 50%">
			<h2 class="SideHeading"> <strong>Book An Appoinment</strong></h2>

			<form name="input" method="post" action="index.php" onsubmit="return validateForm()" class="reg_form">
				<div class="visitor">
					<h3 class="visitor">Your Details</h3>
					<div class="Reg">
						<input type="text" name="Name" placeholder="Your Name">
						<span class="error">* <?php echo $nameErr;?></span>
					</div>
					<div class="Reg">
						<input type="text" name="Email" placeholder="Your Email Address">
						<span class="error">* <?php echo $EmailErr;?></span>
					</div>
					<div class="Reg">
						<input type="text" name="Contact" placeholder="Your Contact number">
						<span class="error">* <?php echo $contactErr;?></span>
					</div>
				</div>

			<div class="host">
				<h3>Host Details</h3>
				<div class="Reg">
					<input type="text" name="hostName" placeholder="Host Name">
					<span class="error">* <?php echo $hostnameErr;?></span>
				</div>
				<div class="Reg">
					<input type="text" name="hostEmail" placeholder="Your Email Address">
					<span class="error">* <?php echo $hostEmailErr;?></span>
				</div>
				<div class="Reg">
					<input type="text" name="hostContact" placeholder="Host Contact number">
					<span class="error">* <?php echo $hostcontactErr;?></span>
				</div>
			</div>

			<div class="Enter">
				<button type="submit" name="checkin" class="btn">CheckIn</button>
			</div>
		</form>
		</div>
	</body>
</html>