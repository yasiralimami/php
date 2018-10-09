<?php
global $lab_name, $lab_email, $first_lab, $name_errMsg, $email_errMsg, $general_errMsg;

//define variable
$lab_name ="";
$lab_email ="";
$first_lab ="";
$name_errMsg ="";
$email_errMsg ="";
$general_errMsg ="";

$valid_form = false;
 

if( isset($_POST['lab_submit']) )
	{
		//process form data	
	//	$general_Msg ="Form has been submitted and should be processed";
	
	//BEGIN FORM VALIDATION
	$lab_name = $_POST['lab_name'];
	$lab_email = $_POST['lab_email'];
	$first_lab = $_POST['first_lab'];
	
	
	$valid_form = true;		
	
	//validate name - Cannot be empty
	if( empty($lab_name)) {
		$name_errMsg = "Please enter a name";
		$valid_form = false;
	}

	//validate email using PHP filter
	if( !filter_var($lab_email, FILTER_VALIDATE_EMAIL)) {
		$email_errMsg = "Invalid email";
		$valid_form = false;	
	}
	
		//set protection
		if(!$firstName ==""){ 
		$valid_form = false; 
	                         } 
  
  } 
		
		//show the form to the customer/user

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>WDV341 Intro PHP</title>
</head>

<body>
<h1>WDV341 Intro PHP</h1>
<h2>Unit-7 and Unit-8 Form Validations and Self Posting Forms.</h2>
<h3>In Class Lab - Self Posting Form</h3>
<?php
			if($valid_form)
			{ 
				echo $general_Msg;
		?>
			<h1>Form Was Successful</h1>
            <h2>Thank you for submitting your information</h2>        
        <?php
			}
			else
			{
		?>
		
<p><strong>Instructions:</strong></p>
<ol>
  <li>Modify this page as needed to convert it into a PHP self posting form.</li>
  <li>Use the validations provided on the page for the server side validation. You do NOT need to code any validations.</li>
  <li>Modify the page as needed to display any input errors.</li>
  <li>Include some form of form protection.</li>
  <li>You do NOT need to do any database work with this form. </li>
</ol>
<p>When complete:</p>
<ol>
  <li>Post a copy on your host account.</li>
  <li>Push a copy to your repo.</li>
  <li>Submit the assignment on Blackboard. Include a link to your page and to your repo.</li>
</ol>

<form name="form1" method="post" action="lab-self-posting-form.php">
  <p>
    <label for="lab_name">Name:</label>
    <input type="text" name="lab_name" id="lab_name" value="<?php echo $lab_name; ?>">
    <span id="errorName"><?php echo $name_errMsg; ?></span>
  </p>
  <p>
    <label for="lab_email">Email:</label>
    <input type="text" name="lab_email" id="lab_email">
    <span id="erroremail"><?php echo $email_errMsg; ?></span>
  </p>
  <input name="first_name" type="text" id="firstname" style ="display:none" >
  <p>
    <input type="submit" name="lab_submit" id="lab_submit" value="Submit">
    <input type="reset" name="reset" id="reset" value="reset">
  </p>
</form>
 <?php
			}	//end valid form confirmation 
		?>
        
<p>&nbsp;</p>
</body>
</html>
