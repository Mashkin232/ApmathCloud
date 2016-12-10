<html>
  <head>
    <title> php</title>
  </head>
  <body>
    <?php 
    echo '<p>hello world</p>';
    ?>
    <?php
//Получаем настройки поискового запроса
//$data    = MyDB::get() -> selectOne('*',self::TABLE,'`id_mod` = '.$this->id_mod);

//На каком сайте ищем?
$sireUrl = $data['url'];

//Данные полученные от пользователя
$sigs = array(
  'q'    => array('type' => 'string', 'required' => false),
  'start'  => array('type' => 'integer', 'required' => false)
);
$reqData = SpeData::sanitize_vars($this->queryArray, $sigs, 'RequestException');    
$q     = urlencode($reqData['q'].' site:'.$sireUrl);
$start   = empty($reqData['start']) ? 0 : $reqData['start']; 

//Отправляем запрос гуглу, собственно это основаня часть :)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&q=$q&rsz=large&hl=ru&start=$start");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, "http://$sireUrl/");
$body = curl_exec($ch);
curl_close($ch);

//Ответ получили, в принципе, зада выполнена :)
$json = json_decode($body);
//На этом этапе можно сделать print_r($json) и все станет понятно
//Но что бы в smarty было проще разобрать результаты, можно преобразовать его в следующий вид

$search = array();

//Результаты поиска
if (count($json -> responseData -> results) == 0) { //если ничего не найдено
  $search['result'] = false;
} else {
  foreach ($json -> responseData -> results as $v) {
    $search['result'][] = array(
      'GsearchResultClass'   => $v -> GsearchResultClass,
      'unescapedUrl'       => $v -> unescapedUrl,
      'url'           => $v -> url,
      'visibleUrl'       => $v -> visibleUrl,
      'cacheUrl'         => $v -> cacheUrl,
      'title'         => $v -> title, //заголовок найденого документа (индексируется ведь не только html-странички)
      'titleNoFormatting'   => $v -> titleNoFormatting,
      'content'         => $v -> content //выдержка из текста документа
    ); 
  }
}

//Список ссылок на остальные результаты поиска 
if (count($json -> responseData -> results) == 0) { //если ничего не найдено
  $search['pages'] = false;
} else {    
  $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REDIRECT_URL'].'?q='.$reqData['q'];
  foreach ($json -> responseData -> cursor -> pages as $v) {
    $search['pages'][] = array(
      'start'   => $v -> start,
      'startUrl'  => $url.'&start='.$v -> start,
      'label'   => $v -> label
    );
  }
}

//Общая информация о результатах поиска
$currentPageIndex = $json -> responseData -> cursor -> currentPageIndex;
$search['info'] = array(
  'q'            => $reqData['q'],
  'estimatedResultCount'   => $json -> responseData -> cursor -> estimatedResultCount,
  'moreResultsUrl'    => $json -> responseData -> cursor -> moreResultsUrl,
  'currentPageIndex'     => $currentPageIndex,
  'currentLabel'      => $currentPageIndex + 1,
  'startResult'      => $currentPageIndex * 8 + 1,
  'endResult'        => ($currentPageIndex * 8 + 1) + count($search['result']),
  'next'          => (count($search['pages']) > $currentPageIndex + 1) ? $search['pages'][$currentPageIndex + 1]['startUrl'] : false,
  'prev'          => ($currentPageIndex) ? $search['pages'][$currentPageIndex - 1]['startUrl'] : false
);
  

//Все готово
MySmarty::get() -> assign('search', $search);

?>
 
 
