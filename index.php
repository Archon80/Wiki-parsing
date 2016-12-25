<?php
// конфигурационные настройки: подключение Smarry, и проч.
require_once 'config.php';
require_once 'lib/Tools.trait.php';
require_once 'lib/add_article.php';
require_once 'lib/db.php';

// информационное сообщение для пользователя
$answer = '';

// итог импорта статьи
$res = [
	"success" => false,
    "body"    => '',
    "error"   => ''
];

// AddArticles::showDev($_POST);// просто отладочный вывод

// если была совершена отправка данных из формы (т.е пользователь нажал "Найти статью")
if (AddArticles::isUserQuery()) {
	$arrArticle = []; // cсформированный массив данных о статье (для сохранения в БД)

	// в целях безопасности обрабатываем запрос пользователя
	$user_query = AddArticles::clearData($_POST['field_search_in_wiki']);// получение и обработка данных от клиента

	// проверяем, есть ли такая статья, и засекаем время работы скрипта с АПИ википедии
	$time_start = microtime(true);
	$article = AddArticles::isArticle($user_query);

	// если произошла техническая ошибка, и скрипт выбросил исключение
	if($article['error']) {
		$answer = 'Произошла техническая ошибка.';// не будем пугать пользователя техническими подробностями
		AddArticles::errorLog($article['error']); // а здесь уже подробная информация для разработчиков
	}
	// если ошибок не было, но статья не найдена
	elseif(!$article['success']) {
		// $answer = $article['body'];// реальный текст о не найденной статье от АПИ
		$answer = 'По вашему запросу ничего не найдено.';
	}
	// если статья безошибочно обнаружена и получена от АПИ
	else {
		// AddArticles::showDev($article['body']);

		// информация о статье (в виде массива) - для добавления в БД
		$arrArticle = AddArticles::getArrayForArticle($user_query, $article['body']);

		// формируем объект слов (из данной статьи) для сохранения в БД
        $arrWords = AddArticles::getArrayForWords($arrArticle['content']);

        // единой транзакцией добавляем в БД и статью, и слова к ней
        $res = DB::add($arrArticle, $arrWords);

        $time_end = microtime(true);
		$full_time = round($time_end - $time_start, 5);
   		$answer = AddArticles::getTotalInfo($res, $arrArticle, $full_time);
   		AddArticles::reloadPage();// вынужденная мера: защита от спама в БД по кнопке F5
	}
}
if (AddArticles::isEmptyUserQuery()) {
	$answer = 'Необходимо ввести название статьи.';
}
$smarty->assign('answer', $answer);



// парсим шаблоны-вставки (хедер, и оба блока с контентом)
$menu = $smarty->fetch('menu.tpl');
$import = $smarty->fetch('import.tpl');
$search = $smarty->fetch('search.tpl');

// формируем переменные для главного шаблона
$smarty->assign('menu', $menu);
$smarty->assign('import', $import);
$smarty->assign('search', $search);

// подключаем главный шаблон
if ($smarty->templateExists('main.tpl')) {
	$smarty->display('main.tpl');
}
