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

?>
<?php require($path . 'templates/header.php') ?>

	<div class="container-fluid my-4">
		<div class="row my-2">
			<h2>Diamond Hotel - Bookings</h2>	
		</div>
		
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" style="padding-bottom:20px">
		Enter booking id:
		<input type="text" name="id" value="<?php if (isset($_POST['id'])) echo $_POST['id'];?>" >
		<input type="submit" name="submit" value="Search">
		</form>

		<?php 
		if ($res !== false && $res->num_rows > 0)
		{
		?>	
			
			<table class="table table-responsive"> 
			<thead> 
				<tr> 
					<th style="width:6%">Booking No.</th>
					<th style="width:6%">Room No.</th> 
					<th style="width:12%">Room Image</th>
					<th style="width:7%">Room Type</th>
					<th style="width:9%">Customer Email</th> 
					<th style="width:8%">No. of guests</th> 
					<th style="width:9%">Check-In Date</th> 
					<th style="width:9%">Check-Out Date</th>
					<th style="width:6%">Price</th>
					<th style="width:6%">Status</th>					
					<th style="width:8%">Action</th>
				</tr> 
			</thead> 
			<tbody> 
		<?php 
			while($r = mysqli_fetch_assoc($res))
			{
		?>
				<tr> 
					<th scope="row"><?php echo $r["id"]; ?></th>
					<td><?php echo $r["room_no"]; ?></td>
					<td><img src="/hotel/img/rooms/<?php echo $r['image']; ?>" style="width:200px;height:150px;"></td>	
					<td><?php echo $r['type']; ?></td> 
					<td style="word-break: break-all"><?php echo $r["customer_email"]; ?></td> 
					<td><?php echo ($r["adults_num"] + $r["children_num"]); ?></td>
					<td><?php echo $r["check_in"]; ?></td> 
					<td><?php echo $r["check_out"]; ?></td>
					<td>$<?php echo $r["price"]; ?></td>
					<td><span id="clear_bill"><?php echo ($r["clear_bill"] == 1) ? "Paid" : "Unpaid" ; ?></span></td>
					<td>
						<a href="update.php?id=<?php echo $r["id"]; ?>"><button type="button" class="btn btn-info" style="width:100px">Edit</button></a><br>
						
						<a href="?action=delete&id=<?php echo $r["id"]; ?>" onclick="return confirm('Are you sure to delete?')"><button style="margin-top:3px; margin-bottom:3px; width:100px;" type="button" class="btn btn-danger btn-xs">Delete</button></a><br>

						<?php						
						$paymentStatus = $r["clear_bill"];
						
						if ($paymentStatus == 0) { ?>
							<a href="../payment/checkout.php?id=<?php echo $r["id"]; ?>"><button type="button" class="btn btn-success" style="width:100px">Checkout</button></a>
						<?php } ?>

					</td>
				</tr> 
		<?php 
			} 
		?>	
			</tbody> 
			</table>
		<?php 
		}
		else
		{
			echo "No record found";
		}
		?>	
	</div>  


<div id="confirm" class="modal hide fade">
  <div class="modal-body">
    Are you sure?
  </div>
  <div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
  </div>
</div>

<?php require($path . 'templates/footer.php') ?>