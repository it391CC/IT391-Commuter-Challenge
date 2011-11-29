<?php

/* Copyright (c) 2009 Google Inc.

 *

 * Licensed under the Apache License, Version 2.0 (the "License");

 * you may not use this file except in compliance with the License.

 * You may obtain a copy of the License at

 *

 *     http://www.apache.org/licenses/LICENSE-2.0

 *

 * Unless required by applicable law or agreed to in writing, software

 * distributed under the License is distributed on an "AS IS" BASIS,

 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.

 * See the License for the specific language governing permissions and

 * limitations under the License.

 *

 * Author: Eric Bidelman <e.bidelman>

 */

 



//Google Session

session_start();


//Connect To Database

$hostname='it391test.db.8404538.hostedresource.com';

$username='it391test';

$password='Binoy01';

$dbname='it391test';

$usertable='usercommute';

$yourfield = 'mileage';

						

$user = $_SESSION['user'] ;

//echo $user;



mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');

mysql_select_db($dbname);



$query = 'SELECT userid FROM USER where loginemail = ' . "'" . $user . "'";

				$result = mysql_query($query);

				if ($result) {

					while ($row = mysql_fetch_array($result)) {

						$id = $row['userid'];



					}

				}
				//echo '<script language=javascript>alert('.$id.')</script>';
//bonus				
function subBonus($id,$bid,$bdate)
 {
     //echo '<script language=javascript>alert('.$id.$bid.$bdate.')</script>';
     
     //echo $id." ".$bid." ".$bdate;
     $query = 'INSERT INTO USERBONUS (userID,bonusID,bonusDate) VALUES ('.$id.','.$bid.',"'.$bdate.'")';
	 $result = mysql_query($query);
	
	 
	 if ($result)
	 {
	 	echo '<script language=javascript>alert("Your bonus has been logged.")</script>';
	 }else	 	
	 	echo '<script language=javascript>alert("An error has occured please try again")</script>';
 }
 
 if (isset($_POST['bonusname']))
 {
 	//echo "ppoooooop";
 	$bdate = isset($_REQUEST["date2"]) ? $_REQUEST["date2"] : "";;
	$bid = $_POST['bonusname'];
	//echo $bdate;
	//echo '<script language=javascript>alert("'.$bdate.'")</script>';	
 	subBonus($id,$bid,$bdate);
 }


// Post Commute (add support for favorite)

					if (isset($_POST['dist'])) {

						if (is_numeric($_POST['dist'])) {

							$miles = $_POST['dist'];

							$desc = $_POST['status'];

							if (isset($POST['fav'])) {

 							$fav = 1;

							} 

							else {
							$fav = 0;
							}

							

							$query = 'INSERT INTO USERCOMMUTE (userID,commuteDate,mileage,isFavorite,description)  VALUES(' . $id . ',' . 'CURRENT_TIMESTAMP' . ',' . $miles . ','.$fav.',' . '"' . $desc . '"' . ')';

							echo $query;

							$result = mysql_query($query);

						}

else{

	$message = "Please enter a number for miles travelled";

}

					}

//Query to get and calculate total mileage

					$query = 'SELECT mileage FROM USERCOMMUTE where userID =' . "'" . $id. "'";

					$result = mysql_query($query);

					if ($result) {

						while ($row = mysql_fetch_array($result)) {

							$totalmiles = $totalmiles + $row[$yourfield];

						}



					}

					





// //Twitter PHP Class

// //http://code.google.com/p/twitter-php/

// $consumerKey = 'o3dsmxU8Eh4pNe9ca2nhtQ';

// $consumerSecret = 'GF02LPeBdb2Ea1LpHdjjPkqqriBvTV0nS5qoXA5Y';

// $accessToken = '14080973-aDGvZNOXjtYFam3hbAgxmcKpOINankQemDJJ7GRmb';

// $accessTokenSecret = 'nIPeLBTfZfEU3tgCfxQLwQSin7yT9mDsQzlMNUjkCJ4';

// require_once 'Twitter-PHP/twitter.class.php';

// $twitter = new Twitter($consumerKey, $consumerSecret,

