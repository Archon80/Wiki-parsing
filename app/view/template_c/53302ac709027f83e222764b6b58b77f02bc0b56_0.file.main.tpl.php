<?php
/* Smarty version 3.1.30, created on 2016-12-27 23:24:06
  from "/var/www/html/sm3/app/view/templates/main.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5862cde60e5c15_53709655',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '53302ac709027f83e222764b6b58b77f02bc0b56' => 
    array (
      0 => '/var/www/html/sm3/app/view/templates/main.tpl',
      1 => 1482870195,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5862cde60e5c15_53709655 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="css/main.css" />
	<?php echo '<script'; ?>
 src="js/jquery-3.1.1.min.js"><?php echo '</script'; ?>
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
 src="js/main.js"><?php echo '</script'; ?>
>
</html><?php }
}
