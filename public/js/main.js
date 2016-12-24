// конфигурационные данные - пути и переменные верстки
const PATH_TO_SERVER      = './lib/server/';		// путь до папки с серверными скриптами, к которым стучимся аяксом
const PATH_TO_SOURCE      = '../../source/';		// путь до папки со статьями

const BTN_ARTICLES_FIND   = $('.btn_articles_find');	// кнопка поиска статей
const BTN_ARTICLES_ADD    = $('.btn_articles_add');	// кнопка добавления статьи в БД
const BTN_ARTICLES_SEARCH = $('.btn_articles_search');	// кнопка поиска статьи в БД

const SELECT_ART_LIST     = $('.select_articles_list');
const DIV_SELECT_ART_LIST = $('.div_articles_list');


// выполняем запрос к БД и выстраиваем таблицу всех имеющихся в БД статей
(function() {
	// запрос на сервер
	$.post(PATH_TO_SERVER+'get_all_articles.php', '', function(answer){
		// console.log(typeof answer, answer);// return;
		answer = JSON.parse(answer);
		if (!answer['success']) {
			alertUser(answer['error']);
		}
		var
			articles = answer['body'],
			tableBlock = document.querySelector('.tb_search').firstElementChild.nextElementSibling;

		articles.forEach(function(elem, i, arr) {
			addOneArticle(elem);
		});
	})
	.fail(function(xhr) {
		alertUser('error - ' + xhr.status);
	});
})();

// работа со вкладками меню (дефолтные установки, и переключение вкладок)
showImportTab();

[].forEach.call(document.querySelectorAll('.menu-divs'), function(elem, i, arr) {
	elem.onclick = function() {
		if(hasClass(elem, 'i')) showImportTab();
		if(hasClass(elem, 's')) showSearchTab();
	}
});

// вкладка "Import": клик по кнопке "Поиск статей"
BTN_ARTICLES_FIND.click(function() {
	var btn = $(this).prop('disabled', true);

	$.post(PATH_TO_SERVER+'find_articles.php', '', function(answer){
		console.log(typeof answer, answer); //return;
		var arrArticles = JSON.parse(answer);

		if (arrArticles.length) {
			arrArticles.forEach(function(elem, i, arr) {
				SELECT_ART_LIST.append(new Option(elem, i));
			});
		}
		else {
			DIV_SELECT_ART_LIST.html('Нет статей, доступных для добавления в БД.');
		}

		DIV_SELECT_ART_LIST.show();
	})
	.fail(function(xhr) {
		alertUser('error - ' + xhr.status);
	})
	.always(function() {
		btn.prop('disabled', false);
	});
});

// вкладка "Import": клик по кнопке "Добавить стаью в БД"
BTN_ARTICLES_ADD.click(function() {
	var
		btn = $(this).prop('disabled', true),
		dataToServer = {
			"fname":PATH_TO_SOURCE + $('.select_articles_list :selected').text()
		};

	$.post(PATH_TO_SERVER+'add_article.php', dataToServer, function(answer){
		console.log(typeof answer, answer); //return;
		var answer = JSON.parse(answer);
		if (!answer['success']) {
			alertUser(answer['error']);
		}
		addOneArticle(answer['body'], 'arr');
	})
	.fail(function(xhr) {
		alertUser('error - ' + xhr.status);
	})
	.always(function() {
		btn.prop('disabled', false);
	});
});

// вкладка "Search": клик по кнопке "Найти"
BTN_ARTICLES_SEARCH.click(function() {
	var
		btn = $(this).prop('disabled', true),
		dataToServer = {
			"wordName": $('.search_field').val()
		};

	$.post(PATH_TO_SERVER+'get_some_words.php', dataToServer, function(answer){
		// console.log(typeof answer, answer); return;
		var answer = JSON.parse(answer);
		if (!answer['success']) {
			alertUser(answer['error']);
		}
		var articles = answer['body'];

		// если из БД пришла хотя бы одна статья
		if (articles.length) {
			$('.show-list-of-articles').append('div').html('Найдено совпадений: '+articles.length+'<br><br>');
			const SEARCH_ART_LIST = document.querySelector('.show-list-of-articles');
			
			// вставляем на страницу информацию о каждой статье
			articles.forEach(function(elem, i, arr) {
				SEARCH_ART_LIST.appendChild(uCreateDiv(elem));
			});

			// вешаем событие: при клике по заголовку - показ содержимого (в блоке справа)
			$('.search-anchor').click(function() {
				console.log($(this).parent().attr('cont'));
				$('.show-one-article').html($(this).parent().attr('cont'));
			});

			///////////////////////////////////////////////

			function uCreateDiv(elem) {
				var d = document.createElement('div');//.appendChild(a);
				d.className = 'search_wrap_div';
				d.setAttribute("cont", elem.content);
				d.innerHTML = 
								'<a href="#" class="search-anchor">'+
								elem.name+'</a> <span class="search-span">(количество вхождений - '+
								elem.count+')<span>';
				return d;
			}
		} else {
			$('.show-list-of-articles').append('div').html('Совпадений не найдено.');
		}
	})
	.fail(function(xhr) {
		alertUser('error - ' + xhr.status);
	})
	.always(function() {
		btn.prop('disabled', false);
	});
});




/************************************ вспомогательные функции *****************************/

// показать левую вкладку
function hideBothTabs() {
	$('.content').hide();
}
// показать левую вкладку
function showImportTab() {
	hideBothTabs()
	$('.import').show();
}
// показать левую вкладку
function showSearchTab() {
	hideBothTabs()
	$('.search').show();
}


// проверить, содержит ли DOM-элемент указанный класс разметки
function hasClass(elem, className) {
    return elem.classList.contains(className);
}

// функция выводит стандартное предупреждению юзеру о возникшей технической проблеме,
// которую, естественно, упорно пытаются решить наши доблестные гномики
function alertUser(error) {
	alert('Возникла техническая проблема. Обратитесь за помощью к специалисту.');
	if (error) {
		console.log(error);
	}
}

// функция принимает массив данных о статье
// и добавляет статью в общую выборку
function addOneArticle(elem) {
	var tableBlock = document.querySelector('.tb_search').firstElementChild.nextElementSibling;
	var TR = document.createElement('tr');
	TR.appendChild(createTD(elem.name, 'name'));
	TR.appendChild(createTD(elem.link));
	TR.appendChild(createTD(elem.size, 'size'));
	TR.appendChild(createTD(elem.count));
	tableBlock.appendChild(TR);

	// обработка каждой из четырех ячеек текущей строки таблицы
	function createTD(data, cnt) {
		var td = document.createElement('td');

		if(cnt == 'size') {
			td.innerHTML = (+data / 1000) + 'Kb';
		} else {
			td.innerHTML = data;
		}

		if(cnt == 'name') {
			td.className = 'show-article';
			td.onclick = function() {
				showArticle(data);
			}
		}

		return td;
	}

	// показ содержимого статьи при клике по названию статьи
	function showArticle(articleName) {
		$.post(PATH_TO_SERVER+'get_one_article.php', {"articleName":articleName}, function(answer){
			console.log(typeof answer, answer); //return;
			var answer = JSON.parse(answer);
			if (!answer['success']) {
				alertUser(answer['error']);
			}
			var article = answer['body'];					
			$('.show-one-article').html(article.content);
			showSearchTab();
		})
		.fail(function(xhr) {
			alertUser(console.log('error - ' + xhr.status));
		});
	}
} // addOneArticle

