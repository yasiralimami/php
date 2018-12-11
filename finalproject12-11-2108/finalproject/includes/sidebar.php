<!-- take 4 col from the index page -->
				<aside class="col-lg-4">
				<!-- make the search with form to call search.php -->
					<form class="panel-group form-horizontal" action="search.php" role="form">
						<div class="panel panel-default">
							<div class="panel-body">
								<div class="panel-header">
									<h4>Search Something</h4>
								</div>
								<!-- class input-group make the icon and the input in same line-->
								<div class="input-group">
									<input type="search" name="search" class="form-control" placeholder="Search Something....">
									<div class="input-group-btn">
										<button class="btn btn-default" name="search_submit" type="submit"><i class="glyphicon glyphicon-search"></i></button>
									</div>
								</div>
							</div>
						</div>
					</form>
					
					<!-- Add login form to the index page -->
					<form class="panel-group form-horizontal" role="form" action="accounts/login.php" method="post">
						<div class="panel panel-default">
							<div class="panel-heading">Login Area</div>
							<div class="panel-body">
								<div class="form-group">
									<label for="username" class="control-label col-sm-4">User Name</label>
									<div class="col-sm-7">
										<input type="text" id="username" placeholder="Insert Email Address" name="user_name" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="control-label col-sm-4">Password</label>
									<div class="col-sm-7">
										<input type="password" id="password" class="form-control" name="password" placeholder="Insert Your Password">
									</div>
								</div>
								<div class="form-group">
									
									<div class="col-sm-12">
										<input type="submit" class="btn btn-success btn-block" name="submit_login">
									</div>
								</div>
							</div>
						</div>
					</form>
					
					
					
					<!-- Add the the published posts in the side Bar-->
					<div class="list-group">
						<?php
						$stmt = $conn->prepare("SELECT * FROM posts WHERE status = 'published' ORDER BY id DESC LIMIT 6");
						$stmt->execute();
						 							
							 while($rows = $stmt->fetch(PDO::FETCH_ASSOC)){
								if(isset($_GET['post_id'])){
								/* if the selected item choosed the class will be active */	
									if($_GET['post_id'] == $rows['id']){
										$class='active';
									}else {
										$class='';
									}
								}else {
									$class='';	
								}
								echo '
								<a href="post.php?post_id='.$rows['id'].'" class="list-group-item '.$class.'">
									<div class="col-sm-4">
									<!-- Add image path to the link from database -->
										<img src="'.$rows['image'].'" width="100%">
									</div>
									<div class="col-sm-8">
										<h4 class="list-group-item-heading">'.$rows['title'].'</h4>
										<!-- Add .substr() to show 50 char. only -->
										<p class="list-group-item-text">'.substr($rows['description'],0,50).'</p>
									</div>
									<div style="clear:both;"></div>
									
								</a>
								';
							}
						?>
					</div>
				</aside>