<?php session_start();
	include 'includes/connectPDO.php';
	//validate user and password and Role 
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
	if(isset($_GET['del_id'])){
		$delStmt = $conn->prepare("DELETE FROM category WHERE c_id = :Cid");
        $delStmt->bindParam(':Cid',$_GET[del_id]);
        $delStmt->execute();
		
		if(!empty($delStmt)){
			$result = '<div class="alert alert-danger">You&apos;ve Deleted a Cateogry no. &apos;'.$_GET['del_id'].'&apos;</div>';
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
		
	</head>
	<body>
		<?php include 'includes/header.php';?>
		<div style="width:50px;height:50px;"></div>
		<?php include 'includes/sidebar.php';?>
		<div class="col-lg-10">
		<div style="width:50px;height:50px;"></div>
			<?php echo $result; ?>
			<div class="col-lg-8">
				<div class="panel panel-primary">
					
					<div class="panel-heading">
						<h4>Categories</h4>
					</div>
					<div class="panel-body">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Category Name</th>
									<th>Edit</th>
									<th>Delete</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								
								$stmt = $conn->prepare("SELECT * FROM category");
						        $stmt->execute();
								$number = 1;
						 while ($rows = $stmt->fetch(PDO::FETCH_ASSOC))
	                          {
							      if($rows['category_name'] == 'home'){
										continue;
									} else {
										$category_name = ucfirst($rows['category_name']);
									}
									echo '
									<tr>
										<td>'.$number.'</td>
										<td>'.$category_name.'</td>
										<td><a href="edit_category.php?cat_id='.$rows['c_id'].'" class="btn btn-warning btn-xs">Edit</a></td>
										<td><a href="category_list.php?del_id='.$rows['c_id'].'" class="btn btn-danger btn-xs">Delete</a></td>
									</tr>
									';
									$number++;
								}
							?>
								
							</tbody>
						</table>
					</div>
					
				</div>
			</div>

		</div>
		
		<footer></footer>
	</body>
</html>