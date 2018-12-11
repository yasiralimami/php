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
					$stmt = $conn->prepare("SELECT * FROM posts WHERE category = '$_GET[cat_id]'");
						$stmt->execute();
						 						
						while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
							echo '
							<div class="panel panel-success">
								<div class="panel-heading">
									<h3><a href="post.php?post_id='.$rows['id'].'">'.$rows['title'].'</a></h3>
								</div>
								<div class="panel-body">
									<div class="col-lg-4">
										<img src="'.$rows['image'].'" width="100%">
									</div>
									<div class="col-lg-8">
										<p>'.substr($rows['description'],0,300).'........</p>
									</div>
									<a href="post.php?post_id='.$rows['id'].'" class="btn btn-primary">Read More</a>
								</div>
							</div>
							';
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