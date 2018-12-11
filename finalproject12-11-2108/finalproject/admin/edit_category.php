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
	$result = '';
	if(isset($_POST['update_category'])){
		$category = strip_tags($_POST['category']);
		
		$sql ="UPDATE category SET category_name = :CategoryName WHERE c_id = $_POST[cat_id]";
		try{
		$stmt = $conn->prepare($sql); //prepare the sql statment
		$stmt-> bindparam(':CategoryName',$category);
		   
		$stmt->execute(); // process the SQL againt the database
        
        header('Location: category_list.php');
		}

		catch(PDOException $e)
			{
			//echo "problem";
			//die();

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
		<script src="//tinymce.cachefly.net/4.2/tinymce.min.js"></script>
		<script>tinymce.init({selector:'textarea'});</script>
	</head>
	<body>
		<?php include 'includes/header.php';?>
		<div style="width:50px;height:50px;"></div>
		<?php  include 'includes/sidebar.php';?>
		<div class="col-lg-10">
			<?php echo $result;?>
			<?php
				if(isset($_GET['cat_id'])){
					$stmt3= $conn->prepare("SELECT * FROM category WHERE c_id = '$_GET[cat_id]'");
						        $stmt3->execute();
								$number = 1;
						 while ($rows = $stmt3->fetch(PDO::FETCH_ASSOC)){
					?>
					<div class="page-header"><h1> Edit Category</h1></div>
					<div class="container-fluid">
						<form class="form-horizontal col-lg-5" action="edit_category.php" method="post">
							<div class="form-group">
								<input type="hidden" name="cat_id" value="<?php echo $_GET['cat_id'];?>">
								<label for="category">Category Name</label>
								<input id="category" type="text" value="<?php echo $rows['category_name']; ?>"name="category" class="form-control">
							</div>
							<div class="form-group">
								<input type="submit" name="update_category" class="btn btn-danger btn-block">
							</div>
						</form>
					</div>
			<?php	}
				} else {
					echo $result = '<div class="alert alert-danger">Please Select a Category</div>';
				
				}
			?>
		</div>
		<footer></footer>
	</body>
</html>