// $accessToken, $accessTokenSecret);

// $channel = $twitter->load(Twitter::REPLIES);



// OAuth/OpenID libraries and utility functions.



require_once 'common.inc.php';



// Load the necessary Zend Gdata classes.

require_once 'Zend/Loader.php';

Zend_Loader::loadClass('Zend_Gdata_HttpClient');



// Setup OAuth consumer with our "credentials"

$CONSUMER_KEY = 'limbotestserver.com';

$CONSUMER_SECRET = 'NAXXzJLbe6PQTuRszF2rvXpi';

$consumer = new OAuthConsumer($CONSUMER_KEY, $CONSUMER_SECRET);

$sig_method = $SIG_METHODS['HMAC-SHA1'];



// Define scope of what google can access



// $scopes = array(

//   'http://docs.google.com/feeds/',*/

//   'http://spreadsheets.google.com/feeds/',*/

//   'http://www-opensocial.googleusercontent.com/api/people/'*/

// );



$openid_params = array('openid.ns' => 'http://specs.openid.net/auth/2.0', 'openid.claimed_id' => 'http://specs.openid.net/auth/2.0/identifier_select', 'openid.identity' => 'http://specs.openid.net/auth/2.0/identifier_select', 'openid.return_to' => "http://{$CONSUMER_KEY}{$_SERVER['PHP_SELF']}", 'openid.realm' => "http://{$CONSUMER_KEY}", 'openid.mode' => @$_REQUEST['openid_mode'], 'openid.ns.ui' => 'http://specs.openid.net/extensions/ui/1.0', 'openid.ns.ext1' => 'http://openid.net/srv/ax/1.0', 'openid.ext1.mode' => 'fetch_request', 'openid.ext1.type.email' => 'http://axschema.org/contact/email', 'openid.ext1.type.first' => 'http://axschema.org/namePerson/first', 'openid.ext1.type.last' => 'http://axschema.org/namePerson/last', 'openid.ext1.type.country' => 'http://axschema.org/contact/country/home', 'openid.ext1.type.lang' => 'http://axschema.org/pref/language', 'openid.ext1.required' => 'email,first,last,country,lang', 'openid.ns.oauth' => 'http://specs.openid.net/extensions/oauth/1.0', 'openid.oauth.consumer' => $CONSUMER_KEY,



// uncomment if declaring scope above

//   'openid.oauth.scope'       => implode(' ', $scopes)*/

);



$openid_ext = array('openid.ns.ext1' => 'http://openid.net/srv/ax/1.0', 'openid.ext1.mode' => 'fetch_request', 'openid.ext1.type.email' => 'http://axschema.org/contact/email', 'openid.ext1.type.first' => 'http://axschema.org/namePerson/first', 'openid.ext1.type.last' => 'http://axschema.org/namePerson/last', 'openid.ext1.type.country' => 'http://axschema.org/contact/country/home', 'openid.ext1.type.lang' => 'http://axschema.org/pref/language', 'openid.ext1.required' => 'email,first,last,country,lang', 'openid.ns.oauth' => 'http://specs.openid.net/extensions/oauth/1.0', 'openid.oauth.consumer' => $CONSUMER_KEY,



// uncomment if declaring scope above

//   'openid.oauth.scope'       => implode(' ', $scopes),*/

	'openid.ui.icon' => 'true');



//Google API Pop Up Window phCode 

if (isset($_REQUEST['popup']) && !isset($_SESSION['redirect_to'])) {

	$query_params = '';

	if ($_POST) {

		$kv = array();

		foreach ($_POST as $key => $value) {

			$kv[] = "$key=$value";

		}

		$query_params = join('&', $kv);

	} else {

		$query_params = substr($_SERVER['QUERY_STRING'], strlen('popup=true') + 1);

	}



	$_SESSION['redirect_to'] = "http://{$CONSUMER_KEY}{$_SERVER['PHP_SELF']}?{$query_params}";

	echo '<script type = "text/javascript">window.close();</script>';

	exit ;

} else if (isset($_SESSION['redirect_to'])) {

	$redirect = $_SESSION['redirect_to'];

	unset($_SESSION['redirect_to']);

	header('Location: ' . $redirect);

}



