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
	$error = '';
	if(isset($_POST['submit_post'])){
		$title = strip_tags($_POST['title']);
		$date = date('Y-m-d h:i:s');
		// upload files please review https://www.tutorialspoint.com/php/php_file_uploading.htm 
		if($_FILES['image']['name'] != ''){
			// exact image name 
			$image_name = $_FILES['image']['name'];
			//assign temp image name
			$image_tmp = $_FILES['image']['tmp_name'];
			//  image size
			$image_size = $_FILES['image']['size'];
			//get image extention
			$image_ext = pathinfo($image_name,PATHINFO_EXTENSION);
			//get image path we assign the Dir images
			$image_path = '../images/'.$image_name;
			//Assign image path
			$image_db_path = 'images/'.$image_name;
			//check the file size(5MB) and type   
			if($image_size < 5000000){
				if($image_ext == 'jpg' || $image_ext == 'png' || $image_ext == 'gif'){
					
           //The move_uploaded_file() function moves an uploaded file to a new location.
            //This function returns TRUE on success, or FALSE on failure.					
					if(move_uploaded_file($image_tmp,$image_path)){
						
						$sql ="INSERT INTO posts (title, description, image, category, status, date, author ) VALUES (:Title,:Description,:Image,:Category,:Status,:Date,:Author )"; //sql language  sql Insert INTO table (fields)VALUes (...);

		
					try{
					$stmt = $conn->prepare($sql); //prepare the sql statment

					$stmt-> bindparam(':Title', $title);//bind
					$stmt-> bindparam(':Description', $_POST['description']);//bind
					$stmt-> bindparam(':Image', $image_db_path);//bind
					$stmt-> bindparam(':Category', $_POST['category']);
					$stmt-> bindparam(':Status', $_POST['status']);	
					$stmt-> bindparam(':Date', $date);
					$stmt-> bindparam(':Author', $_SESSION['user']);

					$stmt->execute(); // process the SQL againt the database
                     header('Location: post_list.php');

						$general_Msg ="You Have Successfully add a new post";
					}

					catch(PDOException $e)
						{
						$error = '<div class="alert alert-danger">The Query Was not Working!</div>';
						//die();

						}
					
	              
					}
					else{
						$error = '<div class="alert alert-danger">Sorry, Unfortunately Image hos not been uploaded!</div>';
					}
					
				} 
				else {
					$error = '<div class="alert alert-danger">Image Format was not Correct!</div>';
				}
				
			} 
			else {
				$error = '<div class="alert alert-danger">Image File Size is much bigger then Expect!</div>';
			}
		}
		else {
			
			//for post without image
			$sql ="INSERT INTO posts (title, description, category, status, date, author ) VALUES (:Title,:Description,:Category,:Status,:Date,:Author )"; //sql language  sql Insert INTO table (fields)VALUes (...);

		
					try{
					$stmt = $conn->prepare($sql); //prepare the sql statment

					$stmt-> bindparam(':Title', $title);//bind
					$stmt-> bindparam(':Description', $_POST['description']);//bind
					$stmt-> bindparam(':Category', $_POST['category']);
					$stmt-> bindparam(':Status', $_POST['status']);	
					$stmt-> bindparam(':Date', $date);
					$stmt-> bindparam(':Author', $_SESSION['user']);

					$stmt->execute(); // process the SQL againt the database
                    header('Location: post_list.php');

						$general_Msg ="You Have Successfully add a new post";
					}

					catch(PDOException $e)
						{
						$error = '<div class="alert alert-danger">The Query Was not Working!</div>';
						//die();

						}
			
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
		
		<?php echo $error; include 'includes/sidebar.php';?>
		<div class="col-lg-10">
			<div class="page-header"><h1>New Post</h1></div>
			<div class="container-fluid">
				<form class="form-horizontal" action="new_post.php" method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label for="image">Upload an Image</label>
						<input id="image" type="file" name="image" class="btn btn-primary">
					</div>
					<div class="form-group">
						<label for="title">Title</label>
						<input id="title" type="text" name="title" class="form-control" required>
					</div>
					<div class="form-group">
						<label for="category">Category</label>
						<select id="category" name="category" class="form-control" required>
							<option value="">Select Any Category</option>
							<?php
							$stmt = $conn->prepare("SELECT * FROM category");
						     $stmt->execute();
						      while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)){								
								
									if($rows['category_name'] == 'home'){
										continue;
									}
					echo '<option value="'.$rows['c_id'].'">'.ucfirst($rows['category_name']).'</option>';
								}
							?>
						</select>
					</div>
					<div class="form-group">
						<label for="description">Description</label>
						<textarea id="description" name="description"></textarea>
					</div>
					<div class="form-group">
						<label for="status">Status</label>
						<select id="status" name="status" class="form-control">
							<option value="draft">Draft</option>
							<option value="published">Publish</option>
						</select>
					</div>
					<div class="form-group">
						<input type="submit" name="submit_post" class="btn btn-danger btn-block">
					</div>
				</form>
			</div>
			
		</div>

		<footer></footer>
	</body>
</html>