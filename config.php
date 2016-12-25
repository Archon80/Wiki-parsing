<?php
// настройки соединения
ini_set('display_errors','On');
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('display_startup_errors', '1');

error_reporting(E_ALL | E_STRICT);

header('Content-type: text/html; charset=utf-8');

// подключение и инициация шаблонизатора
require_once('./lib/smarty/Smarty.class.php');
$smarty = new Smarty();

// задание дефолтных системных директорий
$smarty->template_dir = './templates';
$smarty->compile_dir  = './template_c';
$smarty->config_dir   = './configs';
$smarty->cache_dir    = './cache';
