<?php
/* Smarty version 3.1.30, created on 2017-01-19 17:34:38
  from "/var/www/html/sm4/app/view/templates/import.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5880ce7ebf1793_26612890',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e43b064872dba0b796332c863239627920cd7e99' => 
    array (
      0 => '/var/www/html/sm4/app/view/templates/import.tpl',
      1 => 1482969664,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5880ce7ebf1793_26612890 (Smarty_Internal_Template $_smarty_tpl) {
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
