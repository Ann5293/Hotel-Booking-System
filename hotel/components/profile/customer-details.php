
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
	$ReadSql = "SELECT * FROM `users` ORDER BY id";
	# code...
}else {
	$email =$_SESSION['email'];
	$ReadSql = "SELECT * FROM `users` WHERE email='$email' ORDER BY id";
}


$res = mysqli_query($connection, $ReadSql);
$r = mysqli_fetch_assoc($res);

?>
	

<?php	
	$id=$r['id'];
	$name=$r['name'];
	$email=$r['email'];
?>


<?php require($path . 'templates/header.php') ?>

<div class="wrapper mx-auto" style="float:center;">
		
	    <h2>Diamond Hotel - Profile</h2>
<?php		
	
?>
<form action="customer-update.php" method="post">
<table border="1">
<tr style="padding: 100px;">
<td>ID:(Not editable)</td>
<td><input type="text" name="id" value="<?php echo $id;?>" readonly="readonly" /></td>
</tr>
<tr style="padding: 100px;">
<td>Name:</td>
<td><input type="text" name="name" value="<?php echo $name;?>" /></td>
</tr>
<tr style="padding: 100px;">
<td>Email:</td>
<td><input type="text" name="email" size="32" value="<?php echo $email;?>" />
</tr>

<tr>
<td colspan=2>

<button type="submit" class="btn btn-info" name="update" value="update">Update</button>
<input type="button" name="BTC" class="btn btn-info" value="Cancel" 
onclick="document.location='/hotel/index.php'" />

</td>
</tr>
</form>

<tr>
<td> Uploaded Image</td>
<td>
<?php

	$img='cusimages/'.$r['id'].'.jpg';
	if(file_exists($img)){
    	echo '<img src="'.$img.'" width="218" height="300" /><br />';
		echo '
			<form action="customer-delete.php" method="post">
				<input type="hidden" name="do" value="0" >
				<input type="hidden" name="path" value="'.$img.'" >
				<input type="hidden" name="id" value="'.$id.'" >
				<input type="submit" name="delete" value="delete" >
			</form> 
		';

	} else {
		echo '
			<form action="customer-edit.php" method="post" enctype="multipart/form-data">
				Filename:<input type="file" name="userfile" size="70000000000" /><br />
				<i>Acceptable image formats:JPEG; File size below 300KB</i><br />
				<input type="hidden" name="id" value="'.$id.'" >
				<input type="submit" name="submit" value="Edit" />
			</form> 
		';
	}	
?>	
</td>
</tr>

</table>

</div> 

<?php require($path . 'templates/footer.php') ?>