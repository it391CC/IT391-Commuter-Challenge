<?php

/* ***********************************

		IT391 Commuter Challenge

			User Functions

   *********************************** */

function getUserFullName($userID)
{
	return getUserFirstName($userID)." ".getUserLastName($userID);
}

function getUserFirstName($userID)
{
	connectToDatabase();	
	$query = "SELECT * FROM USER WHERE userID=".$userID;
	$result = mysql_query($query);
	$userFirst = "";
	disconnectFromDatabase();
	while($row = mysql_fetch_array($result)) {
		$userFirst = $row["firstName"];
	}
	return $userFirst;	
}

function getUserLastName($userID)
{
	connectToDatabase();	
	$query = "SELECT * FROM USER WHERE userID=".$userID;
	$result = mysql_query($query);
	$userLast = "";
	disconnectFromDatabase();
	while($row = mysql_fetch_array($result)) {
		$userLast = $row["lastName"];
	}
	return $userLast;		
}

function getUserTotalPoints($userID)
{
	// Regular commutes
	connectToDatabase();
	
	$query = "SELECT commuteID,mileage FROM USERCOMMUTE WHERE userID=".$userID;
	$result = mysql_query($query);
	$totalDist = 0;
	
	disconnectFromDatabase();
	
	while($row = mysql_fetch_array($result))
	{
		$commuteID = $row["commuteID"];
		$mileage = $row["mileage"];
		$value = getCommuteTypeValue($commuteID);
		$totalDist += ($mileage * $value);
	}
	
	// Other commutes
	connectToDatabase();
	
	$query2 = "SELECT oCommuteID,mileage FROM USEROTHERCOMMUTE WHERE userID=".$userID;
	$result2 = mysql_query($query2);
	
	disconnectFromDatabase();
	
	while($row2 = mysql_fetch_array($result2))
	{
		$oCommuteID = $row2["oCommuteID"];
		$mileage = $row2["mileage"];
		$value = getOtherCommuteTypeValue($oCommuteID);
		$totalDist += ($mileage * $value);
	}
	
	return $totalDist;
}

?>