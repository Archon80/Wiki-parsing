<?php       
class DB {
    private $host     = '';
    private $login    = '';
    private $password = '';
    private $db_name  = '';
    private $db       = '';

    public function __construct($db_data) {
        $this->host     = $db_data['host'];
        $this->login    = $db_data['login'];
        $this->password = $db_data['password'];
        $this->db_name  = $db_data['db_name'];
        $this->db       = $this->dbSafeConnect();
    }

    // получение всех слов
    public function getAllArticles()
    {
        return $this->db->getAll("SELECT * FROM ?n", 'articles');
    }

    // выборка статей из БД по ключевому слову
    public function getSomeWords($wordName)
    {
        $wordName = $this->clearData($wordName);

        $q =   "SELECT articles.id_article, articles.name, articles.content,
                       articles_words.id_article, articles_words.id_word, articles_words.count,
                       words.id_word, words.word
                FROM   ?n, ?n, ?n
                WHERE  words.word=?s
                AND    articles.id_article = articles_words.id_article
                AND    words.id_word = articles_words.id_word
                ORDER BY articles_words.count DESC";

        return $this->db->getAll($q, 'articles', 'articles_words', 'words', $wordName);
    }

    /*
        Михаил, этот метод - единственный, который не исполнил через safemysql,
        а оставил PDO-синтаксис. Причины две:
        
        1) Первая, она же основная: у меня опять возникла блуждающая ошибка с AJAX-запросами.
           Когда я переписал этот метод через safesql, у меня все работало нормально,
           статья успешно и без ошибок добавлялась в базу, но возникла трудность:
           ajax-запрос на клиенте не может дождаться ответа. 
           Т.о. я не могу получить обратную связь по данному запросу,
           и статья добавляется в общую таблицу только после перезагрузки страницы.
           Пробовал обернуть в try-catch - это ничего не дало, никаких ошибок
           интерпретатор не выбрасывает.
           Поскольку причину этой технической проблемы я так и не установил,
           после пары часов отладки принял решение - оставить этот метод
           в виде PDO-синтаксиса.

        2) Все же хотелось сохранить транзакцию, а safemysql, как я понял,
           их не поддерживает, что не прибавляет надежности работе приложения
    */
    public function addArticleInDB($arrArticle, $arrWords)
    {
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        $db = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, $this->login, $this->password, $options);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec('SET NAMES utf8');

        $db->beginTransaction();
        
        // добавление статьи в БД Articles
        $name    = $this->clearData($arrArticle['name']);
        $content = $this->clearData($arrArticle['content']);
        $link    = $this->clearData($arrArticle['link']);
        $size    = $this->clearData($arrArticle['size'], 'i');
        $count   = $this->clearData($arrArticle['count'], 'i');

        $q =    "INSERT INTO articles(`name`,    `content`,    `link`,    `size`,    `count`)
                              VALUES (\"$name\", \"$content\", \"$link\", \"$size\", \"$count\")";
        $query = $db->prepare($q);
        $query->execute();
        $id_article = intval($db->lastInsertId());
        
        // для каждого слова из массива слов статьи
        $l = count($arrWords);
        foreach($arrWords as $k => $v) {
            // безопасная обработка данных
            $k = $this->clearData($k);
            $v = $this->clearData($v, 'i');

            // добавляем слово-атом в таблицу Words
            $q = "INSERT INTO words(`word`) VALUES (\"$k\")";
            $query = $db->prepare($q);
            $query->execute();
            $id_word = intval($db->lastInsertId());

            // добавляем запись в таблицу связей
            $q = "INSERT INTO articles_words(`id_article`, `id_word`, `count`)
                VALUES (\"$id_article\", \"$id_word\", \"$v\")";
            $query = $db->prepare($q);
            $query->execute();
        }

        $db->commit();
        return true;
    } // addArticleInDB

    private function dbSafeConnect()
    {
        $opts = [
            'user' => $this->login,
            'pass' => $this->password,
            'db' => $this->db_name,
            'charset' => 'utf8'
        ];

        return new SafeMySQL($opts);
    }

    // стандартизированная обработка данных из форм (POST-параметров из форм и GET-параметров из адресной строки)
    private function clearData($data, $type="s")
    {
        switch ($type)
        {
            case 's':   return trim(htmlspecialchars($data));   // если тип переменной - строка (по умолчанию)
            case 'i':   return abs( (int) $data);                           // если тип переменной - целое число
        }
    }
}

$DB = new DB($db_data);