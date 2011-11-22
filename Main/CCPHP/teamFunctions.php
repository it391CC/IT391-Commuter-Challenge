<?php

/* ***********************************

		IT391 Commuter Challenge

			Team Functions

   *********************************** */
   
function getTeamTotalPoints($teamID)
{
	connectToDatabase();	
	$query = "SELECT userID FROM USERTEAM WHERE teamID=".$teamID;
	$result = mysql_query($query);
	$numPoints = 0;
	disconnectFromDatabase();
	while($row = mysql_fetch_array($result)) {
		$oUserID = $row["userID"];
		$oUserPoints = getUserTotalPoints($oUserID);
		$numPoints += $oUserPoints;
	}
	return $numPoints;	
}
 
function getNumSpokespersons($teamID)
{
	connectToDatabase();	
	$query = "SELECT isSpokesperson FROM USERTEAM WHERE teamID=".$teamID;
	$result = mysql_query($query);
	$numSpokes = 0;
	disconnectFromDatabase();
	while($row = mysql_fetch_array($result)) {
		$isSpokesperson = $row["isSpokesperson"];
		if($isSpokesperson == 1)
			$numSpokes++;
	}
	return $numSpokes;	
}

function removeUserFromTeam($userID, $teamID)
{
	connectToDatabase();	
	$query = "DELETE FROM USERTEAM WHERE userID=" . $userID . " AND teamID=" . $teamID;
	$result = mysql_query($query);
	disconnectFromDatabase();
	
	if(!$result)
		return false;
	else
		return true;
}

function isUserSpokesperson($userID,$teamID)
{
	connectToDatabase();
	
	$query = "SELECT isSpokesperson FROM USERTEAM WHERE userID=".$userID." AND teamID=".$teamID;
	$result = mysql_query($query);
	$isSpokes = 0;
	
	while($row = mysql_fetch_array($result))
	{
		if($row["isSpokesperson"] == 1)
			$isSpokes = 1;
	}
	
	disconnectFromDatabase();
	
	return $isSpokes;
}

function setUserAsSpokesperson($userID,$teamID)
{
	connectToDatabase();	
	$query = "UPDATE USERTEAM SET isSpokesperson= 1 WHERE userID=".$userID." AND teamID=".$teamID;
	$result = mysql_query($query);
	disconnectFromDatabase();

	if(!$result)
		return false;
	else
		return true;
}

function setUserAsNotSpokesperson($userID,$teamID)
{
	connectToDatabase();	
	$query = "UPDATE USERTEAM SET isSpokesperson=0 WHERE userID=".$userID." AND teamID=".$teamID;
	$result = mysql_query($query);
	disconnectFromDatabase();

	if(!$result)
		return false;
	else
		return true;	
}

function getTeamName($teamID)
{
	connectToDatabase();
	
	$query = "SELECT name FROM TEAM WHERE teamID=".$teamID;
	$result = mysql_query($query);
	$teamName = "";
	
	while($row = mysql_fetch_array($result))
	{
		$teamName = $row["name"];
	}
	
	disconnectFromDatabase();
	
	return $teamName;	
}

function isUserOnTeamInComp($userID,$compID)
{
	connectToDatabase();	
	$query = "SELECT teamID FROM TEAM WHERE compID=".$compID;
	$result = mysql_query($query);
	$isInComp = false;
	disconnectFromDatabase();
	while($row = mysql_fetch_array($result)) {
		$teamID = $row["teamID"];
		if(isUserOnTeam($userID,$teamID))
			$isInComp = true;
	}
	return $isInComp;	
}

function isUserOnTeam($userID,$teamID)
{
	connectToDatabase();	
	$query = "SELECT userID FROM USERTEAM WHERE teamID=".$teamID;
	$result = mysql_query($query);
	$isOnTeam = false;
	disconnectFromDatabase();
	while($row = mysql_fetch_array($result)) {
		$oUserID = $row["userID"];
		if($oUserID == $userID)
			$isOnTeam = true;
	}
	return $isOnTeam;		
}

function getTeamCompID($teamID)
{
	connectToDatabase();
	
	$query = "SELECT compID FROM TEAM WHERE teamID=".$teamID;
	$result = mysql_query($query);
	$compID = 0;
	
	while($row = mysql_fetch_array($result))
	{
		$compID = $row["compID"];
	}
	
	disconnectFromDatabase();
	
	return $compID;	
}
   
function getTeamID($teamName)
{
	connectToDatabase();
	
	$query = "SELECT teamID FROM TEAM WHERE name='".$teamName."'";
	$result = mysql_query($query);
	$teamID = 0;
	
	while($row = mysql_fetch_array($result))
	{
		$teamID = $row["teamID"];
	}
	
	disconnectFromDatabase();
	
	return $teamID;
}
 
function createTeam($compID, $teamName)
{
	connectToDatabase();
	
	$query = "INSERT INTO TEAM (compID,name) VALUES (".$compID.",'".$teamName."')";
	$result = mysql_query($query);
	
	disconnectFromDatabase();
	
	if(!$result)
		return false;
	else
		return true;	
}
 
function addUserToTeam($userID, $teamID, $isSpokesperson)
{
	connectToDatabase();
	
	$query = "INSERT INTO USERTEAM (userID,teamID,isSpokesperson) VALUES (".$userID.",".$teamID.",".$isSpokesperson.")";
	$result = mysql_query($query);
	
	disconnectFromDatabase();
	
	if(!$result)
		return false;
	else
		return true;
}

?>