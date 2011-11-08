<?php
//Connect To Database
$hostname='it391test.db.8404538.hostedresource.com';
$username='it391test';
$password='Binoy01';
$dbname='it391test';

mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);

//Get userID using email
if (isset($_GET['email'])) {
	$email = $_GET['email'];
	
	$query = 'SELECT userid FROM USER where loginemail = ' . "'" . $email . "'";
				$result = mysql_query($query);
				if ($result) {
					while ($row = mysql_fetch_array($result)) {
						$id = $row['userid'];

					}
				}

	
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Favorite Commutes</title>
</head>	
<body>
	<?php

	// select all user commutes for a given user id
	$query = 'Select * FROM USERCOMMUTE WHERE isFavorite=1 AND userID ='.$id;
	$result = mysql_query($query);
				if ($result) {
					while ($row = mysql_fetch_array($result)) {
						$desc = $row['description'];
						$miles = $row['mileage'];
						$cid = $row['commuteID'];


						//print results to page
						echo '<div id="favorite">'."\r";	
						echo '<div id="type" >'.$type.'</div>'."\r";
						echo '<div id="desc" >'.$desc.'</div>'."\r";
						echo '<div id="miles" >'.$miles.'</div>'."\r";
						echo '</div>'."\r";	
						echo "\r";
					}
				}
	?>
</body>	
</html>