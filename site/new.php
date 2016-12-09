<?php
$query = 'Nikita%20Platonenko';
$url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=".$query;

$body = file_get_contents($url);
$json = json_decode($body);

for($x=0;$x<count($json->responseData->results);$x++){

echo "<b>Result ".($x+1)."</b>";
echo "<br>URL: ";
echo $json->responseData->results[$x]->url;
echo "<br>VisibleURL: ";
echo $json->responseData->results[$x]->visibleUrl;
echo "<br>Title: ";
echo $json->responseData->results[$x]->title;
echo "<br>Content: ";
echo $json->responseData->results[$x]->content;
echo "<br><br>";

}

?>
