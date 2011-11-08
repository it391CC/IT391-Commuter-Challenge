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


$email = $_SESSION['user'];
$admin = $_SESSION['admin'];

$query = 'SELECT userID FROM USER where loginEmail = ' . "'" . $email . "';";
$result = mysql_query($query);
				if ($result) {
					while ($row = mysql_fetch_array($result)) {
						
						$id = $row['userID'];
						//echo $id;

					}
				}
				
$query = 'Select isSpokesperson from USERTEAM where userID= ' .$id;
$sesSpoke = mysql_query($query);
				
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
							<a href="team.php"id="active">Teams</a>
						</li>
						<!-- <li>
							<a href="admin.php" >Administration</a>
						</li> -->
						
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
					<table class="testimonial"><tr><td>
				<?php
								echo "<h3>Join a Team</h3><br>";								
								echo "<form name='addToTeam' action='addtoteam.php' method='post'>";
								echo "<input type='hidden' name='usersID' value=".$id.">";
								echo "<center><select name='teamName'>";
								$query = "SELECT * FROM TEAM";
								$result = mysql_query($query);
								while($row = mysql_fetch_array($result))
								{
									$name = $row["name"];
									echo "<option value='".$name."'>".$name."</option>";
								}
								echo "</select>";
								echo "<br><input type='submit' value='Join'></center><br>";
								echo "</form>";
								echo "<center>OR</center><br><form name='createTeam' action='createteam.php' method='post'>";
								echo "<h3>Create a Team</h3><br>Name: <input type='text' name='teamName'><br>";
								echo "<input type='hidden' name='usersID' value=".$id.">";
								echo "To Participapte In:";
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
								echo "<br/>";
								echo "<center><input type='submit' value='Create Team'></center>";
								echo "</form>";
				?>	
	</td></tr></table>
			</div><!-- cA -->
			<div id="content">
				<div id="cB">
					<div class="Ctopright"></div>
	<div id="cB1">
				<h3>Your Team Information</h3>
				<div class="news">
					
                    <!-- MY TEAM INFORMATION -->
                    <?php
						//echo "EMAIL: '".$id."'<br>";
						if($id != "")
						{
							//echo 'My userID is '.$id.'<br>';
							
							$query = "SELECT teamID from USERTEAM WHERE userID=".$id;
							$result = mysql_query($query);
							
							if(mysql_num_rows($result)==0) {
								echo "<b>You are not currently on any teams!</b><br>";	
							}
							
							while($row = mysql_fetch_array($result)){
								
								$teamID = $row["teamID"];
								//echo $teamID . "<br>";
							
								$query = "SELECT name FROM TEAM WHERE teamID=".$teamID;
								$result2 = mysql_query($query);
								while($row = mysql_fetch_array($result2)) {
									$teamName = $row["name"];	
								}
								
								echo "<center><h1>".$teamName."</h1></center><br>";
								//echo "Total Points: <i>[TODO: Place Team Points]</i><br><br>";
								echo "Total Points: <h2>551</h2><br><br>";
								echo "<br/>";
								
								
								echo "Other users on your team: <br/>";
								$query = "SELECT * FROM USERTEAM WHERE teamID=".$teamID;
								$result3 = mysql_query($query);
								echo "<ol>";
								while($row = mysql_fetch_array($result3)) {
									$userID = $row["userID"];
									$isSpokes = $row["isSpokesperson"];
									$query = "SELECT * FROM USER WHERE userID=".$userID;
									$result4 = mysql_query($query);
									while($row = mysql_fetch_array($result4)) {	
										$fName = $row["firstName"];
										$lName = $row["lastName"];
										//$isAdmin = $row["isAdmin"];
										
										if($sesSpoke) {
											if($isSpokes){
												$button = '<input type="button" value="Already Spokesperson" disabled="disabled" />';
											}else{
												$cmsg = "Are you sure you want to promote ".$flName." to spokesperson?";
												$form = '<form action="promotespokesperson.php" method="post" onsubmit="return confirm('.$cmsg.')" >';
												$input1 = '<input type="hidden" name="user" value="'.$userID.'" />';
												$input2 = '<input type="hidden" name="team" value="'.$teamID.'" />';
												$sub = '<input type="submit" value="Promote to Spokesperson" />';
												$closeform = '</form>';	
												$button = $form.$input1.$input2.$sub.$closeform;
											}
										}else{
											$button = "";
										}
										if($isSpokes)
											echo "<b>";
										echo "<li>".$fName." ".$lName." ".$button."</li>";
										if($isSpokes)
											echo "</b>";
									}
								}
								
								echo "</ol><br/>";
								echo "<form name='removeFromTeam' action='removefromteam.php' method='post'>";
								echo "<input type='hidden' name='usersID' value='" . $id . "'>";
								echo "<input type='hidden' name='teamID' value='" . $teamID . "'>";
								echo "<input type='submit' value='Leave Team'>";
								echo "</form>";
								
								}
								echo "<br><br><i>*Note: Team spokespersons names are in bold.</i><br>";
							
						}
						else
						{
							// User is not logged in.
							echo 'You need to be logged in to view teams!<br>';
						}
					?>
                    
				</div>
			</div><!-- cB1 -->
			<div id="cB2">
				&nbsp;<br/>
				<div class="about">
					
                    <center><h3>Teams</h3></center><br>
                    <?php
						$query = "SELECT * FROM TEAM";
						$result = mysql_query($query);
						echo "<ol>";
						while($row = mysql_fetch_array($result)) {
							$teamName = $row["name"];
							echo "<li>".$teamName."</li>";
						}
						echo "</ol>";
					?>
                                        
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
	</body>
	<!--Sends user back to home page if not logged in-->
	<?php if (!$_SESSION['loggedin']){
	?>
	<meta HTTP-EQUIV="REFRESH" content="0; url=http://limbotestserver.com">
	<?php }?>
</html>
