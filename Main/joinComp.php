<?php

	// addToTeam(POST-userID,POST-teamID)


	$hostname='it391test.db.8404538.hostedresource.com';
	$username='it391test';
	$password='Binoy01';
	$dbname='it391test';
	
	mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
	mysql_select_db($dbname);
	
	$compID = $_POST["comp"];
	$userID = $_POST["user"];

	$query = "INSERT INTO USERCOMP (compID,userID) VALUES ('. $compID .','.$userID.')";
	$result = mysql_query($query);
?> 