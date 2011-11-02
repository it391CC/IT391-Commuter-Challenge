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
	//counter to increment
	$num =1;
	
	// select all user commutes for a given user id
	$query = 'Select * FROM USERCOMMUTE WHERE isFavorite=1 AND userID ='.$id;
	$result = mysql_query($query);
				if ($result) {
					while ($row = mysql_fetch_array($result)) {
						$desc = $row['description'];
						$miles = $row['mileage'];
						
						//print results to page
						echo '<div id="desc'.$num.'" >'.$desc.'<div><br/>'."\r";
						echo '<div id="miles'.$num.'" >'.$miles.'<div><br/>'."\r";
						echo "\r";
						//increment counter
						$num ++;

					}
				}
	?>
</body>	
</html>