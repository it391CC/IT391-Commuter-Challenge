<?php

	// addToTeam(POST-userID,POST-teamID)


	$hostname='it391test.db.8404538.hostedresource.com';
	$username='it391test';
	$password='Binoy01';
	$dbname='it391test';
	
	mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
	mysql_select_db($dbname);
	
	$teamID = 0;
	$teamname = $_POST["teamName"];
	$userID = $_POST["usersID"];
	
	$query = "SELECT * FROM TEAM WHERE name='".$teamname."'";
	$result = mysql_query($query);
	
	while($row = mysql_fetch_array($result)) {
		$teamID = $row["teamID"];
	}
	//echo $userID."<br>";
	
	if($teamID != 0 && $userID != NULL) {
		$query = "INSERT INTO USERTEAM VALUES (".$userID.",".$teamID.",0)";
		$result = mysql_query($query);
		echo "<script>location.href='team.php'</script>";
		exit();
	} else {
		echo "Not logged in or failed to find team '".$teamname."'<br>";	
	}
?> 