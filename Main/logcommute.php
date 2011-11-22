<?php

	// addToTeam(POST-userID,POST-teamID)


	$hostname='it391test.db.8404538.hostedresource.com';
	$username='it391test';
	$password='Binoy01';
	$dbname='it391test';
	
	mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
	mysql_select_db($dbname);
	
	$userid = $_POST["usersID"];
	$commtype = $_POST["commuteType"];
	$dist = $_POST["dist"];
	$desc = $_POST["description"];
	$isFav = 0;
	if($_POST["isfavorite"] == "on")
		$isFav = 1;
	
	echo $commtype."<br>".$dist."<br>".$desc."<br>".$isFav."<br>";
	
	$query = "INSERT INTO USERCOMMUTE (userID,commuteID,mileage,isFavorite,description) VALUES (".$userid.",".$commtype.",".$dist.",".$isFav.",'".$desc."')";
	echo $query."<br>";
	$result = mysql_query($query);
	
	echo "<script>location.href='commutes.php'</script>";
	
		if($_POST["deletefav"]){
			$query = 'UPDATE USERCOMMUTE SET isFavorite=0 WHERE userCommuteID = ' . $_POST["deletefav"]; 
			$result = mysql_query($query);
		}
	exit();
	
?> 