$request_token = @$_REQUEST['openid_ext2_request_token'];

if ($request_token) {

	$data = array();

	$httpClient = new Zend_Gdata_HttpClient();

	$access_token = getAccessToken($request_token);

}



switch(@$_REQUEST['openid_mode']) {

	case 'checkid_setup' :

	case 'checkid_immediate' :

		$identifier = $_REQUEST['openid_identifier'];

		if ($identifier) {

			$fetcher = Auth_Yadis_Yadis::getHTTPFetcher();

			list($normalized_identifier, $endpoints) = Auth_OpenID_discover($identifier, $fetcher);



			if (!$endpoints) {

				debug('No OpenID endpoint found.');

			}



			$uri = '';

			foreach ($openid_params as $key => $param) {

				$uri .= $key . '=' . urlencode($param) . '&';

			}

			header('Location: ' . $endpoints[0] -> server_url . '?' . rtrim($uri, '&'));

		} else {

			debug('No OpenID endpoint found.');

		}

		break;

	case 'cancel' :

		debug('Sign-in was cancelled.');

		break;

	case 'associate' :

	// TODO

		break;

}



/**

 * Upgrades an OAuth request token to an access token.

 *

 * @param string $request_token_str An authorized OAuth request token

 * @return string The access token

 */

function getAccessToken($request_token_str) {

	global $consumer, $sig_method;



	$token = new OAuthToken($request_token_str, NULL);



	$token_endpoint = 'https://www.google.com/accounts/OAuthGetAccessToken';

	$request = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $token_endpoint);

	$request -> sign_request($sig_method, $consumer, $token);



	$response = send_signed_request($request -> get_normalized_http_method(), $token_endpoint, $request -> to_header(), NULL, false);



	// Parse out oauth_token (access token) and oauth_token_secret

	preg_match('/oauth_token=(.*)&oauth_token_secret=(.*)/', $response, $matches);

	$access_token = new OAuthToken(urldecode($matches[1]), urldecode($matches[2]));



	return $access_token;

}



?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml"

xmlns:fb="http://www.facebook.com/2008/fbml">

	<head>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>Green Commute Challenge</title>
		
		<link rel="stylesheet" href="calendar/calendar.css" /> 
		
		<script language="javascript" src="calendar/calendar.js"></script>

		<link rel="stylesheet" href="style.css" />

		<script src="http://code.jquery.com/jquery-latest.min.js"></script>

		<script type="text/javascript" src="popuplib.js"></script>

		<script src="http://connect.facebook.net/en_US/all.js"></script>

		<script type="text/javascript">

			var upgradeToken = function() {

window.location = '<?php echo $_SESSION['redirect_to'] ?>

	';

	};

	var extensions = 

<?php echo json_encode($openid_ext);?>;

