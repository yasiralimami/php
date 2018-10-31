<?php
require_once('exception_handlers.php');
function set_connection_exception_handler($con,$e)
{
	//put a developer defined error message on the PHP log file
	error_log($e->getMessage());		
	error_log($con->connect_errno);
	error_log($con->connect_error);
	//error_log(var_dump(debug_backtrace()));		
	
	//send control to a User friendly Error display page				
	header('Location: 505_error_response_page.php');	
}


function set_statement_exception_handler($stmt,$e)
{
	//put a developer defined error message on the PHP log file
	error_log($e->getMessage());		
	error_log($stmt->errno);
	error_log($stmt->error);
	//error_log(var_dump(debug_backtrace()));		
	
	//send control to a User friendly Error display page				
	header('Location: 505_error_response_page.php');
		
}

?>