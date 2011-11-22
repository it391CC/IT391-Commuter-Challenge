<?php

session_start();

require("php_functions.php");

$userID = getUserID();
$isAdmin = isUserAdmin();

$message = "";
$message2 = "";

if(isset($_POST["doAddToTeam"]))
{
	$teamID = $_POST["teamID"];
	$compID = getTeamCompID($teamID);
	
	// Validation
	$valid = true;
	if(isUserOnTeamInComp($userID,$compID)) {
		$message = "You are already on a team in this competition!";
		$valid = false;	
	}
	
	if($valid) {
		if(!addUserToTeam($userID, $teamID, 0)) {
			echo "Could not join team.";	
		}
	}
}

if(isset($_POST["doCreateTeam"]))
{
	$compID = $_POST["compID"];
	$teamName = $_POST["teamName"];
	
	// Validation
	$valid = true;
	if(isUserOnTeamInComp($userID,$compID)) {
		$message = "You are already on a team in this competition!";
		$valid = false;	
	}
	if(strlen($teamName) > 50)
	{
		$message = "Team names can be a maximum of 50 characters";
		$valid = false;	
	}
	
	if($valid) {
		if(!createTeam($compID, $teamName)) {
			echo "Could not create team!";	
		} else {
			$teamID = getTeamID($teamName);
			if(!addUserToTeam($userID,$teamID,1)) {
				echo "Was able to create team, but not add user to it!";	
			}
		}
	}
}

if(isset($_POST["doRemoveFromTeam"]))
{
	$teamID = $_POST["teamID"];
	
	$valid = true;
	if(isUserSpokesperson($userID,$teamID) && getNumSpokespersons($teamID) == 1) {
		$message2 = $message2."You cannot leave a team if you are the last spokesperson!<br>Please promote someone else to be spokesperson before you leave.<br>";
		$valid = false;
	}
	
	if($valid)
	{
		if(!removeUserFromTeam($userID,$teamID)) {
			echo "Was unable to remove user from team.";	
		}
	}
}

