<?php 
//include will only produce a warning (E_WARNING) and the script will continue
include 'includes/connectPDO.php';
include 'classes/Database.php';
//require will produce a fatal error (E_COMPILE_ERROR) and stop the script
require 'classes/emailer.php';
$firstName="";
$name ="";
$email ="";
$subject ="";
$comment ="";
$name_errMsg ="";
$subject_errMsg ="";
$email_errMsg ="";
$comment_errMsg ="";
$general_Msg ="";
$valid_form = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	
	//to protect the data from special char and hacking
	function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
	//to validate the name 
	function validateName( $inName ) {
	//cannot be empty
	
	if( empty($inName) ) {
		return false;	//Failed validation
	}
	else {
		return true;	//Passes validation	
	}	
}//end validateEventName()
	
	function validateSubject( $inName ) {
	//cannot be empty
	
	if( empty($inName) ) {
		return false;	//Failed validation
	}
	else {
		return true;	//Passes validation	
	}	
	}
//end validateSubject()
		
	function validateComment( $inName ) {
	//cannot be empty
	
	if( empty($inName) ) {
		return false;	//Failed validation
	}
	else {
		return true;	//Passes validation	
	}	
	}
//end validateComment()
		$name =test_input($_POST['name']);
        $email =$_POST['email'];
        $subject =test_input($_POST['subject']);
        $comment =test_input($_POST['comment']);
		
		// start verification
		
		if( !validateName($name) ) {
			$valid_form = false;
			$name_errMsg = "Please enter a your name";
		
		}
	
	if( !validateSubject($subject) ) {
			$valid_form = false;
			$subject_errMsg = "Please enter a Subject";
		}
	if( !validateComment($comment) ) {
			$valid_form = false;
			$comment_errMsg = "Please enter a Comment";
		}
	
	
	//validate email using PHP filter
	if( !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$email_errMsg = "Invalid email";
		$valid_form = false;	
	}
		
		//set protection
		if(!$firstName ==""){ 
		$valid_form = false; 
	                         } 
	//ReCapatcha server side confiration
	$statusMsg = '';
	if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
     {
        $secretKey  = "6Lfzi3MUAAAAAKQ1sRukiWmpfwkD6wBbpa5Vz5bC";
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secretKey.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);
        if($responseData->success)
        {
            $valid_form = true; 
        }
		}
        else
        {
            $statusMsg = 'Robot verification failed, please try again.';
			$valid_form = false; 
        }
   
	
		if($valid_form) { 
		
			$name =test_input($_POST['name']);
            $email =$_POST['email'];
            $subject =test_input($_POST['subject']);
            $comment =test_input($_POST['comment']);
			$date = date('Y-m-d h:i:s');
			//Try database class 
			$db= new Database("localhost","yasir_cms_system","yasir_3","@try@123@!@#");
			$params = array(':Name'=> $name,':Email'=> $email,':Subject'=> $subject,':Comment'=> $comment,':Date'=> $date );
            $sql ="INSERT INTO comments (name, email, subject, comment, date) VALUES (:Name,:Email,:Subject,:Comment,:Date)";

            
			/*$sql ="INSERT INTO comments (name, email, subject, comment, date ) VALUES (:Name,:Email,:Subject,:Comment,:Date )"; //sql language  sql Insert INTO table (fields)VALUes (...);*/

try{
            $db->preparePDO($sql);

            $dbResult = $db->executePDO($params);
			
	/*$stmt = $conn->prepare($sql); //prepare the sql statment

$stmt-> bindparam(':Name', $name);//bind
$stmt-> bindparam(':Email', $email);
$stmt-> bindparam(':Subject', $subject);
$stmt-> bindparam(':Comment', $comment);
$stmt-> bindparam(':Date', $date);   
$stmt->execute(); // process the SQL againt the database */
	
	
	$general_Msg ="you have successfully add the information";
}

catch(PDOException $e)
    {
    die();
    
    }
	// send an email to the client telling him we received his message.
			
			
			$businessEmail = new Emailer (); //instantiate a new of instance of a class 
            $businessEmail->setMessageLine("Dear ".$name." We received your message and we will response ASAP"); //loaded a value into the object
            $businessEmail->setSenderAddress ("info@yasiralimami.info");
            $businessEmail->setSendToAddress ($email);
            $businessEmail->setSubjectLine ("Thanks For Contact Us");
            $validEmail = $businessEmail->sendPHPEmail();

		}
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>CMS System</title>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.css">
        <script src="../finalproject/js/jquery.js"></script> 
		<script src="../finalproject/bootstrap/js/bootstrap.js"></script>
		<script src='https://www.google.com/recaptcha/api.js' async defer></script>
		
		
	</head>
	<body>
		<?php include 'includes/header.php';?>
		<div class="container">
			<article class="row">
				<section class="col-lg-8">
					<div class="page-header">
						<h2>Contact Us Form</h2>
					</div>
					<h3><span><?php echo $general_Msg ?></span></h3>
					<form class="form-horizontal"  method="post" role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="form-group">
							<label for="name" class="col-sm-2 control-label">Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="name" placeholder="Insert your Name" id="name" value="<?php echo $name ?>">
								<span id="errorName"><?php echo $name_errMsg; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">Email Address</label>
							<div class="col-sm-8">
								<input type="email" class="form-control" name="email" placeholder="Email Address" id="email " value="<?php echo $email ?>">
								<span id="errorName"><?php echo $email_errMsg; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="subject" class="col-sm-2 control-label">Subject</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="subject" placeholder="Subject" id="subject" value="<?php echo $subject ?>">
								<span id="errorName"><?php echo $subject_errMsg; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="comments" class="col-sm-2 control-label">Comment</label>
							<div class="col-sm-8">
								<textarea class="form-control" rows="10" name="comment" style="resize:none;" value="<?php echo $comment ?>"></textarea>
								<span id="errorName"><?php echo $comment_errMsg; ?></span>
							</div>
							<div class="form-group">
							<div class="col-sm-8">
							<label for="" class="col-sm-3 control-label"></label>
							<!-- Google reCAPTCHA widget -->
     <div style="margin:5px;" name ="g-captcha-response"  class=" col-sm-2 g-recaptcha" data-sitekey="6Lfzi3MUAAAAAGxBbzGmu54a9G1Exca-7VlZdXtJ"></div>
      <div class="col-sm-8">
      <label for="" class="col-sm-4 control-label"></label>
    <div class=" col-sm-8"><span><?php echo $statusMsg;?></span> </div> 
                     </div>
					  </div>
						</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label"></label>
							<div class="col-sm-8">
								<input type="submit" value="Submit your Form" name="submit_contact" class="btn btn-block btn-danger" id="subject">
							</div>
						</div>
					</form>
					
				</section>
				<?php include 'includes/sidebar.php';?>
			</article>
		</div>
		<div style="width:50px;height:50px;"></div>
		<?php include 'includes/footer.php';?>
	</body>
</html>