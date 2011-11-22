<?php

/* ***********************************

		IT391 Commuter Challenge

			Commute Functions

   *********************************** */
 
function setCommuteAsFavorite($userCommuteID)
{
	connectToDatabase();

	$query = "UPDATE USERCOMMUTE SET isFavorite=1 WHERE userCommuteID=".$userCommuteID;
	$result = mysql_query($query);

	disconnectFromDatabase();
	
	if(!$result)
		return false;
	else
		return true;
}
   
function setCommuteAsNotFavorite($userCommuteID)
{
	connectToDatabase();

	$query = "UPDATE USERCOMMUTE SET isFavorite=0 WHERE userCommuteID=".$userCommuteID;
	$result = mysql_query($query);

	disconnectFromDatabase();
	
	if(!$result)
		return false;
	else
		return true;
}

function setOtherCommuteAsNotFavorite($userOtherCommuteID)
{
	connectToDatabase();

	$query = "UPDATE USEROTHERCOMMUTE SET isFavorite=0 WHERE userOtherCommuteID=".$userOtherCommuteID;
	$result = mysql_query($query);

	disconnectFromDatabase();
	
	if(!$result)
		return false;
	else
		return true;
}

function logCommute($userID, $commuteID, $mileage, $isFavorite, $description)
{
	connectToDatabase();
	
	$query = "INSERT INTO USERCOMMUTE (userID,commuteID,mileage,isFavorite,description) VALUES (".$userID.",".$commuteID.",".$mileage.",".$isFavorite.",'".$description."')";
	$result = mysql_query($query);
	
	disconnectFromDatabase();	
		
	if(!$result)
		return false;
	else
		return true;
}

function logCompOnlyCommute($userID, $oCommuteID, $mileage, $isFavorite, $description)
{
	connectToDatabase();
	
	$query = "INSERT INTO USEROTHERCOMMUTE (userID,oCommuteID,mileage,isFavorite,description) VALUES (".$userID.",".$oCommuteID.",".$mileage.",".$isFavorite.",'".$description."')";
	$result = mysql_query($query);
	
	disconnectFromDatabase();	
		
	if(!$result)
		return false;
	else
		return true;
}

function getCommuteTypeValue($commuteID)
{
	connectToDatabase();
	
	$query = "SELECT value FROM COMMUTE WHERE commuteID = ".$commuteID;
	$result = mysql_query($query);
	
	if(!$result)
		return false;
	
	while($row = mysql_fetch_array($result))
	{
		return $row["value"];
	}
	
	disconnectFromDatabase();
	
	return false;	
}

function getOtherCommuteTypeValue($oCommuteID)
{
	connectToDatabase();
	
	$query = "SELECT value FROM OTHERCOMMUTE WHERE oCommuteID = ".$oCommuteID;
	$result = mysql_query($query);
	
	if(!$result)
		return false;
	
	while($row = mysql_fetch_array($result))
	{
		return $row["value"];
	}
	
	disconnectFromDatabase();
	
	return false;	
}

function getCommuteTypeName($commuteID)
{
	connectToDatabase();
	
	$query = "SELECT commtype FROM COMMUTE WHERE commuteID = ".$commuteID;
	$result = mysql_query($query);
	
	if(!$result)
		return false;
	
	while($row = mysql_fetch_array($result))
	{
		return $row["commtype"];
	}
	
	disconnectFromDatabase();
	
	return false;
}

function getOtherCommuteTypeName($oCommuteID)
{
	connectToDatabase();
	
	$query = "SELECT ocommtype FROM OTHERCOMMUTE WHERE oCommuteID = ".$oCommuteID;
	$result = mysql_query($query);
	
	if(!$result)
		return false;
	
	while($row = mysql_fetch_array($result))
	{
		return $row["ocommtype"];
	}
	
	disconnectFromDatabase();
	
	return false;
}

function getOtherCommuteTypeComp($oCommuteID)
{
	connectToDatabase();
	
	$query = "SELECT compID FROM OTHERCOMMUTE WHERE oCommuteID = ".$oCommuteID;
	$result = mysql_query($query);
	
	if(!$result)
		return false;
	
	while($row = mysql_fetch_array($result))
	{
		return $row["compID"];
	}
	
	disconnectFromDatabase();
	
	return false;
}
?>