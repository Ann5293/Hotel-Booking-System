<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/hotel/";

require_once($path . 'connect.php');

session_start();

if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) {
	echo "Unauthorized Access";
	return;
}
?>
<?php require($path . 'templates/header.php') ?>



<h2><?php
echo '<div class="d-flex mt-4 mx-4">';
echo 'Deleting customer particulars image...';
echo '&nbsp; <a href="customer-details.php"><button type="button" class="btn btn-info">Customer Details</button></a><br />';
echo '</div>';



$imagePath = $_POST['path'];

if(file_exists($imagePath)){
    $deleteimg = $imagePath;


    echo '<div class="d-flex mt-4 mx-4">';
    if (!unlink($deleteimg))
    {
        echo "You Have An Error!<br />";
        echo 'Image not complete delete successfully!<br />';
    }
    else 
    {
        clearstatcache();
        echo "Delete Succesful!<br />";
        $ReadSql = "UPDATE users SET image = '' WHERE id =" .$_POST['id'];
		echo 'Image complete delete successfully!<br />';		
		$res = mysqli_query($connection, $ReadSql);
		
		echo '</div>';
    }
    
}

?></h2><br />


</div>
<?php require($path . 'templates/footer.php') ?>