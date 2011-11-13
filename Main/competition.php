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

mysql_connect($hostname,$username, $password) OR DIE ('Unable to connect to database! Please try again later.');
mysql_select_db($dbname);

$user = $_SESSION['user'] ;
echo $user;

$query = 'SELECT userID FROM USER where loginEmail = ' . "'" . $user . "';";
echo $query;	
$result = mysql_query($query);
				if ($result) {
					while ($row = mysql_fetch_array($result)) {
						$id = $row['userID'];

					}
				}
$query = 'SELECT isAdmin from USER
where userID=' .$id.';';	
echo $query;	
$result = mysql_query($query);
				if ($result) {
					while ($row = mysql_fetch_array($result)) {
						$admin = $row['isAdmin'];
						echo $admin;
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
		<link rel="stylesheet" href="style.css" />
		<link rel="stylesheet" href="calendar/calendar.css" />
		<script language="javascript" src="calendar/calendar.js"></script>
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
							<a href="competition.php" id="active">Challenges</a>
						</li>
						<li>
							<a href="commutes.php" >Commutes</a>
						</li>
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
			<div id="cA">
				<div class="Ctopleft"></div>
				<!-- <h3>SEARCH &nbsp; &nbsp; &nbsp; <fb:login-button autologoutlink="true" onlogin="Log.info('onlogin callback')" perms="publish_stream, read_stream, email, user_birthday"></fb:login-button></h3> -->
				<!-- <div id="search">
					<input type="text" class="search" />
					<input type="submit" class="submit" value="Find" />
				</div><!-- search --> 
				<p>
					&nbsp;
				</p>
				<!-- <h3>Your Current Points(currently miles for testing):</h3>
				<div id="facebooklogin" style="background-image:url(images/bg_points.jpg); background-position:center; background-repeat:no-repeat; height:100px">
					<p style="text-align:center; font-size:36px; padding-top:40px; color:#FC0">
						<?php print "".$totalmiles
						?>
					</p>
				</div>
				<div id="googlelogin">
					<h3 style="padding-top:10px">Your Challenges:</h3>
					<ul style="padding-left:5px">
						<li>
							<a href="./" title="Challenge A">Challenge A</a>
						</li>
					</ul>
				</div> -->
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
							print "<br/><br/><b>New challenge entered succefully!!</b><br/>Name:&nbsp;&nbsp;".$name."<br/>Start:&nbsp;&nbsp;&nbsp;".$date1."<br/>End:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$date1;
						}
					?>
					<!-- close admin check -->
	<?php }?>
	<?php if($admin==0) {
							?>
							
							<?php print "Please log in as an administrative user to view challenges"?>
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
						<h3>Current Competitions</h3>
						<div class="about">
						<!-- add current competitions here -->
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
	<?php if (!$fbme){
	?>
	<!-- <meta HTTP-EQUIV="REFRESH" content="0; url=http://limbotestserver.com"> -->
	<?php }?>
</html>
