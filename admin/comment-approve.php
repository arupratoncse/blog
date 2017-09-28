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
if(isset($_REQUEST['id'])){
	try{
		$statement = $db->prepare("UPDATE tbl_comment SET active=1 WHERE c_id=?");
		$statement->execute(array($_REQUEST['id']));
		
		$success_message = "Comment is approved. Thank you.";
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
	<h2>All Un-approved Comments </h2>
	<?php
		if(isset($error_message)){echo "<div style='color: red;font-weight:bold;'>".$error_message."</div>";}
		if(isset($success_message)){echo "<div style='color: green;font-weight: bold;'>".$success_message."</div>";}
	?>
	<table class="tbl2">
		<tr>
			<th width="">Serial</th>
			<th width="">Name</th>
			<th width="">Email</th>
			<th width="">URL</th>
			<th width="">Message</th>
			<th width="">Post ID</th>
			<th width="">Action</th>
		</tr>
		<?php
			$i = 0;
			$statement = $db->prepare("SELECT * FROM tbl_comment WHERE active=0 ORDER BY c_id DESC");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row){
				$i++;
			?>
			<tr>
			<td><?php echo $i;?></td>
			<td><?php echo $row['c_name']; ?></td>
			<td><?php echo $row['c_email']; ?></td>
			<td><?php echo $row['c_url']; ?></td>
			<td><?php echo $row['c_message']; ?></td>
			<td>
			<a class="fancybox" href="#inline<?php echo $i;?>"><?php echo $row['post_id']; ?></a>
			
			<div style="display: none;">
				<div id="inline<?php echo $i;?>" style="width:800px; height:auto; overflow:auto;">
				<h3 style="border-bottom:2px solid #808080;">View Data</h3>
				<p>
					<?php 
						$statement1 = $db->prepare("SELECT * FROM tbl_post WHERE post_id=?");
						$statement1->execute(array($row['post_id']));
						$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
						foreach($result1 as $row1)
						{
							?>
							
						<table>
						<tr>
							<td><b>Title</b></td>
						</tr>
						<tr>
							<td><?php echo $row1['post_title']; ?></td>
						</tr>
						<tr>
							<td><b>Description</b></td>
						</tr>
						<tr>
							<td><?php echo $row1['post_description']; ?></td>
						</tr>
						<tr>
							<td><b>Featured Image</b></td>
						</tr>
						<tr>
							<td><img src="../uploads/<?php echo $row1['post_image']; ?>" alt="Featured Image" width="300"></td>
						</tr>
						<tr>
							<td><b>Category</b></td>
						</tr>
						<tr>
							<td>
							<?php
								$statement2 = $db->prepare("SELECT * FROM tbl_category WHERE cat_id=?");
								$statement2->execute(array($row1['cat_id']));
								$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
								foreach($result2 as $row2){
									echo $row2['cat_name'];
								}
							?>
							</td>
						</tr>
						<tr>
							<td><b>Tags</b></td>
						</tr>
						<tr>
							<td> 
							<?php
								$arr = explode(",",$row1['tag_id']);
								$count_array = count(explode(",",$row1['tag_id']));
								for($j=0;$j<$count_array;$j++){
									$statement2 = $db->prepare("SELECT * FROM tbl_tag WHERE tag_id=?");
									$statement2->execute(array($arr[$j]));
									$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
									foreach($result2 as $row2){
										echo $row2['tag_name'];
										if($j<$count_array-1)
											echo ", ";
									}
								
								}
							?>
							</td>
						</tr>
					</table>
				</p>
				</div>
			</div>	
						<?php
						}
					?>

			</td>
			<td><a href="comment-approve.php?id=<?php echo $row['c_id'];?>">Approve</a></td>
			
			</tr>
			<?php
			}
		
		?>
	</table>
	
	
	
	<h2>All Approved Comments </h2>
	
	
	<table class="tbl2">
		<tr>
			<th width="">Serial</th>
			<th width="">Name</th>
			<th width="">Email</th>
			<th width="">URL</th>
			<th width="">Message</th>
			<th width="">Post ID</th>
		</tr>
		<?php
			$i = 0;
			$statement = $db->prepare("SELECT * FROM tbl_comment WHERE active=1 ORDER BY c_id DESC");
			$statement->execute();
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row){
				$i++;
			?>
			<tr>
			<td><?php echo $i;?></td>
			<td><?php echo $row['c_name']; ?></td>
			<td><?php echo $row['c_email']; ?></td>
			<td><?php echo $row['c_url']; ?></td>
			<td><?php echo $row['c_message']; ?></td>
						<td>
			<a class="fancybox" href="#inline<?php echo $i;?>"><?php echo $row['post_id']; ?></a>
			
			<div style="display: none;">
				<div id="inline<?php echo $i;?>" style="width:800px; height:auto; overflow:auto;">
				<h3 style="border-bottom:2px solid #808080;">View Data</h3>
				<p>
					<?php 
						$statement1 = $db->prepare("SELECT * FROM tbl_post WHERE post_id=?");
						$statement1->execute(array($row['post_id']));
						$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
						foreach($result1 as $row1)
						{
							?>
							
						<table>
						<tr>
							<td><b>Title</b></td>
						</tr>
						<tr>
							<td><?php echo $row1['post_title']; ?></td>
						</tr>
						<tr>
							<td><b>Description</b></td>
						</tr>
						<tr>
							<td><?php echo $row1['post_description']; ?></td>
						</tr>
						<tr>
							<td><b>Featured Image</b></td>
						</tr>
						<tr>
							<td><img src="../uploads/<?php echo $row1['post_image']; ?>" alt="Featured Image" width="300"></td>
						</tr>
						<tr>
							<td><b>Category</b></td>
						</tr>
						<tr>
							<td>
							<?php
								$statement2 = $db->prepare("SELECT * FROM tbl_category WHERE cat_id=?");
								$statement2->execute(array($row1['cat_id']));
								$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
								foreach($result2 as $row2){
									echo $row2['cat_name'];
								}
							?>
							</td>
						</tr>
						<tr>
							<td><b>Tags</b></td>
						</tr>
						<tr>
							<td> 
							<?php
								$arr = explode(",",$row1['tag_id']);
								$count_array = count(explode(",",$row1['tag_id']));
								for($j=0;$j<$count_array;$j++){
									$statement2 = $db->prepare("SELECT * FROM tbl_tag WHERE tag_id=?");
									$statement2->execute(array($arr[$j]));
									$result2 = $statement2->fetchAll(PDO::FETCH_ASSOC);
									foreach($result2 as $row2){
										echo $row2['tag_name'];
										if($j<$count_array-1)
											echo ", ";
									}
								
								}
							?>
							</td>
						</tr>
					</table>
				</p>
				</div>
			</div>		
				<?php
		}
					?>
			</td>
			</tr>
			<?php
			}
		
		?>
	</table>

<?php include('footer.php')?>
