<?php

session_start();

require("php_functions.php");

$userID = getUserID();
$isAdmin = isUserAdmin();

$message = "";

//bonus				
function subBonus($id,$bid,$bdate)
 {
     //echo '<script language=javascript>alert('.$id.$bid.$bdate.')</script>';
     connectToDatabase();
     //echo $id." ".$bid." ".$bdate;
     $query = 'INSERT INTO USERBONUS (userID,bonusID,bonusDate) VALUES ('.$id.','.$bid.',"'.$bdate.'")';
	 $result = mysql_query($query);
	
	 
	 if ($result)
	 {
	 	echo '<script language=javascript>alert("Your bonus has been logged.")</script>';
	 }else	 	
	 	echo '<script language=javascript>alert("An error has occured please try again")</script>';
	 	
	 disconnectFromDatabase();	
 }
 
 if (isset($_POST['bonusname']))
 {
 	//echo "ppoooooop";
 	$bdate = isset($_REQUEST["date2"]) ? $_REQUEST["date2"] : "";;
	$bid = $_POST['bonusname'];
	//echo $bdate;
	//echo '<script language=javascript>alert("'.$bdate.'")</script>';	
 	subBonus($userID,$bid,$bdate);
 }

// Check if this page is the result of a form submission.
if(isset($_POST["doLogCommute"]))
{
	// Log a commute
	$commuteID = $_POST["commuteID"];
	$mileage = $_POST["mileage"];
	
	$isFavorite = 0;
	if(isset($_POST["isFavorite"]) && $_POST["isFavorite"] == "on")
		$isFavorite = 1;
		
	$description = "";
	if(isset($_POST["description"]))
		$description = $_POST["description"];
	
	// TODO: Commute validation.
	$valid = true;
	// Mileage is a valid number.
	if(!is_numeric($mileage)) {
		$message = $message."Mileage must be an integer!<br>";
		$valid = false;
	}
	// If its a favorite then it has a description
	if($isFavorite && $description == "") {
		$message = $message."If you are making this a favorite please enter a description!<br>";
		$valid = false;	
	}

	if($valid) {
		if(!logCommute($userID, $commuteID, $mileage, $isFavorite, $description))
			echo "Failed to log commute.";
	}
}

if(isset($_POST["doLogCompOnlyCommute"]))
{
	// Log a commute
	$oCommuteID = $_POST["oCommuteID"];
	$mileage = $_POST["mileage"];
	
	$isFavorite = 0;
	if(isset($_POST["isFavorite"]) && $_POST["isFavorite"] == "on")
		$isFavorite = 1;
		
	$description = "";
	if(isset($_POST["description"]))
		$description = $_POST["description"];
	
	// TODO: Commute validation.
	$valid = true;
	// Mileage is a valid number.
	if(!is_numeric($mileage)) {
		$message = $message."Mileage must be an integer!<br>";
		$valid = false;
	}
	// If its a favorite then it has a description
	if($isFavorite && $description == "") {
		$message = $message."If you are making this a favorite please enter a description!<br>";
		$valid = false;	
	}

	if($valid) {
		if(!logCompOnlyCommute($userID, $oCommuteID, $mileage, $isFavorite, $description))
			echo "Failed to log commute.";
	}
}

if(isset($_POST["doRemoveFavorite"]))
{
	$userCommuteID = $_POST["userCommuteID"];
	
	if(!setCommuteAsNotFavorite($userCommuteID))
		echo "Failed to set commute as not favorite.";
}

if(isset($_POST["doRemoveOtherFavorite"]))
{
	$userOtherCommuteID = $_POST["userOtherCommuteID"];
	
	if(!setOtherCommuteAsNotFavorite($userOtherCommuteID))
		echo "Failed to set commute as not favorite.";
}

