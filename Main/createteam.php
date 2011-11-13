<?php

	// addToTeam(POST-userID,POST-teamID)


	$hostname='it391test.db.8404538.hostedresource.com';
	$username='it391test';
	$password='Binoy01';
	$dbname='it391test';
	
	mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
	mysql_select_db($dbname);
	
	$userid = $_POST["usersID"];
	$teamname = $_POST["teamName"];
	$compID = $_POST["compID"];
	echo $userid . "<br/>";
	echo $teamname . "<br/>";
	echo $compID . "<br/>";
	
	// Check if user is already on a team in this competition
	$query = "SELECT * FROM USERTEAM WHERE userID=".$userid;
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)) {
		$tteamId = $row["teamID"];
		// Check each team to see if its in the same comp as what were trying to make
		$tquery = "SELECT * FROM TEAM WHERE teamID=".$tteamId;
		$tresult = mysql_query($tquery);
		while($trow = mysql_fetch_array($tresult)) {
			$tcompID = $trow["compID"];
			if($tcompID == $compID) {
					echo "<script>location.href='alreadyonteam.php'</script>";
					exit();	
			}
		}
	}

	
	// Create team
	$query = "INSERT INTO TEAM (compID,name) VALUES (". $compID .",'".$teamname."')";
	echo $query;
	$result = mysql_query($query);
	
	// Make user spokesperson of the new team
	$query = "SELECT teamID FROM TEAM WHERE name='".$teamname."'";
	$result = mysql_query($query);
	
	while($row = mysql_fetch_array($result)) {
		$teamID = $row["teamID"];
	}
	echo "<br/>" . $teamID . "<br/>";
	
	if($teamID != 0 && $userid != NULL) {
		$query = "INSERT INTO USERTEAM VALUES (".$userid.",".$teamID.",1)";
		echo $query."<br>";
		$result = mysql_query($query);
		echo "<script>location.href='team.php'</script>";
		exit();
	} else {
		echo "Not logged in or failed to find team '".$teamname."'<br>";	
	}
?> 