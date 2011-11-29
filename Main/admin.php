<?php

//Session
session_start();

//Connect To Database
$hostname='it391test.db.8404538.hostedresource.com';
$username='it391test';
$password='Binoy01';
$dbname='it391test';

mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);

$admin = $_SESSION['admin'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Green Commute Challenge</title>
		<link rel="stylesheet" href="style.css" />
		<link rel="stylesheet" href="calendar/calendar.css" />
		<script language="javascript" src="calendar/calendar.js"></script>
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript">
			function confirmDelete(msg){
				return confirm('Are you sure you want to delete the team' + msg); 
			}
		</script>
	</head>
	<body>
		<div id="daddy">
			<div id="header">
				<div id="logo">
					<a href="./"><img src="images/logo.gif" alt="Your Company Logo" width="318" height="85" /></a><span id="logo-text"><a href="./"></a></span>
				</div><!-- logo -->
				<div id="menu">
					<ul>
						<li>
							<a href="index.php" >Home</a>
						</li>
						<li>
							<a href="profile.php">Profile</a>
						</li>
						<li>
							<a href="competition.php" >Challenges</a>
						</li>
						<li>
							<a href="commutes.php" >Commutes</a>
						</li>
						<li>
							<a href="team.php">Teams</a>
						</li>
						<li>
							<a href="admin.php" id="active">Administration</a>
						</li>
						
					</ul>
				</div><!-- menu -->
				<div id="headerimage">
					<div id="slogan"></div>
				</div>
				<!-- headerimage -->
			</div>
			<!-- header -->
			<div id="cA">
				<div class="Ctopleft"></div>

				<p>
						<h3>Add Custom Commute Type</h3>
					<form name="customcommute" action="<?=$config['baseurl . competition.php']?>" method="post">
						&nbsp;Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="text" id="ccname" name="ccname"/>
								<br /><br />
								&nbsp;Point Value:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="ccvalue" name="ccvalue"/><br/><br />
						
						&nbsp;Competition:&nbsp;&nbsp;
						<?php
						echo "<select name='compID'>";
								$query = "SELECT * FROM COMPETITION";
								$result = mysql_query($query);
								while($row = mysql_fetch_array($result))
								{
									$name = $row["compName"];
									$compID = $row["compID"];
									echo "<option value='".$compID."'>".$name."</option>";
								}
								echo "</select>";
								?>
								<br/><br />
								&nbsp;<input type="submit" value="Create"/>
					</form>	
				</p>
				
				<br/><?php if($admin==1){?>
				<p>
					<h3>Add Bonus for Competition</h3>
					<form name="bonus" action="admin.php" method="post">
						<!--		&nbsp;Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="text" id="bName" name="bName"/>
								<br /><br /> -->
								&nbsp;Description:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="bDesc" name="bDesc"/><br/><br />
								&nbsp;Point Value:&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="bValue" name="bValue"/><br/><br />
								&nbsp;Competition: &nbsp;
								<?php
									echo "<select name='compID2'>";
									$query = "SELECT * FROM COMPETITION";
									$result = mysql_query($query);
									while($row = mysql_fetch_array($result))
									{
										$name = $row["compName"];
										$compID = $row["compID"];
										echo "<option value='".$compID."'>".$name."</option>";
									}
									echo "</select>";
								?>
								<br/><br />
								&nbsp;Start Date: &nbsp;<br/>
						<?php 
							require_once('calendar/classes/tc_calendar.php');
							$myCalendar = new tc_calendar("date3",true);
							$myCalendar->setIcon("calendar/images/iconCalendar.gif");
	 						//$myCalendar->setDate(01, 03, 1960);
							$myCalendar->setPath("calendar/");
							$myCalendar->setYearInterval(2011,2015);
							$myCalendar->dateAllow('2011-01-01', '2015-03-01');							
							$myCalendar->writeScript();
						?>
							<br/><br/>
							&nbsp;End Date: &nbsp;
						<?php 
							require_once('calendar/classes/tc_calendar.php');
							$myCalendar = new tc_calendar("date4",true);
							$myCalendar->setIcon("calendar/images/iconCalendar.gif");
							$myCalendar->setPath("calendar/");
							$myCalendar->setYearInterval(2011,2015);
							$myCalendar->dateAllow('2011-01-01', '2015-03-01');							
							$myCalendar->writeScript();
						?>	
						<br/><br/><br/><br/>
						<input type="submit" value="Create" />						
					</form>
				</p>
				
				<?php
// Post Bonus
					if (isset($_POST['bDesc'])) {
							//$name= $_POST['bName'];
							$cid = $_POST['compID2'];
							$date3 = isset($_REQUEST["date3"]) ? $_REQUEST["date3"] : "";
							$date4 = isset($_REQUEST["date4"]) ? $_REQUEST["date4"] : "";
							$point = $_POST['bValue'];
							$desc = $_POST['bDesc'];
							$query = 'INSERT INTO BONUS (compID,startDate,endDate,point,description) VALUES ("'.$cid.'","'.$date3.'","'.$date4.'","'.$point.'","'.$desc.'");';
							$result = mysql_query($query);
							//print "<br/><br/><b>New challenge entered succefully!!</b><br/>Name:&nbsp;&nbsp;".$name."<br/>Start:&nbsp;&nbsp;&nbsp;".$date1."<br/>End:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$date1;
						}
					?>
	<?php }?>
				
				<?php
// Post Challenge
					if (isset($_POST['ccvalue'])) {
							$ccname= $_POST['ccname'];
						    $ccvalue = $_POST['ccvalue'];
							$cid = $_POST['compID'];

							$query = 'INSERT INTO OTHERCOMMUTE (ocommtype,value,compID) VALUES ("'.$ccname.'",'.$ccvalue.','.$cid.');';
							//echo $query;
							$result = mysql_query($query);
							//print "<br/><br/><b>New challenge entered succefully!!</b><br/>Name:&nbsp;&nbsp;".$name."<br/>Start:&nbsp;&nbsp;&nbsp;".$date1."<br/>End:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$date1;
						}
					?>
					
				<br />
					<h3>Add Special Promotion</h3>
					<form name="promotion" action="<?=$config['baseurl . competition.php']?>" method="post">
						&nbsp;Commute:&nbsp;&nbsp;
						<?php
						echo "<select name='commuteID'>";
								$query = "SELECT * FROM COMMUTE";
								$result = mysql_query($query);
								while($row = mysql_fetch_array($result))
								{
									$type = $row["commtype"];
									$commuteID = $row["commuteID"];
									echo "<option value='".$commuteID."'>".$type."</option>";
								}
								echo "</select>";
								?>
								<br /><br />
								&nbsp;Value:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="cbvalue" name="cbvalue"/><br/><br />

								&nbsp;Start Date:<br/>
								<?php
									//get class into the page
									require_once('calendar/classes/tc_calendar.php');
								
									  $myCalendar = new tc_calendar("date3", true);
									  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
									  $myCalendar->setPath("calendar/");
									  $myCalendar->setYearInterval(2011, 2015);
									  $myCalendar->dateAllow('2011-01-01', '2015-03-01');
									  $myCalendar->writeScript();
								
								?>
								<br/><br />
								&nbsp;End Date:<br/>
								<?php
									//get class into the page
									require_once('calendar/classes/tc_calendar.php');
									
									  $myCalendar = new tc_calendar("date4", true);
									  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
									  $myCalendar->setPath("calendar/");
									  $myCalendar->setYearInterval(2011, 2015);
									  $myCalendar->dateAllow('2011-01-01', '2015-03-01');
									  $myCalendar->writeScript();
								?>
								
								<br /><br />&nbsp;<input type="submit" value="Create"/>
					</form>	
				</p>
				<?php
					// Post Challenge
					if (isset($_POST['cbvalue']))
					{
						    $cbvalue = $_POST['cbvalue'];
							$commid = $_POST['commuteID'];
							$date3 = isset($_REQUEST["date3"]) ? $_REQUEST["date3"] : "";
							$date4 = isset($_REQUEST["date4"]) ? $_REQUEST["date4"] : "";
							$cbvalue = $_POST['cbvalue'];

							$query = 'INSERT INTO COMMUTEBONUS (commuteID,startDate,endDate,value) VALUES ('.$commid.',"'.$date3.'","'.$date4.'",'.$cbvalue.');';
							
							//echo $query;
							$result = mysql_query($query);
							//print "<br/><br/><b>New challenge entered succefully!!</b><br/>Name:&nbsp;&nbsp;".$name."<br/>Start:&nbsp;&nbsp;&nbsp;".$date1."<br/>End:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$date1;
					}
				?>
				
				
			</div><!-- cA -->
			<div id="content">
				<div id="cB">
					<div class="Ctopright"></div>
					<div id="cB1">
						<h3>Create New Challenge</h3>
						<div style="height: 300px" class="news">
						<?php if($admin==1) {
							?>
						
							<form name="competition" action="<?=$config['baseurl . competition.php']?>" method="post">
								Name: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="text" id="name" name="name"/>
								<br /><br />
								Start Date:&nbsp;&nbsp;<br/>
								<?php
//get class into the page
require_once('calendar/classes/tc_calendar.php');

	  $myCalendar = new tc_calendar("date1", true);
	  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
	  $myCalendar->setPath("calendar/");
	  $myCalendar->setYearInterval(2011, 2015);
	  $myCalendar->dateAllow('2011-01-01', '2015-03-01');
	  $myCalendar->writeScript();

?>

								<br/><br />
								End Date:&nbsp;&nbsp;&nbsp;&nbsp;<br/>
								<?php
//get class into the page
require_once('calendar/classes/tc_calendar.php');

	  $myCalendar = new tc_calendar("date2", true);
	  $myCalendar->setIcon("calendar/images/iconCalendar.gif");
	  $myCalendar->setPath("calendar/");
	  $myCalendar->setYearInterval(2011, 2015);
	  $myCalendar->dateAllow('2011-01-01', '2015-03-01');
	  $myCalendar->writeScript();

?>
			<br/><br/>
								</p>
								<input type="submit" value="Create"/>
							</form>
<?php
// Post Challenge
					if (isset($_POST['name'])) {
							$name= $_POST['name'];
							$date1 = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
							$date2 = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
							$query = 'INSERT INTO COMPETITION (startDate,endDate,compName) VALUES ("'.$date1.'","'.$date2.'","'.$name.'");';
							$result = mysql_query($query);
							//print "<br/><br/><b>New challenge entered succefully!!</b><br/>Name:&nbsp;&nbsp;".$name."<br/>Start:&nbsp;&nbsp;&nbsp;".$date1."<br/>End:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$date1;
						}
					?>
	<?php }?>
	<?php if($admin==0) {
							?>
							<?php print "Please log in as an administrative user"?>
							<?php }?>				
						</div>
					
					</div><!-- cB1 -->
					<div id="cB2">
					&nbsp;<br/>
						<div class="about">
						 <center><h3>Competitions</h3></center><br>
	
                    <?php
						$query = "SELECT compName FROM COMPETITION";
						$result = mysql_query($query);
						echo "<ol>";
						while($row = mysql_fetch_array($result)) {
							$compName = $row["compName"];
							echo "<li>".$compName."</li>";
						}
						echo "</ol>";
					?>
					<br/>
					<hr/>
					 <center><h3>Teams</h3></center><br>
					 <?php
						$query = "SELECT teamID,name FROM TEAM";
						$result = mysql_query($query);
						echo "<ol>";
						while($row = mysql_fetch_array($result)) {
							$teamID = $row["teamID"];	
							$teamName = $row["name"];
							
							echo '<li>'.$teamName.'  <form name="delete" action="deleteteam.php" method="post" onsubmit="return confirmDelete('.$teamName.');">
							<input type="hidden" name="team" value="'. $teamID .'" /><input type="submit" value="Delete Team" />
							</form></li>';
						}
						echo "</ol>";
					?>
					<br/>
					<hr/>
					<center><h3>Bonuses</h3></center><br/>
					<?php
						$query = "SELECT description FROM BONUS";
						$result = mysql_query($query);
						echo "<ol>";
						while($row = mysql_fetch_array($result)) {
							$desc = $row["description"];
							echo '<li>'.$desc.'</li>';
						}
						echo "</ol>";						
					?><br/>
						</div>
					</div><!-- cB2 -->
				</div><!-- cB -->
				<div class="Cpad">
					<br class="clear" />
					<div class="Cbottomleft"></div><div class="Cbottom"></div><div class="Cbottomright"></div>
				</div><!-- Cpad -->
			</div><!-- content -->
			<div id="properspace"></div><!-- properspace -->
			<!-- Place this render call where appropriate -->
		</div><!-- daddy -->
		<div id="footer">
			<div id="foot">
				<div id="foot1">
					<a href="./">it391project@gmail.com</a> - <a href="./"></a>
				</div><!-- foot1 -->
				<div id="foot2">
					Copyright Fall 2011 IT391 Designed by <a href="http://groups.google.com/group/itk391fall2011/about?hl=en" title="it391">Google Group IT391<span class="star">*</span></a>
					<script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>
				</div><!-- foot1 -->
			</div><!-- foot -->
		</div><!-- footer -->
		<!-- needed to log out of google -->
		<iframe id="myIFrame" width="0" height="0" ></iframe>
	</body>
	<!--Sends user back to home page if not logged in-->
	<?php if (!$_SESSION['loggedin']){
	?>
	<meta HTTP-EQUIV="REFRESH" content="0; url=http://limbotestserver.com">
	<?php }?>
</html>
