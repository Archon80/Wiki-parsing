<?php
/* Smarty version 3.1.30, created on 2016-12-23 02:21:10
  from "/var/www/html/sm3/templates/main.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_585c5fe633eb40_56107467',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b8adba489a60673fe0846f8f54ee59e0a920c194' => 
    array (
      0 => '/var/www/html/sm3/templates/main.tpl',
      1 => 1482448863,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_585c5fe633eb40_56107467 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="./public/css/main.css" />
	<?php echo '<script'; ?>
 src="./public/js/jquery-3.1.1.min.js"><?php echo '</script'; ?>
>
</head>	
<body>		
	<div class="wrapper">
		<div class="menu"><?php echo $_smarty_tpl->tpl_vars['menu']->value;?>
</div>
		<div class="import content"><?php echo $_smarty_tpl->tpl_vars['import']->value;?>
</div>
		<div class="search content"><?php echo $_smarty_tpl->tpl_vars['search']->value;?>
</div>
	</div>
</body>
<?php echo '<script'; ?>
 src="./public/js/main.js"><?php echo '</script'; ?>
>		<!-- осн. логика, использует все подключенные функции -->
</html><?php }
}
