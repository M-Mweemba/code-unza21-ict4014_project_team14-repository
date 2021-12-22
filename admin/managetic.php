<?php
	session_start();
	require '../style/conn.php';
	//Student's Information
	$sql_stud = "SELECT * FROM users WHERE role = 'student'";
	$rows_stud = mysqli_query($dbc, $sql_stud);
	$total_stud = mysqli_num_rows($rows_stud);

	//Staff Information
	$sql_staff = "SELECT * FROM users WHERE role = 'Staff Member'";
	$rows_staff = mysqli_query($dbc, $sql_staff);
	$total_staff = mysqli_num_rows($rows_staff);

	//All users' Information
	$sql_all = "SELECT * FROM users";
	$rows_all = mysqli_query($dbc, $sql_all);
	$total_all = mysqli_num_rows($rows_all);


	//Retrieve and count withdraw applications
	$sql2 = "SELECT * FROM withdraws";
	$result2 = mysqli_query($dbc ,$sql2);
	$count_with_apps = mysqli_num_rows($result2);

	////Retrieve and count readmission applications
	$sql3 = "SELECT * FROM readmission";
	$result3 = mysqli_query($dbc ,$sql3);
	$count_read_apps = mysqli_num_rows($result3);

	mysqli_close($dbc);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initialscale=1.0">
	<title>Manage Records</title>
	<link rel="stylesheet" href="../style/css/all.min.css">
	<link rel="stylesheet" href="../style/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="../style/stylesheet.css">
	<link rel="stylesheet" type="text/css" href="../style/bootstrap/css/bootstrap.css">
	<style type="text/css">
		.cont{
			background-color: whitesmoke;
			font-family: aria;
		}
		.right{
			float: right;
			margin-top: 25px;
			margin-right: 0.5em;
			color: green;
			text-decoration: none;
		}
		.right:hover{
			cursor: pointer;
			color: green;
		}
		.right:active{
			cursor: wait;
			color: red;
			text-decoration: underline;
		}
		input[type=text]:focus{
			outline: 1px solid green;
			border-radius: 4px;
			color: black;
		}
		.topic{
			position: absolute;
			margin-top: 6%;
			width: 90%;
			margin-left: 12%;
			padding: 5px;
			text-align: center;
		}
		.msgs{
			position: absolute;
			margin-top: 9%;
			width: 90%;
			margin-left: 12%;
			margin-right: 5%;
			padding: 5px;
			text-align: center;
		}
		.row{
			position: absolute;
			margin-top: 10%;
			width: 85%;
			margin-left: 24%;
			padding: 5px;
			text-align: center;
		}
		.wrapper{
			margin-top: 2%;
			border: 1px solid #ccc;
		}
		.fas{
			margin-top: 17px;
			margin-left: 76.5%;
			font-size: 20px;
		}
		.btn-sm{
			text-decoration: none;
		}
		.table{
				font-size: 12px;
		}
		#add{
			float: left;
			font-family: aria;
			font-weight: bold;
			background-color: #00a550;
		}
		#rem{
			float: right;
			font-family: aria;
			font-weight: bold;
		}
		.error{
			color:red;
		}
		.msg{
			color: green;
		}
		.search{
			margin-top: 4%;
		}
		.search-field{
			padding: 6px;
			width: 90%;
			margin-left: auto;
			margin-top: 5px;
			font-family: georgia;
			border: 1px solid #00a550;
		}
		.search-btn{
			padding: 18px;
			width: 10%;
			margin-top: 5px;
			background-color: white;
			float: right;
			font-family: georgia;
			border: 1px solid #00a550;
			background-color: #00a550;
		}
		.menu{
			position: fixed;
			margin-top: auto;
			padding-top: 3%;
			width: 20%;
			height: 100%;
			background-color: rgb(0,130,65);
			color:white;
			/*background-color: rgb(110,110,110);*/
		}
		.copyright{
			position: absolute;
			color: white;
			margin-top: 25px;
			text-align: center;
			background-color: #00a550;
			padding: 8px;
		}
		.aside-links{
			color: #ccc;
			text-decoration: none;
			padding-top: 4px;
			padding-bottom: 4px;
			padding-right: 30%;
			font-weight: bold;
		}
		li{
			color: #ccc;
			list-style: none;
			padding-top: 3px;
		}
		.aside-links:hover{
			color: white;
			text-decoration: none;
		}
		.admin{
			color: white;
			font-weight: bold;
			margin-top: 11px;
			margin-left: 10px;
		}
	</style> 
</head>

