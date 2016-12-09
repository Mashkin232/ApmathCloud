<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Поиск по сайту с использованием Google | Демонстрация для сайта RUSELLER.COM</title>
<link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
<div id="page">
<h1>Поиск по сайту с использованием Google</h1>
<form id="searchForm" method="post">
<fieldset>
<input id="s" type="text" />
<input type="submit" value="Submit" id="submitButton" />
<div id="searchInContainer">
<input type="radio" name="check" value="site" id="searchSite" checked />
<label for="searchSite" id="siteNameLabel">Поиск по</label>
<input type="radio" name="check" value="web" id="searchWeb" />
<label for="searchWeb">Поиск в Интернет</label>
</div>
<ul class="icons">
<li class="web" title="Страницы" data-searchType="web">Страницы</li>
<li class="images" title="Изображения" data-searchType="images">Изображения</li>
<li class="news" title="Новости" data-searchType="news">Новости</li>
<li class="videos" title="Видео" data-searchType="video">Видео</li>
</ul>
</fieldset>
</form>
<div id="resultsDiv"></div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="script.js"></script>
</body>
</html>
