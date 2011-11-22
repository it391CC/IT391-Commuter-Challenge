<?php

session_start();

require("php_functions.php");

$userID = getUserID();
$isAdmin = isUserAdmin();

$message = "";

if(isset($_POST["doJoinCompetition"]))
{
	$compID = $_POST["compID"];
	
	$valid = true;
	if(isUserInCompetition($userID,$compID)) {
		$message = "You are already in this competition!";
		$valid = false;	
	}
	
	if($valid)
	{
		if(!addUserToCompetition($userID, $compID))
		{
			echo "Could not add user to competition";	
		}
	}
}

if(isset($_POST["doLeaveCompetition"]))
{
	$compID = $_POST["compID"];
	
	$valid = true;
	
	if($valid)
	{
		if(!removeUserFromCompetition($userID, $compID))
		{
			echo "Could not remove user from competition";	
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
				<p>&nbsp;</p>
				<h3>Your Current Points:</h3><br>
				<div id="facebooklogin" style="background-image:url(images/bg_points.jpg); background-position:center; background-repeat:no-repeat; height:100px">
				<p style="text-align:center; font-size:36px; padding-top:40px; color:#FC0">
					<?php
                        echo getUserTotalPoints($userID);
                    ?>
                </p>
                </div>
			</div><!-- cA -->
			<div id="content">
            <div id="cB">
            <div class="Ctopright"></div>
            <div id="cB1">
                <center><h3>Competition Information</h3></center>
                <?php
                	echo "<br>";
					
					connectToDatabase();
					$query = "SELECT * FROM USERCOMP WHERE userID=".$userID;
					$result = mysql_query($query);
					disconnectFromDatabase();
					
					if(mysql_num_rows($result)==0)
					{
						echo "You are not currently enrolled in any competitions!<br>";	
					} else {
						echo "Competitions you are enrolled in:<br>";
						while($row = mysql_fetch_array($result))
						{
							$compID = $row["compID"];
							$compName = getCompName($compID);
							
							echo "<h4>".$compName."</h4>";
							//TODO: Leave a competition button.
							echo "<form name='doleavecomp' action='competition.php' method='post'>";
							echo "<input type='hidden' name='doLeaveCompetition' value='true'>";
							echo "<input type='hidden' name='compID' value=".$compID.">";
							echo "<input type='submit' value='Leave This Competition'>";
							echo "</form>";
						}
					}
				
				?>
                <br><br>
                <center><h3>Join A Competition</h3></center>
                <form name='joincomp' action='competition.php' method='post'>
                <input type='hidden' name='doJoinCompetition' value='true'>
                <select name='compID'>
                <?php
					connectToDatabase();
					$query = "SELECT * FROM COMPETITION";
					$result = mysql_query($query);
					disconnectFromDatabase();
					while($row = mysql_fetch_array($result))
					{
						$compID = $row["compID"];
						$compName = $row["compName"];
						echo "<option value=".$compID.">".$compName."</option>";	
					}
				?>
                </select>
                <input type='submit' value='Join Competition'>
                </form>
                
                <?php echo "<center><b>".$message."</b></center><br>"; ?>
			</div><!-- cB1 -->
			<div id="cB2">
                <center><h3>Current Competitions</h3></center>
                <?php
				
					connectToDatabase();
					$query = "SELECT * FROM COMPETITION";
					$result = mysql_query($query);
					disconnectFromDatabase();
					
					if(mysql_num_rows($result)==0)
					{
						echo "There are currently no competitions.<br>";	
					} else {
						echo "<ol>";
						while($row = mysql_fetch_array($result))
						{
							$compName = $row["compName"];
							echo "<li>".$compName."</li>";
						}
						echo "</ol>";
					}
				
				?>
                
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
