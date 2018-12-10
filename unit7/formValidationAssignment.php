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

/*function validateRadio(){
     if(empty($_POST['inRadio'])) {
    
      $radioErrMsg = "Choose a Response to submit"; }
} */


//   ---  FORM VALIDATION BEGINS HERE!!!   --------

if( isset($_POST['submit'])  )				//if the form has been submitted Validate the form data
{
	//pull data from the POST variables in order to validate their values
	$inName = $_POST['inName'];
	$inSocial = $_POST['inSocial'];
	$inRadio = $_POST['inRadio'];
	if (!isset($_POST['inRadio'])){
        
        $radioErrMsg = "Choose a Response to submit";
	}
     $validForm = true;					//Set form flag/switch to true.  Assumes a valid form so far
	 validateName();					//call the validateName() function
	validateSocial();
   // validateRadio();
    
	
	if($validForm)
	{
		//If the form is properly validated some or all of the following processes would be completed before displaying a confirmation message to the user
		//- Create and send an email confirmation to the user using the email address they entered on the form.  You would use the Email class for this process
		//- Use SQL to put the form data into a table in the database.  This is often done to record the registration/order/contact, etc.
		//- Perform additional processing of the form data depending upon the application requirements.	
	}

}//Completes the Form Validation process for this page.  


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
      <td width="246"><input type="text" name="inName" id="inName" size="40" value="<?php echo "$inName" ?>"/></td>
      <td width="210" class="error"><?php echo "$nameErrMsg"; //place error message on form  ?></td>
    </tr>
    <tr>
      <td>Social Security</td>
      <td><input type="text" name="inSocial" id="inSocial" size="40" value="<?php echo "$inSocial" ?>" /></td>
      <td class="error"><?php echo "$socialErrMsg"; //place error message on form  ?></td>
    </tr>
    <tr>
      <td>Choose a Response</td>
      <td><p>
      
         <label>
          <input type="radio" name="inRadio" id="inRadio_0" value="phone"
          <?php if($inRadio == "phone"){ echo "checked"; } ?>>
          Phone</label>
        <br>
        <label>
          <input type="radio" name="inRadio" id="inRadio_1" value="email"
          <?php if($inRadio == "email"){ echo "checked"; } ?>>
          Email</label>
        <br>
        <label>
          <input type="radio" name="inRadio" id="inRadio_2" value="US Mail"
          <?php if($inRadio == "US Mail"){ echo "checked"; } ?>>
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