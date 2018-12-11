<?php include 'includes/connectPDO.php';
	$match = '';
    $Role = 'subscriber';
    $first_name ="";
    $last_name ="";
    $password ="";
    $conPassword ="";
    $email ="";
    $gender ="";
    $marital_status ="";
    $phone_no ="";
    $designation ="";
    $website ="";
    $address ="";
    $about_me ="";
    $first_name_errMsg ="";
    $last_name_errMsg ="";
    $email_errMsg ="";
    $gender_errMsg ="";
    $marital_status_errMsg ="";
    $phone_no_errMsg ="";
    $designation_errMsg ="";
    $website_errMsg ="";
    $address_errMsg ="";
    $about_me_errMsg ="";
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
	//to validate the first name 
	function validateFirstName( $inFirstName ) {
	//cannot be empty
	
	if( empty($inFirstName) ) {
		return false;	//Failed validation
	}
		 elseif (preg_match("/^\s /",$inFirstName  )){
			return false;	//Failed validation 
		 }
	else {
		return true;	//Passes validation	
	}	
}//end validateFirstName()
	
	//to validate the Last name 
	function validateLastName( $inLastName ) {
	//cannot be empty
	
	if( empty($inLastName) ) {
		return false;	//Failed validation
	}
	else {
		return true;	//Passes validation	
	}	
}//end validateLastName()
	
//to validate the phone number	
function validatePhoneNumber( $inPhone ) {
	//cannot be empty
	
	if( empty($inPhone) ) {
		return false;	//Failed validation
	}
	//validate the input if its number or not
	elseif (!preg_match("/^[0-9]*$/", $inPhone)){ 
         
         $validForm = false;
        
     }
     
        //number length validation         
       elseif (!preg_match('/^\d{10}$/', $inPhone)){
       $validForm = false;
		
}
	else {
		return true;	//Passes validation	
	}	
}//end validatePhoneNumber()
	
//to validate the website
function validateWebsite( $inWebsite ) {
	//cannot be empty
	
	if( empty($inWebsite) ) {
		return false;	//Failed validation
	}
	else {
		return true;	//Passes validation	
	}	
}//end validateWebsite()
	
//to validate the website
function validateDesignation( $inDesignation) {
	//cannot be empty
	
	if( empty($inDesignation) ) {
		return false;	//Failed validation
	}
	else {
		return true;	//Passes validation	
	}	
}//end validateWebsite()
		//to validate the address
function validateAddress( $inAddress ) {
	//cannot be empty
	
	if( empty($inAddress ) ) {
		return false;	//Failed validation
	}
	else {
		return true;	//Passes validation	
	}	
}//end validateAddress
	
	//to validate the About me
function validateAboutMe( $inAboutMe ) {
	//cannot be empty
	
	if( empty($inAboutMe ) ) {
		return false;	//Failed validation
	}
	else {
		return true;	//Passes validation	
	}	
}//end validateAddress
		
