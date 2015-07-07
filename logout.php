<?
/**
 * filename	: logout.php
 * author	: David Roof 
 * course	: CIS 355
 * purpose	: this program terminates the user's session. Then redirects back to login 
 * design	: 			
 *			1. Terminates the session
 *			2. Redirect to login.php 
 *			
*/	
session_start();
session_unset();
session_destroy();
ob_start();
header("location:login.php");
ob_end_flush(); 
exit();
?>
