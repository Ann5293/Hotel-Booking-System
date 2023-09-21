<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/hotel/";

require_once($path . 'connect.php');

session_start();

if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
	echo "Unauthorized Access";
	return;
}

$query="UPDATE bookings SET clear_bill =1 where id=".$_POST['id'];
$res = mysqli_query($connection, $query);

if ($res)
{
	echo "<h1>Payment Success！</h1>";
	echo "<p>Return to bookings page in a few seconds.</p>";
	header('Refresh: 2.5; URL = ../booking/view.php');
}
else
{
	echo "<h1>Payment Unsuccessfull！</h1>";
	echo "<p>Return to bookings page in a few seconds.</p>";
	header('Refresh: 2.5; URL = ../booking/view.php');
}

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Payment Status</title>
<meta charset="utf-8">
</body>
</html>