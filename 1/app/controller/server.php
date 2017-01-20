<?php       
require_once '../config.php';
require_once '../../vendor/safemysql/safemysql.class.php';
require_once '../model/db.php';
require_once '../model/add_article.php';

// получить все статьи (дефолтный запрос при загрузке главной страницы приложения)
if ( (isset($_POST['get_all_articles']) && $_POST['get_all_articles'] != '') ) {
	echo json_encode($DB->getAllArticles());
}

// на вкладке "Search" пользователь вбил в поиск название статьи, для поиска в БД
if ( (isset($_POST['get_some_words']) && $_POST['get_some_words'] != '') ) {
	echo json_encode($DB->getSomeWords($_POST['get_some_words']));
}

// добавляем статью в БД
if ( (isset($_POST['add_article_in_db']) && $_POST['add_article_in_db'] != '') ) {
	$res = AddArticles::main($_POST['add_article_in_db'], $DB);

	if ($res) {
		echo json_encode($res);
	}
}