<?php
//Connect To Database
$hostname='it391test.db.8404538.hostedresource.com';
$username='it391test';
$password='Binoy01';
$dbname='it391test';

mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);

?>
<!DOCTYPE html>
<html>
<head>
<title>Commute Types</title>
</head>	
<body>
	<?php
	
	//counter to increment
	$num =1;
	
	//get all commute types from commute table
	$query = 'Select commtype FROM COMMUTE ;';
	$result = mysql_query($query);
				if ($result) {
					while ($row = mysql_fetch_array($result)) {
						$type = $row['commtype'];
						
						//print to screen						
						echo '<div id="comm'.$num.'" >'.$type.'<div><br/>'."\r";
						echo "\r";
						//increment counter
						$num ++;

					}
				}
	//get all commute types from othercommute table			
	$query = 'Select ocommtype FROM OTHERCOMMUTE ;';
	$result = mysql_query($query);
				if ($result) {
					while ($row = mysql_fetch_array($result)) {
						$type = $row['ocommtype'];
												
						//print to screen						
						echo '<div id="comm'.$num.'" >'.$type.'<div><br/>'."\r";
						echo "\r";
						//increment counter
						$num ++;

					}
				}
	?>
</body>	
</html>