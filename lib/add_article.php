<?php       
/*
    Класс для работы со статьей, запрошенной пользователем:
        1) получения статьи из АПИ википедии
        2) ее обработка перед добавлением в БД
*/
class AddArticles {
    use Tools;

    // если запрос был из нескольких слов, склеиваем их по подчеркиванию
    public static function cleanSpacesInQuery($query)
    {
        $temp = explode(' ', $query);
        return (count($temp) > 1) ? implode('_', $temp) : $query;
    }

    // пишем в файл подробные логи об ошибках
    // а пользователю просто выводим сообщение о временных технических проблемах
    public static function errorLog($text)
    {
        $dt      = date("y-m-d H:i:s");
        $path    = 'error_log.txt';
        $message = PHP_EOL.PHP_EOL.$dt.PHP_EOL.$text;

        // вывод сообщения
        file_put_contents($path, $message, FILE_APPEND);
    }

    // функция получает текст статьи в строковом виде
    // возвращает валидный массив данных о статье для занесения статьи в БД
    public static function getArrayForArticle($user_query, $article)
    {
        $arrArticle = [];// объект, который будет передан классу для работы с БД
        
        $arrArticle['name']    = $user_query;           // название статьи
        $arrArticle['content'] = self::getArticleContent($article);
        $arrArticle['link']    = self::getArticleLink($user_query);
        $arrArticle['size']    = mb_strlen($arrArticle['content'], 'utf8');// размер статьи в байтах
        
        $arrWords = explode(' ', preg_replace("/[^a-zA-ZА-Яа-я0-9\s]/ui", "", $arrArticle['content']));// массив  слов
        $arrArticle['count']   = count($arrWords);      // количество слов в статье

        return $arrArticle;
    }

    // функция получает текст статьи в строковом виде
    // убирает оттуда лишние символы и возвращает массив уникальных слов из статьи
    public static function getArrayForWords($article)
    {
        return AddArticles::getUniqueArr( explode(' ', preg_replace("/[^a-zA-ZА-Яа-я0-9\s]/ui", "", $article)) );
    }

    // очищаем статью от инородных символов
    public static function getArticleContent($text)
    {
        return strip_tags($text);
    }

    // получаем имя ссылки для найденной статьи
    public static function getArticleLink($search_word)
    {
        return 'https://ru.wikipedia.org/wiki/'.$search_word;
    }

    // функция составляет информационное сообщение для пользователя,
    // которое будет выведено по итогам импорта статьи из АПИ в БД
    public static function getTotalInfo($res, $arrArticle, $full_time)
    {
        // если транзакция не завершилась успешно
        if (!$res['success']) {
            self::errorLog($res['error']);
            return 'Не удалось сохранить статью. Обратитесь за помощью к техническому специалисту';
        }

        // формируем информационную строку
        $info = '';
        $info .= 'Импорт завершен.<br /><br />';
        $info .= 'Найдена статья по адресу: '.$arrArticle['link'].'<br />';
        $info .= 'Время импорта: '  . $full_time.' сек.<br />';
        $info .= 'Размер статьи: '  . $arrArticle['size'].'<br />';
        $info .= 'Количество слов: '. $arrArticle['count'].'<br />';

        return $info;
    }

    // убрать повторяющиеся элементы из массива слов статьи
    // подсчитать количество вхождений каждого слова
    private static function getUniqueArr($arr)
    {
        $end = count($arr);
        $arrFinal = [];
        
        for($i = 0; $i < $end; $i++){
            $word = strtolower($arr[$i]);

            if (!array_key_exists($word, $arrFinal)) {
                $arrFinal[$word] = 1;
            } else {
                $arrFinal[$word]++;
            }
        }
        return $arrFinal;
    }

    // проверяем, найдена ли статья (если да, то возвращаем ее)
    public static  function isArticle($query)
    {
        $answer = [
            "success" => false,
            "body"    => '',
            "error"    => ''
        ];
        try {  
            // выполняем проверки для входных параметров
            if(!$query) {
                throw new Exception(__FILE__. ':'.__LINE__.'<br />В метод isArticle() класса AddArticles не поступил параметр query');
            }
            if(gettype($query) !== 'string') {
                throw new Exception(__FILE__. ':'.__LINE__.'<br />В метод isArticle() класса AddArticles в качестве параметра query поступила не строка');
            }
            // формируем адресную строку запроса для АПИ
            $standart_path = "https://ru.wikipedia.org/w/api.php?action=parse&format=json&page=";
            $query = self::cleanSpacesInQuery($query);// на случай, если запрос был из нескольких слов
            $full_path = $standart_path . $query;

            // с помощью PHP-cURL обращаемся к АПИ википедии,
            // пытаемся получить данные по запросу пользователя
            $res = self::Send($full_path, []);
            if(!$res) {
                throw new Exception(__FILE__. ':'.__LINE__.'<br />В методе isArticle() класса AddArticles произошла техническая ошибка. Не удалось получить данные из АПИ');
            }
            if(gettype($res) !== 'string') {
                throw new Exception(__FILE__. ':'.__LINE__.'<br />В метод isArticle() класса AddArticles из АПИ пришла не строка');
            }

            // пытаемся распарсить ответ апи
            $res = json_decode($res, true);
            if(gettype($res) !== 'array') {
                throw new Exception(__FILE__. ':'.__LINE__.'<br />В методе isArticle() класса AddArticles не удалось распарсить ответ АПИ. Вероятно, из АПИ пришел не JSON-формат.');
            }
            // self::showDev($res);exit();

            // если статья не найдена
            if (isset($res['error'])) {
                $answer["success"] = false;
                $answer["body"] = $res['error']['info'];
            }
            // если статья найдена, и от АПИ пришел валидный ответ
            else if(
                isset($res['parse']) &&
                isset($res['parse']['text']) &&
                isset($res['parse']['text']['*'])
            ) {
                $answer["success"] = true;
                $answer["body"] = $res['parse']['text']['*'];
            }
        }  
        catch(Exception $e) {  
            $answer["error"] = 'ERROR: ' . $e->getMessage();
        }
        finally {
            return $answer;
        }
    } // isArticle

    // если пользователь отключил JS на клиенте, обошел проверку
    // и отправил пустой запрос
    public static function isEmptyUserQuery()
    {
        if (
            count($_POST) > 0 &&
            isset($_POST['field_search_in_wiki']) &&
            $_POST['field_search_in_wiki'] == ''
        ) {
            return true;
        }
    }

    // проверяем, пришли ли данные из формы (обшариваем массив POST)
    public static  function isUserQuery()
    {
        if (
            count($_POST) > 0 &&
            isset($_POST['field_search_in_wiki']) && // нажатие клавиши "Найти статью"
            $_POST['field_search_in_wiki'] != ''
        ) {
            return true;
        }
    }

    public static function reloadPage()
    {
        header("location: index.php");
    }

    // отправляем запрос в API сервиса 
    public static  function Send($url, $data)
    {     
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // выводим ответ в переменную

        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    } // Send

} // AddArticles