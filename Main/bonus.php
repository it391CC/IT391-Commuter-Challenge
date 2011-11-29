<?php

	//Connect To Database
$hostname='it391test.db.8404538.hostedresource.com';
$username='it391test';
$password='Binoy01';
$dbname='it391test';

mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);

    $bid = $_GET['bonusID'];
	
	$query = 'SELECT * from BONUS WHERE bonusID='.$bid;
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result)){
	$sdate = $row['startDate'];			
	$edate = $row['endDate'];
	$points = $row['point'];	
	$point = '<br/><br/>Value: <input type="text" name="value" value="'.$points.'" readonly="readonly" /><br/><br/>';
	echo "Date: <br/>";
	
	
	  require_once('calendar/classes/tc_calendar.php');
	  $myCalendar = new tc_calendar('date2', true);
	  $myCalendar->setIcon('calendar/images/iconCalendar.gif');
	  $myCalendar->setPath('calendar/');
	//$myCalendar->setDateFormat('Y-m-d');
	  $myCalendar->setYearInterval(2011, 2015);
	//$myCalendar->dateAllow($sdate, $edate, false);
	  $myCalendar->writeScript();	   
		  
	$datein = '<input type="hidden" name="date123" value="1234-11-11" />';
	  
	$submit = ' <input type="submit" value="Log Bonus" />';
	$response = $point.$datein.$submit;
	echo $response;
	}
?>