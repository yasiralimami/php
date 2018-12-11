<?php session_start();
	include '../includes/connectPDO.php';
	if(isset($_POST['submit_login'])){
		if(!empty($_POST['user_name']) && !empty($_POST['password'])){
			$get_user_name = $_POST['user_name'];
			$get_password = $_POST['password'];
			$statement = $conn->prepare ("SELECT * FROM users WHERE user_email = '$get_user_name' AND user_password = '$get_password'");
			$statement->execute(  
                     array(  
                          'event_user_name'     =>     $_POST['user_name'],  
                          'event_user_password'     =>     $_POST['password'] 
                     )  
                ); 
			$rows =$statement->fetch(PDO::FETCH_ASSOC);
                $count = $statement->rowCount();  
                if($count > 0)  
                {  
                        $_SESSION['user'] = $get_user_name;
						$_SESSION['password'] = $get_password;
						$_SESSION['role'] = $rows['role'];
						header('Location:../admin/index.php');
                }  
		
			else {
			
						header('Location:../index.php?login_error=wrong');
					}
				
		}
		 else {
			header('Location:../index.php?login_error=empty');
		}
	}else {
	}
?>