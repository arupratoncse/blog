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
		if(empty($_POST['old'])){
			throw new Exception("Old password can not be empty.");
		}
		if(empty($_POST['new'])){
			throw new Exception("New password can not be empty.");
		}
		if(empty($_POST['confirm'])){
			throw new Exception("Confirm password can not be empty.");
		}
		
		$password = $_POST['old'];
		$password = md5($password);
		
		$num = 0;
		$statement = $db->prepare("SELECT * FROM tbl_login WHERE password=?");
		$statement->execute(array($password));
		$num = $statement->rowCount();
		
		if($num == 0){
			throw new Exception('Old password does not match');
		}
		if($_POST['new'] != $_POST['confirm']){
			throw new Exception('New password Confirm password does not match');
		}
		$new_password = $_POST['confirm'];
		$new_password = MD5($new_password);
		$statement = $db->prepare("UPDATE tbl_login SET password=? WHERE id=1");
		$statement->execute(array($new_password));
		
		
		$success_message = "Password change successfully in database";
		
	}
	catch(Exception $e){
		 $error_message = $e->getMessage();
	}
}

?>

<?php include('header.php')?>
	<h2>Change Password</h2>
	<?php
		if(isset($error_message)){echo "<div style='color: red;'>".$error_message."</div>";}
		if(isset($success_message)){echo "<div style='color: green;'>".$success_message."</div>";}
	?>
	<form action="" method="post">
	<table class="tbl1">
		<tr>
			<td>Old password</td>
		</tr>
		<tr>
		<td><input class="short" type="password" name="old"></td>
		</tr>
		<tr>
			<td>New Password</td>
		</tr>
		<tr>
			<td><input class="short" type="password" name="new"></td>
		</tr>
		<tr>
			<td>Confirm Password</td>
		</tr>
		<tr>
			<td><input class="short" type="password" name="confirm"></td>
		</tr>
		<tr>
			<td><input  type="submit" value="Change" name="form1"></td>
		</tr>
	</table>
	</form>
<?php include('footer.php')?>
