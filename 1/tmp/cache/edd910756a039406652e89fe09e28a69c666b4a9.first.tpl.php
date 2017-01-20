<?php
/* Smarty version 3.1.30, created on 2016-12-19 20:45:59
  from "/var/www/html/sm3/templates/first.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58581cd7590ae6_20778300',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a5c06b0d9162d6caf60ad0dd47722628523ec873' => 
    array (
      0 => '/var/www/html/sm3/templates/first.tpl',
      1 => 1482164022,
      2 => 'file',
    ),
    '759cd0a8287063c37e71974b9c4f04bdcf1eda12' => 
    array (
      0 => '/var/www/html/sm3/templates/second.tpl',
      1 => 1482161687,
      2 => 'file',
    ),
  ),
  'cache_lifetime' => 3600,
),true)) {
function content_58581cd7590ae6_20778300 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title><br />
<b>Notice</b>:  Undefined index: title in <b>/var/www/html/sm3/template_c/a5c06b0d9162d6caf60ad0dd47722628523ec873_0.file.first.tpl.cache.php</b> on line <b>30</b><br />
<br />
<b>Notice</b>:  Trying to get property of non-object in <b>/var/www/html/sm3/template_c/a5c06b0d9162d6caf60ad0dd47722628523ec873_0.file.first.tpl.cache.php</b> on line <b>30</b><br />
</title>
	<meta charset="utf-8" />
</head>	
<body>		
	

	<!-- Простая переменная -->
	<div>Darnas</div>

	<br><hr>
	<!-- Вывод индивидуальных элементов массивов -->
	5
	<br>
	PHP
	

	<br><hr>
	<!-- Условие -->
			<div>Условие не сработало...</div>
	

	<br><hr>
	<!-- цикл foreach -->
			<div>pl - PHP</div>
			<div>name - Archon</div>
	

	<br><hr>
	<!-- подключение шаблона из шаблона -->
	<h3>Я - шаблон second.tpl !!!</h3>

	<br><hr>
	<!-- подключение шаблона из контроллера за счет буфферизации -->
	<h3>Я - шаблон second.tpl !!!</h3>

	<br><hr>
	<!-- буфферизация в шаблоне -->
	
	<div>До этой строки была выполнена буфферизация в шаблоне. Но выведена она будет ниже...</div>
		<!-- А здесь происходит вывод буфферизированных данных -->
		
		<div>И вот она, буфферизация!!!</div>
	


	<br><hr>
	<!-- использование файлов конфигурации -->
		<!-- подключаем файл -->
		
		<div>Выводим переменную c1 (глобальная область видимости конфига) - Это глобальная переменнная из конфиг-файла</div>
		<div>Выводим переменную c2 (локальная  область видимости конфига) - Это локальная переменнная из конфиг-файла</div>




</body>
</html><?php }
}
