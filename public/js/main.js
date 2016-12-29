const PATH_TO_SERVER      = '../app/controller/';

// выполняем запрос к БД и выстраиваем таблицу всех имеющихся в БД статей
(function() {
	$.post(PATH_TO_SERVER+'server.php', {'get_all_articles':true}, function(answer){
		var articles = JSON.parse(answer);

		articles.forEach(function(elem) {
			addOneArticle(elem);
		});
	})
	.fail(function(xhr) {
		console.log('Не удалось получить ответ от сервера get_all_articles. Статус - '+xhr.status);
		return;
	});
})();

// работа со вкладками меню (дефолтные установки, и переключение вкладок)
showImportTab();

$('.menu-divs').each(function() {
	$(this).click(function() {
		if ($(this).hasClass('i')) {
			showImportTab();
		}
		if ($(this).hasClass('s')) {
			showSearchTab();
		}
	});
});

// вкладка "Import": клик по кнопке "Скопировать", запрос статьи из вики
$("#btn_search_in_wiki").click(function() {
		
		$('.after_add_info').html('');
		
		var time_start = (new Date).getTime(),		
			userSearchWord = $('#field_search_in_wiki').val();
		
		if ( !userSearchWord ) {
			alert('Нужно ввести имя искомой статьи.');
			return;		
		}
		var btn = $(this).prop('disabled', true);

		$.post(PATH_TO_SERVER+'server.php', {"add_article_in_db": userSearchWord}, function(answer){
			// console.log(answer);return ;
			var total = '';
			if (answer) {
				var article    = JSON.parse(answer),
					time_end   = (new Date).getTime(),
					time_total = (time_end - time_start)/1000;

				addOneArticle(article);
				total = getTotalInfo(true, article, time_total);
			} else {
				total = getTotalInfo(false);
			}
			$('.after_add_info').html(total);
		})
	.fail(function(xhr) {
		console.log('Не удалось получить ответ от сервера add_article_in_db. Статус - '+xhr.status);
	})
	.always(function() {
		btn.prop('disabled', false);
	});
});


// вкладка "Search": клик по кнопке "Найти" (поиск существующих статей в БД по введенному юзером слову)
$('#btn_articles_search').click(function() {
	var userWord = $('#search_field').val();
	if (!userWord) {
		alert('Необходимо ввести слово для поиска в БД');
		return;
	}

	var btn = $(this).prop('disabled', true);
	$('.show-one-article').html("");

	$.post(PATH_TO_SERVER+'server.php', {"get_some_words": userWord}, function(answer){
		if (!answer) {
			console.log('С сервера "get_some_words" не пришли никакие данные.');
			return;
		}
		var articles = JSON.parse(answer);

		// если из БД пришла хотя бы одна статья
		if (articles.length) {
			$('.show-list-of-articles').append('div').html('Найдено совпадений: '+articles.length+'<br><br>');
			
			// циклически добавляем все найденные статьи на страницу
			articles.forEach(function(elem, i, arr) {
				$('.show-list-of-articles').append(uCreateDiv(elem));
			});
			// вешаем событие: при клике по заголовку - показ содержимого (в блоке справа)
			$('.search-anchor').click(function() {
				$('.show-one-article').html( $(this).parent().attr('cont') );
			});

			// принимает информацию о найденной статье, выводит ее на страницу
			function uCreateDiv(elem) {
				return $('<div class="search_wrap_div"></div>')
						.attr("cont", elem.content)
						.html('<a href="#" class="search-anchor">'+
								elem.name+'</a> <span class="search-span">(количество вхождений - '+
								elem.count+')<span>');
			}
		} else {
			$('.show-list-of-articles').append('div').html('Совпадений не найдено.');
		}
	})
	.fail(function(xhr) {
		console.log('Не удалось получить ответ от сервера get_some_words. Статус - '+xhr.status);
		return;
	})
	.always(function() {
		btn.prop('disabled', false);
	});
});

/************************************ вспомогательные функции *****************************/

// скрыть обе вкладки
function hideBothTabs() {
	$('.content').hide();
}
// показать левую вкладку
function showImportTab() {
	hideBothTabs()
	$('#import').show();
}
// показать левую вкладку
function showSearchTab() {
	hideBothTabs()
	$('#search').show();
}

// функция принимает массив данных о статье и добавляет статью в общую выборку
function addOneArticle(elem) {
	$('.tb_search tbody').append(
		$('<tr>')
			.append(createTD(elem.name, 'name'))
			.append(createTD(elem.link))
			.append(createTD(elem.size, 'size'))
			.append(createTD(elem.count))
	);

	// обработка каждой из четырех ячеек текущей строки таблицы
	function createTD(data, cnt) {
		var temp = cnt == 'size' ? (+data/1000) + 'Kb' : data; 
		return $('<td></td>').html(temp);
	}
}

// вывод сообщения пользователю об итогах копирования статьи
function getTotalInfo(res, arrArticle, full_time)
{
    if (!res) {
        return 'Статья с таким названием в википедии не найдена.';
    }

    var info = '';
    info += 'Импорт завершен.<br /><br />';
    info += 'Найдена статья по адресу: ' + arrArticle['link'] + '<br />';
    info += 'Время импорта: '  + full_time + ' сек.<br />';
    info += 'Размер статьи: '  + arrArticle['size']  + '<br />';
    info += 'Количество слов: '+ arrArticle['count'] + '<br />';

    return info;
}