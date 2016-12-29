<?php
/* Smarty version 3.1.30, created on 2016-12-29 03:02:42
  from "/var/www/html/sm3/app/view/templates/import.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_586452a29d6554_14245619',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ce78c583bd0e0d0133d317551ef98bb8cefbd2ea' => 
    array (
      0 => '/var/www/html/sm3/app/view/templates/import.tpl',
      1 => 1482969664,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_586452a29d6554_14245619 (Smarty_Internal_Template $_smarty_tpl) {
?>
<br>
<br>
<form class="form-search">
	<input type="text" id="field_search_in_wiki" class="input-medium search-query" placeholder="Название статьи">
	<button id="btn_search_in_wiki" class="btn btn-success">Скопировать</button>
</form>
<br>
<div class="after_add_info"></div>
<br />
<br />
<table class="tb_search table table-striped table-bordered">
	<thead>
		<th class="tb-search-name">Название статьи</th>
		<th class="tb-search-link">Ссылка</th>
		<th class="tb-search-size">Размер статьи</th>
		<th class="tb-search-count">Кол-во слов</th>
	</thead>	
	<tbody></tbody>
	<tfoot></tfoot>
</table><?php }
}