<body class="cont">
	<header class="top">
		<div class="nav">
			<h5 class="admin">SWRS Admin</h5>
			<a class="links" href="admin_dash.php">Dashboard</a>
				<div class="nav-right">
					<a class="links" href="../login-out/logout.php">Sign Out</a>
				</div>
		</div>
	</header>

	<main>
		<div class="topic">
			<h5><b>SYSTEM USERS</b></h5><br>
		</div>
		<div class="msgs">
			<?php
				if (empty($total_all)) {
					echo '<h5 class="error">No Staff Member Available</h5>';
				}
				if (isset($_GET["error"])) {
					if ($_GET["error"] == "usernametaken") {
						echo '<p class="error">User already exists</p>';
					}
					  if ($_GET["error"] == "erroroccurred") {
					  	echo '<p class="error">User not added, try again later</p>';
					  }
				}
				elseif (isset($_GET["success"])) {
					echo '<p class="msg">New user added</p>';
				}
				if(isset($_GET["rem"])){
					if($_GET["rem"] == "notremoved"){
						echo '<p class="error">Error deleting user!</p>';
					}
					if($_GET["rem"] == "removed"){
							echo '<p class="msg">User removed</p>';
					}
				}
				if(isset($_GET["clear"])){
					if($_GET["clear"] == "notcleared"){
						echo '<p class="error">Error clearing system!</p>';
					}
					if($_GET["clear"] == "cleared"){
						echo '<p class="msg">System cleared</p>';
					}
				}
				if (isset($_GET["edit"])) {
					if ($_GET["edit"] == "namesupdatesuccess") {
						echo '<p class="msg">User fullname updated</p>';
					}
					if ($_GET["edit"] == "compupdatesuccess") {
						echo '<p class="msg">Username updated</p>';
					}
					if ($_GET["edit"] == "mailupdatesuccess") {
						echo '<p class="msg">Email address updated</p>';
					}
					if ($_GET["edit"] == "roleupdatesuccess") {
						echo '<p class="msg">User role/responsibility updated</p>';
					}
				}
			?>
		</div><br>
		
		<aside class="menu">
			<div>
				<ul type="square">
					<li class="navbar-default"><b>SYSTEM USERS:</b>
							<ul>
								<li><?php echo "$total_stud";?> <a class="aside-links" href="manage.stud.php">Student(s)</a></li>
								<li><?php echo "$total_staff";?> <a class="aside-links" href="manage.staff.php">Staff Member(s)</a></li>
								<li><a class="aside-links" href="manage.php">Total (<?php echo "$total_all";?>)</a></li>
							</ul>
					</li><br>
					<li><b>APPLICATIONS:</b>
						<ul>
							<li><a class="aside-links" href="../staff/view_withdrawal.php"><?php echo "$count_with_apps";?> withdraw apps</a></li>
							<li><a class="aside-links" href=""><?php echo "$count_read_apps";?> readmission</a></li>
						</ul>
					</li><br>
					<li><b>PROFILE:</b>
						 <ul>
							<li><a class="aside-links" href="">Update</a></li>
						</ul>
					</li><hr>
					<li><b>LINKS:</b><hr>
						<ul>
							<li><a class="aside-links" href="https://www.unza.moodle.zm">Moodle</a></li>
							<li><a class="aside-links" href="https://www.unza.zm">UNZA Home</a></li>
						</ul>
					</li>
				</ul>

				<div class="copyright">
					&copy Student Withdraw/Readmission System v1.0
				</div>
			</div>
		</aside>

		<div class="row">
			<div class="col-md-10" id="col">
				
				<!--button to add new users-->
				<a href="add.php" id="add" class="btn-sm btn-primary">Add User</a>

				<!--button to add new users-->
				<a href="remove_all.php" id="rem" class="btn-sm btn-danger">Delete All</a>

				<!--Search field-->
				<div class="search">
					<form action="search.php" method="post">
						<div class="holder">
							<i class="fas fa-search"></i>
							<input class="search-field" type="text" name="word" placeholder="Search">
							<button class="search-btn" type="submit" name="search"></button>
						</div>
					</form>
				</div>
			
				<!--user's table-->
				<div class="wrapper">	
					<table class="table">
						<div class="row">
				<div class="col-xl-3 col-md-6">
					<div class="card bg-primary text-white mb-4">
						<div class="card-header">Posts</div>
						<?php 
						$connection = mysqli_connect('localhost','root','','cms');
						$query = "SELECT * FROM posts";
						$queryResult = mysqli_query($connection,$query);
						$num_row_posts = mysqli_num_rows($queryResult);

						?>
						<div class="card-body display-4"><?php echo $num_row_posts ?></div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" href="post.php">View Details</a>
							<div class="small text-white"><i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-warning text-white mb-4">
						<div class="card-header">Comments</div>
						<?php 
						$connection = mysqli_connect('localhost','root','','cms');
						$query = "SELECT * FROM comments";
						$queryResult = mysqli_query($connection,$query);
						$num_row_comments = mysqli_num_rows($queryResult);

						?>
						<div class="card-body display-4"><?php echo $num_row_comments; ?></div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" href="comments.php">View Details</a>
							<div class="small text-white"><i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-success text-white mb-4">
						<div class="card-header">Users</div>
						<?php 
						$connection = mysqli_connect('localhost','root','','cms');
						$query = "SELECT * FROM users";
						$queryResult = mysqli_query($connection,$query);
						$num_row_users = mysqli_num_rows($queryResult);

						?>
						<div class="card-body display-4"><?php echo $num_row_users; ?></div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" href="users.php">View Details</a>
							<div class="small text-white"><i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card bg-danger text-white mb-4">
						<div class="card-header">Category</div>
						<?php 
						$connection = mysqli_connect('localhost','root','','cms');
						$query = "SELECT * FROM categories";
						$queryResult = mysqli_query($connection,$query);
						$num_row_categories = mysqli_num_rows($queryResult);

						?>
						<div class="card-body display-4"><?php echo $num_row_categories; ?></div>
						<div class="card-footer d-flex align-items-center justify-content-between">
							<a class="small text-white stretched-link" href="categories.php">View Details</a>
							<div class="small text-white"><i class="fas fa-angle-right"></i></div>
						</div>
					</div>
				</div>
			</div>
					</table>
				</div>
			</div>
		</div>
	</main>
</body>
</html>