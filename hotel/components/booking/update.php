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

$id = $_GET['id'];

$SelSql = "SELECT * FROM `bookings` WHERE id=$id";
$res = mysqli_query($connection, $SelSql);
$r = mysqli_fetch_assoc($res);

if(isset($_POST) & !empty($_POST)){
	$room_no = ($_POST['type']);
	echo $room_no;
	$customer_email = ($_POST['customer_email']);
	$adults = ($_POST['adults']);
	$children = ($_POST['children']);
	$check_in = ($_POST['check_in']);
	$check_out = ($_POST['check_out']);
	
	if((date($check_in) < date($check_out))){
		$UpdateSql = "UPDATE `bookings` SET room_no='$room_no', customer_email='$customer_email', adults_num='$adults', children_num='$children', check_in='$check_in', check_out='$check_out' WHERE id='$id' ";
		$res = mysqli_query($connection, $UpdateSql);
		
		if($res && (date($check_in) < date($check_out))){
			header('location: view.php');
		} else if((date($check_in) > date($check_out))){
			$fmsg = "The <b>check in</b> date cannot be greater than <b>check out</b> date.";
		} else {
			$fmsg = "Failed to Update data.";
		}
	} else {
		$fmsg = "The <b>check in</b> date cannot be greater than <b>check out</b> date.";
	}
} 

?>
<?php require($path . 'templates/header.php') ?>
	<div class="mt-4">
	<?php if(isset($fmsg)){ ?><div class="alert alert-danger" role="alert"> <?php echo $fmsg; ?> </div><?php } ?>
	<h2 class="mx-auto col-lg-4 col-md-6">Edit Booking Information</h2>
	<h5 class="mx-auto col-lg-4 col-md-6">Booking No: <b><?php echo $r['id']; ?></b></h5>
		<form method="post" id="form" name="form" class="mx-auto col-lg-4 col-md-6" style="padding-top:30px; padding-bottom:30px">  			
            <div class="form-group">
                <label>Customer Email</label>
				<input type="text" class="form-control" name="customer_email" value="<?php echo $r['customer_email']; ?>" readonly />
            </div>
			<div class="form-group">
                <label>Room Type <small style="color:green"> [*Remember to select]</small></label>
				<select class="form-control" name="type" required>
					<?php
						echo "<option disabled value='' selected>-- Select Room Type --</option>";
					
						$records = mysqli_query($connection, "SELECT * FROM rooms");  // Use select query here 
						while($data = mysqli_fetch_array($records))
						{
							echo "<option value='". $data['id'] ."'>" .$data['type'] ."</option>";  // displaying data in option menu
						}	
					?>  
				  </select>
            </div>
            <div class="form-group">
                <label>No. of Adults</label>
				<input type="number" class="form-control" name="adults" value="<?php echo $r['adults_num']; ?>" min="1" required />
            </div> 
            <div class="form-group">
                <label>No. of Children</label>
				<input type="number" class="form-control" name="children" value="<?php echo $r['children_num']; ?>" min="0" required />
            </div> 
			<div class="form-group">
				<label>Check In</label>
				<input type="date" id="check_in" name="check_in" class="form-control" value="<?php echo $r['check_in']; ?>" required />
			</div>
			<div class="form-group">
				<label>Check Out</label>
				<input type="date" id="check_out" name="check_out" class="form-control" value="<?php echo $r['check_out']; ?>" required />
			</div>
				
			<input type="submit" class="btn btn-primary" value="Update" />
		</form>
	</div>
	
<?php require($path . 'templates/footer.php') ?>