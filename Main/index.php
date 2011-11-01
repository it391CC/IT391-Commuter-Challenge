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
$usertable='usercomp';
$yourfield = 'mileage';

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

<!DOCTYPE html>
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
		<?php
		//add user from Google
if(@$_REQUEST['openid_mode'] === 'id_res') {


$firstname = $_REQUEST['openid_ext1_value_first'];
$lastname = $_REQUEST['openid_ext1_value_last'];
$email = $_REQUEST['openid_ext1_value_email'];

//Query to get user name

				$query = 'SELECT userid FROM USER where loginemail = ' . "'" . $email . "'";
				$result = mysql_query($query);
				if ($result) {
					while ($row = mysql_fetch_array($result)) {
						$id = $row['userid'];
						$registered = true;
					}
				}
			// Add User to Database
					if (isset($_POST['first'])) {
						$first = $_POST['first'];
						$last = $_POST['last'];
						$phone = $_POST['phone'];
						$age = $_POST['age'];
						$weight = $_POST['weight'];
						$prefemail = $_POST['email'];

						$query = 'INSERT INTO USER (firstName,lastName,phone,loginEmail,prefferedEmail,age,weight,isAdmin) VALUES("' . $first . '","' . $last . '",' . $phone . ',"' . $email . '","' . $prefemail . '",' . $age . ',' . $weight . ',0' . ');';
						echo $query;
						$result = mysql_query($query);
						// add check to see if user was added successfully
						$registered = true;
					}
				}
		?>
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
					
			// Add User to Database
					if (isset($_POST['first'])) {
						$first = $_POST['first'];
						$last = $_POST['last'];
						$phone = $_POST['phone'];
						$age = $_POST['age'];
						$weight = $_POST['weight'];
						$prefemail = $_POST['email'];

						$query = 'INSERT INTO USER (firstName,lastName,phone,loginEmail,prefferedEmail,age,weight,isAdmin) VALUES("' . $first . '","' . $last . '",' . $phone . ',"' . $email . '","' . $prefemail . '",' . $age . ',' . $weight . ',0' . ');';
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
	
	<!-- document body -->
	<body>
		<div id="daddy">
			<div id="header">
				<div id="logo">
					<a href="./"><img src="images/logo.gif" alt="Your Company Logo" width="318" height="85" /></a><span id="logo-text"><a href="./"></a></span>
				</div><!-- logo -->
				<div id="menu">
					<ul>
						<li>
							<a href="index.php" id="active">Home</a>
						</li>
						
						<!-- rendered if logged in and registered -->
						<?php if ($fbme || @$_REQUEST['openid_mode'] == 'id_res'){
						?>
						<?php if ($registered){
						?>
						<li>
							<a href="profile.php">Profile</a>
						</li>
						<li>
							<a href="competition.php">Challenges</a>
						</li>
						<li>
							<a href="commutes.php">Commutes</a>
						</li>
						<?php }?>
						<?php }?>
						<!-- end conditional render -->
						
						<li>
							<a href="./">About</a>
						</li>
						<li>
							<a href="./">Contact</a>
						</li>
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
					
					<!-- uneeded search -->
					<!--<h3>SEARCH</h3>
					<div id="search">
						<input type="text" class="search" />
						<input type="submit" class="submit" value="Find" />
					</div> search -->
	
					<div id="facebooklogin">
						<p class="testimonial">
							<!-- rendered if user is not logged in -->
							<?php if (!$fbme):
							?>
							<!-- Facebook Login Button-->
							<a href='#' id='login' class='customLoginLink'><img src="images/facebook_icon.jpg" alt="Facebook Icon" width="87" height="100"/></a>
							<script type='text/javascript'>
								$('#login').click(function(event) {
									FB.login(function(response) {
										if(response.session) {
											if(response.perms) {
												// user is logged in and granted some permissions.
												// perms is a comma separated list of granted permissions
											} else {
												// user is logged in, but did not grant any permissions
											}
										} else {
											// user is not logged in
										}
									}, {
										perms : 'publish_stream, read_stream, email, user_birthday'
										//permissions granted by user
									});
								});

							</script>
							<?php else:?>
								
							<!-- Facebook Logout Button-->
							<a href='#' id='logout' class='customLoginLink'><img src="images/facebook_icon.jpg" alt="Facebook Icon" width="87" height="100"/></a>
							<script type='text/javascript'>
								$('#logout').click(function(event) {
									FB.logout(function(response) {
									});
								});
							</script>
							<!-- end conditional render -->
							<?php endif;?>
						</p>
					</div>
					<div id="googlelogin">
						<p class="testimonial">
							<!-- rendered if user is logged into Google --> 
							<?php if(@$_REQUEST['openid_mode'] === 'id_res'):
							?>
							<!-- Google log out button -->
							<a href="http://limbotestserver.com"
							onclick="myIFrame.location='https://www.google.com/accounts/Logout';StartPollingForCompletion();return false;"> <img src="images/google_icon.jpg"/></a>
							<?php else:?>
							<a href="<?php echo $_SERVER['PHP_SELF'] . '?openid_mode=checkid_setup&openid_identifier=google.com/accounts/o8/id' ?>" id="LoginWithGoogleLink"><span class="google"><img src="images/google_icon.jpg" /></a>
							<?php endif;?>
							<!-- end Google log out button -->
						</p>
					</div>
					<br/>
					<br/>
					<br/>
					&nbsp;&nbsp;&nbsp;
				</div><!-- cA -->
				<div id="cB">
					<div class="Ctopright"></div>
					<div id="cB1">
						<!-- main body text -->
						<div class="news">
							<?php if(@$_REQUEST['openid_mode'] !== 'id_res' && !$fbme) {
							?>
							<h3>Welcome to the GREEN COMMUTE CHALLENGE!</h3>
							<p>
								The Green Commute Challenge is a point-based competition centered on getting people to use alternative forms of transportation as they go about their everyday lives.
							</p>
						</div>
						<!-- not sure why there are multiple divs-->
						<div class="news">
							<p>
								Registering with us requires a <a href="http://www.facebook.com/">Facebook</a> or <a href="https://accounts.google.com/ServiceLogin?hl=en&continue=http://www.google.com/">Google</a> account and just a few clicks. As a user, you'll be able to enter your daily commutes into the system. Just choose a commute type and enter your miles travelled and you'll be awarded a point value. Rack up your points, and compare how you're doing with your friends with our search feature.
							</p>
						</div>
						<div class="news">
							<p>
								From time to time, a competition may be created by the system administrator. Any user or team of users will be able to enter any number of active competitions, and the points earned will be put toward the competition. Have the most points at the end of a competition? You may be eligible for prizes.
							</p>
						</div>
						<div class="news">
							<p>
								Commute. Enter. Win. It's that easy. Get started by logging in with your Facebook or Google account to the left.
							</p>
						</div>
						<div class="news">
							<p>
								Good luck!
							</p>
							<!-- rendered if user is logged into Facebook but not present in the system -->
							<?php }?>
							<?php if($fbme ||  @$_REQUEST['openid_mode'] == 'id_res' ) {
							?>
							<?php if (! $registered){
							?>
							<form name="register" action="<?=$config['baseurl']?>" method="post">
								<h3>Welcome, please enter your information below(currently all fields are required)</h3>
								<p>
									First Name:
									<input type="text" class="search" id="first" name="first" value="<?php print $firstname ?>"  />
								</p>
								<p>
									Last Name:
									<input type="text" class="search" id="last" name="last" value="<?php print $lastname ?>" />
								</p>
								<p>
									Phone(No Dashes):
									<input type="text" class="search" id="phone" name="phone" />
								</p>
								<p>
									Age:
									<input type="text" class="search" id="age" name="age" />
								</p>
								<p>
									Weight:
									<input type="text" class="search" id="weight" name="weight" />
								</p>
								<h3 style="padding-top:20px">Contact Information</h3>
								<p>
									E-mail:
									<input type="text" class="search"  id="email" name="email" value="<?php print $email ?>" />
								</p>
								<input type="submit" value="Register"/>
								<br/>
								<br/>
							</form>
							<?php }?>
							<?php }?>

					<!-- rendered if logged into google -->
							<?php if(@$_REQUEST['openid_mode'] === 'id_res' && $registered) {
							?>

							You are logged into Google as <?php echo "{$_REQUEST['openid_ext1_value_first']} {$_REQUEST['openid_ext1_value_last']} - {$_REQUEST['openid_ext1_value_email']}"
							?>

							<br/>
							<br/>
							<br/>
							<?php }?>
							<?php if ($fbme && $registered){
							?>
							You are logged into Facebook <!-- Display user name-->
							<?php
							foreach ($userInfo as $result) {
								print "as " . ($result['name']) . " - " . ($result['email']) . "</br>";
							}
							?>

							<?php }?>
						</div>
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
						<h3>CHALLENGE NEWS</h3>
						<div class="about">
							<ul>
								<li>
									Challenge website is under constructon
								</li>
								<li>
									Challenges begin MAY 2012
								</li>
								<li>
									Look for our Android mobile app
								</li>
							</ul>
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
</html>