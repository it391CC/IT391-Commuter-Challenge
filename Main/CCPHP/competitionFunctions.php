<?php

/* ***********************************

		IT391 Commuter Challenge

			Team Functions

   *********************************** */
function removeUserFromCompetition($userID, $compID)
{
	connectToDatabase();	
	$query = "DELETE FROM USERCOMP WHERE compID=" . $compID . " AND userID=" . $userID;
	$result = mysql_query($query);
	disconnectFromDatabase();
	return $result;		
}
 
function addUserToCompetition($userID, $compID)
{
	connectToDatabase();	
	$query = "INSERT INTO USERCOMP (compID,userID) VALUES ('". $compID ."','".$userID."')";
	$result = mysql_query($query);
	disconnectFromDatabase();
	return $result;
}

function isUserInCompetition($userID,$compID)
{
	connectToDatabase();
	$query = "SELECT * FROM USERCOMP WHERE userID=".$userID;
	$result = mysql_query($query);
	disconnectFromDatabase();
	
	while($row = mysql_fetch_array($result))
	{
		$uCompID = $row["compID"];
		if($uCompID == $compID)
			return true;
	}
	return false;
}

function createCompetition($startDate,$endDate,$compName)
{
	connectToDatabase();	
	$query = "INSERT INTO COMPETITION (startDate,endDate,compName) VALUES ('". $startDate ."','".$endDate."','".$compName."')";
	$result = mysql_query($query);
	disconnectFromDatabase();
	return $result;	
}

function getCompName($compID)
{
	connectToDatabase();
	
	$query = "SELECT compName FROM COMPETITION WHERE compID=".$compID;
	$result = mysql_query($query);
	$compName = "";
	
	disconnectFromDatabase();
	
	while($row = mysql_fetch_array($result))
	{
		$compName = $row["compName"];
	}
	
	return $compName;		
}

?>