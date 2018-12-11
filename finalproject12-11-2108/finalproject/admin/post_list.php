<?php session_start();
	include 'includes/connectPDO.php';
// check the admin session
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

	$result = '';
	if(isset($_GET['new_status'])){
		
		$new_status =$_GET['new_status'];
		
		$sql ="UPDATE posts SET status=:Status WHERE id =  $_GET[id] ";
		try{
		$stmt = $conn->prepare($sql); //prepare the sql statment
		$stmt-> bindparam(':Status', $new_status);

		$stmt->execute(); // process the SQL againt the database
		  
			if(!empty($delStmt)){
			$result = '<div class="alert alert-success">We Just Updated the Status</div>';
		}

		}

		catch(PDOException $e)
			{
			//echo "problem";
			//die();

			}

	}
	
	if(isset($_GET['del_id'])){
	
		$del_id = $_GET['del_id'];
		$delStmt = $conn->prepare("DELETE FROM posts WHERE id = :ID");
        $delStmt->bindParam(':ID',$del_id);
        $delStmt->execute();
		
		if(!empty($delStmt)){
			$result = '<div class="alert alert-danger">You Deleted Post No. '.$del_id.' from CMS</div>';
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Admin Panel</title>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="../js/jquery.js"></script> 
		<script src="../bootstrap/js/bootstrap.js"></script>
		<script>
			
		</script>
	</head>
	<body>
		<?php include 'includes/header.php';?>
		<div style="width:50px;height:50px;"></div>
		<?php include 'includes/sidebar.php';?>
		<div class="col-lg-10">
		<div style="width:50px;height:50px;"></div>
		<?php 
			echo $result;
		?>
			<!------ Users Area --->
			<!------ Post lists Starts----->
			<div class="panel panel-primary">
				<div class="panel-heading"><h3>Posts</h3></div>
				<div class="panel-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Date</th>
								<th>Image</th>
								<th>Title</th>
								<th>Description</th>
								<th>Category</th>
								<th>Author</th>
								<th>status</th>
								<th>Action</th>
								<th>Edit Post</th>
								<th>View Post</th>
								<th>Delete Post</th>
							</tr>
							
						</thead>
						<tbody>
							<?php
								//$sql = "SELECT * FROM posts ORDER BY ID DESC";
							$stmt = $conn->prepare("SELECT * FROM posts p JOIN users u ON p.author = u.user_email ORDER BY id DESC");
						        $stmt->execute();
								$number = 1;
						 while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
							
									echo '
									<tr>
										<td>'.$number.'</td>
										<td>'.$rows['date'].'</td>
										<!-- put if condition for image -->
										<td>'.($rows['image'] == '' ? 'No Image' : '<img src="../'.$rows['image'].'" width="50px">').'</td>
										<td>'.$rows['title'].'</td>
										<td>'.substr($rows['description'],0,50).'......</td>
										<td>'.$rows['category'].'</td>
										<td>'.$rows['user_f_name'].' '.$rows['user_l_name'].'</td>
										<td>'.$rows['status'].'</td>
										<!-- make toggle by if and then with minipulate with http -->
										<td>'.($rows['status'] == 'draft'? '<a href="post_list.php?new_status=published&id='.$rows['id'].'" class="btn btn-primary btn-xs navbar-btn">Publish</a>': '<a href="post_list.php?new_status=draft&id='.$rows['id'].'" class="btn btn-info btn-xs navbar-btn">Draft</a>').'</td>
										<td><a href="edit_post.php?edit_id='.$rows['id'].'" class="btn btn-warning btn-xs navbar-btn">Edit</a></td>
										<td><a href="../post.php?post_id='.$rows['id'].'" class="btn btn-success btn-xs navbar-btn">View</a></td>
										<td><a href="post_list.php?del_id='.$rows['id'].'" class="btn btn-danger btn-xs navbar-btn">Delete</a></td>
									</tr>
									';
									$number++;
								}
							?>
							
							
						</tbody>
					</table>
				</div>
			</div>
			<div class="text-center">
				<ul class="pagination">
					<li><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
					<li><a href="#">6</a></li>
				</ul>
			</div>
			
		</div>
		<footer></footer>
	</body>
</html>