var googleOpener = popupManager.createPopupOpener({

'realm' : '<?php echo $openid_params['openid.realm'] ?>

	',

	'opEndpoint' : 'https://www.google.com/accounts/o8/ud',

	'returnToUrl' : '

<?php echo $openid_params['openid.return_to'] . '?popup=true' ?>

	',

	'onCloseHandler' : upgradeToken,

	'shouldEncodeUrls' : true,

	'extensions' : extensions

	});

	$(document).ready(function() {

		jQuery('#LoginWithGoogleLink').click(function() {

			googleOpener.popup(450, 500);

			return false;

		});

	});



		</script>

		<script type="text/javascript">

			function toggle(id, type) {

				if(type === 'list') {

					$('pre.' + id).hide();

					$('div.' + id).show();

				} else {

					$('div.' + id).hide();

					$('pre.' + id).show();

				}

			}

		</script>

		<?php

		include_once "fbmain.php";

		$config['baseurl'] = "http://limbotestserver.com/";



		//if user is logged into Facebook and session is valid.

		if ($fbme) {

			//Query to get user name

			try {

				$fql = "SELECT name,email FROM user WHERE uid=" . $uid;

				$param = array('method' => 'fql.query', 'query' => $fql, 'callback' => '');

				$userInfo = $facebook -> api($param);



				//Query to get user id (should be ammended to use a single query)

				foreach ($userInfo as $result) {

					$email = $result['email'];

				}

				$query = 'SELECT userid FROM USER where loginemail = ' . "'" . $email . "'";

				$result = mysql_query($query);

				if ($result) {

					while ($row = mysql_fetch_array($result)) {

						$id = $row['userid'];



					}



				}



			} catch(Exception $o) {

				d($o);

			}

		}

		?>



		<!-- Begining of Facebook Scripts -->

		<script>

			FB.init({

				appId : '110603805686133',

				status : true, // check login status

				cookie : true, // enable cookies to allow the server to access the session

				xfbml : true, // parse XFBML

			});



		</script>

		<script>

			window.fbAsyncInit = function() {

				FB.init({

					appId : '110603805686133',

					status : true,

					cookie : true,

					xfbml : true

				});



				/* All the events registered */

				FB.Event.subscribe('auth.login', function(response) {

					window.location.reload();

					//Code to allow the page to refresh after login.

				});

				FB.Event.subscribe('auth.logout', function(response) {

					window.location.reload();

					//Code to allow the page to refresh after logout.

				});

				FB.getLoginStatus(function(response) {

					if(response.session) {

						// logged in and connected user, someone you know

						login();

					}

				});

			};



		</script>

		<!-- End of Facebook Scripts -->
		
	
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

		<div id="fb-root"></div>

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

							<a href="competition.php">Challenges</a>

						</li>

						<li>

							<a href="commutes.php" id="active">Commutes</a>

						</li>

						<li>

							<a href="team.php">Teams</a>

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

				<p>&nbsp;

					

				</p>

				<h3>Your Current Points(currently miles for testing):</h3>

				<div id="facebooklogin" style="background-image:url(images/bg_points.jpg); background-position:center; background-repeat:no-repeat; height:100px">

					<p style="text-align:center; font-size:36px; padding-top:40px; color:#FC0">

						<?php print "".$totalmiles

						?>

					</p>

				</div>

				<div id="googlelogin">

				<!-- 	<h3 style="padding-top:10px">Your Challenges:</h3>
					<ul style="padding-left:5px">
						<li>
							<a href="./" title="Challenge A">Challenge A</a>
						</li>
					</ul> -->

				</div>

			</div><!-- cA -->

			<div id="content">

				<div id="cB">

					<div class="Ctopright"></div>

					<div id="cB1">

						<h3>Transportation Type / Miles Travelled</h3>

						<div style="height: 200px" class="news">
                        
                        <?php
						
						$query = "SELECT * FROM COMMUTE";
						$result = mysql_query($query);
						
						echo "<form name='logcommute' action='logcommute.php' method='post'>";
						echo "<input type='hidden' name='usersID' value='".$id."'>";
						echo "Commute Type:<select style='width:125px' name='commuteType'>";
						while($row = mysql_fetch_array($result)) {
							$comid = $row["commuteID"];
							$type = $row["commtype"];
							echo "<option value='".$comid."'>".$type."</option>";
						}
						echo "</select><br>";
						echo "<br>Distance: <input type='text' name='dist'/><br>";
						echo "Description:<br><textarea rows='5' cols='25' name='description'></textarea><br>";
						echo "Log as Favorite <input type='checkbox' name='isfavorite'/><br>";
						echo "<input type='submit' value='Log Commute' />";
						echo "</form>";						
											
						?>
						
						</div>
												
						<h3>Bonus Opportunitys</h3>
						<div name="Bonus" style="height: 150px" class="news">
						
						
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

							<!--<form name="logcommute" action="<?=$config['baseurl . commutes.php']?>" method="post">

								<select style="width:125px">

									<option value="Vehicle1">Walk</option>

									<option value="Vehicle2">Bike</option>

									<option value="Vehicle3">Bus</option>

									<option value="Vehicle4">Carpool</option>

									<option value="Vehicle5">Train</option>

								</select>

								<input type="text" id="dist" name="dist"/>

								<br />

								<br/>

								Description/Notes 								<textarea  rows="5" cols="25" id="status" name="status"> </textarea>

