<?php
 include "probnik.php"; 
$search = new iMarc\GoogleCustomSearch(012801828530494578547:7ddq3fkh7ew, AIzaSyD7Vffkn2jWpPwwfSwHrVhMH4dBHGSl_AA);
 $results = $search->search('Apples');
Echo $results;
 ?>
