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
?>
<?php require($path . 'templates/header.php') ?>

<?php
if ($_POST['update']=='update')
    {
        if (empty($error))
        {
            $ReadSql="update users set name= '".$_POST['name']."',
            email='".$_POST['email']."' where id= ".$_POST['id'];
            $res = mysqli_query($connection, $ReadSql);
    
            if($res)
            {
                echo '<script type="text/javascript">alert("Data Updated")</script>';
            }
            else 
            {
                echo '<script type="text/javascript">alert("Data Not Updated")</script>'; 
            }
        }
    }
    echo '<div class="wrapper mx-auto">';
    echo '<h2>Updating customer particulars...</h2><br />';
    echo '<a href="customer-details.php"><button type="button" class="btn btn-info">Customer Details</button></a>';
    echo '</div>';
?>

<?php require($path . 'templates/footer.php') ?>