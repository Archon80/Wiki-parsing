<?php
/* Smarty version 3.1.30, created on 2016-12-23 03:02:42
  from "/var/www/html/sm3/templates/search.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_585c69a2039141_77345766',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2c9bfe476b01204421118f0566e1834f65ec0ef3' => 
    array (
      0 => '/var/www/html/sm3/templates/search.tpl',
      1 => 1482451292,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_585c69a2039141_77345766 (Smarty_Internal_Template $_smarty_tpl) {
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
