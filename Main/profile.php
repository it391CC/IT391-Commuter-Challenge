<?php
//Session
session_start();

//Connect To Database
$hostname='it391test.db.8404538.hostedresource.com';
$username='it391test';
$password='Binoy01';
$dbname='it391test';

$user =$_SESSION['user'];
			
mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);

$query = 'SELECT userID FROM USER where loginemail = ' . "'" . $user . "'";
				$result = mysql_query($query);
				if ($result) {
					while ($row = mysql_fetch_array($result)) {
						$id = $row['userID'];
					}
				}
				
if (!isset($_POST['fname'])) {
$query = 'SELECT * FROM USER where loginemail = ' . "'" . $user . "'";
				$result = mysql_query($query);
				if ($result) {
					while ($row = mysql_fetch_array($result)) {
						$id = $row['userID'];
						$first = $row['firstName'];
						$last = $row['lastName'];
						$phone = $row['phone'];
						$age = $row['age'];
						$weight = $row['weight'];
						$prefemail = $row['prefferedEmail'];
					}
				}
}
if (isset($_POST['fname'])) {
						$first = $_POST['fname'];
						$last = $_POST['lname'];
						$phone = $_POST['phone'];
						$age = $_POST['age'];
						$weight = $_POST['weight'];
						$prefemail = $_POST['email'];

					   $query = 'UPDATE USER SET firstName="'.$first.'",lastName ="'.$last.'",phone='.$phone.',prefferedEmail ="'.$prefemail.'",age='.$age.',weight='.$weight. ' WHERE loginEmail ="'.$user.'"';
						
						echo $query;
						$result = mysql_query($query);
						$registered = true;
					}
//Calculate total Mileage
					$query = 'SELECT mileage FROM USERCOMMUTE where userID =' . $id;
					$result = mysql_query($query);
					if ($result) {
						while ($row = mysql_fetch_array($result)) {
							$totalmiles = $totalmiles + $row['mileage'];
						}

					}
					
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Green Commute Challenge</title>
		<link rel="stylesheet" href="style.css" />
		
		<!-- import jquery -->
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		

	</head>

<body>
<div id="daddy">
	<div id="header">
		<div id="logo"><a href="./"><img src="images/logo.gif" alt="Your Company Logo" width="318" height="85" /></a><span id="logo-text"><a href="./"></a></span></div><!-- logo -->
		<div id="menu">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="profile.php" id="active">Profile</a></li>
				<li><a href="competition.php">Challenges</a></li>
				<li><a href="commutes.php">Commutes</a></li>
				<li><a href="team.php">Teams</a></li>
			</ul>
		</div><!-- menu -->
		<div id="headerimage">
			<div id="slogan"></div>
		</div>
		<!-- headerimage -->
	</div>
	<!-- header -->
	<div id="content">
		<div id="cA">
			<div class="Ctopleft"></div>
			<<p>
					&nbsp;
				</p>
				<h3>Your Current Points(currently miles for testing):</h3>
				<div id="facebooklogin" style="background-image:url(images/bg_points.jpg); background-position:center; background-repeat:no-repeat; height:100px">
					<p style="text-align:center; font-size:36px; padding-top:40px; color:#FC0">
						<?php print $totalmiles
						?>
					</p>
				</div>
            <div id="googlelogin">
        
            <h3></h3>
            	<?php 
            		//$query = 'DELETE FROM USER WHERE userID = ' . $id; 
            		//$result = mysql_query($query);
            	?> 
            
            </div>
		</div><!-- cA -->
		<div id="cB">
			<div class="Ctopright"></div>
			<div id="cB1">
				<h3>Change Your Profile Settings:</h3>
				<form name="editprofile" action="<?=$config['baseurl . /team/shlee4071/profile.php']?>" method="post">
				<div class="news">
					<p>First Name :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="fname"class="search" value = <?php print $first?> /></p>
                    <p>Last Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="lname"class="search" value = <?php print $last?> /></p>
                    <p>Age :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="age" class="search" value = <?php print $age?> /></p>
                    <p>Weight :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name ="weight" class="search" value = <?php print $weight?> /></p>
                    <h3 style="padding-top:20px">Contact Information</h3>
                    <p>E-mail:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="email"class="search" value =<?php print $prefemail?> /></p>
					 <p>Phone:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="phone"class="search" value =<?php print $phone?> /></p>
                    <input type="submit" value="Edit profile"/>
     </form><br/><br/><br/>
                    <a href="delete.php">Delete User</a>
				</div>
			</div><!-- cB1 -->
			<div id="cB2">
				<h3>CHALLENGE NEWS</h3>
				<div class="about">
					<ul>
						<li>Challenge website is under constructon</li>
                        <li>Challenges begin MAY 2012</li>
                        <li>Look for our Android mobile app</li>
					</ul>
				</div>
			</div><!-- cB2 -->
		</div><!-- cB -->
		<div class="Cpad">
			<br class="clear" /><div class="Cbottomleft"></div><div class="Cbottom"></div><div class="Cbottomright"></div>
		</div><!-- Cpad -->
	</div><!-- content -->
	<div id="properspace"></div><!-- properspace -->
</div><!-- daddy -->
<div id="footer">
	<div id="foot">
		<div id="foot1"><a href="mailto:it391project@gmail.com">it391project@gmail.com</a> - <a href="./"></a></div><!-- foot1 -->
		<div id="foot2">
	Copyright Fall 2011 IT391 Designed by <a href="http://groups.google.com/group/itk391fall2011/about?hl=en" title="it391">Google Group IT391<span class="star">*</span></a>
		</div><!-- foot1 -->
	</div><!-- foot -->
</div><!-- footer -->
	<?php if (!$_SESSION['loggedin']){
	?>
	<meta HTTP-EQUIV="REFRESH" content="0; url=http://limbotestserver.com">
	<?php }?>
</body>
</html>
