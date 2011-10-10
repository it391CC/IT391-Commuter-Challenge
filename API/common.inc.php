<?php
/* Copyright (c) 2007 Google Inc.
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

// OAuth libraries - http://oauth.googlecode.com/svn/code/php/
require_once('OAuth.php');

// OpenID libraries - http://www.openidenabled.com/php-openid/
require_once 'Auth/OpenID/Consumer.php';
require_once 'Auth/OpenID/FileStore.php';
require_once 'Auth/OpenID/SReg.php';
require_once 'Auth/OpenID/PAPE.php';

// Google's accepted signature methods
$hmac_method = new OAuthSignatureMethod_HMAC_SHA1();
$rsa_method = new OAuthSignatureMethod_RSA_SHA1();

$SIG_METHODS = array($rsa_method->get_name() => $rsa_method,
                     $hmac_method->get_name() => $hmac_method);

/**
 * Makes an HTTP request to the specified URL
 *
 * @param string $http_method The HTTP method (GET, POST, PUT, DELETE)
 * @param string $url Full URL of the resource to access
 * @param string $auth_header (optional) Authorization header
 * @param string $postData (optional) POST/PUT request body
 * @param bool $returnResponseHeaders True if resp. headers should be returned.
 * @return string Response body from the server
 */
function send_signed_request($http_method, $url, $auth_header=null,
                             $postData=null, $returnResponseHeaders=true) {
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_FAILONERROR, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

  if ($returnResponseHeaders) {
    curl_setopt($curl, CURLOPT_HEADER, true);
  }

  switch($http_method) {
    case 'GET':
      if ($auth_header) {
        curl_setopt($curl, CURLOPT_HTTPHEADER, array($auth_header));
      }
      break;
    case 'POST':
      $headers = array('Content-Type: application/atom+xml', $auth_header);
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl, CURLOPT_POST, 1);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
      break;
    case 'PUT':
      $headers = array('Content-Type: application/atom+xml', $auth_header);
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $http_method);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
      break;
    case 'DELETE':
      $headers = array($auth_header);
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $http_method);
      break;
  }
  $response = curl_exec($curl);
  if (!$response) {
    $response = curl_error($curl);
  }
  curl_close($curl);
  return $response;
}

/**
 * Prettifies an XML string into a human-readable and indented work of art.
 *
 * @param string $xml The XML as a string
 * @param boolean $html_output True if the output should be escaped (for HTML)
 * @return string A beautifully formatted XML string. *
 */
function xml_pp($xml, $html_output=false) {
  $xml_obj = new SimpleXMLElement($xml);
  $level = 4;  // level to indent tagseleme
  $indent = 0; // current indentation level
  $pretty = array();

  // get an array containing each XML element
  $xml = explode("\n", preg_replace('/>\s*</', ">\n<", $xml_obj->asXML()));

  // shift off opening XML tag if present
  if (count($xml) && preg_match('/^<\?\s*xml/', $xml[0])) {
    $pretty[] = array_shift($xml);
  }

  foreach ($xml as $el) {
    if (preg_match('/^<([\w])+[^>\/]*>$/U', $el)) {
      // opening tag, increase indent
      $pretty[] = str_repeat(' ', $indent) . $el;
      $indent += $level;
    } else {
      if (preg_match('/^<\/.+>$/', $el)) {
        $indent -= $level;  // closing tag, decrease indent
      }
      if ($indent < 0) {
        $indent += $level;
      }
      $pretty[] = str_repeat(' ', $indent) . $el;
    }
  }
  $xml = implode("\n", $pretty);
  return ($html_output) ? htmlentities($xml) : $xml;
}

/**
 * Prettifies a JSON object.
 *
 * @param string $json A string formmatted as a JSON object
 * @return string Formatted json object for pretty print.
 */
function json_pp($json) {
  $tab = '  ';
  $new_json = '';
  $indent_level = 0;
  $in_string = false;

  $json_obj = json_decode($json);

  if(!$json_obj) {
    return $new_json;
  }

  $json = json_encode($json_obj);
  $len = strlen($json);

  for($c = 0; $c < $len; $c++) {
    $char = $json[$c];
    switch($char) {
      case '{':
      case '[':
        if(!$in_string) {
          $new_json .= $char . "\n" . str_repeat($tab, $indent_level + 1);
          $indent_level++;
        } else {
          $new_json .= $char;
        }
        break;
      case '}':
      case ']':
        if(!$in_string) {
          $indent_level--;
          $new_json .= "\n" . str_repeat($tab, $indent_level) . $char;
        } else {
          $new_json .= $char;
        }
        break;
      case ',':
        if(!$in_string) {
          $new_json .= ",\n" . str_repeat($tab, $indent_level);
        } else {
          $new_json .= $char;
        }
        break;
      case ':':
        if(!$in_string) {
          $new_json .= ': ';
        } else {
          $new_json .= $char;
        }
        break;
      case '"':
        $in_string = !$in_string;
      default:
        $new_json .= $char;
        break;
    }
  }
  return $new_json;
}

/**
 * Joins key:value pairs by inner_glue and each pair together by outer_glue
 *
 * @param string $inner_glue The HTTP method (GET, POST, PUT, DELETE)
 * @param string $outer_glue Full URL of the resource to access
 * @param array $array Associative array of query parameters
 * @return string Urlencoded string of query parameters
 */
function implode_assoc($inner_glue, $outer_glue, $array) {
  $output = array();
  foreach($array as $key => $item) {
    $output[] = $key . $inner_glue . urlencode($item);
  }
  return implode($outer_glue, $output);
}

function explode_assoc($glue1, $glue2, $array) {
  $tempArr = explode($glue2, $array);
  foreach($tempArr as $val) {
    $pos = strpos($val, $glue1);
    $key = substr($val, 0, $pos);
    $array2[$key] = substr($val, $pos + 1, strlen($val));
  }
  return $array2;
}

function debug($message) {
  echo "<div class=\"errors\">$message</div>";
}
?>
