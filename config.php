<?php
require_once('./lib/start.php');

require_once('./lib/smarty/Smarty.class.php');

$smarty = new Smarty();

// задание дефолтных системных директорий
$smarty->template_dir = './templates';
$smarty->compile_dir  = './template_c';
$smarty->config_dir   = './configs';
$smarty->cache_dir    = './cache';