<br />								<p style="text-align:left">

									Save as a favorite?

									<input type="checkbox" id="fav" name="fav"/>

								</p>

								<input type="submit" value="Log Commute"/>

							</form> -->

							<?php print $message; ?>

						

						<!-- Facebook/Google/Twitter Buttons -->

						<script type="text/javascript">

							(function() {

								var po = document.createElement('script');

								po.type = 'text/javascript';

								po.async = true;

								po.src = 'https://apis.google.com/js/plusone.js';

								var s = document.getElementsByTagName('script')[0];

								s.parentNode.insertBefore(po, s);

							})();



						</script>

						<center>

							<table>

								<tr>

									<td><div class="fb-like" data-send="false" data-href="http://limbotestserver.com" data-layout="button_count" data-width="45" data-show-faces="false"></div></td>

									<td><div class="g-plusone" data-size="medium" data-href="http://limbotestserver.com"></div> &nbsp; </td>

									<td><a href="https://twitter.com/share" data-text="I'm going green with the Commuter Challenge!! " class="twitter-share-button">Tweet</a></td>

								</tr>

							</table>

						</center>

						<!-- End Facebook/Google/Twitter Buttons -->

					</div><!-- cB1 -->

					<div id="cB2">

						<h3>YOUR FAVORITE COMMUTES</h3>

						<div class="about">
                        <?php
						
						//echo $id;
						$query = "SELECT * FROM USERCOMMUTE WHERE userID=".$id; 
						$result = mysql_query($query);

						echo "<ul>";				
						while($row = mysql_fetch_array($result)) {
							$usercommuteid = $row["userCommuteID"];
							$commid = $row["commuteID"];
							$mileage = $row["mileage"];
							$isFav = $row["isFavorite"];
							$desc = $row["description"];
							$ucid = $row["userCommuteID"];
							if($isFav == 1) {
								echo "<li>".$desc;
								echo "<form action='logcommute.php' method='post'>";
								echo "<input type='hidden' name='usersID' value='".$id."'>";
								echo "<input type='hidden' name='commuteType' value='".$commid."'>";
								echo "<input type='hidden' name='dist' value='".$mileage."'>";
								/*if($isFav == 1)
									echo "<input type='hidden' name='isfavorite' value='on'>";
								else
									echo "<input type='hidden' name='isfavorite' value='off'>";*/
								echo "<input type='hidden' name='isfavorite' value='off'>";
								//echo "<input type='hidden' name='description' value='".$desc."'>";									
								echo "<br><input type='submit' value='Log This Commute'/>";
								echo "</form>";			
								echo "<form action='logcommute.php' method='post'>"	;		
								echo "<input type='hidden' name='deletefav' value='".$ucid."'>";
								echo "<input type='submit' value='Remove from Favorites'/>";
								echo "</form>";					
								echo "</li>";
								// TODO: Add a fill out commute button
							}
						}
						echo "</ul>";
						
						?>

							<!--<ul style="text-align:center">

								<li>

									<input type="button" width="100px" value="Commute A" />

								</li>

								<li>

									<input type="button" value="Commute B" />

								</li>

								<li>

									<input type="button" value="Commute C" />

								</li>

							</ul>-->

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

					Copyright 2011, IT391. Designed by <a href="http://www.symisun.com/" title="We digitalize your ambitions">SymiSun<span class="star">*</span></a>

					<script src="//platform.twitter.com/widgets.js" type="text/javascript"></script>

				</div><!-- foot1 -->

			</div><!-- foot -->

		</div><!-- footer -->

		<!-- needed to log out of google -->

		<iframe id="myIFrame" width="0" height="0" ></iframe>

	</body>

	<!--Sends user back to home page if not logged into Facebook -->

	<?php if (!$_SESSION['loggedin']){

	?>

	<meta HTTP-EQUIV="REFRESH" content="0; url=http://limbotestserver.com">

	<?php }?>

</html>

