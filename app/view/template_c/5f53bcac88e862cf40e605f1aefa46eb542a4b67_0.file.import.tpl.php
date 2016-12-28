<?php
/* Smarty version 3.1.30, created on 2016-12-26 14:37:40
  from "/var/www/html/sm3/templates/import.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_58610104bde5c7_44800201',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5f53bcac88e862cf40e605f1aefa46eb542a4b67' => 
    array (
      0 => '/var/www/html/sm3/templates/import.tpl',
      1 => 1482706760,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_58610104bde5c7_44800201 (Smarty_Internal_Template $_smarty_tpl) {
?>
<form action="" method="post" id="form_inport_article">
	<fieldset>
		<legend><div>Введите ключевое слово</div></legend>
		<input type="text" id="field_search_in_wiki" name="field_search_in_wiki">
		<button type="submit" name="btn_search_in_wiki" id="btn_search_in_wiki">Скопировать</button>
	</fieldset>
</form>
<br>
<br>
<!-- вывод информации для пользователя: итог импорта статьи -->
<div><?php echo $_smarty_tpl->tpl_vars['answer']->value;?>
</div>
<br />
<br />
<!-- таблица вывода статей, уже имеющихся в БД -->
<table class="tb_search">
	<thead>
		<th class="tb-search-name">Название статьи</th>
		<th class="tb-search-link">Ссылка</th>
		<th class="tb-search-size">Размер статьи</th>
		<th class="tb-search-count">Кол-во слов</th>
	</thead>
	
	<tbody></tbody>
	<tfoot></tfoot>
</table>
<?php }
}
