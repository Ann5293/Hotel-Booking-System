<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/hotel/";

require_once($path . 'connect.php');

// Initialize the session
session_start();

if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
	echo "Unauthorized Access";
	return;
}


if ($_SESSION['role'] == 'admin') {
	if (isset($_POST['submit']))
	{
		$ReadSql = "Select a.id, b.image, a.room_no, b.type, a.customer_email, a.adults_num, a.children_num, a.check_in, a.check_out, b.price, a.clear_bill from bookings a, rooms b where a.room_no=b.id AND a.id=".$_POST["id"];
	}
	else
	{
		$ReadSql = "Select a.id, b.image, a.room_no, b.type, a.customer_email, a.adults_num, a.children_num, a.check_in, a.check_out, b.price, a.clear_bill from bookings a, rooms b where a.room_no=b.id ORDER BY a.id";
	}
	
	# code...
	
}else {
	$email =$_SESSION['email'];
	
	if (isset($_POST['submit']))
	{
		$ReadSql = "Select a.id, b.image, a.room_no, b.type, a.customer_email, a.adults_num, a.children_num, a.check_in, a.check_out, b.price, a.clear_bill from bookings a, rooms b where a.room_no=b.id AND a.customer_email='".$_SESSION["email"]."' AND a.id=".$_POST["id"];
	}
	else
	{	
		$ReadSql = "Select a.id, b.image, a.room_no, b.type, a.customer_email, a.adults_num, a.children_num, a.check_in, a.check_out, b.price, a.clear_bill from bookings a, rooms b where a.room_no=b.id AND a.customer_email='".$_SESSION["email"]."' ORDER BY a.id";
	}
} 
$res = mysqli_query($connection, $ReadSql);
$r = mysqli_fetch_assoc($res);

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Payment Gateway</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Stylesheet file -->
<link rel="stylesheet" href="/hotel/css/style2.css">
	
<!-- Stripe JS library -->
<script src="https://js.stripe.com/v3/"></script>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</head>
<body>
<div class="container">
	<div class="mt-4" style="margin-left: auto; margin-right: auto;">
		<h1>Payment Gateway</h1>
		<div class="panel  col-lg-4 col-md-6">
			<div class="panel-heading">
				<h3 class="panel-title">Order Summary</h3>
							
				<!-- Product Info -->
				<p1><b>Booking No:</b>  <?php echo $r["id"]; ?></p1><br />
				<p1><b>Room Type:</b>  <?php echo $r['type']; ?></p1><br>
				<p1><b>Price:</b>  $<?php echo $r['price']; ?></p1>
			</div>
			<div class="panel-body">
			
				<!-- Display errors returned by createToken -->
				<div id="paymentResponse"></div>
			
				<!-- Payment form -->
				<form action ="payment.php" method="POST" id="paymentFrm">
					<div class="form-group">
						<label>NAME</label>
						<input type="text" name="name" id="name" class="field" placeholder="Enter name" required="" autofocus="">
					</div>
					<div class="form-group">
						<label>EMAIL</label>
						<input type="email" name="email" id="email" class="field" placeholder="Enter email" required="">
					</div>
					<div class="form-group">
						<label>CARD NUMBER</label>
						<input type="text" name="card_number" id="card_number" class="field" placeholder="1234 1234 1234 1234" maxlength="16" size="16"  required="">
					</div>
					<div class="row">
						<div class="left">
							<div class="form-group">
								<label>EXPIRY DATE</label>
								<input type="text" name="date" id="expired_date" class="field" placeholder="MM/YY" pattern="[0-9]{2}/[0-9]{2}" required="">
							</div>
						</div>
						<div class="right">
							<div class="form-group">
								<label>CVC CODE</label>
								<input type="text" name="cvc" id="cvc_code"  class="field" placeholder="CVC" maxlength="3" required="">
							</div>
						</div>
					</div>
					<span><sub>The receipt will send to <b style="color: blue"><?php echo $r["customer_email"]; ?></b> when payment success.</sub></span>
				</div><!-- Change here to design the button -->
					<input type="hidden" name="id" value=" <?php echo $r["id"]; ?>">
					<button type="submit" class="btn btn-success" id="payBtn">Submit Payment</button>
				</form>
			<!-- Normally "</div>" should close here -->
		</div>
	</div>
</div>
</body>
</html>
