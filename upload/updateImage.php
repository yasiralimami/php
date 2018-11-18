<?php
 
 $inEventID = $_GET['eventID']; 
   echo $inEventID;
	if( isset($_POST['uploadButton']) )
	{   
		$inEventID = $_POST['event_id'];
		$target_dir = "uploadImages/";
		$target_file = $target_dir . basename($_FILES["inFile"]["name"]);
		$validUpload = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				
      	//upload the file
		//update datbase 
		require 'connectPDO.php';
		
$sql ="UPDATE wdv341_event set event_id=:eventID, image_path=:Image_path  WHERE event_id=:eventID";
try{
$stmt = $conn->prepare($sql); //prepare the sql statment
$stmt-> bindparam(':eventID', $inEventID);
$stmt-> bindparam(':Image_path', $target_file);//bind
$stmt->execute(); // process the SQL againt the database
  
}

catch(PDOException $e)
    {
	echo "problem";
    //die();
    
    }

		//end of databse update
		
		if ($validUpload == 0) {
			echo "Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES["inFile"]["tmp_name"], $target_file)) {
				echo "The file ". basename( $_FILES["inFile"]["name"]). " has been uploaded and Your database Updated.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}		
		

	}
	else{
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<h1>WDV341 Intro PHP</h1>
<h2>File Upload</h2>
<p>&nbsp;</p>

    <form method="post" enctype="multipart/form-data" name="form1" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
     <p>Event ID  <input type="" id="event_id" name="event_id" placeholder="your record ID " value="<?php echo $inEventID ?>">
      <p>
       
        <label for="imageName">Picture Name</label>
        <input type="text" name="imageName" id="imageName">
      </p>
      <p>
        <label for="inFile">Select Image </label>
        <input type="file" name="inFile" id="inFile">
        <input name="eventID" type="text" id="first_Name" style ="display:none" >
      </p>
      <p>
        <input type="submit" name="uploadButton" id="button" value="Upload File">
        <input type="reset" name="button2" id="button2" value="Reset">
      </p>
    </form>

<p>&nbsp;</p>
<?php
	}//close isset() 
?>
</body>
</html>