<?php

$hostname='it391test.db.8404538.hostedresource.com';
$username='it391test';
$password='Binoy01';
$dbname='it391test';

mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);



?>

<html>
	<head>
		<title>Tables</title>
	</head>
	
	<body>
		
		<?php

		
		
			echo "<h2>BONUS</h2>";
			$query = 'select * from BONUS';
			$result = mysql_query($query);
			if($result)
			{
				echo "<table border='1'>";
				echo "<tr>";
				echo "<th>bonusID</th> <th>compID</th> <th>startDate</th> <th>endDate</th> <th>point</th> <th>description</th>";
				while($row = mysql_fetch_array($result))
				{
					echo "<tr>";
						echo "<td>" . $row['bonusID'] . "</td>";
						echo "<td>" . $row['compID'] . "</td>";
						echo "<td>" . $row['startDate'] . "</td>";
						echo "<td>" . $row['endDate'] . "</td>";
						echo "<td>" . $row['point'] . "</td>";
						echo "<td>" . $row['description'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}		
		
		
			echo "<h2>COMMUTE</h2>";
			$query = 'select * from COMMUTE';
			$result = mysql_query($query);
			if($result)
			{
				echo "<table border='1'>";
				echo "<tr>";
				echo "<th>commuteID</th> <th>commtype</th> <th>value</th>";
				while($row = mysql_fetch_array($result))
				{
					echo "<tr>";
						echo "<td>" . $row['commuteID'] . "</td>";
						echo "<td>" . $row['commtype'] . "</td>";
						echo "<td>" . $row['value'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}


			echo "<h2>COMMUTEBONUS</h2>";
			$query = 'select * from COMMUTEBONUS';
			$result = mysql_query($query);
			if($result)
			{
				echo "<table border='1'>";
				echo "<tr>";
				echo "<th>commBonusID</th> <th>commuteID</th> <th>startDate</th> <th>endDate</th> <th>value</th>";
				while($row = mysql_fetch_array($result))
				{
					echo "<tr>";
						echo "<td>" . $row['commBonusID'] . "</td>";
						echo "<td>" . $row['commuteID'] . "</td>";
						echo "<td>" . $row['startDate'] . "</td>";
						echo "<td>" . $row['endDate'] . "</td>";
						echo "<td>" . $row['value'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}


			echo "<h2>COMPETITION</h2>";
			$query = 'select * from COMPETITION';
			$result = mysql_query($query);
			if($result)
			{
				echo "<table border='1'>";
				echo "<tr>";
				echo "<th>compID</th> <th>startDate</th> <th>endDate</th> <th>compName</th>";
				while($row = mysql_fetch_array($result))
				{
					echo "<tr>";
						echo "<td>" . $row['compID'] . "</td>";
						echo "<td>" . $row['startDate'] . "</td>";
						echo "<td>" . $row['endDate'] . "</td>";
						echo "<td>" . $row['compName'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}


			echo "<h2>DIVISION</h2>";
			$query = 'select * from DIVISION';
			$result = mysql_query($query);
			if($result)
			{
				echo "<table border='1'>";
				echo "<tr>";
				echo "<th>divisionID</th> <th>compID</th> <th>minSize</th> <th>maxSize</th>";
				while($row = mysql_fetch_array($result))
				{
					echo "<tr>";
						echo "<td>" . $row['divisionID'] . "</td>";
						echo "<td>" . $row['compID'] . "</td>";
						echo "<td>" . $row['minSize'] . "</td>";
						echo "<td>" . $row['maxSize'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}


			echo "<h2>OTHERCOMMUTE</h2>";
			$query = 'select * from OTHERCOMMUTE';
			$result = mysql_query($query);
			if($result)
			{
				echo "<table border='1'>";
				echo "<tr>";
				echo "<th>oCommuteID</th> <th>compID</th> <th>ocommtype</th> <th>value</th>";
				while($row = mysql_fetch_array($result))
				{
					echo "<tr>";
						echo "<td>" . $row['oCommuteID'] . "</td>";
						echo "<td>" . $row['compID'] . "</td>";
						echo "<td>" . $row['ocommtype'] . "</td>";
						echo "<td>" . $row['value'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}


			echo "<h2>TEAM</h2>";
			$query = 'select * from TEAM';
			$result = mysql_query($query);
			if($result)
			{
				echo "<table border='1'>";
				echo "<tr>";
				echo "<th>teamID</th> <th>compID</th> <th>name</th>";
				while($row = mysql_fetch_array($result))
				{
					echo "<tr>";
						echo "<td>" . $row['teamID'] . "</td>";
						echo "<td>" . $row['compID'] . "</td>";
						echo "<td>" . $row['name'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}			
			

			echo "<h2>USER</h2>";
			$query = 'select * from USER order by userID';
			$result = mysql_query($query);
			if($result)
			{
				echo "<table border='1'>";
				echo "<tr>";
				echo "<th>userID</th> <th>firstName</th> <th>lastName</th> <th>phone</th> <th>loginEmail</th> <th>prefferedEmail</th> <th>age</th> <th>weight</th> <th>isAdmin</th>";
				echo "</tr>";
				while($row = mysql_fetch_array($result))
				{
					echo "<tr>";
						echo "<td>" . $row['userID'] . "</td>";
						echo "<td>" . $row['firstName'] . "</td>";
						echo "<td>" . $row['lastName'] . "</td>";
						echo "<td>" . $row['phone'] . "</td>";
						echo "<td>" . $row['loginEmail'] . "</td>";
						echo "<td>" . $row['prefferedEmail'] . "</td>";
						echo "<td>" . $row['age'] . "</td>";
						echo "<td>" . $row['weight'] . "</td>";
						echo "<td>" . $row['isAdmin'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			
			
			echo "<h2>USERBONUS</h2>";
			$query = 'select * from USERBONUS';
			$result = mysql_query($query);
			if($result)
			{
				echo "<table border='1'>";
				echo "<tr>";
				echo "<th>userID</th> <th>bonusID</th> <th>bonusDate</th>";
				while($row = mysql_fetch_array($result))
				{
					echo "<tr>";
						echo "<td>" . $row['userID'] . "</td>";
						echo "<td>" . $row['bonusID'] . "</td>";
						echo "<td>" . $row['bonusDate'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}

			
			echo "<h2>USERCOMMUTE</h2>";
			$query = 'select * from USERCOMMUTE';
			$result = mysql_query($query);
			if($result)
			{
				echo "<table border='1'>";
				echo "<tr>";
				echo "<th>userCommuteID</th> <th>userID</th> <th>commuteID</th> <th>commuteDate</th> <th>mileage</th> <th>isFavorite</th> <th>description</th>";
				while($row = mysql_fetch_array($result))
				{
					echo "<tr>";
						echo "<td>" . $row['userCommuteID'] . "</td>";
						echo "<td>" . $row['userID'] . "</td>";
						echo "<td>" . $row['commuteID'] . "</td>";
						echo "<td>" . $row['commuteDate'] . "</td>";
						echo "<td>" . $row['mileage'] . "</td>";
						echo "<td>" . $row['isFavorite'] . "</td>";
						echo "<td>" . $row['description'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			
			
			echo "<h2>USERCOMP</h2>";
			$query = 'select * from USERCOMP';
			$result = mysql_query($query);
			if($result)
			{
				echo "<table border='1'>";
				echo "<tr>";
				echo "<th>compID</th> <th>userID</th>";
				while($row = mysql_fetch_array($result))
				{
					echo "<tr>";
						echo "<td>" . $row['compID'] . "</td>";
						echo "<td>" . $row['userID'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			
					
			echo "<h2>USEROTHERCOMMUTE</h2>";
			$query = 'select * from USEROTHERCOMMUTE';
			$result = mysql_query($query);
			if($result)
			{
				echo "<table border='1'>";
				echo "<tr>";
				echo "<th>userOtherCommuteID</th> <th>userID</th> <th>oCommuteID</th> <th>otherCommuteDate</th> <th>mileage</th> <th>isFavorite</th> <th>description</th>";
				while($row = mysql_fetch_array($result))
				{
					echo "<tr>";
						echo "<td>" . $row['userOtherCommuteID'] . "</td>";
						echo "<td>" . $row['userID'] . "</td>";
						echo "<td>" . $row['oCommuteID'] . "</td>";
						echo "<td>" . $row['otherCommuteDate'] . "</td>";
						echo "<td>" . $row['mileage'] . "</td>";
						echo "<td>" . $row['isFavorite'] . "</td>";
						echo "<td>" . $row['description'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			
			
			echo "<h2>USERTEAM</h2>";
			$query = 'select * from USERTEAM';
			$result = mysql_query($query);
			if($result)
			{
				echo "<table border='1'>";
				echo "<tr>";
				echo "<th>userID</th> <th>teamID</th> <th>isSpokesperson</th>";
				while($row = mysql_fetch_array($result))
				{
					echo "<tr>";
						echo "<td>" . $row['userID'] . "</td>";
						echo "<td>" . $row['teamID'] . "</td>";
						echo "<td>" . $row['isSpokesperson'] . "</td>";
					echo "</tr>";
				}
				echo "</table>";
			}



		?>
		
		
		
		
		
		
	</body>	
</html>