$sesSpoke = 0;
				
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
		
		<!-- JS for AJAX -->
		<script type="text/javascript">
			function showValue(bid){
				if (bid == 0){
					document.getElementById("points").innerHTML="";
 					return;
				}
				if (window.XMLHttpRequest)
  					{// code for IE7+, Firefox, Chrome, Opera, Safari
 						xmlhttp=new XMLHttpRequest();
 					}
				else
  					{// code for IE6, IE5
  						xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  					}
				xmlhttp.onreadystatechange=function()
 					{
  						if (xmlhttp.readyState==4 && xmlhttp.status==200)
    						{
    							document.getElementById("points").innerHTML=xmlhttp.responseText;
    						}
  					}
				xmlhttp.open("GET","bonus.php?bonusID="+bid,true);
				xmlhttp.send();
			}
		</script>
		
		<script type="text/javascript">
			function hidden()
			{
				//var a = document.getElementById("date2").value;
				//var b = document.getElementById("date").value;
				alert("n");
				//alert("dood " + form.getElementById("date123")+
				//" " +document.getElementById("date12"));
				
				
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
                
                <br/><br/><br/><br/><br/><br/><h3>Bonus Opportunitys</h3><br/>
					<div style="height: 300px" class="news">

					
					<?php 
						
						$query = "SELECT * FROM BONUS";
						$result = mysql_query($query);
						$tnow = strtotime("now");
						//print $tnow;						
						echo "<form name='logbonus' action='commutes.php' method='post' onsubmit='return hidden()'>";
						echo "Bonuses: <select style='width:200px' name='bonusname' onchange='showValue(this.value)'>";
						echo "<option value='0'>Select a Bonus</option>";
						while($row = mysql_fetch_array($result)){
							$bid = $row["bonusID"];
							$compid = $row["compID"];							
							$desc = $row["description"];
							
								echo "<option value='".$bid."'>".$desc."</option>";
							
							
						}
						echo "</select><br/>";
							
						echo "<span id='points'></span>";
						echo '<input type="hidden" name="date12" value="0000-00-00"/>';
						echo "</form>";
						
						?>
					</div>
					
                </div>
			</div><!-- cA -->
			<div id="content">
            <div id="cB">
            <div class="Ctopright"></div>
            <div id="cB1">
                <center><h3>Log A Commute!</h3></center>
                <form name="logcommute" action="commutes.php" method="post">
                <input type='hidden' name='doLogCommute' value='TRUE'>
                Commute Type: <select style='width:125px' name='commuteID'>
                <?php
                    connectToDatabase();
                    
                    $query = "SELECT * FROM COMMUTE";
                    $result = mysql_query($query);
					
					disconnectFromDatabase();
                    while($row = mysql_fetch_array($result)) {
                        $comid = $row["commuteID"];
                        $type = $row["commtype"];
                        echo "<option value='".$comid."'>".$type."</option>";
                    }
                    
                ?>
                </select><br>
                Distance (miles): <input type="text" name="mileage"><br>
                Make this a favorite commute? <input type="checkbox" name="isFavorite"><br>
                If it was a favorite, please enter a short description:<br>
                <textarea rows=3 cols=40 name="description"></textarea><br>
                <input type="submit" value="Log Commute">
                </form>
                <br><center>OR</center><br>
                <center><h3>Log A Competition Only Commute!</h3></center>
                If you are enrolled in a competition with new commute types they will appear here:
                <form name="logcomponmlycommute" action="commutes.php" method="post">
                <input type='hidden' name='doLogCompOnlyCommute' value='TRUE'>
                Commute Type: <select style='width:125px' name='oCommuteID'>
                <?php
                    connectToDatabase();
                    
                    $query = "SELECT * FROM OTHERCOMMUTE";
                    $result = mysql_query($query);
					
                    disconnectFromDatabase();
                    while($row = mysql_fetch_array($result)) {
                        $oCommuteID = $row["oCommuteID"];
						$compID = $row["compID"];
                        $ocommtype = $row["ocommtype"];
						if(isUserInCompetition($userID,$compID))
	                        echo "<option value='".$oCommuteID."'>".$ocommtype."</option>";
                    }
                ?>
                </select><br>
                Distance (miles): <input type="text" name="mileage"><br>
                Make this a favorite commute? <input type="checkbox" name="isFavorite"><br>
                If it was a favorite, please enter a short description:<br>
                <textarea rows=3 cols=40 name="description"></textarea><br>
                <input type="submit" value="Log Commute">
                </form>
                
                <?php echo "<center><b>".$message."</b></center><br>"; ?>
			</div><!-- cB1 -->
			<div id="cB2">
                <center><h3>Your Favorite Commutes</h3></center>
                <?php
                // Regular Favorite Commutes
                connectToDatabase();
                
                $query = "SELECT * FROM USERCOMMUTE WHERE userID=".$userID;
                $result = mysql_query($query);
				
                disconnectFromDatabase();
                            
                while($row = mysql_fetch_array($result)) {
                    $userCommuteID = $row["userCommuteID"];
                    $commuteID = $row["commuteID"];
                    $mileage = $row["mileage"];
                    $isFavorite = $row["isFavorite"];
                    $description = $row["description"];
                
                    if($isFavorite == 1) {
						
                        echo "<hr>";
                        echo "<h3>".$description."</h3><br>";
                        echo "Type: ".getCommuteTypeName($commuteID)."<br>";
                        echo "Mileage: ".$mileage."<br>";
                
                        echo "<form action='commutes.php' method='post'>";
                        echo "<input type='hidden' name='doLogCommute' value='true'>";
                        echo "<input type='hidden' name='commuteID' value='".$commuteID."'>";
                        echo "<input type='hidden' name='mileage' value='".$mileage."'>";
                        echo "<input type='hidden' name='isFavorite' value='off'>";
                        echo "<br><input type='submit' value='Log This Commute'/>";
                        echo "</form>";			
                        echo "<form action='commutes.php' method='post'>"	;		
                        echo "<input type='hidden' name='doRemoveFavorite' value='true'>";
                        echo "<input type='hidden' name='userCommuteID' value=".$userCommuteID.">";
                        echo "<input type='submit' value='Remove from Favorites'/>";
                        echo "</form><br>";				
                    }
                }
                
                ?>
                <?php
                // Other favorite commutes
                connectToDatabase();
                
                $query = "SELECT * FROM USEROTHERCOMMUTE WHERE userID=".$userID;
                $result = mysql_query($query);
				
				disconnectFromDatabase();
                            
                while($row = mysql_fetch_array($result)) {
                    $userOtherCommuteID = $row["userOtherCommuteID"];
                    $oCommuteID = $row["oCommuteID"];
                    $mileage = $row["mileage"];
                    $isFavorite = $row["isFavorite"];
                    $description = $row["description"];
                	$oCompID = getOtherCommuteTypeComp($oCommuteID);
					$isInComp = isUserInCompetition($userID,$oCompID);
					
                    if($isFavorite == 1 && $isInComp) {
						
                        echo "<hr>";
                        echo "<h3>".$description."</h3><br>";
                        echo "Type: ".getOtherCommuteTypeName($oCommuteID)."<br>";
                        echo "Mileage: ".$mileage."<br>";
                
                        echo "<form action='commutes.php' method='post'>";
                        echo "<input type='hidden' name='doLogOtherCommute' value='true'>";
                        echo "<input type='hidden' name='oCommuteID' value='".$oCommuteID."'>";
                        echo "<input type='hidden' name='mileage' value='".$mileage."'>";
                        echo "<input type='hidden' name='isFavorite' value='off'>";
                        echo "<br><input type='submit' value='Log This Commute'/>";
                        echo "</form>";			
                        echo "<form action='commutes.php' method='post'>"	;		
                        echo "<input type='hidden' name='doRemoveOtherFavorite' value='true'>";
                        echo "<input type='hidden' name='userCommuteID' value=".$userOtherCommuteID.">";
                        echo "<input type='submit' value='Remove from Favorites'/>";
                        echo "</form><br>";				
                    }
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
