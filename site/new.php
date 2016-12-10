 <html>
  <head>
   <title>Тестируем PHP</title>
  </head>
  <body>
  <?php echo '<p> hello </p>'; ?>
  <?php

         $search =str_replace(' ', '+', @$_GET["q"]);

            $query = $search;
            for ($i=1; $i < 100; $i+8) { 



            $url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=8&start=".$i."&q=".$query;
            $body = file_get_contents($url);
            $json = json_decode($body);

            for($x=0;$x<count($json->responseData->results);$x++){

            echo "<b>Result ".($x+1)."</b>";
            echo "<br>URL: ";
            ?>
            <a href="<?php echo $json->responseData->results[$x]->url; ?>" target="_blank"> <?php echo $json->responseData->results[$x]->url; ?> </a>
            <?php
            echo "<br>VisibleURL: ";
            ?>
            <a href="http://<?php echo $json->responseData->results[$x]->visibleUrl; ?>" target="_blank"> <?php echo $json->responseData->results[$x]->visibleUrl; ?> </a>
            <?php

            echo "<br>Title: ";
            echo $json->responseData->results[$x]->title;
            echo "<br>Content: ";
            echo $json->responseData->results[$x]->content;
            echo "<br><br>";              

        }
            $i+=8;
         }
?>
  </body>
</html>
