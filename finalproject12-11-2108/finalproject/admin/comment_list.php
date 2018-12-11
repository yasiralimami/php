<?php session_start();
	include 'includes/connectPDO.php';
	$checkUser = $_SESSION['user'];
$roleStmt = $conn->prepare("SELECT role FROM users WHERE user_email = '$checkUser' ");
$roleStmt->execute();
$rows = $roleStmt->fetch(PDO::FETCH_ASSOC);
$role = $rows['role'];
					
	if(isset($_SESSION['user']) && isset($_SESSION['password']) == true && $role == "admin"){
		}
else {
		header('Location:../index.php');
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Admin Panel</title>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="../js/jquery.js"></script> 
		<script src="../bootstrap/js/bootstrap.js"></script>
	</head>
	<body>
		<?php include 'includes/header.php';?>
		<div style="width:50px;height:50px;"></div>
		<?php include 'includes/sidebar.php';?>
		<div class="col-lg-10">
		<div style="width:50px;height:50px;"></div>
			<!----------- Latest Comments Area -->
			<div class="panel panel-primary">
				<div class="panel-heading"><h3>Latest Comments</h3></div>
				<div class="panel-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Date</th>
								<th>Author</th>
								<th>Email</th>
								<th>Post</th>
								<th>Comments</th>
								<th>Status</th>
								<th>Delete</th>
							</tr>
							
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>12-11-2018</td>
								<td>Yasir</td>
								<td>yasir_altaee@yahoo.com</td>
								<td>2</td>
								<td>I like that Post</td>
								<td>Approved</td>
								<td><a href="#" class="btn btn-danger btn-xs">Delete</a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		
		<footer></footer>
	</body>
</html>