<?php
require_once '../app/config.php';
require_once('../vendor/smarty/Smarty.class.php');

$smarty = new Smarty();

// задание дефолтных системных директорий
$smarty->template_dir = '../app/view/templates';
$smarty->compile_dir  = '../app/view/template_c';
$smarty->cache_dir    = '../tmp/cache';

// парсим шаблоны-вставки (хедер, и оба блока с контентом)
$menu = $smarty->fetch('menu.tpl');
$import = $smarty->fetch('import.tpl');
$search = $smarty->fetch('search.tpl');

// формируем переменные для главного шаблона
$smarty->assign('title', 'CUBA');
$smarty->assign('menu', $menu);
$smarty->assign('import', $import);
$smarty->assign('search', $search);

// подключаем главный шаблон
if ($smarty->templateExists('main.tpl')) {
	$smarty->display('main.tpl');
}
