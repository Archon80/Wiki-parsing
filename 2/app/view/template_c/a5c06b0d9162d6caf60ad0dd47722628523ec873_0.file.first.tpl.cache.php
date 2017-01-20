<?php
/* Smarty version 3.1.30, created on 2016-12-19 20:45:59
  from "/var/www/html/sm3/templates/first.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58581cd75837e1_61580546',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a5c06b0d9162d6caf60ad0dd47722628523ec873' => 
    array (
      0 => '/var/www/html/sm3/templates/first.tpl',
      1 => 1482164022,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:second.tpl' => 1,
  ),
),false)) {
function content_58581cd75837e1_61580546 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->compiled->nocache_hash = '181921791758581cd7547764_81389589';
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
	<meta charset="utf-8" />
</head>	
<body>		
	

	<!-- Простая переменная -->
	<div><?php echo $_smarty_tpl->tpl_vars['city']->value;?>
</div>

	<br><hr>
	<!-- Вывод индивидуальных элементов массивов -->
	<?php echo $_smarty_tpl->tpl_vars['num']->value[1];?>

	<br>
	<?php echo $_smarty_tpl->tpl_vars['ass']->value['pl'];?>

	

	<br><hr>
	<!-- Условие -->
	<?php if (isset($_smarty_tpl->tpl_vars['cnt']->value) && $_smarty_tpl->tpl_vars['cnt']->value == 'YII') {?>
		<div>Условие сработало!</div>
	<?php } else { ?>
		<div>Условие не сработало...</div>
	<?php }?>


	<br><hr>
	<!-- цикл foreach -->
	<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ass']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
		<div><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
 - <?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</div>
	<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>


	<br><hr>
	<!-- подключение шаблона из шаблона -->
	<?php $_smarty_tpl->_subTemplateRender("file:second.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


	<br><hr>
	<!-- подключение шаблона из контроллера за счет буфферизации -->
	<?php echo $_smarty_tpl->tpl_vars['template']->value;?>


	<br><hr>
	<!-- буфферизация в шаблоне -->
	<?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'buff', null, null);
?>

		<div>И вот она, буфферизация!!!</div>
	<?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);
?>

	<div>До этой строки была выполнена буфферизация в шаблоне. Но выведена она будет ниже...</div>
		<!-- А здесь происходит вывод буфферизированных данных -->
		<?php echo $_smarty_tpl->smarty->ext->_capture->getBuffer($_smarty_tpl, 'buff');?>



	<br><hr>
	<!-- использование файлов конфигурации -->
		<!-- подключаем файл -->
		<?php
$_smarty_tpl->smarty->ext->configLoad->_loadConfigFile($_smarty_tpl, 'handbook.conf', 'any_name_of_section', 0);
?>

		<div>Выводим переменную c1 (глобальная область видимости конфига) - <?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'c1');?>
</div>
		<div>Выводим переменную c2 (локальная  область видимости конфига) - <?php echo $_smarty_tpl->smarty->ext->configLoad->_getConfigVariable($_smarty_tpl, 'c2');?>
</div>




</body>
</html><?php }
}
