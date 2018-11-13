<?php  
 //login_success.php  
 session_start();  


 ?>  
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
      <meta charset="UTF-8">
      <title>workspace page</title>
      <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <style>
		  h1{
		   text-align: center;
	   }
      #big-cont{
       display: flex;
        text-align: left;
    height: 100%;
    margin: 20px;
    justify-content: flex-start;
    margin-left: auto;
    margin-right: auto;
    align-items: left;
    flex-direction: column;
     
      }
  #container1{
		width:960px;
		background-color:lightblue;
		margin:20px;
        padding: 10px;
            
			}
      h3{
       font-weight: 600;
       
       color: red;
      }
      a.button {
    -webkit-appearance: button;
    -moz-appearance: button;
    appearance: button;

    text-decoration: none;
    color: initial;
}
      #left{
       float: right;
       margin-right: 5%;
       border: 1px solid black;
      }
      #eventlist{
       
		width:960px;
		background-color:lightblue;
		margin:20px;
        justify-content: center;
		  
      }
	
		 .container {
    display: flex;
    border: 2px solid black;
    text-align: center;
    height: 100%;
    margin: 20px;
    justify-content: center;
    margin-left: auto;
    margin-right: auto;
    align-items: center;
    flex-direction: column;
     
        
}
        button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100px;
}
        
        input {
            padding: 10px;
             margin: 10px;
        }
        label {
            padding: 10px;
            margin: 10px;
        }
        #formdiv{ 
            width: 40%;
            justify-content: center;
            text-align: center;
             border: 2px dashed red;
             margin-bottom: 5%;
            margin-top: 5%;
        }
     
        
  </style>
 <?php 
	  if(isset($_SESSION["validUser"]))  
 {  
      echo '<h3>Login Success, Welcome - '.$_SESSION["validUser"].'</h3>';  
      echo '<div id="left"><a href="logout.php" class="btn btn-default button">Logout</a></div>';  
      $message="";
      require 'connectPDO.php';
      global $event_name,$event_description,$event_date,$event_time;
	 ?>
 </head>
 <body>
   <div id="big-cont">
   <h1> Admin Panel </h1>
   
   <h2><a href="eventsForm.php" target="_blank">+ Add New Event</a>   </h2> 
   
   <h2> <a href="selectEvents.php" target="_blank">+ View your list event</a> </h2>
   <div>
      
  </div>
  
 </div>
 
   

<?php
	  }  
 else  
 { 
	 ?>
	 <?php
session_start();

 $message = "";

include 'connectPDO.php';			//connects to the database

	
    if(isset($_POST["login"]))  
      {  
           if(empty($_POST["username"]) || empty($_POST["password"]))  
           {  
                $message = '<label>All fields are required</label>';  
           }  
           else  
           {  
               $statement = $conn->prepare ("SELECT * FROM event_user WHERE event_user_name = :event_user_name AND event_user_password = :event_user_password");  
                
               
                $statement->execute(  
                     array(  
                          'event_user_name'     =>     $_POST["username"],  
                          'event_user_password'     =>     $_POST["password"]  
                     )  
                );  
                $count = $statement->rowCount();  
                if($count > 0)  
                {  
                     $_SESSION["validUser"] = $_POST["username"];  
                     header("location:login.php");
                }  
                else  
                {  
                     $message = '<label>Invalid username or password</label>';  
                }  
           }  
      }  

  ?>
	 <div class="container">
    <h2>Welcome to my login page</h2>
    
    
    <div id="formdiv">
    <?php  
                if(isset($message))  
                {  
                     echo '<label class="text-danger">'.$message.'</label>';  
                }  
                ?>  
    
     <form method="post" action="<?=$_SERVER['PHP_SELF'];?>">
     <fieldset>
      <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="username" required>
       <br/>
      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>
        <br/>
      <button type="submit" name="login">Login</button>
        <button type="reset" name="reset">Rest</button>
        </fieldset>
        
      </form>
    </div>
  </div>
  
  </body>
 </html>
	<?php  
 } 

	 ?>