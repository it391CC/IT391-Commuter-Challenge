<?php

// copyright notice for Google Oauth/OpenID code

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
$usertable='user';
$yourfield = 'userID';

mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);

//Example Query

// $query = 'SELECT * FROM ' . $usertable;
// $result = mysql_query($query);
// if($result) {
    // while($row = mysql_fetch_array($result)){
        // $name = $row[$yourfield];
        // echo 'Name: ' . $name;
    // }
// }

// //Twitter PHP Class (uncomment to use)

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

// Load the necessary Zend Gdata classes for Google login.

require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_HttpClient');

// Setup OAuth consumer with our "credentials" for Google login

$CONSUMER_KEY = 'limbotestserver.com';
$CONSUMER_SECRET = 'NAXXzJLbe6PQTuRszF2rvXpi';
$consumer = new OAuthConsumer($CONSUMER_KEY, $CONSUMER_SECRET);
$sig_method = $SIG_METHODS['HMAC-SHA1'];

// Define scope of what google can access, uncomment to use

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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html xmlns="http://www.w3.org/1999/xhtml"
xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Green Commute Challenge</title>
		<link rel="stylesheet" href="style.css" />
		
		<!-- import jquery -->
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		
		<!-- pop up window library (from Google) -->
		<script type="text/javascript" src="popuplib.js"></script>
		
		<!-- import for Facebook connect -->
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		
		<!-- Script to pop up google login window -->
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
		<!-- End Google pop up window script -->
		
		<!-- Facebook PHP Code-->
		<?php
		include_once "fbmain.php";
		$config['baseurl'] = "http://limbotestserver.com/";

		//if user is logged into Facebook and session is valid.
		if ($fbme) {
			//Query to get user name
			try {
				$fql = "SELECT name,first_name,last_name,email FROM user WHERE uid=" . $uid;
				$param = array('method' => 'fql.query', 'query' => $fql, 'callback' => '');
				$userInfo = $facebook -> api($param);
				//Query to get user id (should be ammended to use a single query)
				foreach ($userInfo as $result) {
					$email = $result['email'];
					$firstname = $result['first_name'];
					$lastname = $result['last_name'];
				}
				$query = 'SELECT userid FROM USER where loginemail = ' . "'" . $email . "'";
				$result = mysql_query($query);
				if ($result) {
					while ($row = mysql_fetch_array($result)) {
						$id = $row['userid'];
						$registered = true;

					}
							// Add User to Database (should be able to use this for the edit profile use case)
							// Example query: UPDATE USER SET firstName=,lastName=,phone=,loginEmail=,age=,weight= WHERE userID =;
					if (isset($_POST['first'])) {
						$first = $_POST['first'];
						$last = $_POST['last'];
						$phone = $_POST['phone'];
						$age = $_POST['age'];
						$weight = $_POST['weight'];
						$prefemail = $_POST['email'];

						$query = 'INSERT INTO USER (firstName,lastName,phone,loginEmail,prefferedEmail,age,weight,isAdmin) VALUES(' . $first . '","' . $last . '",' . $phone . ',"' . $email . '","' . $prefemail . '",' . $age . ',' . $weight . ',0' . ')';
						echo $query;
						$result = mysql_query($query);
						$registered = true;
					}
					
				}
			} catch(Exception $o) {
				d($o);
			}

		}

		// Add status using graph api
		// if (isset($_POST['status'])) {
		//
		// $statusUpdate = $facebook -> api('/me/feed', 'post', array('message' => $_POST['status']));
		// }
		//
		?>

		<!-- Begining of Facebook Scripts -->
		<div id="fb-root"></div>
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
				<li><a href="./">About</a></li>
				<li><a href="./">Contact</a></li>
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
			<h3>SEARCH</h3>
			<div id="search">
				<input type="text" class="search" /><input type="submit" class="submit" value="Find" />
			</div><!-- search -->
			<p>&nbsp;</p>
			<h3>Your Current Points:</h3>
            <div id="facebooklogin" style="background-image:url(images/bg_points.jpg); background-position:center; background-repeat:no-repeat; height:100px">
            	<p style="text-align:center; font-size:36px; padding-top:40px; color:#FC0">
            		<?php
            			print 56;
            		?>
            	</p>
            </div>
            <div id="googlelogin">
            <h3 style="padding-top:10px">Your Challenges:</h3>
            <ul style="padding-left:5px">
            	<li><a href="./" title="Challenge A">Challenge A</a></li>
            </ul>
            
            <h3></h3>
            	<?php 
					/*$query = 'SELECT * FROM USER where userID =' . "'" . $id. "'";
					$result = mysql_query($query);
					echo $query;

            		//$query = 'DELETE FROM USER WHERE userID = ' . $id; 
            		//$result = mysql_query($query);
					
					if ($result) {
						while ($row = mysql_fetch_array($result)) {
							$firstName = $row['firstName'];
							$lastName = $row['lastName'];
							$phone = $row['phone'];
							$prefferedEmail = $row['prefferedEmail'];
							$age = $row['age'];
							$weight = $row['weight'];
							
							echo '<p>First Name:	<input type="text" class="search" value="' . $firstName . '"> /></p>';
							
							//print results to page
							//echo '<div id="favorite">'."\r";	
							//echo '<div id="desc'.$num.'" >'.$desc.'<div>'."\r";
							//echo '<div id="miles'.$num.'" >'.$miles.'<div>'."\r";
							//echo '</div>'."\r";	
							//echo "\r";
						}
					}*/
					
            	?> 
            
            </div>
		</div><!-- cA -->
		<div id="cB">
			<div class="Ctopright"></div>
			<div id="cB1">
				<h3>Change Your Profile Settings:</h3>
				<div class="news">
					
                    <!-- MY TEAM INFORMATION -->
                    <?php
						if($id != "")
						{
							//echo 'My userID is '.$id.'<br>';
							
							$teamID = 0;
							$query = "SELECT teamID from USERTEAM WHERE userID=".$id;
							$result = mysql_query($query);
							
							while($row = mysql_fetch_array($result))
							{
								$teamID = $row["teamID"];
							}
							if($teamID != 0)
							{
								// User is on a team.
								//echo $teamID."<br>";
								$query = "SELECT name FROM TEAM WHERE teamID=".$teamID;
								$result = mysql_query($query);
								$teamName = '';
								while($row = mysql_fetch_array($result)) {
									$teamName = $row["name"];	
								}
								
								echo "Your team:<br><center><h1>".$teamName."</h1></center><br>";
								echo "Total Points: <i>[TODO: Place Team Points]</i><br><br>";
								
								echo "Other users on your team: <br>";
								$query = "SELECT * FROM USERTEAM WHERE teamID=".$teamID;
								$result = mysql_query($query);
								echo "<ol>";
								while($row = mysql_fetch_array($result)) {
									$userID = $row["userID"];
									$query2 = "SELECT * FROM USER WHERE userID=".$userID;
									$result2 = mysql_query($query2);
									while($row = mysql_fetch_array($result2)) {	
										$fName = $row["firstName"];
										$lName = $row["lastName"];
										$isAdmin = $row["isAdmin"];
										if($isAdmin)
											echo "<b>";
										echo "<li>".$fName." ".$lName."</li>";
										if($isAdmin)
											echo "</b>";
									}
								}
								echo "</ol>";
								echo "<br><br>";
								echo "<input type='button' value='Leave Team'><br>";
							}
							else
							{
								// User is not on a team.
								echo "You aren't on any teams!<br><br>
								<h3>Join a team:</h3><br>";								
								echo "<form name='addToTeam' action='addtoteam.php' method='post'>";
								echo "<input type='hidden' name='usersID' value=".$id.">";
								echo "<select name='teamName'>";
								$query = "SELECT * FROM TEAM";
								$result = mysql_query($query);
								while($row = mysql_fetch_array($result))
								{
									$name = $row["name"];
									echo "<option value='".$name."'>".$name."</option>";
								}
								echo "</select>";
								echo "<br><input type='submit' value='Join'><br>";
								echo "</form>";
							}
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
				<h3>CHALLENGE NEWS</h3>
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
			<br class="clear" /><div class="Cbottomleft"></div><div class="Cbottom"></div><div class="Cbottomright"></div>
		</div><!-- Cpad -->
	</div><!-- content -->
	<div id="properspace"></div><!-- properspace -->
</div><!-- daddy -->
<div id="footer">
	<div id="foot">
		<div id="foot1"><a href="mailto:it391project@gmail.com">it391project@gmail.com</a> - <a href="./"></a></div><!-- foot1 -->
		<div id="foot2">
			Copyright 2011, IT391. Designed by <a href="http://www.symisun.com/" title="We digitalize your ambitions">SymiSun<span class="star">*</span></a>
		</div><!-- foot1 -->
	</div><!-- foot -->
</div><!-- footer -->
</body>
</html>
