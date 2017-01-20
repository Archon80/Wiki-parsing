<?php       
/*
    Класс для работы со статьей, запрошенной пользователем:
        1) получения статьи из АПИ википедии
        2) ее обработка перед добавлением в БД
*/
class AddArticles {
    public static function main($userWord, $DB)
    {
        $userWord = self::clearData($userWord);
        $article = self::getArticleFromWiki($userWord);

        if($article) {
            $arrArticle = self::getArrayForArticle($userWord, $article);
            $arrWords = self::getUniqueArr( explode(' ', preg_replace("/[^a-zA-ZА-Яа-я0-9\s]/ui", "", $arrArticle['content'])) );

            if ( $DB->addArticleInDB($arrArticle, $arrWords) ) {
                return $arrArticle;
            }
        }
    }

    // если запрос был из нескольких слов, склеиваем их по подчеркиванию
    private static function cleanSpacesInQuery($query)
    {
        $temp = explode(' ', $query);
        return (count($temp) > 1) ? implode('_', $temp) : $query;
    }

    // стандартизированная обработка данных из форм (POST-параметров из форм и GET-параметров из адресной строки)
    private static function clearData($data, $type="s")
    {
        switch ($type)
        {
            case 's':   return trim(htmlspecialchars($data));   // если тип переменной - строка (по умолчанию)
            case 'i':   return abs( (int) $data);                           // если тип переменной - целое число
        }
    }

    // функция получает текст статьи в строковом виде
    // возвращает валидный массив данных о статье для занесения статьи в БД
    private static function getArrayForArticle($user_query, $article)
    {
        $arrArticle = [];
        
        $arrArticle['name']    = $user_query;
        $arrArticle['content'] = strip_tags($article);
        $arrArticle['link']    = 'https://ru.wikipedia.org/wiki/'.$user_query;
        $arrArticle['size']    = mb_strlen($arrArticle['content'], 'utf8');
        $arrArticle['count']   = count(explode(' ', preg_replace("/[^a-zA-ZА-Яа-я0-9\s]/ui", "", $arrArticle['content'])));

        return $arrArticle;
    }

    // пытаемся получить статью из вики
    private static function getArticleFromWiki($query)
    {
        $query = self::cleanSpacesInQuery($query);// на случай, если запрос был из нескольких слов
        $full_path = "https://ru.wikipedia.org/w/api.php?action=parse&format=json&page=" . $query;

        $res = json_decode(self::Send($full_path, []), true);

        if( isset($res['parse']['text']['*']) )
            return $res['parse']['text']['*'];
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

    // отправляем запрос в API сервиса 
    private static  function Send($url, $data)
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
    }

} // AddArticles