<?php
/* Smarty version 3.1.30, created on 2016-12-27 23:20:47
  from "/var/www/html/sm3/app/view/templates/search.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5862cd1fbc64f5_41682374',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '727aef56dbc1caf4702bfdcdfa8367665c4c8475' => 
    array (
      0 => '/var/www/html/sm3/app/view/templates/search.tpl',
      1 => 1482451292,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5862cd1fbc64f5_41682374 (Smarty_Internal_Template $_smarty_tpl) {
?>
<h3>Поиск статей в БД</h3>
<br />
<br />
<input type="text" class="search_field">
<button class="btn_articles_search">Найти</button>
<hr>

<br />
<br />
<div class="search-wrapper">
	<div class="search-div show-list-of-articles"></div>
	<div class="search-div show-one-article"></div>
</div>
<br>
<br>
<?php }
}
