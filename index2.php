<?php
	if(!isset($_REQUEST['id'])){
		header("location: index.php");
	}
	else
	{
		$id = $_REQUEST['id'];
	}
?>
<?php
if(isset($_POST['c_email'])){
	try{
		if(empty($_POST['c_message'])){
			throw new Exception("Message can not be empty.");
		}
		if(empty($_POST['c_name'])){
			throw new Exception("Name can not be empty.");
		}
		if(empty($_POST['c_email'])){
			throw new Exception("Email name can not be empty.");
		}
		if(!(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $_POST['c_email'])))
		{
			throw new Exception("Please enter a valid email.");
		}
		$c_date = date('Y-m-d');
		$active = 0;
		include('config.php');
		$statement = $db->prepare("INSERT INTO tbl_comment (c_name,c_email,c_url,c_message,c_date,post_id,active) VALUES(?,?,?,?,?,?,?)");
		$statement->execute(array($_POST['c_name'],$_POST['c_email'],$_POST['c_url'],$_POST['c_message'],$c_date,$id,$active));
		
		
		$success_message = "Your comment has been sent. It will be published on the website after admin's approval.";
	}
	catch(Exception $e){
		 $error_message = $e->getMessage();
	}
}
?>





<?php include('header.php');?>
<?php
include('config.php');
$statement = $db->prepare("select * from tbl_post WHERE post_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row){
	?>
	
	<div class="post">
	<h2><?php echo $row['post_title']; ?></h2>
	<div><span class="date">
	<?php 
		$post_date = $row['post_date'];
		$day = substr($post_date,8,2); 
		$month = substr($post_date,5,2); 
		$year = substr($post_date,0,4);
		if($month=='01'){$month="Jan";}
		if($month=='02'){$month="Feb";}
		if($month=='03'){$month="Mar";}
		if($month=='04'){$month="Apr";}
		if($month=='05'){$month="May";}
		if($month=='06'){$month="Jun";}
		if($month=='07'){$month="Jul";}
		if($month=='08'){$month="Aug";}
		if($month=='09'){$month="Sep";}
		if($month=='10'){$month="Oct";}
		if($month=='11'){$month="Nov";}
		if($month=='12'){$month="Dec";}
		echo $day.' '.$month.', '.$year;
	?>
	</span>
	<span class="categories">
		Tags: &nbsp;
		<?php
		$arr = explode(",",$row['tag_id']);
		$count_array = count(explode(",",$row['tag_id']));
		for($j=0;$j<$count_array;$j++){
			$statement1 = $db->prepare("SELECT * FROM tbl_tag WHERE tag_id=?");
			$statement1->execute(array($arr[$j]));
			$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
			foreach($result1 as $row1){
				echo $row1['tag_name'];
				if($j<$count_array-1)
					echo ", ";
				}					
		}
		?>
	</span></div>
	<div class="description">
	
		<p>
		
		<a class="example5" href="uploads/<?php echo $row['post_image'];?>"><img src="uploads/<?php echo $row['post_image'];?>" alt="" width="220" /></a>
		
		<?php echo $row['post_description'];?> </p>
		</div>
</div>
	
	
	<?php
}
?>





<div id="comments">
	<img src="images/title3.gif" alt="" width="216" height="39" /><br />
	
	<?php
		$statement = $db->prepare("select * from tbl_comment WHERE active=1 AND post_id=?");
		$statement->execute(array($id));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row)
		{
			?>
				<div class="comment">
					<div class="avatar">
					<?php
						$gravatarMd5 = md5($row['c_email']);
					?>
						<img src="http://www.gravatar.com/avatar<?php echo $gravatarMd5; ?>" alt="" width="80" height="80"><br>
						<!--<img src="images/avatar1.jpg" alt="" width="80" height="80" /><br />-->
						
						
						
						<span>
						<?php 
							if(empty($row['c_url']))
							{
								echo $row['c_name'];
							}
							else
							{
								echo "<a href='".$row['c_url']."'>";
								echo $row['c_name'];
								echo "</a>";
							}
							
						?>
						</span><br />
						<?php
							$year = substr($row['c_date'],0,4);
							$month = substr($row['c_date'],5,2);
							$day = substr($row['c_date'],8,2);
							if($month=='01'){$month="January";}
							if($month=='02'){$month="February";}
							if($month=='03'){$month="March";}
							if($month=='04'){$month="April";}
							if($month=='05'){$month="May";}
							if($month=='06'){$month="June";}
							if($month=='07'){$month="July";}
							if($month=='08'){$month="Aught";}
							if($month=='09'){$month="September";}
							if($month=='10'){$month="October";}
							if($month=='11'){$month="November";}
							if($month=='12'){$month="December";}
							echo $day.' '.$month.', '.$year;
						?>
					</div>
					<p><?php echo $row['c_message'];?></p>
				</div>
			<?php
		}
	
	?>
	
	
	<div id="add">
		<img src="images/title4.gif" alt="" width="216" height="47" class="title" /><br />
		<?php
			if(isset($error_message)){echo "<div style='color: red;font-weight:bold;'>".$error_message."</div>";}
			if(isset($success_message)){echo "<div style='color: green;font-weight:bold;'>".$success_message."</div>";}
		?>
		<div class="avatar">
			<img src="images/avatar2.gif" alt="" width="80" height="80" /><br />
			<span>Name User</span><br />
			<?php
				
				$date_current = date("Y-m-d");
				$year = substr($date_current,0,4);
				$month = substr($date_current,5,2);
				$day = substr($date_current,8,2);
				if($month=='01'){$month="January";}
				if($month=='02'){$month="February";}
				if($month=='03'){$month="March";}
				if($month=='04'){$month="April";}
				if($month=='05'){$month="May";}
				if($month=='06'){$month="June";}
				if($month=='07'){$month="July";}
				if($month=='08'){$month="Aught";}
				if($month=='09'){$month="September";}
				if($month=='10'){$month="October";}
				if($month=='11'){$month="November";}
				if($month=='12'){$month="December";}
				echo $day.' '.$month.', '.$year;
			?>
		</div>
		<div class="form">
			<form action="index2.php?id=<?php echo $id; ?>" method="post">
				<textarea placeholder="Your Message..." name="c_message"></textarea><br />
				<input type="text" name="c_name" placeholder="Name" /><br />
				<input type="text" name="c_email" placeholder="E-mail" /><br />
				<input type="text" name="c_url" placeholder="URL (Optional)" /><br />
				<input type="image" src="images/button.gif" alt="" >
			</form>
		</div>
	</div>
</div>
<?php include('footer.php');?>																															
			