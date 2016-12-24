<?php
/* Smarty version 3.1.30, created on 2016-12-23 02:58:28
  from "/var/www/html/sm3/templates/import.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_585c68a4cdc3e6_17794054',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5f53bcac88e862cf40e605f1aefa46eb542a4b67' => 
    array (
      0 => '/var/www/html/sm3/templates/import.tpl',
      1 => 1482451106,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_585c68a4cdc3e6_17794054 (Smarty_Internal_Template $_smarty_tpl) {
?>
<h3>В данном блоке будет производиться скачивание статей.</h3>
<br>
<button class="btn_articles_find">Поиск статей</button>
<br />
<br />
<br />
<div class="div_articles_list">
	<select class="select_articles_list"></select>
	<button class="btn_articles_add">Добавить статью в БД</button>
</div>
<br />
<br />
<br />
<table class="tb_search">
	<thead>
		<th class="tb-search-name">Название статьи</th>
		<th class="tb-search-link">Ссылка</th>
		<th class="tb-search-size">Размер статьи</th>
		<th class="tb-search-count">Кол-во слов</th>
	</thead>
	
	<tbody>
			
	</tbody>

	<tfoot>
	</tfoot>
</table>
<?php }
}
