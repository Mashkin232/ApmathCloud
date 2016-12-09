<?php
/* Accessing the Google Web API via PHP
   - by Simon Willison (simon@incutio.com)
   This code is in the public domain - do whatever you want with it

   To use this code you will need both PEAR and the PEAR SOAP package
   installed somewhere on your php include path. You can get the SOAP
   package from CVS:

   cvs -d :pserver:cvsread@cvs.php.net:/repository login
   (enter phpfi as the password)
   cvs -d :pserver:cvsread@cvs.php.net:/repository co pear/SOAP

   You will need a Google license key - see this site:
      http://www.google.com/apis/

*/

include("SOAP/Client.php");

// Google search query
$query = 'soap';

// Your google license key
$key = 'xxxxxxxxxxxxxxxxxxxxxxxxx';

$s = new SOAP_Client('http://api.google.com/search/beta2');
$result = $s->call('doGoogleSearch', array(
    'key' => $key,
    'q' => $q,
    'start' => 0,
    'maxResults' => 10,
    'filter' => false,
    'restrict' => '',
    'safeSearch' => false,
    'lr' => '',
    'ie' => '',
    'oe' => '',
), 'urn:GoogleSearch');

// Is result a PEAR_Error?
if (get_class($result) == 'pear_error')
{
	$message = $result->message;
	$output = "An error occured: $message<p>";
}
else
{
	// We have proper search results
	$num = $result['estimatedTotalResultsCount'];
	$elements = $result['resultElements'];
	$list = '';
	if ($num > 0) {
		foreach ($elements as $item) {
			$size = $item['cachedSize'];
			$title = $item['title'];
			$url = $item['URL'];
			$snippet = $item['snippet'];
			$desc = "<p><b>$title</b> - <a href=\"$url\">$url</a> ";
			$desc .= "<small>[Size: $size]</small></p>";
			$desc .= "\n<blockquote>$snippet</blockquote>\n\n";
			$list .= $desc;
		}
	}
	$output = "$num results returned:\n\n$list";
}
echo $output;
?>
