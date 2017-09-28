<?php
ob_start();
session_start();
if($_SESSION['name']!='raton')
{
	header('location: login.php');
}
include('../config.php');
?>
<?php
if(isset($_POST['form1'])){
	try{
		if(empty($_POST['footer_text'])){
			throw new Exception("Footer text can not be empty.");
		}
		$statement = $db->prepare("UPDATE tbl_footer SET description=? WHERE id=1");
		$statement->execute(array($_POST['footer_text']));
		
		$success_message = "Footer Text update Successfully.";
	}
	catch(Exception $e){
		 $error_message = $e->getMessage();
	}
}

?>

<?php

	$statement = $db->prepare("SELECT * FROM tbl_footer WHERE id=1");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row){
		$description = $row['description'];
	}


?>


<?php include('header.php')?>
	<h2>Change Footer Text</h2>
	<?php
		if(isset($error_message)){echo "<div style='color: red;'>".$error_message."</div>";}
		if(isset($success_message)){echo "<div style='color: green;'>".$success_message."</div>";}
	?>
	<form action="" method="post">
	<table class="tbl1">
		<tr>
			<td>Footer text</td>
		</tr>
		<tr>
		<td><input class="medium" type="text" name="footer_text" value="<?php echo $description; ?>"></td>
		</tr>
		<tr>
			<td><input  type="submit" value="SAVE" name="form1"></td>
		</tr>
	</table>
	</form>
<?php include('footer.php')?>
