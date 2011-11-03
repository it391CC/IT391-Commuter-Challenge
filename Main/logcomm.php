<?php
//Connect To Database
$hostname='it391test.db.8404538.hostedresource.com';
$username='it391test';
$password='Binoy01';
$dbname='it391test';

mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);

	$miles = $_GET['miles'];
	$desc = $_GET['desc'];
	$fav = $_GET['fav'];
	
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
<title>Log Commutes</title>
</head>	
<body>
	<?php
							$query = 'INSERT INTO USERCOMMUTE (userID,commuteDate,mileage,isFavorite,description)  VALUES(' . $id . ',' . 'CURRENT_TIMESTAMP' . ',' . $miles . ','.$fav.',' . '"' . $desc . '"' . ')';
							echo $query;
							$result = mysql_query($query);
	?>
</body>	
</html>