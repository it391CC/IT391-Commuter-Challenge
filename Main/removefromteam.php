<?php
	// removeFromTeam(POST-userID,POST-teamID)

	$hostname='it391test.db.8404538.hostedresource.com';
	$username='it391test';
	$password='Binoy01';
	$dbname='it391test';
	
	mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
	mysql_select_db($dbname);
	
	$userid = $_POST["usersID"];
	$teamid = $_POST["teamID"];
	
	// Check to see if there are any other spokespersons
	$query = "SELECT * FROM USERTEAM WHERE teamID=".$teamid;
	$result = mysql_query($query);
	$userIsSpokes = 0;
	$numSpokes = 0;
	while($row = mysql_fetch_array($result)) {
		$usersId = $row["userID"];
		$isSpokes = $row["isSpokesperson"];	
		
		if($usersId == $userid && $isSpokes == 1)
			$userIsSpokes = 1;
		
		if($isSpokes == 1)
			$numSpokes = $numSpokes+1;
	}
	//echo "UserIsSpokes= ".$userIsSpokes."<br>NumSpokes= ".$numSpokes."<br>";
	if($userIsSpokes == 1 && $numSpokes == 1) {
		// User cannot leave team if there are no other spokesperson
		echo "<script>location.href='islastspokes.php'</script>";
		exit();
	}

	$query = "DELETE FROM USERTEAM WHERE userID=" . $userid . " AND teamID=" . $teamid;
	$result = mysql_query($query);
	
	echo "<script>location.href='team.php'</script>";
	
?>