// Start Validation 
	   
        $first_name = test_input($_POST['first_name']);
        $last_name = test_input($_POST['last_name']);
        $email = test_input($_POST['email']);
		$password = $_POST['password'];
	    $conPassword = $_POST['con_password'];
		$gender = $_POST['gender'];
		$marital = $_POST['marital_status'];
        $phone_no = $_POST['phone_no'];
        $designation = test_input($_POST['designation']);
        $website = test_input($_POST['website']);
        $address = test_input($_POST['address']);
        $about_me = test_input($_POST['about_me']);

	
	if( !validateFirstName($first_name) ) {
			$valid_form = false;
			$first_name_errMsg = "Please enter a your first name";
		
		}
	
	if( !validateLastName($last_name) ) {
			$valid_form = false;
			$last_name_errMsg = "Please enter a your last name";
		
		}
	
	if( !validatePhoneNumber($phone_no) ) {
			$valid_form = false;
			$phone_no_errMsg = "Please enter a phone number with 10 digits without space or text";
		
		} 
	
	if( !validateWebsite($website) ) {
			$valid_form = false;
			$website_errMsg = "Please enter a your website";
		
		}
	if( !validateDesignation($designation) ) {
			$valid_form = false;
			$designation_errMsg = "Please enter a your Designation";
		
		}
	
	
	if( !validateAddress($address) ) {
			$valid_form = false;
			$address_errMsg = "Please enter a your address";
		
		}
	
	if( !validateAboutMe($about_me) ) {
			$valid_form = false;
			$about_me_errMsg = "Please write about yourself";
		
		}

	
	//validate email using PHP filter
	if( !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$email_errMsg = "Invalid email";
		$valid_form = false;	
	}
	//validate if the password macthing or not
	if($password !== $conPassword){
		$match = '<div class="alert alert-danger">Password doesn&apos;t match!</div>';
		$valid_form = false;
	}
	// validate the gender select
	if (!isset($_POST['gender'])){
        
        $radioErrMsg = "Choose a Response to submit";
		$valid_form = false;
	}
	// validate the merital select
	if (!isset($_POST['marital_status'])){
        
        $radioErrMsg = "Choose a Response to submit";
		$valid_form = false;
	}
	
	//ReCapatcha server side confiration
	$statusMsg = '';
	if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response']))
     {
        $secretKey  = "6Lfzi3MUABbpa5Vz5bC";
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
				
		$date = date('Y-m-d h:i:s');
		$sql ="INSERT INTO users (role, user_f_name, user_l_name, user_email, user_password, user_gender, user_marital_status, user_phone_no, user_designation, user_website, user_address, user_about_me, user_date ) VALUES (:Role,:FirstName,:LastName,:Email,:Password,:Gender,:Marital,:Phone,:Designation,:Website,:Address,:AboutMe,:Date )"; //sql language  sql Insert INTO table (fields)VALUes (...);

		
try{
$stmt = $conn->prepare($sql); //prepare the sql statment

$stmt-> bindparam(':Role', $Role);//bind
$stmt-> bindparam(':FirstName', $first_name);//bind
$stmt-> bindparam(':LastName', $last_name);//bind
$stmt-> bindparam(':Email', $email);
$stmt-> bindparam(':Password', $password);	
$stmt-> bindparam(':Gender', $gender);
$stmt-> bindparam(':Marital', $marital);
$stmt-> bindparam(':Phone', $phone_no);
$stmt-> bindparam(':Designation', $designation);
$stmt-> bindparam(':Website', $website);
$stmt-> bindparam(':Address', $address);
$stmt-> bindparam(':AboutMe', $about_me);	
$stmt-> bindparam(':Date', $date);   
$stmt->execute(); // process the SQL againt the database
	
	
	$general_Msg ="You Have Successfully Finished The Registration";
}

catch(PDOException $e)
    {
    die();
    
    }
	//else display the form with original values and error messages	
	
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
						<h2>Registration Form</h2>
					</div>
					<h3><span ><?php echo $general_Msg ?></span></h3>
					<?php echo $match; ?>
					<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" role="form">
						<div class="form-group">
							<label for="first_name" class="col-sm-3 control-label">First Name *</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="first_name" placeholder="Insert your Name" id="first_name" value="<?php echo $first_name ?>" required>
								<span style="color:red" id="errorFirstName"><?php echo $first_name_errMsg; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="last_name" class="col-sm-3 control-label">Last Name *</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="last_name" placeholder="Insert your Name" id="last_name" value="<?php echo $last_name ?>" required>
								<span style="color:red" id="errorLastName"><?php echo $last_name_errMsg; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="email" class="col-sm-3 control-label">Email Address *</label>
							<div class="col-sm-8">
								<input type="email" class="form-control" name="email" placeholder="Email Address" id="email" value="<?php echo $email ?>" required>
								<span style="color:red" id="errorLastName"><?php echo $email_errMsg; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="passsword" class="col-sm-3 control-label">Password *</label>
							<div class="col-sm-8">
								<input type="password" class="form-control" name="password" placeholder="Insert a password" id="password" required>
							</div>
						</div>
						<div class="form-group">
							<label for="con_passsword" class="col-sm-3 control-label"> Confirm Password *</label>
							<div class="col-sm-8">
								<input type="password" class="form-control" name="con_password" placeholder="Confirm password" id="con_password" required>
							</div>
						</div>
						
						<div class="form-group">
							<label for="gender" class="col-sm-3 control-label"> Gender *</label>
							<div class="col-sm-3">
								<select class="form-control" name="gender" id="gender" value="<?php echo $gender ?>" required>
									<option value="">Select Gender</option>
									<option value="male">Male</option>
									<option value="female">Female</option>
								</select>
							</div>
						
							<label for="marital_status" class="col-sm-2 control-label"> Marital Status</label>
							<div class="col-sm-3">
								<select class="form-control" name="marital_status" id="marital_status" value="<?php echo $marital_status ?>">
									<option value="">Select Status</option>
									<option value="single">Single</option>
									<option value="married">Married</option>
									<option value="divorced">Divorced</option>
									<option value="other">Other</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label for="phone_no" class="col-sm-3 control-label"> Phone No: *</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="phone_no" id="phone_no" placeholder="Insert Your Contact No." id="con_password" value="<?php echo $phone_no ?>" required>
								<span style="color:red" id="errorPhone"><?php echo $phone_no_errMsg; ?></span>
								
							</div>
						</div>
						<div class="form-group">
							<label for="designation" class="col-sm-3 control-label"> Designation:</label>
							<div class="col-sm-8">
								<input type="text" name="designation" class="form-control" name="designation" placeholder="Insert your Designation" id="con_password" value="<?php echo $designation ?>">
								<span style="color:red" id="errorPhone"><?php echo $designation_errMsg; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="website" class="col-sm-3 control-label"> Official Website:</label>
							<div class="col-sm-8">
								<input type="text" id="website" class="form-control" name="website" placeholder="Insert your Official Website" id="con_password" value="<?php echo $website ?>">
								<span style="color:red" id="errorPhone"><?php echo $website_errMsg; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="address" class="col-sm-3 control-label"> Address:</label>
							<div class="col-sm-8">
								<textarea class="form-control" name="address" id="address" rows="2" value="<?php echo $address ?>"></textarea>
								<span style="color:red" id="errorPhone"><?php echo $address_errMsg; ?></span>
							</div>
						</div>
						<div class="form-group">
							<label for="about_me" class="col-sm-3 control-label"> About me: *</label>
							<div class="col-sm-8">
								<textarea id="about_me" name="about_me" class="form-control" rows="6" value="<?php echo $about_me ?>"required></textarea>
								<span style="color:red" id="errorPhone"><?php echo $about_me_errMsg; ?></span>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-9">
							<label for="" class="col-sm-4 control-label"></label>
							<!-- Google reCAPTCHA widget -->
							  <div style="margin:5px;" name ="g-captcha-response"  class=" col-sm-4 g-recaptcha" data-sitekey="6Lf1Exca-7VlZdXtJ"></div>
							  <div class="col-sm-12">
							  <label for="" class="col-sm-4 control-label"></label>
							  <div class=" col-sm-8"><span><?php echo $statusMsg;?></span> </div> 
                           </div>
					  </div>
						</div>
												<div class="form-group">
							<label class="col-sm-3 control-label"></label>
							<div class="col-sm-8">
								<input type="submit" value="Register Yourself" name="submit_user" class="btn btn-block btn-danger" id="subject">
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
