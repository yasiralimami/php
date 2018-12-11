<?php session_start();
	include 'includes/connectPDO.php';
		$login_err = '';
	if(isset($_GET['login_error'])){
		if($_GET['login_error'] == 'empty'){
			$login_err = '<div class="alert alert-danger">User name or Password was empty!</div>';
		}elseif($_GET['login_error'] == 'wrong'){
			$login_err = '<div class="alert alert-danger">User name or Password was Wrong!</div>';
		}elseif($_GET['login_error'] == 'query_error'){
			$login_err = '<div class="alert alert-danger">There is somekind of Database Issue!</div>';
		}
	}
	// assign $per_page to 4 for make sure that we have 4 post in the page 
	$per_page = 4;
  // check if we have page number in the link to retrieve the information from database in line 43.
	if(isset($_GET['page'])){
		$page = $_GET['page'];
	} else{
		$page = 1;
	}
// give the starting point for getting the information from database database in line 43.
	$start_from = ($page-1) * $per_page;
?>

<!DOCTYPE html>
<html>
	<head>
		<title>CMS System</title>
		
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="../finalproject/js/jquery.js"></script> 
		<script src="../finalproject/bootstrap/js/bootstrap.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		
	</head>
		
	<body>
	<!-- call the header -->
		<?php include 'includes/header.php';?>
		
		<!-- The main area of the page -->
		<div class="container">
			<?php echo $login_err; ?>
			<article class="row">
				<section class="col-lg-8">
					<?php
// we instruct the query to bring just the published posts,from new to old and limited by pagination setting.
						$stmt = $conn->prepare("SELECT * FROM posts WHERE status = 'published' ORDER BY id DESC LIMIT $start_from,$per_page");
						$stmt->execute();
						 while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
	                       {
							echo '
							<!-- add panel-success to get the green header -->
							<div class="panel panel-success">
								<div class="panel-heading">
								<!-- add link to the heading of the post -->
									<h3><a href="post.php?post_id='.$row['id'].'">'.$row['title'].'</a></h3>
								</div>
								<div class="panel-body">
									<div class="col-lg-4">
									<!-- getting the path of the image  -->
										<img src="'.$row['image'].'" width="100%">
									</div>
									<div class="col-lg-8">
									<!--substr to show just 300 char. -->
										<p>'.substr($row['description'],0,300).'........</p>
									</div>
									<!--Add the post link tp the button and link will take us to the post page and get the information from post_id -->
									<a href="post.php?post_id='.$row['id'].'" class="btn btn-primary">Read More</a>
								</div>
							</div>
							';
						}
					?>
				</section>
				
				<!-- call the sidebar -->
				<?php include 'includes/sidebar.php';?>
				
			</article>
			
			<!-- Add div to center the pagination-->
			<div class="text-center">
				<ul class="pagination">
			<?php
					$stmt1 = $conn->prepare("SELECT count(*) FROM posts WHERE status = 'published'");
                    $stmt1->execute();
                   $total_posts = $stmt1->fetchColumn();
			// the function ceil() is give us highest integer of the divition
				$total_pages = ceil($total_posts/$per_page);
			//loop to setup the links with the numbers of the pages	
				for($i=1;$i<=$total_pages;$i++){
					echo '<li><a href="index.php?page='.$i.'">'.$i.'</a></li>';
				}
				
			?>
			</ul>
	</div>
			
</div>
		
		
		<!-- add area between the main body and the footer -->
		<div style="width:50px;height:50px;"></div>
		
		
		<!-- call the footer -->
		<?php include 'includes/footer.php';?>
	</body>
</html>