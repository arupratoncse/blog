
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Dashbord - sample Blog with PHP</title>
	<link rel="stylesheet" href="../style_admin.css">
	<script type="text/javascript">
		function confirmDelete(){
			return confirm("Do you sure want to delete this data?");
		}
	</script>
	<!-- Fancybox jQuery -->
	<script type="text/javascript" src="../fancybox/jquery-1.4.3.min.js"></script>
	<script type="text/javascript" src="../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
 	
	<script type="text/javascript">
		$(document).ready(function() {
			$(".fancybox").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
		});
	</script>
	<!-- //Fancybox jQuery -->
	
	<!-- CKEditor Start -->
	<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
	<!-- CKEditor End -->
 	<link rel="stylesheet" href="style.css" />
</head>
<body>
	
	<div id="wrapper">
		 <div id="header">
			<h1>Admin panel Dashoard</h1>
		 </div>
		 <div id="cintainer">
		 	<div id="sidebar">
				<h2>Page Option</h2>
				<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="change-footer-text.php">Change footer text</a></li>
					<li><a href="change-password.php">Change Password</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
				<h2>Blog Option</h2>
				<ul>
					<li><a href="post-add.php">Add post</a></li>
					<li><a href="post-view.php">View Post</a></li>
					<li><a href="manage-catagory.php">Manage Category</a></li>
					<li><a href="manage-tag.php">Manage Tags</a></li>
				</ul>
				<h2>Comment Section</h2>
				<ul>
					<li><a href="comment-approve.php">View All Comment</a></li>
			</div>
		 	<div id="content">