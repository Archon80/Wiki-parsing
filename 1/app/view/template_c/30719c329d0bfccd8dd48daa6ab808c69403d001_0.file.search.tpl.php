<?php
/* Smarty version 3.1.30, created on 2017-01-19 17:34:38
  from "/var/www/html/sm4/app/view/templates/search.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5880ce7ebfd392_52668767',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '30719c329d0bfccd8dd48daa6ab808c69403d001' => 
    array (
      0 => '/var/www/html/sm4/app/view/templates/search.tpl',
      1 => 1482969757,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5880ce7ebfd392_52668767 (Smarty_Internal_Template $_smarty_tpl) {
?>
<br />
<form class="form-search">
	<input type="text" id="search_field" class="input-medium search-query" placeholder="Введите слово...">
	<button id="btn_articles_search" class="btn btn-success">Найти</button>
</form>
<br />
<br />
<div class="search-wrapper">
	<div class="search-div show-list-of-articles"></div>
	<div class="search-div show-one-article"></div>
</div><?php }
}
