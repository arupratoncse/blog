<?php
ob_start();
session_start();
if($_SESSION['name']!='raton')
{
	header('location: login.php');
}
?>

<?php
include('../config.php');
if(isset($_POST['form1'])) 
{
	
	try {
	
		
		if(empty($_POST['cat_name'])) {
			throw new Exception('Category Name can not be empty');
		}
		
		$total = 0;
		$statement = $db->prepare("select * from tbl_category where cat_name=?");
		$statement->execute(array($_POST['cat_name']));
		$total = $statement->rowCount();
		if($total>0){
			throw new Exception('Category Name already exist');
		}
		$statement = $db->prepare("insert into tbl_category (cat_name) values(?)");
		$statement->execute(array($_POST['cat_name']));
		$success_message = "Category name has been insert successfully.";
	
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
	
}

if(isset($_POST['form2'])){
	try {
	
		
		if(empty($_POST['cat_name'])) {
			throw new Exception('Category Name can not be empty');
		}
		$statement = $db->prepare("UPDATE tbl_category SET cat_name =? WHERE cat_id=?");
		$statement->execute(array($_POST['cat_name'],$_POST['hdn']));
		$success_message1 = "Category name has been update successfully.";
	}
	catch(Exception $e) {
		$error_message1 = $e->getMessage();
	}
	
}
if(isset($_REQUEST['id'])){
	$id = $_REQUEST['id'];
	$statement = $db->prepare("delete from tbl_category where cat_id=?");
	$statement->execute(array($id));
}
?>

<?php 

include('header.php')
?>
	<h2>Add New Category</h2>
	<div style="color:red; font-weight: bold;">
<?php
if(isset($error_message))
{
	echo $error_message;
}
?>
</div>
	<div style="color:green; font-weight: bold;">
<?php
if(isset($success_message))
{
	echo $success_message;
}
?>
</div>
	<form action="" method="post">
	<table class="tbl1">
		<tr>
			<td>Category Name</td>
		</tr>
		<tr>
		<td><input class="sort" type="text" name="cat_name"></td>
		</tr>
		<tr>
			<td><input  type="submit" value="SAVE" name="form1"></td>
		</tr>
	</table>
	</form>
	<h2>View All Categories</h2>
	<?php
if(isset($error_message1))
{
	echo $error_message1;
}
?>
</div>
<div style="color:green; font-weight: bold;">
<?php
if(isset($success_message1))
{
	echo $success_message1;
}
?>
</div>
	<table class="tbl2">
		<tr>
			<th width="5%">Serial</th>
			<th width="75%">Category Name</th>
			<th width="20%">Action</th>
		</tr>
		<?php
		$statement = $db->prepare("select * from tbl_category");
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		$i = 0;
		foreach($result as $row)
		{
			$i++;
			?>
			<tr>
			<td><?php echo $i;?></td>
			<td><?php echo $row['cat_name'];?></td>
			<td><a class="fancybox" href="#inline1<?php echo $i;?>"> Edit</a>
			<div style="display: none;">
				<div id="inline1<?php echo $i;?>" style="width:400px;">
				<h3>Edit Data</h3>
				<p>
					<form action="" method="post">
					<input type="hidden" name="hdn" value="<?php echo $row['cat_id'];?>">
					<table>
						<tr>
							<td>Category Name</td>
						</tr>
						<tr>
							<td><input type="text" name="cat_name" value="<?php echo $row['cat_name'];?>"></td>
						</tr>
						<tr>
							<td><input type="submit" value="Update" name="form2"></td>
						</tr>
					</table>
					</form>
				</p>
				</div>
			</div>
			&nbsp;|&nbsp;
			<a onclick='return confirmDelete();' href="manage-catagory.php? id=<?php echo $row['cat_id'];?>">Delete</a>
			</td>
		</tr>
		<?php
			
		}
		
		?>
		
	</table>
<?php include('footer.php')?>
