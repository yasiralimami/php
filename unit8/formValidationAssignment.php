<?php
//Setup the variables used by the page
$nameErrMsg = "";
$socialErrMsg = "";
$radioErrMsg = "";


$validForm = false;

$inName = "";
$inSocial = "";
$inRadio = "";

/*	FORM VALIDATION PLAN

	FIELD NAME	VALIDATION TESTS & VALID RESPONSES
	inName		Required Field		May not be empty and trim leading spaces
	
				
	inSocial		Required Field		May not be empty
				Format Validation	 numeric,no hyphens or ( ).  Must be the right size.  Use a Regular Expression for this validation.

	inRadio 	Required Field		One must be selected. 

*/

//VALIDATION FUNCTIONS		Use functions to contain the code for the field validations.  

function validateName()
{
	global $inName, $validForm, $nameErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
	$nameErrMsg = "";
	
	if($inName == "")
	{
		$validForm = false;
		$nameErrMsg = "Name cannot be spaces or empty";
	}
    
    elseif (preg_match("/^\s /",$inName  )){
        $validForm = false;
		$nameErrMsg = "leading spaces Must removed";
    }
}//end validateName()


function validateSocial()
 {
    global $inSocial, $validForm, $socialErrMsg;
    $socialErrMsg = "";
    
    // empty validation
    if ( $inSocial == ""){
        
        $validForm = false;
		$socialErrMsg = "Social Number cannot be spaces or empty";
        
    }
    // number validation
     elseif (!preg_match("/^[0-9]*$/", $inSocial)){ 
         
         $validForm = false;
         $socialErrMsg = "Social Number must be a number";
     }
     
                 //number length validation
   
    
    elseif (!preg_match('/^\d{9}$/', $inSocial)){
       $validForm = false;
		$socialErrMsg = "Social Number cannot be less or more 9 Digits";
}
    
}


//   ---  FORM VALIDATION BEGINS HERE!!!   --------

if( isset($_POST['submit'])  )				//if the form has been submitted Validate the form data
{
	//pull data from the POST variables in order to validate their values
	$inName = $_POST['inName'];
	$inSocial = $_POST['inSocial'];
	if (!isset($_POST['inRadio'])){
        
        $radioErrMsg = "Choose a Response to submit";
	}
    global $inRadio;
    
        
	$validForm = true;					//Set form flag/switch to true.  Assumes a valid form so far
	
	validateName($inName);					//call the validateName() function
	validateSocial($inSocial);
   
    
	
	if($validForm)
	{
		//If the form is properly validated some or all of the following processes would be completed before displaying a confirmation message to the user
		//- Create and send an email confirmation to the user using the email address they entered on the form.  You would use the Email class for this process
		//- Use SQL to put the form data into a table in the database.  This is often done to record the registration/order/contact, etc.
		//- Perform additional processing of the form data depending upon the application requirements.	
	

//Completes the Form Validation process for this page.  
try {
    
    require 'database/connectPDO.php';	//CONNECT to the database
				
				//mysql DATE stores data in a YYYY-MM-DD format
				//$todaysDate = date("Y-m-d");		//use today's date as the default input to the date( )
				
				//Create the SQL command string
				$sql = "INSERT INTO selfform (";
				$sql .= "inName, ";
				$sql .= "inSocial, ";
				$sql .= "inRadio ";
                $sql .= ") VALUES (:inName, :inSocial, :inRadio )";
    //PREPARE the SQL statement
				$stmt = $conn->prepare($sql);
				
				//BIND the values to the input parameters of the prepared statement
				$stmt->bindParam(':inName', $inName);
				$stmt->bindParam(':inSocial', $inSocial);		
				$stmt->bindParam(':inRadio', $inRadio);
    //EXECUTE the prepared statement
				$stmt->execute();	
				
				$message = "your information has been registered.";
			}
			
			catch(PDOException $e)
			{
				$message = "There has been a problem. The system administrator has been contacted. Please try again later.";
	
				error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
				error_log(var_dump(debug_backtrace()));
			
				//Clean up any variables or connections that have been left hanging by this error.		
			
				header('Location: files/505_error_response_page.php');	//sends control to a User friendly page					
			}

    }
		else
		{
			$message = "Something went wrong";
		}//ends check for valid form		

	}

	else
	{
		//Form has not been seen by the user.  display the form
	}// ends if submit 



?>
<!DOCTYPE html>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WDV341 Intro PHP - Form Validation Example</title>
<style>

#orderArea	{
	width:600px;
	background-color:#CF9;
}

.error	{
	color:red;
	font-style:italic;	
}
</style>
</head>

<body>
<h1>WDV341 Intro PHP</h1>
<h2>Form Validation Assignment</h2>

<div id="orderArea">
  <form id="form1" name="form1" method="post" action="formValidationAssignment.php">
  <h3>Customer Registration Form</h3>
  <table width="587" border="0">
    <tr>
      <td width="117">Name:</td>
      <td width="246"><input type="text" name="inName" id="inName" size="40" value=""/></td>
      <td width="210" class="error"><?php echo "$nameErrMsg"; //place error message on form  ?></td>
    </tr>
    <tr>
      <td>Social Security</td>
      <td><input type="text" name="inSocial" id="inSocial" size="40" value="" /></td>
      <td class="error"><?php echo "$socialErrMsg"; //place error message on form  ?></td>
    </tr>
    <tr>
      <td>Choose a Response</td>
      <td><p>
        <label>
          <input type="radio" name="inRadio" id="inRadio_0" value="phone">
          Phone</label>
        <br>
        <label>
          <input type="radio" name="inRadio" id="inRadio_1" value="email">
          Email</label>
        <br>
        <label>
          <input type="radio" name="inRadio" id="inRadio_2" value="US Mail">
          US Mail</label>
        <br>
      </p></td>
      <td class="error"><?php echo "$radioErrMsg"; //place error message on form  ?></td>
    </tr>
  </table>
  <p>
    <input type="submit" name="submit" id="button" value="Register" />
    <input type="reset" name="button2" id="button2" value="Clear Form" />
  </p>
</form>
</div>

</body>
</html>