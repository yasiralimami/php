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
	if(isset($_POST['submit_category'])){
		$category = strip_tags($_POST['category']);
		
		$sql ="INSERT INTO category (category_name) VALUES (:CategoryName)"; //sql language  sql Insert INTO table (fields)VALUes (...);

				try{
				$stmt = $conn->prepare($sql); //prepare the sql statment
				$stmt-> bindparam(':CategoryName', $category);//bind
				$stmt->execute(); // process the SQL againt the database
					if (!empty($stmt)){
                $result = '<div class="alert alert-success">You&apos;ve created a new Cateogry named &apos;'.$category.'&apos;</div>';
					}
				}

				catch(PDOException $e)
					{
				   // die();
              $result = '<div class="alert alert-denger">something went wrong</div>';
					}
		
		$sql = "INSERT INTO category (category_name) VALUES ('$category')";
		if(mysqli_query($conn,$sql)){
			$result = '<div class="alert alert-success">You&apos;ve created a new Cateogry named &apos;'.$category.'&apos;</div>';
			
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
			<div class="page-header"><h1>New Category</h1></div>
			<div class="container-fluid">
				<form class="form-horizontal col-lg-5" action="new_category.php" method="post">
					<div class="form-group">
						<label for="category">Title</label>
						<input id="category" type="text" name="category" class="form-control">
					</div>
					<div class="form-group">
						<input type="submit" name="submit_category" class="btn btn-danger btn-block">
					</div>
				</form>
			<div>
			
		</div>

		<footer></footer>
	</body>
</html>