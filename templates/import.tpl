<form action="" method="post" id="form_inport_article">
	<fieldset>
		<legend><div>Введите ключевое слово</div></legend>
		<input type="text" id="field_search_in_wiki" name="field_search_in_wiki">
		<button type="submit" name="btn_search_in_wiki" id="btn_search_in_wiki">Найти статью</button>
	</fieldset>
</form>
<br>
<br>
<!-- вывод информации для пользователя: итог импорта статьи -->
<div>{$answer}</div>
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
