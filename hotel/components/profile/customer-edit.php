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
$SelSql = "SELECT * FROM `users` WHERE email='$email' ORDER BY id";
?>

<?php require($path . 'templates/header.php') ?>

<h2><?php
echo '<div class="d-flex mt-4 mx-4">';
echo 'Editing customer particulars...';
echo '&nbsp;<a href="customer-details.php"><button type="button" class="btn btn-info">Customer Details</button></a><br />';
echo '</div>';

echo '<div class="d-flex mt-4 mx-4">';
if(isset($_FILES['userfile']))
{
	
	if($_FILES['userfile']['error']>0 && $_FILES['userfile']['error']!=4)
	{
		echo 'Error:'.$_FILES['username']['error'];
	}
	else if ($_FILES['userfile']['error']==4)
	{
		echo 'Please browse to upload an image file<br />';
	}
	else if($_FILES['userfile']['error']==0)
	{
		if(!(($_FILES['userfile']['type'] == 'image/jpeg') && ($_FILES['userfile']['size'] < 70000000000000)))
		{
			echo'Invalid file type or size!<br />';
		}
		else
		{
			if(!file_exists('cusimages'))
			{
				mkdir('cusimages');
			}
			if (file_exists('cusimages/' .$_FILES['userfile']['name']))
			{
				echo $_FILES['userfile']['name'] . 'already exists.';
				echo 'Image not complete insert successfully!<br />';
			}
			else
			{
				$destination='cusimages/'.$_POST['id'].'.jpg';
				move_uploaded_file($_FILES['userfile']['tmp_name'], $destination);
				echo 'Image added successfully!<br />';
				$ReadSql = "UPDATE users SET image = '".$_POST['id'].".jpg' WHERE id =" .$_POST['id'];
				echo 'Image complete insert successfully!<br />';
				$res = mysqli_query($connection, $ReadSql);
				
				
			}

		}
		echo '</div>';
	}

}
?></h2><br />
<?php require($path . 'templates/footer.php') ?>