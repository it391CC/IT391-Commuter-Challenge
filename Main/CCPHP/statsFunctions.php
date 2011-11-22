<?php

/* ***********************************

		IT391 Commuter Challenge

			Statistics Functions

   *********************************** */
 
  function printTopTenUsers()
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

  function printTopTenTeams()
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

  function graphTransportationRankings()
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
  
 ?>
