<?php include 'includes/connectPDO.php';?>
<!DOCTYPE html>
<html>
	<head>
		<title>CMS System</title>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="../finalproject/js/jquery.js"></script> 
		<script src="../finalproject/bootstrap/js/bootstrap.js"></script>
		
	</head>
	<body>
		<?php include 'includes/header.php';?>
		<div class="container">
			<article class="row">
				<section class="col-lg-8">
					<?php
					if(isset($_GET['post_id'])){
						$stmt = $conn->prepare("SELECT * FROM posts WHERE id = '$_GET[post_id]'");
						$stmt->execute();
						while($rows =  $stmt->fetch(PDO::FETCH_ASSOC)
	                       ){
							echo '
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="panel-header">
											<h2>'.$rows['title'].'</h2>
										</div>
										<img src="'.$rows['image'].'" width="100%">
										<p>'.$rows['description'].'</p>
									</div>
								</div>
							';
						}
					} else {
						echo '<div class="alert alert-danger">No Post You&apos;ve selected to Show!<a href="index.php">Click Here</a> to Select a Post</div>';
					}
						
					?>
					
				</section>
				<?php include 'includes/sidebar.php';?>
			</article>
		</div>
		<div style="width:50px;height:50px;"></div>
		<?php include 'includes/footer.php';?>
	</body>
</html>