if(isset($_POST["doSetUserSpokesperson"]))
{
	$oUserID = $_POST["userID"];
	$teamID = $_POST["teamID"];
	
	$valid = true;
	if(!isUserSpokesperson($userID,$teamID)) {
		$message2 = $message2."You cannot make someone else a spokesperson unless you are a spokesperson!";
		$valid = false;
	}
	
	if($valid)
	{
		if(!setUserAsSpokesperson($oUserID,$teamID)) {
			echo "Was unable to set user as spokesperson.";	
		}
	}
}
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
		<!-- pop up window library (from Google) -->
		<script type="text/javascript" src="popuplib.js"></script>
		
		<script type="text/javascript">
			function subconfirm(cmsg){
				var answer = confirm(cmsg);
				if (answer)
					return true;
				else false;	
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
                    
                    <h3>Join a Team</h3><br>
                    <center><form name="addtoteam" action="team.php" method="post">
                    <input type="hidden" name="doAddToTeam" value="true">
                    <select name="teamID">
                    <?php
                        connectToDatabase();
                        
                        $query = "SELECT * FROM TEAM";
                        $result = mysql_query($query);
                        while($row = mysql_fetch_array($result))
                        {
                            $teamID = $row["teamID"];
                            $name = $row["name"];
                            echo "<option value=".$teamID.">".$name."</option>";
                        }
                        
                        disconnectFromDatabase();
                    ?>
                    </select><br>
                    <input type="submit" value="Join Team"><br>
                    </form></center>
                    <center><br>OR<br></center>
                    <form name="createateam" action="team.php" method="post">
                    <h3>Create a Team</h3><br>
                    <input type="hidden" name="doCreateTeam" value="true">
                    Name: <input type="text" name="teamName"><br>
                    To Participate In: <select name="compID">
                    <?php
                        connectToDatabase();
                        
                        $query = "SELECT * FROM COMPETITION";
                        $result = mysql_query($query);
                        while($row = mysql_fetch_array($result))
                        {
                            $compID = $row["compID"];
                            $compName = $row["compName"];
                            echo "<option value=".$compID.">".$compName."</option>";
                        }
                        
                        disconnectFromDatabase();
                    ?>
                    </select>
                    <center><input type="submit" value="Create Team!"></center>
                    </form>
                    <br><center><b><?php echo $message; ?></b></center><br>
					</td></tr></table>
			</div><!-- cA -->
			<div id="content">
				<div id="cB">
					<div class="Ctopright"></div>
	<div id="cB1">
				<div class="news">
				<h3>My Teams</h3><br>
                These are the teams you are currently on.<br><br><hr>
					<!--<h3>TEST2</h3>-->
                    <?php
					
					if($userID==0) {
						echo "User not logged in.";
						exit();
					}
					
					connectToDatabase();
					
					$query = "SELECT * FROM USERTEAM WHERE userID = ".$userID;
					$result = mysql_query($query);
					
					disconnectFromDatabase();
					
					if(mysql_num_rows($result)==0) {
						echo "<b>You are not currently on any teams!</b><br>";
				  	} else {
						while($row = mysql_fetch_array($result)) {
							// FOR EVERY TEAM
							$teamID = $row["teamID"];
							$teamName = getTeamName($teamID);
							$teamTotalPoints = getTeamTotalPoints($teamID);
							$compID = getTeamCompID($teamID);
							$compName = getCompName($compID);
							$weAreSpokes = isUserSpokesperson($userID,$teamID);
							
							echo"<h3>".$teamName."</h3>";
							echo"<i>Participating in challenge '".$compName."'</i><br>";
							echo "Total Points: ".$teamTotalPoints;
							echo "<br>Other Members On This Team:<br>";
							echo "<ul>";
							connectToDatabase();
							$uquery = "SELECT * FROM USERTEAM WHERE teamID=".$teamID;
							$uresult = mysql_query($uquery);
							disconnectFromDatabase();
							while($urow = mysql_fetch_array($uresult)) {
								$oUserID = $urow["userID"];
								$oUserName = getUserFullName($oUserID);
								$isSpokesperson = isUserSpokesperson($oUserID,$teamID);
								if($isSpokesperson)
									echo "<b>";
								echo "<li>".$oUserName;
								if($weAreSpokes) {
								echo "<form action='team.php' method='post'>";
								echo "<input type='hidden' name='doSetUserSpokesperson' value='true'>";
								echo "<input type='hidden' name='userID' value=".$oUserID.">";
								echo "<input type='hidden' name='teamID' value=".$teamID.">";
								echo "<input type='submit' value='Promote to Spokesperson'>";
								echo "</form>";
								}
								echo "</li>";
								if($isSpokesperson)
									echo "</b>";
							}
							echo "</ul><br>";
							
							// Team Actions
							echo "<form name='removefromteam' action='team.php' method='post'>";
							echo "<input type='hidden' name='doRemoveFromTeam' value='true'>";
							echo "<input type='hidden' name='teamID' value=".$teamID.">";
							echo "<input type='submit' value='Leave This Team'>";
							echo "</form><br>";
							
							echo "<hr>";
						}
						
					}
					
					?>
                    <br><center><b><?php echo $message2; ?></b></center><br>
                    <i>*Note: Spokespersons names are in bold.</i><br>
                    
				</div>
			</div><!-- cB1 -->
			<div id="cB2">
				&nbsp;<br/>
				<div class="about">
					
                    <h3>Teams</h3>
                    <br>
                    <ol>
                    <?php
					
					connectToDatabase();
					$query = "SELECT name FROM TEAM";
					$result = mysql_query($query);
					disconnectFromDatabase();

					while($row = mysql_fetch_array($result))
					{
						$teamName = $row["name"];
						echo "<li>".$teamName."</li>";	
					}
					
					?>
                    </ol>
                                        
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
