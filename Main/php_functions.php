<?php

/* ***********************************

		IT391 Commuter Challenge
		   PHP FUNCTION FILE
		    (Include this!)

   *********************************** */

/*
	commuteChallengeError
	Handles PHP errors that occur in our functions.
*/ 
function commuteChallengeErrorHandler($errno, $errstr)
{
	echo "<b>Error:</b> [$errno] $errstr<br />";
	echo "Ending Script";
	die();
}
set_error_handler("commuteChallengeErrorHandler"); // Tells PHP to use our function when errors occur.

/*
	connectToDatabase()
	Connects to the database.
*/
function connectToDatabase()
{
	$hostname='it391test.db.8404538.hostedresource.com';
	$username='it391test';
	$password='Binoy01';
	$dbname='it391test';
	
	mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
	mysql_select_db($dbname);
}

/*
	disconnectFromDatabase()
	Disconnects from the database.
*/
function disconnectFromDatabase()
{
	mysql_close();
}

/*
	getUserID()
	Returns the users's ID, or 0 if they are not logged in.
	** WARNING - Must perform session_start() before calling this!
*/
function getUserID()
{
	$id = 0;

	if(!isset($_SESSION["user"]))
		return false;
		
	connectToDatabase();
	
	$user = $_SESSION["user"];
	$query = "SELECT userID FROM USER WHERE loginEmail = '".$user."'";
	$result = mysql_query($query);
	
	if($result) {
		while($row = mysql_fetch_array($result)) {
			$id = $row["userID"];
		}
	}
	
	disconnectFromDatabase();
	
	if($id != 0)
		return $id;
	else
		return false;
}

//	** WARNING - Must perform session_start() before calling this!
function isUserAdmin()
{	
	if(!isset($_SESSION["admin"]))
		return false;
		
	$isAdmin = $_SESSION["admin"];
	
	return $isAdmin;	
}


/*
	Requires
	Include all of the sub-libraries that we need.
*/

require("CCPHP/commuteFunctions.php");
require("CCPHP/userFunctions.php");
require("CCPHP/teamFunctions.php");
require("CCPHP/competitionFunctions.php");


?>