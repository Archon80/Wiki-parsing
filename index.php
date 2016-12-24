<?php
// конфигурационные настройки: подключение Smarry, и проч.
require_once 'config.php';

// основная логика
//...

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
